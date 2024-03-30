<?php
    session_start();

    include_once "./userProfile.php";
    include_once "./userDisplayDB.php";


    $db = new mysqli("localhost","root","1234","cosmo");
    $hobbies1 = isset($_POST["check-substitution-1"]) ? $_POST["check-substitution-1"] : null;
    $hobbies2 = isset($_POST["check-substitution-2"]) ? $_POST["check-substitution-2"] : null;
    $hobbies3 = isset($_POST["check-substitution-3"]) ? $_POST["check-substitution-3"] : null;
    $hobbies4 = isset($_POST["check-substitution-4"]) ? $_POST["check-substitution-4"] : null;

    $userRegistered = $_SESSION["user_id"];

    $allHobbies1=[$hobbies1,$hobbies2,$hobbies3,$hobbies4];
    $allHobbies =array_filter($allHobbies1,function($value){
        return $value !=null;
    });
    $allHobbies = array_values($allHobbies);

       
    $profileName = $_POST["username"];
    $faculty = $_POST['faculty'];
    $aboutme =$_POST['aboutme'];

    $targetDirectory = "../images/profilePics/"; 
    if(isset($_FILES["inputfile"])) {
    $targetFile = basename($_FILES["inputfile"]["name"]);
        echo "Target file:$targetFile";
    }else{
        echo "Field not set";
    }   
    $targetPath = $targetDirectory .$targetFile;
    move_uploaded_file($_FILES["inputfile"]["tmp_name"], $targetPath);
    
    $userProfileInfo = new userProfileInfo($userRegistered,$profileName,$faculty,$aboutme,$targetPath,$allHobbies);
 
        $userProfileInfo->saveUsers($db);
        $userProfileInfo->saveHobbies($db);
    header("Location: ../html/profile.php");
?>
