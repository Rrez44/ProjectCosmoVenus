<?php

session_start();

include_once "UserProfileInfo.php";
include_once "dbconfig.php";


global $conn;
$hobbies1 = $_POST["check-substitution-1"] ?? null;
$hobbies2 = $_POST["check-substitution-2"] ?? null;
$hobbies3 = $_POST["check-substitution-3"] ?? null;
$hobbies4 = $_POST["check-substitution-4"] ?? null;

$userRegistered = $_SESSION["user_id"];

$allHobbies1 = [$hobbies1, $hobbies2, $hobbies3, $hobbies4];
$allHobbies = array_filter($allHobbies1, function ($value) {
    return $value != null;
});
$allHobbies = array_values($allHobbies);

$profileName = trim(htmlspecialchars( $_POST["username"]));
$faculty = trim(htmlspecialchars($_POST['faculty']));
$aboutme = trim(htmlspecialchars($_POST['aboutme']));

$targetDirectory = "../images/" . $userRegistered . "/profileImages/";
if (isset($_FILES["inputfile"])) {
    $targetFile = basename($_FILES["inputfile"]["name"]);
    echo "Target file:$targetFile";
} else {
    echo "Field not set";
}
$targetPath = $targetDirectory . $targetFile;
move_uploaded_file($_FILES["inputfile"]["tmp_name"], $targetPath);

$userProfileInfo = new userProfileInfo($userRegistered, $profileName, $faculty, $aboutme, $targetPath, $allHobbies);

$userProfileInfo->saveUsers($conn);
$userProfileInfo->saveHobbies($conn);
header("Location: ../views/profile.php");

