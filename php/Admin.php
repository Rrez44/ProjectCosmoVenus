<?php

require 'dbconfig.php';
require 'User.php';

class UserAdmin extends User
{
    private bool $admin = true;
    private ?DbConn $db = null;
    private $conn = null;
    private $userGroups = array();

    public function __construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password)
    {
        parent::__construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password);
        $this->db = DbConn::instanceOfDb();
        $this->conn = $this->db->getConnection();
        if (!isset($_SESSION['userGroups'])) {
            $_SESSION['userGroups'] = array();
        }
    }

    public function createAdminUser($UserAdmin)
    {


        $stmt = $this->conn->prepare("UPDATE users SET Admin = true WHERE userName = :username ");
        $username = $UserAdmin;
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        echo "The user is now admin";
    }

    public function loadUserInfo($userName)
    {
        $query = $this->conn->prepare("SELECT * FROM users WHERE userName = :userName");
        $query->bindParam(':userName', $userName);
        $query->execute();

        $userInfo = $query->fetch(PDO::FETCH_ASSOC);

        if ($userInfo) {
            $listItem = '<ul class="list-group">';
            $listItem .= '<li class="list-group-item">First Name: ' . $userInfo['firstName'] . '</li>';
            $listItem .= '<li class="list-group-item">Last Name: ' . $userInfo['lastName'] . '</li>';
            $listItem .= '<li class="list-group-item">Username: ' . $userInfo['userName'] . '</li>';
            $listItem .= '<li class="list-group-item">Email: ' . $userInfo['email'] . '</li>';
            $listItem .= '<li class="list-group-item">Date of Birth: ' . $userInfo['dateOfBirth'] . '</li>';
            $listItem .= '<li class="list-group-item">Password: ' . $userInfo['password'] . '</li>';
            $listItem .= '<li class="list-group-item">Admin: ' . ($userInfo['Admin'] ? 'Yes' : 'No') . '</li>';
            $listItem .= '</ul>';
            return $listItem;
        } else {
            return null;
        }
    }

    public function loadUserComments($userName)
    {

        $stmt = $this->conn->prepare("SELECT * FROM cosmo.postcomments WHERE userName = :userName");
        $stmt->bindParam(":userName", $userName);
        $stmt->execute();

        // Fetch all comments
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generate HTML list
        $html = '<ul class="list-group">';
        foreach ($comments as $comment) {
            $html .= '<li class="list-group-item">';
            $html .= '<strong>Comment ID:</strong> ' . $comment['commentId'] . '<br>';
            $html .= '<strong>Post ID:</strong> ' . $comment['postId'] . '<br>';
            $html .= '<strong>Username:</strong> ' . $comment['userName'] . '<br>';
            $html .= '<strong>Text:</strong> ' . $comment['text'] . '<br>';
            $html .= '<strong>Post Time:</strong> ' . $comment['postTime'] . '<br>';
            $html .= '</li>';
        }
        $html .= '</ul>';

        return $html;
    }


    public function createGroup() {

        $groupName = count($_SESSION['userGroups']) . random_int(0,69);
        if (!isset($_SESSION['userGroups'][$groupName])) {
            $_SESSION['userGroups'][$groupName] = array();
            return true;
        } else {
            return false;
        }
    }



    public function loadGroups($sort_order) {
        $html = "";
        if ($sort_order == 1){ksort($_SESSION['userGroups']);}
        else krsort($_SESSION['userGroups']);
        foreach ($_SESSION['userGroups'] as $groupName => $group) {
            $html .=  '
             <li class="list-group-item d-flex my-3">' . $groupName . '
                            <span style="margin-left: auto" class="d-flex">

                                <form action="" method="post" class="mx-2" >
                                    <button class="btn btn-outline-info" name="view_' . $groupName. '"> View users</button>
                                </form>
                                <form action="" method="post" class="mx-2">
                                    <button class="btn btn-outline-info" name="email_' . $groupName . '"> Email Users</button>
                                </form>
                                <form action="" method="post" class="mx-2" >
                                    <button class="btn btn-outline-danger" name="delete_' . $groupName. '"> Delete Group</button>
                                </form>
                                <form action="" method="post" class="mx-2">
                                    <button class="btn btn-outline-danger" name="ban_' . $groupName . '"> Ban Users in group</button>
                                </form>
                            </span>
                        </li>
                        <hr>
            ';
        }
        return $html;
    }
    public function deleteGroup($groupName) {
        if (isset($_SESSION['userGroups'][$groupName])) {
            unset($_SESSION['userGroups'][$groupName]);
            return true;
        } else {
            return false;
        }
    }
    public function addUserToGroup($userName, $groupName)
    {
        if (!isset($this->userGroups[$groupName])) {
            $this->userGroups[$groupName] = array();
        }
        $this->userGroups[$groupName][] = $userName;
    }

    public function removeUserFromGroup($userName, $groupName)
    {
        if (isset($this->userGroups[$groupName])) {
            $key = array_search($userName, $this->userGroups[$groupName]);
            if ($key !== false) {
                unset($this->userGroups[$groupName][$key]);
            }
        }
    }

    public function getUsersInGroup($groupName)
    {
        if (isset($this->userGroups[$groupName])) {
            return $this->userGroups[$groupName];
        } else {
            return array();
        }
    }

    public function banUsersInGroup($groupName)
    {
        $usernames = $this->getUsersInGroup($groupName);

        foreach ($usernames as $username) {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE userName = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            echo "Banned user: $username <br>";
        }
    }
    public function ban($userName)
    {
        $username = $userName;

            $stmt = $this->conn->prepare("DELETE FROM users WHERE userName = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            echo "Banned user: $username <br>";
    }

    public function emailUsersInGroup($groupName, $subject, $message)
    {
        $usernames = $this->getUsersInGroup($groupName);

        foreach ($usernames as $username) {
            $user = $this->loadUserInfo($username);
            $email = $user['email'];

            $headers = "From: rrezon.beqiri@student.uni-pr.edu\r\n";
            $headers .= "Reply-To: rrezon.beqiri@student.uni-pr.edu\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            if (mail($email, $subject, $message, $headers)) {
                echo "Email sent to user $username successfully. <br>";
            } else {
                echo "Failed to send email to user $username. <br>";
            }
        }
    }
}
