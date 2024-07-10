<?php

    // get env
    $env = parse_ini_string(file_get_contents(__DIR__.'/.env'));
    $hostname = $env['HOSTNAME'];
    $username = $env['USERNAME'];
    $password = $env['PASSWORD'];
    $dbname = $env['DBNAME'];

    $secret_key = $env['SECRET_KEY'];

    $dsn = 'mysql:host='. $hostname .';dbname='. $dbname;
    
    try{
        // connect to db
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $error){
        echo $error->getMessage();
        session_destroy();
        exit;
    }

    // error reporting 
    error_reporting(E_ALL);
    ini_set("display_errors", 0);

    function errorHandler($errno, $errstr, $errfile, $errline){
        echo "ERROR : [$errno] $errstr - ( $errfile | line $errline)";

    }
    set_error_handler("errorHandler");
?>