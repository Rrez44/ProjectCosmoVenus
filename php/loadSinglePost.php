<?php
require 'dbconfig.php';
require 'ProfilePost.php';



$postId = $_POST['postId'] ?? '';

if (!empty($postId)) {
    $postDetails = ProfilePost::loadPost($postId);

    if ($postDetails !== null) {
        echo json_encode($postDetails);
    } else {
        echo json_encode(['error' => 'Post not found']);
    }
} else {
    echo json_encode(['error' => 'No post ID provided']);
}