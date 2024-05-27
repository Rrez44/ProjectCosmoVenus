

    <?php error_reporting(0);
    //    require_once "../admin.php";
    ?>


    <div class="report-container">

        <div class="report-header d-flex">
            <h2>Username</h2>
            <h2>Email</h2>
            <h2>Date Of Register</h2>
            <h1 class="recent-Articles">


                <form method="get" action="">
                    <button class="view" name="log" value="register">RegisterLog</button>
                    <button class="view" name="log" value="login">Login Log</button>
                </form>
        </div>

        <div class="report-body">
            <div class="report-topic-heading">
    <!--            <h3 class="t-op">Comments</h3>-->
                <?php
                $logType = isset($_GET['log']) ? $_GET['log'] : 'register';


                $filenameRead="";
                if ($logType == 'login') {
                    $filenameRead = "C:/xampp/htdocs/cosmovenus/php/loginUser.txt";
                } else {
                    $filenameRead = "C:/xampp/htdocs/cosmovenus/php/registeredUser.txt";
                }
                $file = fopen($filenameRead, "r");
                $counter =0;
                if ($file) {
                while (($line = fgets($file)) !== false) {
                $parts = explode("?", $line);
                echo "$parts[0]";
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; // Add margin to the right of parts[1]
                echo $parts[1];
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp"; // Add margin to the right of parts[1]
                echo $parts[2];

                    $counter =1;

                if($counter==1){
                    echo "<br>";
                }

        }
            fclose($file);
        } else {
            echo "Unable to open file.";
        }
        ?>
            </div>

            <div class="items">
            </div>
        </div>

    </div>
    </div>