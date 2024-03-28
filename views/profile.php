
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
        </div> 
        <!-- NAVEND -->
        <!-- PROFILE COMPONENT STARTS HERE -->
        <div class="row justify-content-center">
            <div class="col-lg-3 d-flex justify-content-center">
                <div class="profile-component">
                    <div class="card-container border border-success">
                        <img class="img-fluid round" src="https://pics.craiyon.com/2023-06-20/89f79a8dee744596981e7417b8a7ea1d.webp" alt="user" />
                        <h3>Rrezon Beqiri</h3>
                        <h6>FIEK</h6>
                        <p>Left my inhibitions i guess where my supervision was</p>
                        <div class="buttons">
                            <button class="primary" disabled>
                                Message
                            </button>
                            <button class="primary ghost" disabled>
                                Request Friend
                            </button>
                        </div>
                        <div class="skills">
                            <h6>Hobbies</h6>
                            <ul>
                                <li>UI / UX</li>
                                <li>Front End Development</li>
                                <li>HTML</li>
                                <li>CSS</li>
                                <li>JavaScript</li>
                                <li>React</li>
                                <li>Node</li>
                                <li>UI / UX</li>
                                <li>Front End Development</li>
                                <li>HTML</li>
                                <li>CSS</li>
                                <li>JavaScript</li>
                                <li>React</li>
                                <li>Node</li>
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
                          <h5 class="card-title">@rrez44</h5>
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
          <button class="btn btn-success " data-toggle="modal" data-target="#addPost">Add post <i class="fa-solid fa-plus" ></i></button>
        </div>
        <div class="p-2">
          <button class="btn btn-success">Friend List <i class="fa-solid fa-user-group"></i></button>
        </div>
        <div class="p-2">
          <button class="btn btn-success">Share <i class="fa-solid fa-share"></i></button>
        </div>
      </div>
    </div>
    

    <div class="container-fluid" >
      <div class="row d-flex justify-content-start mx-4 post-container" id="postContainer">
      </div>
    </div>
        
    </div>
  </div>

  <div class="modal fade bg-dark" id="addPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Post</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../php/addPost.php" method="post" enctype="multipart/form-data">
          <div class="row"> 
          <div class="col custom-file">
            <input type="file" class="custom-file-input" id="customFile" name="postImage" >
          </div>
          </div>
          <div class="row">
          <div class="col">
            <br>
            <input type="text" class="form-control" placeholder="Description" name="description">
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success">Add Post</button>
            </div>
        </form>
      </div>

    </div>
  </div>
</div>





    <!-- LOG OUT -->
    <script>
        $(document).ready(function() {
            $("#logOut").click(function(e) {
                e.preventDefault()
                $.ajax({
                    type: "POST",
                    url: "../php/logout.php",
                    success: function(response) {
                      window.location.href = '/cosmovenus/views/Login_Register/loginForm.html';
                    }

                });
            });
        });
    </script>

    <!--    load posts-->
    <script>
        $(document).ready(function() {
            // Function to load posts
            function loadPosts() {
                $.ajax({
                    type: "GET",
                    url: "../php/loadPosts.php",
                    success: function(response) {
                        $('#postContainer').append(response);
                        
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            loadPosts();
        });
    </script>

<!--    ADD LIKE AND REMOVE LIKE-->
    <script>
      $(document).ready(function() {
    $(document).on('click', '.fa-regular.fa-heart', function() {
        var postId = $(this).closest('.col-lg-3').attr('id');
        var likesCountElement = $(this).siblings('.likes-count');
        
        var currentLikes = parseInt(likesCountElement.text());
        likesCountElement.text(currentLikes + 1);

        $(this).removeClass('fa-regular').addClass('fa-solid');

        $.ajax({
            type: "POST",
            url: "../php/likePost.php",
            data: { postId: postId },
            success: function(response) {
            },
            error: function(xhr, status, error) {
                likesCountElement.text(currentLikes);
                $(this).removeClass('fa-solid').addClass('fa-regular');
                console.error(xhr.responseText);
            }
        });
    });
});
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.fa-solid.fa-heart', function() {
                // Store the reference to the clicked element for use in callbacks
                var clickedElement = $(this);
                var postId = clickedElement.closest('.col-lg-3').attr('id');
                var likesCountElement = clickedElement.siblings('.likes-count');
                var currentLikes = parseInt(likesCountElement.text());

                // Make the AJAX call to attempt to unlike the post
                $.ajax({
                    type: "POST",
                    url: "../php/unlikePost.php",
                    data: { postId: postId },
                    success: function(response) {
                        // On success, update the UI to reflect the unlike action
                        likesCountElement.text(currentLikes - 1); // Update likes count
                        clickedElement.removeClass('fa-solid').addClass('fa-regular'); // Change the icon
                    },
                    error: function(xhr, status, error) {
                        // On error, alert the user and do not change the UI
                        alert('Failed to unlike the post. Please try again.');
                        console.error("Error responseText:", xhr.responseText);
                    }
                });
            });
        });

    </script>

</body>
</html>
