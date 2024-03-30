<?php
require 'dbconfig.php';
require 'PostComment.php';

$postId = $_POST['postId'] ?? '';

header('Content-Type: application/json');

if (!empty($postId)) {
    $postComments = PostComment::loadPostComments($postId);
    if (!empty($postComments)) {
        echo json_encode(['comments' => $postComments]);
    } else {
        echo json_encode(['error' => 'No comments found']);
    }
} else {
    echo json_encode(['error' => 'No post ID provided']);
}