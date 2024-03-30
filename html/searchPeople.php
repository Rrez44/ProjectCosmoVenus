<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/nav.css">
    
    <script src="https://kit.fontawesome.com/74cd7f5a15.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/profile.css">
    <link rel="stylesheet" href="../css/profilePictureComponent.css">
    <link rel="stylesheet" href="../css/searchPeople.css">
    <style>
        body{
        
            overflow-x: hidden;
        }
        </style>
</head>
<body>
        <?php 
            require_once("../html/navbar.php");


                         
                    
        ?>
         <div class="row justify-content-left">

                         <?php

                            $registered = $_POST["searchUser"];
                            // echo "$registered";
                            $db = new mysqli("localhost", "root", "1234", "cosmo");
                                                    
                            $stmt = $db->prepare("SELECT  username,profileName,profpicture    FROM usersDisplayInfo WHERE profileName = ?");

                            $stmt->bind_param("s", $registered);

                            $stmt->execute();
                            $stmt->store_result();

                            if($stmt->num_rows()>0){
                                                            

                            $stmt->bind_result( $username,$profileName,$profpicture);
                            while ($stmt->fetch()) {
                                
                                echo '<div class="col-lg-3 d-flex justify-content-center">';
                                echo '<div class="profile-component">';
                                echo '<div style="height: 400px;" class="card-container border border-success">';
                                echo '<img src="' . $profpicture . '" class="img-fluid round" alt="Profile Picture">';
                                echo '<h3 style="margin-top: 25px;">' . $profileName . '</h3>';
                                echo '<div class="buttons" style="margin-top: 50px;">';
                                echo '<button class="primary equalWidth">Add Friend</button>';
                                echo '</div>';
                                echo '<div class="buttons" style="margin-top: 10px;">';
                                echo '<a href="../html/visitProfile.php?username=' . urlencode($username) . '"><button class="primary ghost equalWidth">Visit Profile</button></a>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                }
                                
                            }else{
                                
                                


                            }
                        


                        ?>

        </div> 


</div>


    
</body>
</html>