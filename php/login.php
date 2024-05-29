<?php
include_once 'dbconfig.php';
include_once 'User.php';
//require_once "PHPTables.php";

$userName = trim(htmlspecialchars($_POST['userName']));
$password = trim(htmlspecialchars($_POST['password']));

User::login($userName,$password);

