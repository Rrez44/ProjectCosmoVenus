<?php
session_start();

require_once 'dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postId = $_POST['postId'] ?? null;
    $commenter = $_SESSION['user_id'] ?? null;
    $text = htmlspecialchars( $_POST['commentText']) ?? null;

    if (is_null($postId) || is_null($commenter) || is_null($text)) {
        echo "Required fields are missing.";

        exit;
    }



    try {

        require_once 'PostComment.php';
        $comment = new PostComment($postId, $commenter, $text);
        $comment->saveComment();

        echo "Comment saved successfully!";
    } catch (Exception $e) {
        echo "Error saving comment: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}