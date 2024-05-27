<?php
session_start();
require '../dbconfig.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $friendUsername = htmlspecialchars(trim($_POST['friend_username']));

    $pdo = DbConn::instanceOfDb()->getConnection();

    $userSql = "SELECT id FROM users WHERE username = ?";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->execute([$username]);
    $userId = $userStmt->fetchColumn();

    $friendSql = "SELECT id FROM users WHERE userName = ?";
    $friendStmt = $pdo->prepare($friendSql);
    $friendStmt->execute([$friendUsername]);
    $friendId = $friendStmt->fetchColumn();

    if ($userId && $friendId) {
        $sql = "INSERT INTO friends (user_id, friend_id, status, requested_at) VALUES (?, ?, 'pending', NOW())";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$userId, $friendId])) {
            echo 'Friend request sent successfully.';
        } else {
            echo 'Failed to send friend request.';
        }
    } else {
        echo 'User or friend not found: ' . $username ."->" .  $friendUsername;
    }
} else {
    echo 'Invalid request method.';
}
?>
