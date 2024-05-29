<!--global$conn;-->
<?php
//    require ("../php/dbconfig.php");
//
session_start();
////var_dump($_COOKIE['user_logged_id']);
//
//
//
//    if(isset($_COOKIE["rememberMeToken"])){
//        $token = $_COOKIE["rememberMeToken"];
//        var_dump($token);
//        if(!validateToken($token)){
//            setcookie("rememberMeToken", "", time() - 3600,"/");
//            header('Location: ./Login_Register/LoginForm.html');
//            exit();
//        }
//    }else{
//        header("Location: ../php/logout.php");
//    }
//
//    function validateToken($token): bool
//    {
//
//        $db =DbConn::instanceOfDb();
//        $conn =$db->getConnection();
//
//
//        $stmt = $conn->prepare("SELECT count(rememberMeToken) as token_count FROM users WHERE rememberMeToken = ?");
//        $stmt->execute([$token]);
//        $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
//
//        if($userInfo['token_count'] ===0){
//            return false;
//        } else {
//            return true;
//        }
//    }
//
    include_once ("../php/checkCookies.php");




//    if(!isset($_COOKIE['rememberMeToken'])){
//        header("Location: ../php/logout.php");
//        exit();
//    }
//



//if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//    header('Location: /cosmovenus/views/Login_Register/loginForm.php');
//    exit;
//
//}


$otherUsername = isset($_GET['username']) ? trim(htmlspecialchars( $_GET['username'])) : null;
$isOwnProfile = true;

//$otherUsername = $_SESSION['user_id'];


if ($otherUsername && $otherUsername != $_SESSION['user_id']) {
    $isOwnProfile = false;
} else if ($otherUsername) {
    header("Location: /projectcosmovenus/views/profile.php");
    exit();
    }
