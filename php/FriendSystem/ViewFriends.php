<?php

include_once '../dbconfig.php';

session_start();
$username =$_SESSION['user_id'];

try {
    $pdo = DbConn::instanceOfDb()->getConnection();

    $userIdQuery = "SELECT id FROM users WHERE username = ?";
    $userIdStmt = $pdo->prepare($userIdQuery);
    $userIdStmt->execute([$username]);
    $userIdResult = $userIdStmt->fetch(PDO::FETCH_ASSOC);

    if ($userIdResult) {
        $userId = $userIdResult['id'];

        $sql = "SELECT u.id, u.firstName, u.lastName, u.username, u.rememberMeToken, udi.profilePicture, f.accepted_at
                FROM users u
                JOIN friends f ON (u.id = f.friend_id OR u.id = f.user_id)
                JOIN usersDisplayInfo udi ON u.username = udi.userName
                WHERE (f.user_id = ? OR f.friend_id = ?) AND f.status = 'accepted' AND u.id != ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $userId, $userId]);

        $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("User ID: " . $userId);
        error_log("Query: " . $stmt->queryString);
        error_log("Friends: " . print_r($friends, true));

        echo json_encode($friends);
    } else {
        echo json_encode(['error' => 'User not found']);
    }
} catch (PDOException $e) {
    // Return the error message as a JSON response
    echo json_encode(['error' => $e->getMessage()]);
}
?>
