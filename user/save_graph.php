<?php
    include '../config/functions.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $imageData = $_POST["image"];
        $imageData = str_replace("data:image/png;base64,", "", $imageData);
        $imageData = base64_decode($imageData);
        
        $filename = "graph_image_" . date("YmdHis") . ".png";
        $filePath = "../uploads/images/" . $filename;
        
        file_put_contents($filePath, $imageData);
        
        echo "Graph image saved successfully!";
        log_activity_message("../log/user_activity_log", "Done");
    } 
    else {
        echo "Error: Invalid request method";
        log_activity_message("../log/user_activity_log", "error");
    }
?>