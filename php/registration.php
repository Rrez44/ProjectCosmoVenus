<?php
require_once 'dbconfig.php';
require_once 'User.php';
require_once 'AutomaticEmail.php';

$firstName = trim(htmlspecialchars( $_POST['firstName']));
$lastName = trim(htmlspecialchars( $_POST['lastName']));
//$userName = trim(htmlspecialchars( $_POST['userName']));
$userNameFromPost = trim(htmlspecialchars( $_POST['userName']));
$userName = preg_replace('/[^\w\s]/u', '', $userNameFromPost);
$email = trim(htmlspecialchars( $_POST['email']));
$dateOfBirth = trim(htmlspecialchars( $_POST['dateOfBirth']));
$password = trim(htmlspecialchars( $_POST['password']));
$confirmPassword = trim(htmlspecialchars( $_POST['confirmPassword']));
try {
    $token = bin2hex(random_bytes(32));
} catch (Exception $e) {
}
if ($password !== $confirmPassword  ) {
    echo "Passwords didnt match";

}
else {
    try {
        $rUser = new User($firstName, $lastName, $userName, $email, $dateOfBirth, $password,true);

        if ($rUser->save()) {
            session_start();
            $rUser->saveToken($userName);
            global $token;
            $expire = time() +10000;
            setcookie("rememberMeToken", $token, $expire, "/");

            $db = DbConn::instanceOfDb();
            $conn=$db->getConnection();

            $sql = "INSERT INTO USERSDISPLAYINFO (userName, profileName, faculty, aboutMe, profilePicture,bannerPicture) VALUES (?, ?, ?, ?, ?,?)";
            $stmt = $conn->prepare($sql);



            $profileName = "Profile Name";
            $faculty = "Faculty";
            $aboutMe = "About me";
            $profilePicture = "../images/profileIcons/fire.png";
            $bannerPicture ="../images/profileIcons/fire.png";

            $stmt->bindParam(1, $userName);
            $stmt->bindParam(2, $profileName);
            $stmt->bindParam(3, $faculty);
            $stmt->bindParam(4, $aboutMe);
            $stmt->bindParam(5, $profilePicture);
            $stmt->bindParam(6, $bannerPicture);




            $stmt->execute();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $userName;
            var_dump($_SESSION['user_id']);
            header("Location: ../views/setUpProfile.php");

        } else {
            echo "Failed to register user.";
        }
    } catch (Exception $e) {
        // Now catch the Exception to print the specific error message
        echo "Failed to register user: " . $e->getMessage();
    }
}