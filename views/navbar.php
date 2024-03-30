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
                                <a class="dropdown-item" href="/ProjectCosmoVenus/html/profile.php">Visit Profile</a>
                                <a class="dropdown-item" href="Login_Register/loginForm.html" id="logOut">Log Out</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Wink Back <i class="fa-regular fa-face-smile-wink"></i></i></a>
                        </li>
                    </ul>
                    <form action="../html/searchPeople.php" method="post" class="form-inline ms-auto search-form" style="margin-right: 15px;">
                        <div class="input-group">
                            <div class="input-group-prepend" >
                                <span class="input-group-text" id="basic-addon1" style="border-radius: 5px 0px 0px 5px;">@</span>
                            </div>
                            <input class="form-control mr-sm-2" name="searchUser" type="search" placeholder="Search Username" aria-label="Search">
                            <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </nav>
        </div>
    </div>