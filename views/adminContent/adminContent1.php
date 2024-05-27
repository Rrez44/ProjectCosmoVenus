
<?php error_reporting(0);
//    require_once "../admin.php";
?>
        <div class="box-container">

            <div class="box box1">
                <div class="text">
                    <h2 class="topic-heading"><?php echo $articleViews; ?></h2>
<h2 class="topic">Profile Visits</h2>
</div>
<img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(31).png" alt="Views">
</div>

<div class="box box2">
    <div class="text">
        <h2 class="topic-heading"><?php echo $likes; ?></h2>
        <h2 class="topic">Likes</h2>
    </div>
    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185030/14.png" alt="likes">
</div>

<div class="box box3">
    <div class="text">
        <h2 class="topic-heading"><?php echo $comments; ?></h2>
        <h2 class="topic">Comments</h2>
    </div>
    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210184645/Untitled-design-(32).png" alt="comments">
</div>

<div class="box box4">
    <div class="text">
        <h2 class="topic-heading"><?php echo $published; ?></h2>
        <h2 class="topic">Posts</h2>
    </div>
    <img src="https://media.geeksforgeeks.org/wp-content/uploads/20221210185029/13.png" alt="published">
</div>
</div>

<div class="report-container">
    <div class="report-header d-flex">
        <h1 class="recent-Articles"><?php if (empty($userResult)){echo "";} else echo $userResult[0]['userName']?></h1>
        <?php
        if ($adminTrue == 0) {
            echo '<form method="post" style="margin-left: auto">
              <button type="submit" name="makeAdmin" class="view" style="font-size: small; margin-left: auto; margin-right: 10px">Make Admin</button>
          </form>';
        }
        else {echo "";}
        echo '<form method="post" style="margin-left: auto">
                <button type="submit" name="banUser" class="view bg-danger" style="font-size: small; margin-left: auto; margin-right: 10px">Ban User</button>
                </form>';
        ?>


        <?php
        if (isset($_POST['makeAdmin'])) {
            if (!empty($userResult)) {
                $admin->createAdminUser($_GET['userQuery']);
            }
        }
        if (isset($_POST['banUser'])) {
            if (!empty($userResult)) {
                $admin->ban($_GET['userQuery']);
            }
        }
        ?>



        <a href="<?php if (empty($userResult)) {echo "#";} else echo ("http://localhost:8080/cosmovenus/views/profile.php?username=" . $userResult[0]['userName']); ?>"><button class="view">View Profile</button></a>

    </div>

    <div class="report-body">
        <div class="report-topic-heading">
            <h3 class="t-op">Comments</h3>
        </div>

        <div class="items">
            <?php echo $admin->loadUserComments($_GET['userQuery'])?>
        </div>
    </div>

</div>
</div>