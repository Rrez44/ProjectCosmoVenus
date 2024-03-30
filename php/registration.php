<?php
require_once 'dbconfig.php';
require_once 'User.php';


$firstName = trim(htmlspecialchars( $_POST['firstName']));
$lastName = trim(htmlspecialchars( $_POST['lastName']));
$userName = trim(htmlspecialchars( $_POST['userName']));
$email = trim(htmlspecialchars( $_POST['email']));
$dateOfBirth = trim(htmlspecialchars( $_POST['dateOfBirth']));
$password = trim(htmlspecialchars( $_POST['password']));
$confirmPassword = trim(htmlspecialchars( $_POST['confirmPassword']));
if ($password !== $confirmPassword) {
    echo "Passwords didnt match";
}
else {
    try {
        $rUser = new User($firstName, $lastName, $userName, $email, $dateOfBirth, $password);

        if ($rUser->save()) {
            session_start();
            global $conn;
            $sql = "INSERT INTO USERSDISPLAYINFO (userName, profileName, faculty, aboutMe, profilePicture) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $profileName = "Profile Name";
            $faculty = "Faculty";
            $aboutMe = "About me";
            $profilePicture = "../images/profileIcons/fire.png";

            $stmt->bindParam(1, $userName);
            $stmt->bindParam(2, $profileName);
            $stmt->bindParam(3, $faculty);
            $stmt->bindParam(4, $aboutMe);
            $stmt->bindParam(5, $profilePicture);

// Execute the prepared statement
            $stmt->execute();
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $userName;
            header("Location: ../views/setUpProfile.php");

        } else {
            echo "Failed to register user.";
        }
    } catch (Exception $e) {
        // Now catch the Exception to print the specific error message
        echo "Failed to register user: " . $e->getMessage();
    }
}