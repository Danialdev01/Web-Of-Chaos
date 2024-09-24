<?php
    session_start();
    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

    $apiEndpoint = "https://api.chatgpt.com/v1/converse";
    $apiKey = $openai_key;

    if(
        isset($_POST['id_graph']) && 
        isset($_POST['image_data_ts']) &&
        isset($_POST['image_data_prediction'])
    ){

        //* Get report data
        $id_graph = validateInput($_POST['id_graph']);
        $check_report_sql = $connect->prepare("SELECT COUNT(*) AS count FROM reports WHERE id_graph = ?");
        $check_report_sql->execute([$id_graph]);
        $check_report = $check_report_sql->fetch(PDO::FETCH_ASSOC);

        if($check_report['count'] == 0){

            //* Get image data
            $imageDataTS = $_POST['image_data_ts'];
            $imageDataP = $_POST['image_data_prediction'];
            $imageDataTS = base64_decode(str_replace('data:image/png;base64,', '', $imageDataTS));
            $imageDataP = base64_decode(str_replace('data:image/png;base64,', '', $imageDataP));
    
            //* Save the image to the server
            $filenameTS = "graph_ts_" . $id_graph . "_" . time() . ".png";
            $filePathTS = "../uploads/graphs/" . $filenameTS;
            file_put_contents($filePathTS, $imageDataTS);
            $filenameP = "graph_p_" . $id_graph . "_" . time() . ".png";
            $filePathP = "../uploads/graphs/" . $filenameP;
            file_put_contents($filePathP, $imageDataP);
            // log_activity_message("../log/user_activity_log", "User ($id_user) Saved Image graph");
    
            //* Generate AI summary
            $graph_report_sql = $connect->prepare("SELECT * FROM graphs WHERE id_graph = ?");
            $graph_report_sql->execute([$id_graph]);
            $graph_report = $graph_report_sql->fetch(PDO::FETCH_ASSOC);
            
            $name_graph = $graph_report['name_graph'];
            $val_one_name_graph = $graph_report['val_one_name_graph'];
            $val_two_name_graph = $graph_report['val_two_name_graph'];
            $prompt = "Given a graph that is normal but quite concerning. Based on the graph given, Please give a small summary about a graph that is about $name_graph that is related to $val_one_name_graph and $val_two_name_graph. Think about the issue that can be associated with $name_graph and give some recommendation on how to prevent it. Give the output as html. Just give some p tag and ul li tags for the points. Dont make a header.";
            include('../components/user/ai.php');
    
            $user_value_txt = openssl_decrypt($_SESSION['user_login_value'], 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
            parse_str($user_value_txt, $user_value);
    
            $id_user = $user_value['id_user'];
            $file_prediction_report = $filenameP;
            $file_ts_report = $filenameTS;
            $text_ai_report = $output;
            $created_date_report = date("Y-m-d");
    
            //* Created new report
            $new_report_sql = $connect->prepare("INSERT INTO reports(id_report, id_graph, id_user, file_prediction_report, file_ts_report, text_ai_report, created_date_report, status_report) VALUES (NULL, ? , ? , ? , ? , ? , ? , 1)");
            $new_report_sql->execute([
                $id_graph,
                $id_user,
                $file_prediction_report,
                $file_ts_report,
                $text_ai_report,
                $created_date_report
            ]);
    
            //* Log and success message
            echo json_encode(array("success" => true));
            log_activity_message("../log/user_activity_log", "User ($id_user) Created a graph report");
        }
        else{
            $count = $check_report['count'];
            log_activity_message("../log/user_activity_log", "Graph ($id_graph) report already in database");
        }

    }
    else{
        log_activity_message("../log/user_activity_log", "Error Data While Generating Graph Image");
    }


?>