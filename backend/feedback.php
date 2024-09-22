<?php
    session_start();

    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

    if(isset($_POST['token']) && verifyCSRFToken($_POST['token'])){

        //@ Insert new feedback
        if(isset($_POST['new_feedback'])){

            if(
                ($_POST['name'] == '') &&
                (
                    isset($_POST['email_feedback']) &&
                    isset($_POST['subject_feedback']) &&
                    isset($_POST['message_feedback'])
                )
            ){
                
                //* get data
                $email_feedback = validateInput($_POST['email_feedback']);
                $subject_feedback = validateInput($_POST['subject_feedback']);
                $create_date_feedback = date("Y-m-d");
                $message_feedback = validateInput($_POST['message_feedback']);
                
                //* store feedback
                $new_feedback_sql = $connect->prepare("INSERT INTO feedbacks(id_feedback, email_feedback, subject_feedback, message_feedback, created_date_feedback, status_feedback) VALUES (NULL, ? , ? , ? , ? , 1)");
                $new_feedback_sql->execute([
                    $email_feedback,
                    $subject_feedback,
                    $message_feedback,
                    $create_date_feedback
                ]);
                
                //* log and redirect user
                alert_message("success", "Feedback Received");
                log_activity_message("../log/user_activity_log", "New Feedback");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            else{
                //* Variable not complete
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);

            }

        }
        else{
            alert_message("error", "Wrong Function");
            log_activity_message("../log/error_log", "Wrong Function");
            header("Location: " . $_SERVER["HTTP_REFERER"]);

        }

    }
    else{
        alert_message("error", "Invalid Token");
        log_activity_message("../log/error_log", "Invalid Token");
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>