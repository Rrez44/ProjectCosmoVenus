<?php
require 'dbconfig.php';
require 'PostComment.php';
function addCommasToNumber($str) {

    $pattern = '/(\d+)(?!\s*(?:-|\/)\s*\d+)/';
    $callback = function($matches) {
        return number_format($matches[1]);
    };
   return preg_replace_callback($pattern, $callback, $str);
}





$postId = $_POST['postId'] ?? '';

header('Content-Type: application/json');

if (!empty($postId)) {
    $postComments = PostComment::loadPostComments($postId);

    foreach ($postComments as &$comment) {
        foreach ($comment as $key => &$value) {
            if (is_string($value)) {
                $value = addCommasToNumber($value);
            }
        }
    }


    if (!empty($postComments)) {
        echo json_encode(['comments' => $postComments]);
    } else {
        echo json_encode(['error' => 'No comments found']);
    }
} else {
    echo json_encode(['error' => 'No post ID provided']);
}