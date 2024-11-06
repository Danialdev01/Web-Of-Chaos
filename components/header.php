<?php 
    require_once("$location_index/config/connect.php");
    session_start();

   include "$location_index/config/csrf-token.php";
    $token = generateCSRFToken();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $location_index?>/src/css/output.css">
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/flowbite/dist/flowbite.min.css">
    <link rel="shortcut icon" href="<?php echo $location_index?>/src/img/favicon/favicon.ico" type="image/x-icon">

    
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

    <!-- for chart -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- for datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <title>Web Of Chaos</title>

    <meta name="title" content="Web Of Chaos">
    <meta name="description" content="Easy to use web application using chaos theory and artificial intelligence to predict time series data.">
</head>