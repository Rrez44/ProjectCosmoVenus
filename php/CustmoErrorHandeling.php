<?php
function customErrorHandler($errno, $errstr,$errfile,$errline) {
    $errorMessage = "[" . date('Y-m-d H:i:s') . "] Error: $errstr in $errfile on line $errline  \n";
    error_log($errorMessage, 3, 'logs/error.log');

    switch ($errno){
        case E_USER_ERROR:

            echo "<script>alert('$errstr');</script>";
            break;
        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
    }
}

set_error_handler("customErrorHandler");
