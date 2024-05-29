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
    <title>Message</title>
    <link rel="stylesheet" href="../css/nav.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/message.css">
</head>
<body>
    <div class="container-fluid">
        <?php require_once("../views/navbar.php"); ?>
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
                  <div class="container-fluid" id="friend-list">
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
        // Function to load friends
            function loadFriends(filter) {
                $.ajax({
                    type: 'POST',
                    url: '../php/FriendSystem/ViewFriends.php', // Adjust the path as needed
                    data: { user_id: '<?php echo $_SESSION['user_id']; ?>' }, // Ensure the user_id is correctly passed as a string
                    success: function(response) {
                        console.log(response); // Log the raw response
                        let friends = JSON.parse(response);
                        console.log(friends); // Log the parsed response to check its structure

                        if (!Array.isArray(friends)) {
                            console.error('The response is not an array:', friends);
                            return;
                        }

                        let filteredFriends = [];

                        // Apply filters
                        if (filter === "Online") {
                            filteredFriends = friends.filter(friend => friend.rememberMeToken !== null);
                        } else if (filter === "Recent") {
                            // Assuming recent means those who became friends most recently
                            filteredFriends = friends.sort((a, b) => new Date(b.accepted_at) - new Date(a.accepted_at));
                        } else {
                            filteredFriends = friends; // All friends
                        }

                        // Clear the existing list
                        $("#friend-list").empty();

                        // Add filtered friends to the list
                        filteredFriends.forEach(friend => {
                            let friendComponent = `
                            <div class="row">
                                <div class="col d-flex justify-content-start align-items-center friend-component">
                                    <div class="col-2 d-flex align-items-center">
                                        <img class="img-fluid round" src="${friend.profilePicture}" alt="friend image">
                                        <p class="friend-name">@${friend.username}</p>
                                    </div>
                                    <div class="col-6 d-flex justify-content-center mx-3">
                                        <p class="last-seen"><i>${new Date(friend.accepted_at).toLocaleString()}</i></p>
                                    </div>
                                    <div class="right-content"></div>
                                    <button class="btn btn-success profile-button" href="../html/profile.html"><i class="fa-regular fa-user"></i></button>
                                    <button class="btn btn-success message-button">Message <i class="fa-regular fa-message"></i></button>
                                </div>
                            </div>
                            <hr>
                        `;
                            $("#friend-list").append(friendComponent);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch friends:', error);
                    }
                });
            }

        // Click event for the navigation tabs
        $(".card-header .nav-tabs .nav-link").click(function(event) {
            event.preventDefault();
            $(".card-header .nav-tabs .nav-link").removeClass('active');
            $(this).addClass('active');

            let filter = $(this).html();
            if (filter == "Online") {
                $("#card-title").html("Online");
            } else if (filter == "Recent") {
                $("#card-title").html("Recent");
            } else if (filter == "All friends") {
                $("#card-title").html("All Friends");
            }

            // Load friends based on the selected filter
            loadFriends(filter);
        });

        // Initial load of all friends
        loadFriends("All friends");
    });
</script>


</html>