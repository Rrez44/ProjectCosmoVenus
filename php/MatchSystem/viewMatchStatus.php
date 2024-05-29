<?php
include_once '../dbconfig.php';

function checkMatchStatus($userName, $friendUserName) {
    $conn = DbConn::instanceOfDb()->getConnection();

    $sql = "SELECT COUNT(*) FROM user_likes WHERE (userName = :userName AND liked_userName = :friendUserName) 
            OR (userName = :friendUserName AND liked_userName = :userName)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':friendUserName', $friendUserName);

    $stmt->execute();

    $count = $stmt->fetchColumn();

    $conn = null;

    return $count > 0 ? 'matched' : 'not matched';
}

$userName = $_POST['userName'];
$friendUserName = $_POST['friendUserName'];

$status = checkMatchStatus($userName, $friendUserName);

echo json_encode(['status' => $status]);
?>
