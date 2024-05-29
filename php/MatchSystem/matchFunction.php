<?php
include_once '../dbconfig.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

try {
    $conn = DbConn::instanceOfDb()->getConnection();

    $userName = $_POST['userName'];
    $likedUserName = $_POST['liked_userName'];

    // Insert the like into the database
    $sql = "INSERT INTO user_likes (userName, liked_userName) VALUES (:userName, :likedUserName) 
            ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':likedUserName', $likedUserName);
    $stmt->execute();

    // Check for mutual like
    $sql = "SELECT * FROM user_likes WHERE userName = :likedUserName AND liked_userName = :userName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':likedUserName', $likedUserName);
    $stmt->bindParam(':userName', $userName);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $response = ['status' => 'success', 'message' => 'Mutual like found'];
    } else {
        $response = ['status' => 'success', 'message' => 'Like added but no mutual like found'];
    }
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);
?>
