<?php

include_once 'dbconfig.php';
include_once 'ProfilePost.php';

session_start();

if(isset($_SESSION['user_id']) && isset($_POST['postId'])) {
    $liker = $_SESSION['user_id'];
    $postId = $_POST['postId'];

    try {

        global $conn;
        $postFinder = $conn->prepare("INSERT INTO postLikes (liker, postId) VALUES (:liker, :postId)");

        $postFinder->bindParam(":liker", $liker);

        $postFinder->bindParam(":postId", $postId);

        $postFinder->execute();

    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "You have already liked this post.";
        } else {
            error_log($e->getMessage());
            echo "Something went wrong";
        }
    }
}