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
        } else {
            echo "Failed to register user.";
        }
    } catch (Exception $e) {
        // Now catch the Exception to print the specific error message
        echo "Failed to register user: " . $e->getMessage();
    }
}