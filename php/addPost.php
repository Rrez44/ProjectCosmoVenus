<?php
include_once 'User.php';
include_once 'ProfilePost.php';
include_once 'dbconfig.php';

session_start();

$userName = $_SESSION['user_id'];
$description = trim(htmlspecialchars($_POST['description']));
$poster = User::getUser($userName);
$post = new ProfilePost($poster,$description);
$target_file = $post->getImagePath() . basename($_FILES["postImage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["postImage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your post was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["postImage"]["tmp_name"], $target_file)) {
        try {
            $post->setImagePath($target_file);
            $post->save();
        } catch (Exception $e) {
        }
        header("Location: /cosmovenus/views/profile.php");
        echo "The post ". htmlspecialchars( basename( $_FILES["postImage"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your post.";
    }
}