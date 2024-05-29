<?php
require '../php/Admin.php';
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: /cosmovenus/views/Login_Register/loginForm.php');
    exit;
}
$_SESSION['groupCounter'] = 1;

if (!isset($_SESSION['sort_order'])) {
    $_SESSION['sort_order'] = 1;
}
$username = $_SESSION["user_id"];
if (!isset($_GET['loadState'])) {
    $_GET['loadState'] = 1;
}

$db = DbConn::instanceOfDb()->getConnection();
$stmt = $db->prepare("SELECT * FROM users as u INNER JOIN usersdisplayinfo on u.userName = usersdisplayinfo.userName  WHERE u.userName = :username");
$stmt->bindParam(":username", $username);
$stmt->execute();
$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

$siteStats = $db->prepare("SELECT
    (SELECT log_count FROM logged_in) AS log_count,
    (SELECT COUNT(*) AS numberPosts FROM userPosts) as posts,
    (SELECT COUNT(*) AS numberUsers FROM users) as users");

$siteStats->execute();

$result = $siteStats->fetch(PDO::FETCH_ASSOC);

 $logCount = $result['log_count'];
 $postsCount = $result['posts'];
$usersCount = $result['users'];

if (!$userInfo['Admin']) {
    echo "You do not have administrator privilege";
    exit;
}
$admin = new UserAdmin($userInfo['firstName'],$userInfo['lastName'],$userInfo['userName'],$userInfo['email'],$userInfo['dateOfBirth'], $userInfo['password']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width,
                   initial-scale=1.0">
    <title>Administrator</title>
    <link rel="stylesheet"
          href="../css/adminPage.css">
    <link rel="stylesheet"
          href="../css/adminPageResponsive.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/charts.css/dist/charts.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

<!-- for header part -->
<header>

    <div class="logosec">
        <div class="logo">CosmoVenus</div>
        <img src=
             "https://media.geeksforgeeks.org/wp-content/uploads/20221210182541/Untitled-design-(30).png"
             class="icn menuicn"
             id="menuicn"
             alt="menu-icon">
    </div>

    <div class="searchbar">
        <form action="" method="GET" class="d-flex">
            <input type="text"
                   placeholder="Search"
                    name = "userQuery">
            <div class="searchbtn">
                <button type="submit" style="border: none">
                    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png" class="icn srchicn" alt="search-icon">
                </button>

            </div>
        </form>


    </div>

    <div class="message">
<!--        <div class="circle"></div>-->
<!--        <img src=-->
<!--             "https://media.geeksforgeeks.org/wp-content/upl5oads/20221210183322/8.png"-->
<!--             class="icn"-->
<!--             alt="">-->
        <div class="dp">
            <img src="<?php echo $userInfo["profilePicture"] ?>"
                 class="dpicn"
                 alt="dp">
        </div>
    </div>

</header>

<?php
$input = trim(htmlspecialchars($_GET['userQuery']));

$userQuery = $db->prepare("
    SELECT 
        u.*,
        COUNT(DISTINCT up.postId) AS post_count,
        COUNT(DISTINCT pc.postId) AS comment_count,
        sum(likes) as likes,
        Admin
    FROM 
        users AS u
    LEFT JOIN 
        userposts AS up ON u.userName = up.poster
    LEFT JOIN 
        postcomments AS pc ON u.userName = pc.userName
    where u.userName = :input
    GROUP BY 
        u.userName
");


$userQuery->bindParam(":input", $input);

if ($userQuery->execute()) {

    $userResult = $userQuery->fetchAll(PDO::FETCH_ASSOC);

} else {

    echo "Error executing query.";
}
?>



<div class="main-container">
    <div class="navcontainer">
        <nav class="nav">
            <div class="nav-upper-options">
                <div class="nav-option option1">
                    <img src=
                         "https://media.geeksforgeeks.org/wp-content/uploads/20221210182148/Untitled-design-(29).png"
                         class="nav-img"
                         alt="dashboard">
                    <h3>User</h3>
                </div>

<!--                <div class="nav-option">-->
<!--                    <img src=-->
<!--                         "https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/9.png"-->
<!--                         class="nav-img"-->
<!--                         alt="articles">-->
<!--                    <h3>Groups</h3>-->
<!--                </div>-->

                <div class="nav-option">
                    <img src=
                         "https://media.geeksforgeeks.org/wp-content/uploads/20221210183320/5.png"
                         class="nav-img"
                         alt="report">
                    <h3> Report</h3>
                </div>

                <div class="nav-option ">
                    <img src=
                         "https://media.geeksforgeeks.org/wp-content/uploads/20221210183322/9.png"
                         class="nav-img"
                         alt="log">
                    <h3>User Log</h3>
                </div>


                <div class="nav-option logout">
                    <img src=
                         "https://media.geeksforgeeks.org/wp-content/uploads/20221210183321/7.png"
                         class="nav-img"
                         alt="logout">

                    <a style="text-decoration: none;color: black" href="../php/logout.php">
                    <h3>Logout</h3>
                    </a>

                </div>

            </div>
        </nav>
    </div>
    <div class="main">

        <div class="searchbar2">
            <input type="text"
                   name=""
                   id=""
                   placeholder="Search">
            <div class="searchbtn">
                <img src=
                     "https://media.geeksforgeeks.org/wp-content/uploads/20221210180758/Untitled-design-(28).png"
                     class="icn srchicn"
                     alt="search-button">
            </div>
        </div>

        <?php

        if (empty($userResult)) {
            $articleViews = 0;
            $likes = 0;
            $comments = 0;
            $published = 0;
            $adminTrue = -1;
        } else {
            $articleViews = $userResult[0]['article_views'] ?? 0;
            $likes = $userResult[0]['likes'] ?? 0;
            $comments = $userResult[0]['comment_count'] ?? 0;
            $published = $userResult[0]['post_count'] ?? 0;
            $adminTrue = $userResult[0]['Admin'] ?? -1;
        }

        switch ($_GET['loadState']){
            case 1: include_once "./adminContent/adminContent1.php";break;
//            case 2: include_once "./adminContent/adminContent2.php";break;
            case 2: include_once  "./adminContent/adminContent3.php";break;
            case 3: include_once "./adminContent/adminContent4.php";break;
//            case 4: include_once header("");break;
            default: include_once "./adminContent/adminContent1.php";
        }

        ?>

</div>

<script>


    let menuicn = document.querySelector(".menuicn");
    let nav = document.querySelector(".navcontainer");

    menuicn.addEventListener("click", () => {
        nav.classList.toggle("navclose");
    })


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function getLoadStateFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('loadState');
        }
        function setActiveNavigationOption(loadState) {
            $('.nav-option').removeClass('option1');
            if (loadState) {
                $('.nav-option').eq(loadState - 1).addClass('option1');
            }
        }
        var loadState = getLoadStateFromUrl();
        setActiveNavigationOption(loadState);

        $('.nav-option').click(function () {


            var selectedOption = $(this).index() + 1;

            var url = window.location.href;

            var regex = /[?&]loadState=\d+/i;
            var separator = url.indexOf('?') !== -1 ? '&' : '?';

            if (url.match(regex)) {
                var newUrl = url.replace(regex, separator + 'loadState=' + selectedOption);
            } else {
                var newUrl = url + separator + 'loadState=' + selectedOption;
            }

            window.history.replaceState({}, '', newUrl);

            window.location.href = newUrl;
        });
    });
</script>
    <script>
        // Check if the 'param' GET parameter is set
        if (!('URLSearchParams' in window)) {
            throw new Error('Browser does not support URLSearchParams.');
        }

        var params = new URLSearchParams(window.location.search);

        // Check if the 'param' parameter is not set
        if (!params.has('userQuery')) {
            // If not set, assign a default value
            params.set('userQuery', '0');

            // Update the URL without refreshing the page
            var newUrl = window.location.pathname + '?' + params.toString();
            window.history.pushState({path:newUrl},'',newUrl);
        }
    </script>
</body>
</html>

