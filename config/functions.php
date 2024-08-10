<?php

    function alert_message($session_set, $text){
        //* Set alert
        if($session_set == "error"){
            $_SESSION['alert-message'] = $text;
            $_SESSION['alert-error'] = TRUE;

        }
        elseif($session_set == "success"){
            $_SESSION['alert-message'] = $text;
            $_SESSION['alert-success'] = TRUE;
        }

    }

    function validateInput($data) {
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function log_activity_message($location, $text){

        //* Set IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } 

        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } 

        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        //* Set text
        $date = date("d/m/Y h:i");
        $file_content = file_get_contents($location);
        $text = "($date) ($ip): $text";
        
        //* Log text
        $text .= "\n$file_content";
        file_put_contents($location, $text);

    }

?>