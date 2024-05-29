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
    <title>Profile</title>
    <link rel="stylesheet" href="../css/nav.css">
    
    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/profilePictureComponent.css">
</head>
<body>
    <div class="container-fluid">
      <?php
        require_once("../html/navbar.php")
      ?>
        <!-- <div class="row g-0"> 
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
                  <li class="nav-item dropdown" >
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Profile
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Visit Profile</a>
                    <a class="dropdown-item" href="Login_Register/loginForm.html" id="logOut">Log Out</a>
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
        </div>  -->
        <!-- NAVEND -->
        <!-- PROFILE COMPONENT STARTS HERE -->
        <div class="row justify-content-center">
            <div class="col-lg-3 d-flex justify-content-center">
                <div class="profile-component">
                    <div class="card-container border border-success">

                    <?php
                        //  session_start();
                         $registered = $_SESSION["user_id"];
                         
                         $db = new mysqli("localhost", "root", "1234", "cosmo");
                         
                         $stmt = $db->prepare("SELECT profpicture, profileName, faculty, aboutMe FROM usersDisplayInfo WHERE username = ?");
                         
                         $stmt->bind_param("s", $registered);
                         
                         $stmt->execute();
                         
                        $stmt->bind_result($profpicture, $profileName, $faculty, $aboutMe);
                         while ($stmt->fetch()) {
                             echo "<img src='$profpicture' class='img-fluid round' alt='Profile Picture'>";
                             echo "<h3>$profileName</h3>";
                             echo "<h6>$faculty</h6>";
                             echo "<p>$aboutMe</p>";
                         }


                        ?>
                       <div class="buttons">
                            <button class="primary">
                                Message
                            </button>
                            <button class="primary ghost">
                                Friends
                            </button>
                        </div>
                        <div class="skills">
                            <h6>Hobbies</h6>
                             <ul>
                              <?php
                                $registered = $_SESSION["user_id"];
                                $db = new mysqli("localhost","root","1234","cosmo");
                                $sql = "select * from hobbies where username ='$registered' ";
                                $result = $db->query($sql);
                                if($result ->num_rows >0){
                                  while($row =$result->fetch_assoc()){
                                    echo "<li> {$row['hoby_name']} </li>";
                                  }
                                }    
                              ?>
                              </ul> 
                        </div>
                    </div>
                  </div>
              </div>
        <div class="col-lg-8">
            <div class="jumbotron jumbotron-fluid d-flex justify-content-center align-items-center">
                <div class="container-fluid">
                    <div class="card mb-3 bg-dark border-success jumbo-container">
                        <img class="card-img-top" style="border-radius: 5% 5% 0px 0px; max-height: 200px; object-fit: cover;" src="https://wallpapers.com/images/hd/ultrawide-4k-u69bk8p5x2no56dj.jpg" alt="Card image cap">
                        <div class="card-body">
                        <?php

                              $registered ='@'. $_SESSION["user_id"];
                                echo "<h5 class='card-title'>$registered </h5>";
                              ?>
                              <hr>
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-3 col-md-3 col-sm-6 small-screen-query d-flex justify-content-center">
                                    <div class="card bg-dark stat-card" >
                                        <img class="card-img-top" src="../images/profileIcons/support.png" alt="Card image cap">
                                        <hr>
                                        <div class="card-body">
                                          <p class="card-text">Friends</p>
                                          <p class="card-text">432</p>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 small-screen-query d-flex justify-content-center">
                                    <div class="card bg-dark stat-card " >
                                        <img class="card-img-top" src="../images/profileIcons/anonymous.png" alt="Card image cap">
                                        <hr>
                                        <div class="card-body">
                                          <p class="card-text">Secret Admirers</p>
                                          <p class="card-text">4</p>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 small-screen-query d-flex justify-content-center">
                                    <div class="card bg-dark stat-card"> 
                                        <img class="card-img-top" src="../images/profileIcons/matches.png" alt="Card image cap">
                                        <hr>
                                        <div class="card-body">
                                          <p class="card-text">Matches</p>
                                          <p class="card-text">1</p>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 small-screen-query d-flex justify-content-center">
                                    <div class="card bg-dark stat-card" >
                                        <img class="card-img-top" src="../images/profileIcons/fire.png" alt="Card image cap">
                                        <hr>
                                        <div class="card-body">
                                          <p class="card-text">Profile Visits</p>
                                          <p class="card-text">1542</p>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
              </div>
        </div>
    </div>
    <div class="container-fluid">
      <div class="d-flex flex-wrap justify-content-start mx-5 my-3 button-list">
        <div class="p-2">
          <button class="btn btn-success">Add post <i class="fa-solid fa-plus"></i></button>
        </div>
        <div class="p-2">
          <button class="btn btn-success">Friend List <i class="fa-solid fa-user-group"></i></button>
        </div>
        <div class="p-2">
          <button class="btn btn-success">Share <i class="fa-solid fa-share"></i></button>
        </div>
        <div class="p-2">
         <button id="setupProfileBtn" class="btn btn-success">Set Up Profile</button>
        </div>
      </div>
    </div>
    

    <div class="container-fluid" >
      <div class="row d-flex justify-content-start mx-4">
        <div class="col-lg-3 col-sm-12">
        <div class="card bg-dark border border-success mx-2 my-2 post-card">
          <img class="card-img-top" src="https://getwallpapers.com/wallpaper/full/0/d/1/1476845-studio-ghibli-wallpaper-hd-2560x1440-windows-xp.jpg" alt="Card image cap">
          <div class="card-body">
            <p class="card-text">Howls moving castle</p>
          </div>
          <div class="like-comment-container">
            <p class="like-comment">
              <span><i class="fa-regular fa-heart"></i></span>
              <span><i class="fa-regular fa-comment"></i></span>
            </p>
            <i class="post-card-date">2024-18-3</i>
          </div>
        </div>
        </div>
        <div class="col-lg-3 col-sm-12">
        <div class="card bg-dark border border-success mx-2 my-2 post-card">
          <img class="card-img-top " src="https://cdn.vox-cdn.com/thumbor/U6grOQo6DmyIi3pm-VqyR1aU-JE=/0x0:510x351/2000x1333/filters:focal(231x153:232x154)/cdn.vox-cdn.com/uploads/chorus_asset/file/4029766/yoda.0.jpg" alt="Card image cap">
          <div class="card-body">
            <p class="card-text">One with the force you must be</p>
          </div>
          <div class="like-comment-container">
            <p class="like-comment">
              <span><i class="fa-regular fa-heart"></i></span>
              <span><i class="fa-regular fa-comment"></i></span>
            </p>
            <i class="post-card-date">2024-18-3</i>
          </div>
        </div>
        </div>
        <div class="col-lg-3 col-sm-12">
        <div class="card bg-dark border border-success mx-2 my-2 post-card">
          <img class="card-img-top " src="https://images8.alphacoders.com/131/1314205.jpeg">
          <div class="card-body">
            <p class="card-text">Zendaya is hot</p>
          </div>
          <div class="like-comment-container">
            <p class="like-comment">
              <span><i class="fa-regular fa-heart"></i></span>
              <span><i class="fa-regular fa-comment"></i></span>
            </p>
            <i class="post-card-date">2024-18-3</i>
          </div>
        </div>
        </div>
        <div class="col-lg-3 col-sm-12">
        <div class="card bg-dark border border-success mx-2 my-2 post-card">
          <img class="card-img-top" src="https://hips.hearstapps.com/hmg-prod/images/jean-luc-picard-63ffd4e72a432.jpg?crop=0.7509765625xw:1xh;center,top&resize=1200:*" alt="Card image cap">
          <div class="card-body">
            <p class="card-text">Captain Picard idolo</p>
          </div>
          <div class="like-comment-container">
            <p class="like-comment">
              <span><i class="fa-regular fa-heart"></i></span>
              <span><i class="fa-regular fa-comment"></i></span>
            </p>
            <i class="post-card-date">2024-18-3</i>
          </div>
        </div>
        </div>
      </div>
    </div>

       
        
      </div>
    </div>
  </div>

    <!-- LOG OUT -->
    <script>
      
      $("#setupProfileBtn").click(function(e) {
            e.preventDefault(); 
      window.location.href = '../html/SetUpProfile/setupprofile.php'; 
            });

        $(document).ready(function() {
            $("#logOut").click(function(e) {
                e.preventDefault()
                $.ajax({
                    type: "POST",
                    url: "../php/logout.php",
                    success: function(response) {
                      window.location.href = '/ProjectCosmoVenus/html/Login_Register/loginForm.html';
                    }

                });
            });
        });


    </script>
</body>
</html>
