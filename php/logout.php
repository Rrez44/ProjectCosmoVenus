<?php
require_once "dbconfig.php";
session_start();


setTokenNull($_COOKIE["rememberMeToken"]);
setcookie("rememberMeToken", "", time() - 3600,"/");
session_regenerate_id();
$_SESSION = array();
session_destroy();

function setTokenNull($token){
    $db =DbConn::instanceOfDb();
    $conn =$db->getConnection();
    $stmt = $conn->prepare("UPDATE users SET rememberMeToken=NULL WHERE rememberMeToken = :rememberMeToken");
    $stmt->bindParam("rememberMeToken", $token);
    $stmt->execute();

}




header("Location: ../views/Login_Register/loginForm.html");





exit;