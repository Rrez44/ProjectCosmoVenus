<?php

function writeToLoginFile($username, $email, $dateOfRegistering) {


    $filename = "loginUser.txt";

    if (is_writable($filename)) {
        if (!$fp = fopen($filename, "a")) {
            echo "unable to open file";
            exit(1);
        }

        if (!fwrite($fp, "$username?$email?$dateOfRegistering \r\n")) {
            echo "Failed to write to file";
            exit(1);
        }
        echo "File written to file";
        fclose($fp);
    } else {
        echo "unable to write file";
    }
}




