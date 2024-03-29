<?php

    $hostname="localhost";
    $user ="root";
    $password="1234";
    $dbname="cosmo";


    
try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname;charset=utf8mb4", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully <br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}


?>