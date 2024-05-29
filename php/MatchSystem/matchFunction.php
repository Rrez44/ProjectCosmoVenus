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

    return $count > 1 ? 'matched' : 'not matched'; // Ensuring both likes exist
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Start output buffering
ob_start();

$response = [];

try {
    $conn = DbConn::instanceOfDb()->getConnection();

    $userName = $_POST['userName'];
    $likedUserName = $_POST['liked_userName'];

    // Insert or update the like
    $sql = "INSERT INTO user_likes (userName, liked_userName) VALUES (:userName, :likedUserName) 
            ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':likedUserName', $likedUserName);
    $stmt->execute();

    // Check for mutual like using the checkMatchStatus function
    $status = checkMatchStatus($userName, $likedUserName);

    if ($status === 'matched') {
        // Fetch email addresses (assuming you have an email field in your users table)
        $sql = "SELECT email FROM users WHERE userName = :userName OR userName = :likedUserName";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':likedUserName', $likedUserName);
        $stmt->execute();
        $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($emails) >= 2) {
            $userEmail = $emails[0]['email'];
            $likedUserEmail = $emails[1]['email'];

            $subject = "Mutual Like Notification";
            $message = "Congratulations! You and $likedUserName have liked each other.";
            $headers = "From: no-reply@cosmovenus.com";

            mail($userEmail, $subject, $message, $headers);
            mail($likedUserEmail, $subject, $message, $headers);

            $response = ['status' => 'success', 'message' => 'Mutual like found and emails sent'];
        } else {
            $response = ['status' => 'error', 'message' => 'Email addresses not found'];
        }
    } else {
        $response = ['status' => 'success', 'message' => 'Like added but no mutual like found'];
    }
} catch (Exception $e) {
    $response = ['status' => 'error', 'message' => $e->getMessage()];
}

// Get the contents of the output buffer and clean the buffer
ob_end_clean();

// Output the JSON response
echo json_encode($response);
?>
