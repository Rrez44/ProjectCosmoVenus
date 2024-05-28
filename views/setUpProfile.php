
<?php
session_start();

//mkdir("../images/$this->userName/profileImages", 0755);
include_once ("../php/checkCookies.php");
//
//if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//    header('Location: /cosmovenus/views/Login_Register/loginForm.html');
//    exit;
//}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../css/nav.css">

    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/profilePictureComponent.css">
    <link rel="stylesheet" href="../css/SetUpProfile/setupprofile.css">

    <style>

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
    require_once("../views/navbar.php")
    ?>

<!-- NAVEND -->
    <!-- PROFILE COMPONENT STARTS HERE -->
    <div class="row justify-content-center">
        <div class="col-lg-3 d-flex justify-content-center">
            <div class="profile-component">
                <div class="card-container border border-success">
                    <?php
                    if( $_SESSION['logged_in']){
                        $registered = $_SESSION["user_id"];

                        $db = DbConn::instanceOfDb();

                        $conn=$db->getConnection();


                        $stmt = $conn->prepare("SELECT profilePicture, profileName, faculty, aboutMe FROM usersDisplayInfo WHERE username = :userName");

                        $stmt->bindParam(":userName", $registered);

                        $stmt->execute();


                        $posts = $stmt->fetch(PDO::FETCH_ASSOC);
                           
                            echo "<img src=" . $posts['profilePicture']  . " class='img-fluid round' id='profilePicture' alt='Profile Picture'>";
                            echo "<h3 id='name'> " .  $posts['profileName'] . "</h3>";
                            echo "<h6 id='facultyy'>" .  $posts['faculty'] . "</h6>";
                            echo "<p id='aboutmee'>" .  $posts['aboutMe'] . "</p>";
                    }
                    ?>


                    <h3 id="name" ></h3>
                    <h6 id="facultyy"></h6>
                    <p id="aboutmee"></p>
                    <div class="buttons">
                        <button class="primary">
                            Message
                        </button>
                        <button class="primary ghost">
                            Friends
                        </button>
                        <!-- <h3 class="hi">Hello</h3> -->
                    </div>
                    <div class="skills">
                        <h6>Hobbies</h6>
                        <ul id="HobbiesUL">
                            <?php
                            if($_SESSION["logged_in"]){
                            }else{
                                echo "<li>  </li>";
                            }
                            // ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div  class="jumbotron jumbotron-fluid d-flex justify-content-center align-items-center">
                <div  class="container-fluid">
                    <div style="padding-bottom: 650px;" class="card mb-3 bg-dark border-success jumbo-container">

                        <form style="margin-left: 40px;" id="profileForm"   action="../php/setUpProfile.php" method="post" enctype="multipart/form-data"  >
                        <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-8">
                               <p class="form-label">Profile Name:</p>
                                    <input type="text" id="username" class="form-control theSameClass " name="username" required>
                                    </div>
                                </div>


                                <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-8">
                                <p class="form-label">Profile Picture</p>
                                <label for="inputFile" class="btn theSameClass form-control">Select Image</label>
                                <input id="inputFile" accept="image/png, image/jpeg" name="inputfile" class="form-control" " type="file" title="" required>

                            </div>
                        </div>

                            <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                                <div class="col-md-8">
                                    <p class="form-label">Cover Photo</p>
                                    <label for="inputFileCoverPhoto" class="btn theSameClass form-control">Select Image</label>
                                    <input id="inputFileCoverPhoto" accept="image/png, image/jpeg" name="inputFileCoverPhoto" class="form-control"  type="file" title="" required>

                                </div>
                            </div>

                            
                        <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-8">
                                        
                                    <p class="allParagraphs form-label">Faculty:</p>
                                    <input   class="form-control theSameClass" id="faculty" name="faculty" type="text" required>
                                </div>
                            </div>

                            <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-8">
                                                           <p class="allParagraphs form-label">Hobbies:</p>
                                <button type="button" class="col-md-3 btn btn-primary form-control  theSameClass" name="hobbies" data-toggle="modal" data-target="#exampleModal">Select</button>
                                </div>
                            </div>

                            <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-8">
                                                              <p class="allParagraphs form-label">About Me:</p>    
                                <textarea maxlength="40" style="max-height: 100px; min-height: 100px" class="form-control theSameClass" id="aboutme" name="aboutme" style="height: 150px; resize: none;"></textarea>
                            </div>
                            </div>
                            
                            <div class="row justify-content-center sameStyle" style="margin-top: 10px;">
                            <div class="col-md-4">
                                
                                <input type="submit" style="background-color:#1DB954;border: none;color:black;
    outline: none; " class="form-control submitButton" value="Save changes"></div>
                                <div class="col-md-4">
                                
                                <input  style="display:inline-block;" type="submit" id="discard" onclick="clearForm()" class="  form-control theSameClass" value="Discard">
                            </div>
                            </div>
                               
                            </div>


                  
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div style="background-color: #222222;" class="modal-dialog" role="document">
                                    <div style="background-color:#222222;" class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: white;" id="exampleModalLabel">Select Hobbies</h5>
                                            <button style="border: none; outline: none; background-color: #222222; font-size: 30px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- <div class="button"> -->
                                            <input type="radio" id="a25" name="check-substitution-1"  value="UI/UX"/>
                                            <label style="color: white;" class="btn btn-default" for="a25">UI/UX</label>
                                            <!-- </div> -->
                                            <!-- <div class="button"> -->
                                            <input type="radio" id="a50" name="check-substitution-2" value="JAVA" />
                                            <label style="color: white;" class="btn btn-default" for="a50">JAVA</label>
                                            <!-- </div> -->
                                            <!-- <div class="button"> -->
                                            <input type="radio" id="a75" name="check-substitution-3" value="CSS" />
                                            <label style="color: white;" class="btn btn-default" for="a75">CSS</label>

                                            <input type="radio" id="a100" name="check-substitution-4" value="C++" />
                                            <label style="color: white;" class="btn btn-default" for="a100">C++</label>
                                            <!-- </div> -->
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>















    </div>
</div>
</body>
</div>
</div>




</div>
</div>
</div>
<script src="../JS/setUpprofile.js" defer></script>

</body>

                           


<script>
function clearForm() {
    var form = document.getElementById("profileForm");
    var inputs = form.querySelectorAll('input:not([type="button"]):not([type="submit"])'); // Select all inputs except buttons and submits
    var textareas = form.getElementsByTagName('textarea');

    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = ''; // Clear input values
    }

    for (var j = 0; j < textareas.length; j++) {
        textareas[j].value = ''; // Clear textarea values
    }
}

    $("#inputFile").change(function() {
  filename = this.files[0].name;
//   console.log(filename);
});

    const radioButtons = document.querySelectorAll('input[type="radio"]');

    radioButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            if (this.getAttribute('data-checked') === 'true') {
                this.checked = false;
                this.setAttribute('data-checked', 'false');
            } else {
                this.setAttribute('data-checked', 'true');
            }
        });
    });

</script>

</html>
