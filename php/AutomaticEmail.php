<?php


function sendMail($to) {


    $msg = "HELL WORLD";

    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set("SMTP", "ssl://smtp.gmail.com");
    ini_set("smtp_port", 587);
    $headers = 'From: sender@example.com';

    $message = '
<html>
<head>
  <title>Beautiful Email</title>
</head>
<body>
<html>
<head>
  <title>Welcome to CosmoVenus!</title>
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px;">
  <h1 style="color: #333; text-align: center">Welcome to CosmoVenus!</h1>
  <div style="text-align: center;">
     <img  style="width: 300px;height: 300px;text-align: center;align-content: center" src="https://cdn-images-1.medium.com/v2/resize:fit:1200/1*tmUgLzUAymI9eHLJuYxLWA.png" alt="Example Image">
</div>
    <hr>
  <p>Dear User,</p>
  <p>We are excited to welcome you to CosmoVenus, your new favorite social media platform!</p>
  <p>With CosmoVenus, you can:</p>
  <ul>
    <li>Connect with friends, family, and new acquaintances</li>
    <li>Share your photos, thoughts, and experiences</li>
    <li>Discover trending topics, news, and entertainment</li>
    <li>Join communities based on your interests and passions</li>
  </ul>
  <p>If you have any questions or need assistance, feel free to contact our support team.</p>
  <p>We hope you enjoy your CosmoVenus experience!</p>
  <p>Best regards,<br>Your CosmoVenus Team</p>
</body>
</html>
';

// Set headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: cosmovenussystem@example.com' . "\r\n";

    if (mail($to, "New Message From cosmovenus", "$message", $headers)) {
        echo "true";
    } else {
        echo "false";


    }
}




