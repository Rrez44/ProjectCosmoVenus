<?php
session_start();
include_once '../dbconfig.php';

// Set content type to JSON and disable error reporting to avoid any unwanted output
header('Content-Type: application/json');

$userName = $_SESSION['user_id'];
$friendName = htmlspecialchars(trim($_POST['friend_username']));

try {
    $pdo = DbConn::instanceOfDb()->getConnection();

    // Retrieve user_id based on username
    $userSql = "SELECT id FROM users WHERE username = ?";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->execute([$userName]);
    $userId = $userStmt->fetchColumn();

    // Debugging: Print the user ID
    if ($userId === false) {
        echo json_encode(['status' => 'error', 'message' => 'User not found.', 'debug' => $userName]);
        exit;
    }

    // Retrieve friend_id based on friend_username
    $friendSql = "SELECT id FROM users WHERE username = ?";
    $friendStmt = $pdo->prepare($friendSql);
    $friendStmt->execute([$friendName]);
    $friendId = $friendStmt->fetchColumn();

    // Debugging: Print the friend ID
    if ($friendId === false) {
        echo json_encode(['status' => 'error', 'message' => 'Friend not found.', 'debug' => $friendName]);
        exit;
    }

    if ($userId && $friendId) {
        $sql = "DELETE FROM friends WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$userId, $friendId, $friendId, $userId])) {
            echo json_encode(['status' => 'success', 'message' => 'Friend removed successfully.']);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove friend.', 'error' => $errorInfo[2]]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User or friend not found.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.', 'error' => $e->getMessage()]);
}
?>
