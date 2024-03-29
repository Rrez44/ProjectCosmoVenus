<?php
require_once 'dbconfig.php';
require_once 'User.php';

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$userName = $_POST['userName'];
$email = $_POST['email'];
$dateOfBirth = $_POST['dateOfBirth'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
if ($password !== $confirmPassword) {
    echo "Passwords didnt match";
}
else {
    try {
        $rUser = new User($firstName, $lastName, $userName, $email, $dateOfBirth, $password);

        if ($rUser->save()) {
            echo "Successful registration.";
            // header("Location: setUpProfile.php");
            session_start();
            $_SESSION['user_id'] = $rUser->getUserName();
            $_SESSION['logged_in'] = true;
            $_SESSION['first_register']=true;
            header("Location: ../html/SetUpProfile/setupprofile.php");
            
        } else {
            echo "Failed to register user.";
        }
    } catch (Exception $e) {
        echo "Failed to register user: " . $e->getMessage();
    }
}