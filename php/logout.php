<?php
session_start();

$_SESSION = array();

session_destroy();

header("Location: /cosmovenus/views/Login_Register/loginForm.html");
exit;