if ($isOwnProfile){
    $otherUsername = $_SESSION['user_id'];
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
    <script src="../JS/AddFriend.js" crossorigin="anonymous"></script>
    <script src="../JS/CheckFriendship.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profilePictureComponent.css">
    <link rel="stylesheet" href="../css/profile.css">
    <style>
      .card-container{
          height: 100%;
      }
      .skills{
          max-height: 500px;
      }


      ::-webkit-scrollbar {
          width: 0.1em;
          height: 2em
      }
      ::-webkit-scrollbar-button {
          background: #ccc
      }
      ::-webkit-scrollbar-track-piece {
          background: #888
      }
      ::-webkit-scrollbar-thumb {
          background: #eee
      }
    </style>
</head>
<body>
    <div class="container-fluid">
        <?php
        require_once("../views/navbar.php");
        $userOnline ="";
        $backgroundColor ="";
        if(isset($_GET["username"])) {


            if (checkOnline($_GET["username"])) {
                $userOnline = "border-success";
                $backgroundColor = "#1DB954";
            } else {
                $backgroundColor = "#dc3545";
                $userOnline = "border-danger";
            }
        }else{
            $userOnline = "border-success";
        }
        ?>
        <!-- NAVEND -->
        <!-- PROFILE COMPONENT STARTS HERE -->
        <div class="row justify-content-center">
            <div class="col-lg-3 d-flex justify-content-center">
                <div class="profile-component"  >
                    <div class="card-container border <?php echo "$userOnline"; ?>">

                        <?php
                        $db = DbConn::instanceOfDb();
                        $conn=$db->getConnection();


                        try {

                            $stmt = $conn->prepare("SELECT profilePicture, profileName, faculty, aboutMe FROM usersDisplayInfo WHERE username = ?");
                            $stmt->execute([$otherUsername]);
                            $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                            if ($userInfo) {
                                echo "<img src='{$userInfo['profilePicture']}' class='img-fluid round $userOnline '  alt='Profile Picture'>";
                                echo "<h3>{$userInfo['profileName']}</h3>";
                                echo "<h6>{$userInfo['faculty']}</h6>";
                                echo "<p>{$userInfo['aboutMe']}</p>";
                            }
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                        <?php
                        $username = isset($_GET['username']) ? $_GET['username'] : null;
                        ?>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const username = '<?php echo $_SESSION['user_id']; ?>';
                                const friendUsername = '<?php echo $_GET['username']; ?>';
                                updateButton(username, friendUsername);
                            });
                        </script>
                        </script>

                        <div class="buttons" style="<?php echo isset($_GET['username']) ? '' : 'display:none;' ?>">
                            <button style="background-color:<?php echo $backgroundColor; ?>" class="primary <?php echo $userOnline; ?>">
                                Message
                            </button>
                            <button id="friendActionButton" class="primary ghost <?php echo $userOnline; ?>">
                                Loading...
                            </button>
                            <button id="acceptFriendRequestButton" class="primary ghost <?php echo $userOnline; ?>" style="display:none;">
                                Accept Request
                            </button>
                            <button id="declineFriendRequestButton" class="primary ghost <?php echo $userOnline; ?>" style="display:none;">
                                Decline Request
                            </button>
                        </div>
                        <div class="buttons" style="<?php echo isset($username) ? 'display:none;' : '' ?>">
                            <button style="background-color:<?php echo $backgroundColor; ?>" class="primary <?php echo $userOnline; ?>">
                                Message
                            </button>
                        </div>
                        <div style="margin-top: 55px; overflow:hidden;background-color:  <?php echo "$backgroundColor"; ?>"   class="skills" >
                            <h6 >Hobbies</h6>
                            <ul id="HobbiesUL">
                                <?php
                                $registered = $_SESSION["user_id"];
                                $db = DbConn::instanceOfDb();

                                $conn=$db->getConnection();

                                try {
                                  $stmt = $conn->prepare("SELECT hobbyName FROM hobbies WHERE username = ?");
                                  $stmt->execute([$registered]);
                                  $hobbies = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                  if ($hobbies) {
                                      foreach ($hobbies as $row) {
                                          echo "<li>{$row['hobbyName']}</li>";
                                      }
                                  }
                              } catch (PDOException $e) {
                                  echo "Error: " . $e->getMessage();
                              } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        <div class="col-lg-8">

            <div class="jumbotron jumbotron-fluid d-flex justify-content-center align-items-center">
                <div class="container-fluid">
                    <div class="card mb-3 bg-dark  jumbo-container <?php echo "$userOnline" ?>">
                        <?php
                        $db = DbConn::instanceOfDb();

                        $conn=$db->getConnection();

                        try {
                            $stmt = $conn->prepare("SELECT bannerPicture FROM usersDisplayInfo WHERE username = ?");
                            $stmt->execute([$registered]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            $bannerPicturePath = $row['bannerPicture'];

                            echo "<img class='card-img-top' id='bannerPicture' style='border-radius: 5% 5% 0px 0px; max-height: 200px; object-fit: cover;'src='$bannerPicturePath'>";

                        }catch (PDOException $e){
                        }
                        ?>
                        <div class="card-body">
                          <?php

                          echo "<h5 class='card-title'>@$otherUsername</h5>"
                          ?>
                            <hr>
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-3 col-md-3 col-sm-6 small-screen-query d-flex justify-content-center">
                                    <div class="card bg-dark stat-card" >
                                        <img class="card-img-top" src="../images/profileIcons/support.png" alt="Card image cap">
                                        <hr>
                                        <div class="card-body">
                                          <p class="card-text">Friends</p>
                                            <?php

                                            $db = DbConn::instanceOfDb();
                                            $conn=$db->getConnection();
                                            $stmt = $conn->prepare("SELECT count(*) as countFriends FROM friends 
                                                                     inner join users on users.id = friends.user_id
                                                                     where users.username = ?");
                                            $stmt->execute([$registered]);
                                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                            $countFriends = $result['countFriends'];
                                            echo " <p class='card-text'>$countFriends</p>"
                                            ?>
<!--                                          <p class="card-text">432</p>-->
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
          <!-- Add buttons for sorting -->
<!--          <button class="btn btn-primary sort-btn" data-sort-type="likes">Sort by Likes</button>-->
<!--          <button class="btn btn-primary sort-btn" data-sort-type="date">Sort by Date</button>-->

          <?php

          if(isset($_GET['username'])){
              ?>
          <div class="p-2">
<!--              <a href="friends.php"><button class="btn btn-success">Friend List <i class="fa-solid fa-user-group"></i></button></a>-->
          </div>
          <div class="p-2">
              <button class="btn btn-success">Share <i class="fa-solid fa-share"></i></button>
              <?php
              }else{

              ?>

                  <div class="p-2">

          <button class="btn btn-success " data-toggle="modal" data-target="#addPost">Add post <i class="fa-solid fa-plus" ></i></button>
        </div>
        <div class="p-2">
                          <a href="friends.php"><button class="btn btn-success">Friend List <i class="fa-solid fa-user-group"></i></button></a>
        </div>


                  <div class="p-2">
          <button class="btn btn-success">Share <i class="fa-solid fa-share"></i></button>
        </div>

        <div class="p-2">
          <a href="../views/setUpProfile.php"><button id="setupProfileButton" class="btn btn-success">Set Up profile</button></a>
        </div>
                  <!-- Add radio buttons for sorting -->

                  <select style="width: 200px; height: 40px; margin-top: 8px; background-color:#198754; border-color: #198754; color: white"  class="form-select sort-select">
                      <option value="likes">Sort by Likes</option>
                      <option value="date">Sort by Date</option>
                      <option value="alphabetical">Sort Alphabetical </option>
                      <option value="alphabeticalReverse">Sort AlphabeticalReverse </option>
                  </select>
              <?php
              }
            ?>

      </div>
    </div>


    <div class="container-fluid" >
      <div class="row d-flex justify-content-start mx-4 post-container" id="postContainer">
      </div>
    </div>

    </div>
  </div>
  <!-- ADD POST -->
  <div class="modal fade bg-dark" id="addPost" tabindex="-1" role="dialog" aria-labelledby="addPostModal" aria-hidden="true">
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
<!-- VIEW POST  -->

<div class="modal fade bg-success bg-gradient" id="viewPost" tabindex="-1" role="dialog" aria-labelledby="viewPostModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-dark" style="color: #afb4c9;">
      <div class="modal-header">
        <h5 class="modal-title" id="singlePostTitle">You shouldnt be here</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col d-flex justify-content-center">
            <img class="img-fluid" id="singlePostImage" src="" alt="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <div class="row" style="width:100%">
          <form class="form-inline d-flex my-2 justify-content-center" autocomplete="off" action="../php/saveComment.php" method="post">
              <input type="text" class="form-control mr-sm-2" style="height:40px;  border-radius: 10px 0 0 10px;" id="commentPostText" placeholder="Comment" name="commentText" required>
              <input type="hidden" id="sendCommentFormPostId" value='' name="postId" />
              <button type="submit" class="btn btn-success" id="saveCommentButton" style="height:40px; width:25%; border-radius: 0 10px 10px 0;"><i class="fa-regular fa-paper-plane"></i></button>
          </form>
        </div>
        <div class="row" style="width:100%;">
          <div class="col d-flex justify-content-start" style="width:100%;">
            <ul class="list-group list-group-flush comment-list" id="commentsContainer" style="width: 100%">
              <!-- <li class="list-group-item bg-dark" style="color: #afb4c9; width:100%;">
                <div class="row d-flex flex-row">
                  <p style="color: #afb4c9;">rrezon44: Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem recusandae fuga assumenda aliquid a deleniti nobis deserunt enim rerum maiores! Perferendis est iste aut dolorem quia maxime enim deleniti quam.</p>
                </div>
              </li> -->
          </ul>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <a href="../php/setUpProfile.php" -->
    <!-- <script>
         document.getElementById("setupProfileButton").addEventListener("click", function() {
            window.location.href = "../php/setUpProfile.php";
        });

    </script> -->

    <!-- LOG OUT -->
    <script>
        // $(document).ready(function() {
        //     $("#logOut").click(function(e) {
        //         e.preventDefault()
        //         $.ajax({
        //             type: "POST",
        //             url: "../php/logout.php",
        //             success: function(response) {
        //                 window.location.href = '../php/logout.php';
        //               // window.location.href = '../views/Login_Register/loginForm.php';
        //             }
        //
        //         });
        //     });
        // });
        document.addEventListener("DOMContentLoaded", function() {
            var logOutButton = document.getElementById("logOut");
            logOutButton.addEventListener("click", function(e) {
                e.preventDefault();

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../php/logout.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            window.location.href = "../php/logout.php";
                            // window.location.href = "../views/Login_Register/loginForm.php";
                        } else {
                            console.error("Error: " + xhr.status);
                            // Handle error case
                        }
                    }
                };
                xhr.send();
            });
        });

    </script>

