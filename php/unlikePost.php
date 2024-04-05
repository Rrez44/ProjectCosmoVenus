<?php
include_once 'dbconfig.php';


//global $conn;
$db = DbConn::instanceOfDb();

$conn=$db->getConnection();
session_start();
$liker = $_SESSION['user_id'];
$postId = trim(htmlspecialchars($_POST['postId']));

$stmnt = $conn->prepare("DELETE FROM postLikes where postId = :postId and liker= :liker");
$stmnt->bindParam(":postId",$postId );
$stmnt->bindParam(":liker",$liker );
$stmnt->execute();

