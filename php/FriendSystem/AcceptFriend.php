<?php
session_start();
include_once '../dbconfig.php';

$userName = $_SESSION['user_id'];
$friendName = htmlspecialchars(trim($_POST['friend_username']));

$pdo = DbConn::instanceOfDb()->getConnection();

// Retrieve user_id based on username
$userSql = "SELECT id FROM users WHERE username = ?";
$userStmt = $pdo->prepare($userSql);
$userStmt->execute([$userName]);
$userId = $userStmt->fetchColumn();

// Retrieve friend_id based on friend_username
$friendSql = "SELECT id FROM users WHERE username = ?";
$friendStmt = $pdo->prepare($friendSql);
$friendStmt->execute([$friendName]);
$friendId = $friendStmt->fetchColumn();

if ($userId && $friendId) {
    $sql = "UPDATE friends SET status = 'accepted', accepted_at = NOW() WHERE user_id = ? AND friend_id = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$friendId, $userId])) {
        echo json_encode(['status' => 'success', 'message' => 'Friend request accepted.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to accept friend request.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User or friend not found.']);
}
?>