<!--    load posts-->
    <script>

        // function setSortType(sortValue) {
        //     $('#sortType').val(sortValue);
        //     loadPosts();
        // }
        // $(document).ready(function() {
        var currentSortType = 'likes'; // Global variable to store current sorting type

        var profileUsername = '<?php echo $otherUsername; ?>';

            function loadPost() {
                // var sortType = $('#sortType').val();
                $.ajax({
                    type: "POST",
                    url: "../php/loadPosts.php",
                    data: {username: profileUsername,sortType: currentSortType},
                    success: function (response) {
                        $('#postContainer').html(response); // Replace old posts with new ones
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        // }
        loadPost();

        // Function to set sorting type and reload posts
        function setSortType(sortValue) {
            currentSortType = sortValue;
            loadPost(); // Reload posts with new sorting type
        }

        // Event listener for button clicks
        $('.sort-select').change(function() {
            var sortType = $(this).val();
            setSortType(sortType);
        });
        //     loadPost();

        // });
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
                var clickedElement = $(this);
                var postId = clickedElement.closest('.col-lg-3').attr('id');
                var likesCountElement = clickedElement.siblings('.likes-count');
                var currentLikes = parseInt(likesCountElement.text());

                $.ajax({
                    type: "POST",
                    url: "../php/unlikePost.php",
                    data: { postId: postId },
                    success: function(response) {
                        likesCountElement.text(currentLikes - 1);
                        clickedElement.removeClass('fa-solid').addClass('fa-regular');
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to unlike the post. Please try again.');
                        console.error("Error responseText:", xhr.responseText);
                    }
                });
            });
        });

    </script>


