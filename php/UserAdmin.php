<?php
require 'dbconfig.php';
require 'User.php';

class UserAdmin extends User
{
    private bool $admin = true;
    private $db = null;
    private $conn = null;
    private $userGroups = array();

    public function __construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password)
    {
        parent::__construct($firstName, $lastName, $userName, $email, $dateOfBirth, $password);
        $this->db = DbConn::instanceOfDb();
        $this->conn = $this->db->getConnection();
    }

    public function createAdminUser(UserAdmin $UserAdmin)
    {


        $stmt = $this->conn->prepare("UPDATE users SET Admin = true WHERE userName = :username ");
        $username = $UserAdmin->getUserName();
        $stmt->bindParam(":username", $username);
        $stmt->execute();
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
    public function loadUserComments($userName) {
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


    public function createGroup($groupName) {
        // Create a new group
        if (!isset($this->userGroups[$groupName])) {
            $this->userGroups[$groupName] = array();
            return true;
        } else {
            return false;
        }
    }
    public function addUserToGroup($userName, $groupName) {
        if (!isset($this->userGroups[$groupName])) {
            $this->userGroups[$groupName] = array();
        }
        $this->userGroups[$groupName][] = $userName;
    }
    public function removeUserFromGroup($userName, $groupName) {
        if (isset($this->userGroups[$groupName])) {
            $key = array_search($userName, $this->userGroups[$groupName]);
            if ($key !== false) {
                unset($this->userGroups[$groupName][$key]);
            }
        }
    }
    public function getUsersInGroup($groupName) {
        if (isset($this->userGroups[$groupName])) {
            return $this->userGroups[$groupName];
        } else {
            return array();
        }
    }
    public function banUsersInGroup($groupName) {
        $usernames = $this->getUsersInGroup($groupName);

        foreach ($usernames as $username) {
            $stmt = $this->conn->prepare("DELETE FROM users WHERE userName = :username");
            $stmt->bindParam(":username", $username);
            $stmt->execute();

            echo "Banned user: $username <br>";
        }
    }
    public function emailUsersInGroup($groupName, $subject, $message) {
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
