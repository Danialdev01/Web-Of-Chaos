<?php 
    require_once("$location_index/config/connect.php");
    session_start();

    require_once("$location_index/config/csrf-token.php");
    $token = generateCSRFToken();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $location_index?>/src/css/output.css">
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/flowbite/dist/flowbite.min.css">
    <link rel="shortcut icon" href="<?php echo $location_index?>/src/img/favicon.ico" type="image/x-icon">
    <style>
        html {
            scroll-behavior: smooth;
        }
        main{
            min-height: 85dvh;
        }
        /* ::-webkit-scrollbar {
            display: none;
        } */
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <title>Web Of Chaos</title>
</head>