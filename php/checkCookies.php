<?php
require ("../php/dbconfig.php");



function validateToken($token): bool
{

    $db =DbConn::instanceOfDb();
    $conn =$db->getConnection();

    $stmt = $conn->prepare("SELECT count(rememberMeToken) as token_count FROM users WHERE rememberMeToken = :rememberMeToken");
    $stmt->bindParam("rememberMeToken", $token);
    $stmt->execute();
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if($userInfo['token_count'] ===0){
        return false;
    } else {
        return true;
    }
}

 function setTokenNull($token){
    $db =DbConn::instanceOfDb();
    $conn =$db->getConnection();
    $stmt = $conn->prepare("UPDATE users SET rememberMeToken=NULL WHERE rememberMeToken = :rememberMeToken");
    $stmt->bindParam("rememberMeToken", $token);
    $stmt->execute();
}


function checkOnline($username): bool
{
    if($username !== NULL) {
        $db = DbConn::instanceOfDb();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT count(rememberMeToken) AS userOnline FROM users WHERE username = :username");
        $stmt->bindParam("username", $username);
        $stmt->execute();
        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userInfo['userOnline'] === 1) {
            return true;
        } else {
            return false;
        }
    }else{
        return true;
    }

}



if(isset($_COOKIE["rememberMeToken"])){
    $token = $_COOKIE["rememberMeToken"];

    if(!validateToken($token)){
        setTokenNull($token);
        setcookie("rememberMeToken", "", time() - 3600,"/");
        header('Location: ./Login_Register/LoginForm.html');
        exit();
    }
}else{
    setTokenNull($_COOKIE["rememberMeToken"]);
    header("Location: ../php/logout.php");
}