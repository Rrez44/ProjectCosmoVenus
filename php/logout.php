<?php
session_start();

$_SESSION = array();

session_destroy();

//Rrezon nese nuk t bon logout e kom ndrru path um vyjke
// header("Location: /cosmovenus/views/Login_Register/loginForm.html");
header("Location: /ProjectCosmoVenus/html/Login_Register/loginForm.html");
exit;