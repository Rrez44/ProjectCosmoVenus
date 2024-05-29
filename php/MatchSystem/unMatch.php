<?php
include_once '../dbconfig.php';

$conn = DbConn::instanceOfDb()->getConnection();

$userName = $_POST['userName'];
$unlikedUserName = $_POST['unliked_userName'];

header('Content-Type: application/json');

try {
    $conn->beginTransaction();

    // First deletion
    $sql = "DELETE FROM user_likes WHERE userName = :userName AND liked_userName = :unlikedUserName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':unlikedUserName', $unlikedUserName);
    $stmt->execute();

    // Second deletion
    $sql = "DELETE FROM user_likes WHERE userName = :unlikedUserName AND liked_userName = :userName";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':unlikedUserName', $unlikedUserName);
    $stmt->bindParam(':userName', $userName);
    $stmt->execute();

    $conn->commit();

    $response = ['status' => 'success', 'message' => 'Match deleted'];
} catch (Exception $e) {
    $conn->rollBack();
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

echo json_encode($response);

$conn = null;
?>
