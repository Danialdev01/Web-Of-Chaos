<?php

    header('X-Frame-Options: SAMEORIGIN');
    header("X-XSS-Protection: 1");
    header('X-Content-Type-Options: nosniff');
    header('Strict-Transport-Security: max-age=16000000;');

    //TODO check if user is logged in 
    // if ((!isset($_SESSION['user_login_value']) && !isset($_POST['signin'])) && basename($_SERVER['PHP_SELF']) !== 'index.php') {
    //     throw new Exception("Not Logged In");
    //     session_destroy();
    //     exit();
    // } 
    
?>