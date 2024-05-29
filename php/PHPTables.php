<?php

require_once "dbconfig.php";

function createUsersDisplayInfoTable($pdo)
{
    $sql = "CREATE TABLE IF NOT EXISTS usersDisplayInfo (
        userName VARCHAR(50) PRIMARY KEY,
        profileName VARCHAR(30),
        faculty VARCHAR(10),
        aboutMe VARCHAR(100),
        profilePicture VARCHAR(200),
        bannerPicture VARCHAR(200),
        FOREIGN KEY (userName) REFERENCES users(userName)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    try {
        $pdo->exec($sql);
        echo "Tabela usersDisplayInfo u krijua me sukses.";
    } catch (PDOException $e) {
        echo "Gabim gjatë krijimit të tabelës: " . $e->getMessage();
    }
}

$db=DbConn::instanceOfDb();
$conn =$db->getConnection();


createUsersDisplayInfoTable($conn);