<!--    load single post-->

        <script>
            $(document).ready(function() {
            $('body').on('click', '.card-img-top, .card-body, .postSelector', function() {
                var postId = $(this).closest('.col-lg-3, .col-sm-12').attr('id');

                // AJAX call to load single post
                $.ajax({
                    url: '../php/loadSinglePost.php',
                    type: 'POST',
                    data: { postId: postId },
                    dataType: 'json',
                    success: function(data) {
                        if (!data.error) {
                            $('#singlePostTitle').text(data.description);
                            $('#singlePostImage').attr('src', data.imagePath);
                            $('#sendCommentFormPostId').val(postId);
                            $('#viewPost').modal('show');
                        } else {
                            console.log(data.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: " + status + ", " + error);
                    }
                });

                $.ajax({
                    url: '../php/loadComments.php',
                    type: 'POST',
                    data: { postId: postId },
                    dataType: 'json',
                    success: function(data) {
                        if (!data.error && data.comments && data.comments.length > 0) {
                            $('#commentsContainer').empty();
                            data.comments.forEach(function(comment) {
                                var commentHtml = '<li class="list-group-item bg-dark" style="color: #afb4c9; width:100%;">' +
                                    '<div class="row d-flex flex-row justify-content-between">' +
                                    '<p style="color: #afb4c9;">' + comment.userName + ': ' + comment.text + '</p>' +
                                    '<span style="font-size: 0.8em; color: #afb4c9;">' + comment.postTime +'</span>' +
                                    '</div>' +
                                    '</li>';
                                $('#commentsContainer').append(commentHtml);
                            });
                        } else if (data.error) {
                            console.log(data.error);
                            $('#commentsContainer').empty();
                            $('#commentsContainer').append('<li class="list-group-item bg-dark" style="color: #afb4c9;">No comments found.</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error: " + status + ", " + error);
                        $('#commentsContainer').html('<li >Error loading comments.</li>');
                    }
                });
            });
        });
    </script>

    <!-- save comment to server -->
    <script>
      $(document).ready(() => {
        $('#saveCommentButton').on('click', (e) => {
          e.preventDefault();
          const form = $(e.target).closest('form');
          const postId = form.find('#sendCommentFormPostId').val();
          const commentText = form.find('#commentPostText').val();
          $.ajax({
            type: 'POST',
            url: '/CosmoVenus/php/saveComment.php',
            data: { postId, commentText },
            success: (response) => {
              console.log(response);
              $('#commentPostText').val('');
              alert("Comment Added successfully")
            },
            error: (xhr, status, error) => {
              console.error('AJAX error: ' + status + ', ' + error);
            }
          });
        });
        }
      )
    </script>


</body>
</html>
