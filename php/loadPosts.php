<?php
include_once 'dbconfig.php'; 
include_once 'ProfilePost.php'; 
include_once 'User.php';

session_start();

$userName = isset($_POST['username']) ? $_POST['username'] : $_SESSION['user_id'];

$db = DbConn::instanceOfDb();
$conn=$db->getConnection();
$loadPosts = $conn->prepare("SELECT * FROM userposts WHERE poster = :userName   ");
$loadPosts->bindParam(":userName", $userName);
$loadPosts->execute();
$posts = $loadPosts->fetchAll(PDO::FETCH_ASSOC);

global $sortedPosts;


$sortType = isset($_POST['sortType']) ?$_POST['sortType'] : 'date';

if($sortType == 'likes') {
    $likes = [];
    foreach ($posts as $index => $post) {
        $likes[$index] = $post['likes'];
    }
    arsort($likes);
    $sortedPosts = [];
    foreach ($likes as $index => $like) {
        $sortedPosts[] = $posts[$index];
    }
}elseif($sortType == 'date') {
    $dates = [];
    foreach ($posts as $index => $post) {
        $dates[$index] = strtotime($post['timeOfPost']);
    }
    asort($dates);
    $sortedPosts = [];
    foreach ($dates as $index => $timestamp) {
        $sortedPosts[] = $posts[$index];
    }
}elseif ($sortType == 'alphabetical') {
    $descriptions = [];
    foreach ($posts as $index => $post) {
        $descriptions[$index] = $post['description'];
    }
    ksort($descriptions);
    $sortedPosts = [];
    foreach ($descriptions as $index => $description) {
        $sortedPosts[] = $posts[$index];
    }
}elseif ($sortType == 'alphabeticalReverse') {
    $descriptions = [];
    foreach ($posts as $index => $post) {
        $descriptions[$index] = $post['description'];
    }
    krsort($descriptions);
    $sortedPosts = [];
    foreach ($descriptions as $index => $description) {
        $sortedPosts[] = $posts[$index];
    }
}


$posts = $sortedPosts;

    $finalString = "";
    foreach ($posts as $row) {
        $liked = "fa-regular fa-heart";
    if (ProfilePost::isLiked($_SESSION['user_id'], $row['postId'])) {
        $liked = "fa-solid fa-heart";
    }

// Reassign sorted array to posts
    $postHTML = '<div class="col-lg-3 col-sm-12" id="' . $row['postId'] . '">';
    $postHTML .= '<div class="card bg-dark border border-success mx-2 my-2 post-card">';
    $postHTML .= '<img class="card-img-top" style="object-fit: cover; object-position: center;height: 75%;" src="' . $row['imagePath'] . '" alt="Card image cap">';
    $postHTML .= '<div class="card-body" style="height: calc(20% - 1rem);">';
    $postHTML .= '<p class="card-text">' . $row['description'] . '</p>';
    $postHTML .= '</div>';
    $postHTML .= '<div class="like-comment-container">';
    $postHTML .= '<p class="like-comment">';
    $postHTML .= '<span><i class="' . $liked . '"></i> <span class="likes-count" style="font-size: medium">' . $row['likes'] . '</span></span>';
    $postHTML .= '<span><i class="fa-regular fa-comment postSelector"></i></span>';
    $postHTML .= '</p>';
    $timeOfPost = DateTime::createFromFormat('Y-m-d H:i:s', $row['timeOfPost']);
    $postHTML .= '<i class="post-card-date">' . $timeOfPost->format('Y-m-d h:i A') . '</i>';
    $postHTML .= '</div>';
    $postHTML .= '</div>';
    $postHTML .= '</div>';
    $finalString .= $postHTML;
}
echo $finalString;
?>
