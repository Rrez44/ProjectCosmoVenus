<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /cosmovenus/views/Login_Register/loginForm.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message</title>
    <link rel="stylesheet" href="../css/nav.css">
    
    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/message.css">
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
        <div class="conatiner-fluid">
            <div class="row d-flex justify-content-center">
            <div class="card text-center bg-dark friend-navigation border border-success">
                <div class="card-header">
                  <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" href="#">Recent</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Online</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">All friends</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <h5 class="card-title" id="card-title">Recent Messages</h5>
                  <div class="container-fluid">
                    <!-- beginning of friend component -->
                    <div class="row">
                        <div class="col d-flex justify-content-start align-items-center friend-component">
                            <div class="col-2 d-flex align-items-center">
                                <img class="img-fluid round" src="https://pics.craiyon.com/2023-06-20/89f79a8dee744596981e7417b8a7ea1d.webp" alt="friend image">
                                <p class="friend-name">@rrez44</p>
                            </div>
                            <div class="col-6 d-flex justify-content-center mx-3">
                                <p class="last-seen"><i>11:22 3/18/2024</i></p>
                            </div>
                            <div class="right-content"></div>
                            <button class="btn btn-success profile-button" href="../html/profile.html"><i class="fa-regular fa-user"></i></button>
                            <button class="btn btn-success message-button">Message <i class="fa-regular fa-message"></i></button>
                        </div>
                    </div>
                    <hr>
                    <!-- end of friend component  -->
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</body>
<script>
$(document).ready(() => {
    $(".card-header .nav-tabs .nav-link").click(function(event) {
        event.preventDefault(); 
        $(".card-header .nav-tabs .nav-link").removeClass('active');
        $(this).addClass('active');
        if($(this).html() == "Online"){
            $("#card-title").html("Online")
        }
        else if($(this).html() == "Recent"){
            $("#card-title").html("Recent")
        }
        else if($(this).html() == "All friends"){
            $("#card-title").html("All Friends")
        }
    });
});
</script>
</html>