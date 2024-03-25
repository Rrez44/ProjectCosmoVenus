<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /cosmovenus/views/Login_Register/loginForm.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Message</title>
    <link rel="stylesheet" href="../css/nav.css">
    
    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/directMessage.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0"> <!--  NAVBAR START  -->
            <div class="container-fluid">
            <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
                <a class="navbar-brand" style="margin-left: 15px;" href="#">CosmoVenus</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation" style="margin-right: 15px;">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                  <ul class="navbar-nav mr-auto ">
                    <li class="nav-item active">
                      <a class="nav-link mx-2" href="/message.html">Message <i class="fa-regular fa-message"></i><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item mx-2">
                      <a class="nav-link" href="profile.php">Profile <i class="fa-regular fa-user"></i></a>
                    </li>
                    <li class="nav-item mx-2">
                      <a class="nav-link" href="#">Wink Back <i class="fa-regular fa-face-smile-wink"></i></i></a>
                    </li>
                  </ul>
                  <form class="form-inline ms-auto search-form" style="margin-right: 15px;">
                    <div class="input-group">
                    <div class="input-group-prepend" >
                        <span class="input-group-text" id="basic-addon1" style="border-radius: 5px 0px 0px 5px;">@</span>
                    </div>
                    <input class="form-control mr-sm-2" type="search" placeholder="Search Username" aria-label="Search">
                    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                </div>
                  </form>
                </div>
              </nav>
            </div>
        </div> 
        <!-- NAVEND -->
        <div class="row d-flex justify-content-center">

            <div class="jumbotron direct-message-component border border-success bg-dark container-fluid">
            <!-- BEGINNING OF TOP DIV -->
                <div class="row mx-1">
                    <div class="friend-user d-flex flex-row">
                        <img src="https://pics.craiyon.com/2023-06-20/89f79a8dee744596981e7417b8a7ea1d.webp" alt="friend-profile-picture" class="img-fluid round">
                        <p class="friend-name">@rrez44</p>
                        <p class="direct-message-p">Direct Message</p>
                    </div>
                </div>
            <!-- END OF TOP DIV -->
                <hr class="my-2">
                <!-- MESSAGES -->
                <div class="container-fluid messages mx-1">
                    <div class="row">
                      <div class="message-left"><p class="message-text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-left"><i>7:22 3/19/2024</i></p></div>
                      <div class="message-right"><p class="message-text-right">why??<p class="date-time-message-right"><i>7:22AM 3/19/2024</i></p></p></div>
                      <div class="message-left"><p class="message-text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-left"><i>7:22 3/19/2024</i></p></div>
                      <div class="message-left"><p class="message-text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-left"><i>7:22 3/19/2024</i></p></div>
                      <div class="message-left"><p class="message-text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-left"><i>7:22 3/19/2024</i></p></div>
                      <div class="message-left"><p class="message-text-left">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-left"><i>7:22AM 3/19/2024</i></p></div>
                      <div class="message-left"><p class="message-text-right">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam quia totam vel ut, amet aperiam beatae iusto consequuntur deleniti sint officia. Laudantium, doloribus quas! Molestias vitae sunt et dicta cupiditate.</p><p class="date-time-message-right"><i>7:25PM 3/19/2024</i></p></div>
                    </div>
                </div>
                <!-- END OF MESSAGES -->
                <hr class="my-1">
                <div class="row mx-1">
                    <form class="form-inline d-flex my-2 justify-content-center">
                        <label class="sr-only" for="inlineFormInputName2">Name</label>
                        <input type="text" class="form-control mb-2 mr-sm-2 send-message" id="inlineFormInputName2" placeholder="CosmoVenus">
                        <button type="submit" class="btn btn-success mb-2 submit-button">Send <i class="fa-regular fa-paper-plane"></i></button>
                    </form>
                </div>
              </div>
        </div>
    </div>
</body>
</html>