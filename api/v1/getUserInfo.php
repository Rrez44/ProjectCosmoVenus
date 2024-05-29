<?php
require_once('../../php/dbconfig.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

try {
    $db = DbConn::instanceOfDb();
    $conn = $db->getConnection();

    $stmt = $conn->query("SELECT id, firstName, lastName, userName, email, dateOfBirth, Admin FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$users) {
        echo json_encode(['error' => 'No users found']);
        exit;
    }

    $allUsersInfo = [];

    foreach ($users as $user) {
        $stmt = $conn->prepare("SELECT profileName, faculty, aboutMe, profilePicture, bannerPicture FROM usersdisplayinfo WHERE userName = ?");
        $stmt->execute([$user['userName']]);
        $displayInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT hobbyName FROM hobbies WHERE userName = ?");
        $stmt->execute([$user['userName']]);
        $hobbies = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $userInfo = [
            'id' => $user['id'],
            'firstName' => $user['firstName'],
            'lastName' => $user['lastName'],
            'userName' => $user['userName'],
            'email' => $user['email'],
            'dateOfBirth' => $user['dateOfBirth'],
            'admin' => $user['Admin'],
            'profileName' => $displayInfo['profileName'],
            'faculty' => $displayInfo['faculty'],
            'aboutMe' => $displayInfo['aboutMe'],
            'profilePicture' => $displayInfo['profilePicture'],
            'bannerPicture' => $displayInfo['bannerPicture'],
            'hobbies' => $hobbies
        ];

        $allUsersInfo[] = $userInfo;
    }

    echo json_encode($allUsersInfo);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
