<?php
session_start();
require '../dbconfig.php'; // Ensure you include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $friendUsername = htmlspecialchars(trim($_POST['friend_username']));

    $pdo = DbConn::instanceOfDb()->getConnection();

    // Retrieve user_id based on username
    $userSql = "SELECT id, username FROM users WHERE username = ?";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->execute([$username]);
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);
    $userId = $user['id'];

    // Retrieve friend_id based on friend_username
    $friendSql = "SELECT id, username FROM users WHERE username = ?";
    $friendStmt = $pdo->prepare($friendSql);
    $friendStmt->execute([$friendUsername]);
    $friend = $friendStmt->fetch(PDO::FETCH_ASSOC);
    $friendId = $friend['id'];

    if ($userId && $friendId) {
        // Check friendship status and retrieve sender's and receiver's usernames
        $statusSql = "
            SELECT f.status, u1.username AS sender_username, u2.username AS receiver_username 
            FROM friends f
            JOIN users u1 ON f.user_id = u1.id
            JOIN users u2 ON f.friend_id = u2.id
            WHERE (f.user_id = ? AND f.friend_id = ?) OR (f.user_id = ? AND f.friend_id = ?)";
        $statusStmt = $pdo->prepare($statusSql);
        $statusStmt->execute([$userId, $friendId, $friendId, $userId]);
        $friendship = $statusStmt->fetch(PDO::FETCH_ASSOC);

        if ($friendship) {
            echo json_encode($friendship);
        } else {
            echo json_encode(['status' => 'none']);
        }
    } else {
        echo json_encode(['status' => 'not_found']);
    }
} else {
    echo json_encode(['status' => 'invalid_request']);
}
?>
