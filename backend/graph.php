<?php
    session_start();

    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

    function validateCSV($filePath, $minColumns) {
        if (($handle = fopen($filePath, 'r')) !== FALSE) {
            $rowCount = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $rowCount++;
                // Check if the number of columns is greater than the specified minimum
                if (count($data) < $minColumns) {
                    fclose($handle);
                    return "Wrong Format";
                }
            }
            fclose($handle);
            return true; // CSV is valid
        } else {
            return "Could not open the file.";
        }
    }

    if(isset($_POST['token']) && verifyCSRFToken($_POST['token'])){

        //@ Insert new graph
        if(isset($_POST['upload_data'])){

            //* Find info about graph
            if(
                isset($_POST['name_graph']) && 
                isset($_POST['variable_one_name']) && 
                isset($_POST['variable_one_unit']) && 
                isset($_POST['variable_two_name']) && 
                isset($_POST['variable_two_unit'])
            ){
    
                //@ Insert Image
                //* Make sure the file valid
                if($_FILES["image"]["name"] != NULL || $_FILES["image"]["name"] != ""){
    
                    //* File is not found
                    if($_FILES["image"]["error"] === 4){

                        alert_message("error", "Image not found");
                        header("location:../user/upload.php");
                    }

                    else{

                        //* Identify file extention
                        $fileName = $_FILES["image"]["name"];
                        $fileSize = $_FILES["image"]["size"];
                        $TmpName = $_FILES["image"]["tmp_name"];
                        $validImageExtension = ['csv'];
                        $imageExtension = explode('.', $fileName);
                        $imageExtension = strtolower(end($imageExtension));
            
                        //* Wrong file extention
                        if(!in_array($imageExtension, $validImageExtension)){

                            alert_message("error", "File type not valid");
                            header("location:../user/upload.php");               
                        }

                        else{
                            //* Image is correct
                            $newImageName = uniqid();
                            $newImageName .= '.' . $imageExtension;
                            $destination = __DIR__ . "/../uploads/documents/" . $newImageName;
                            move_uploaded_file($TmpName, $destination);

                            // Validate the CSV file
                            $csvValidationResult = validateCSV($destination, 3); 
                            if ($csvValidationResult !== true) {
                                alert_message("error", $csvValidationResult);
                                header("location:../user/upload.php");
                                exit();
                            }
                            
                            //* Get user info
                            $user_value_hash = $_SESSION['user_login_value'];
                            $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
                            parse_str($user_value_txt, $user_value);

                            //* Set variables
                            $id_user = $user_value['id_user'];
                            $name_graph = validateInput($_POST['name_graph']);
                            $file_name_graph = $newImageName;
                            $val_one_name_graph = validateInput($_POST['variable_one_name']);
                            $val_one_unit_graph = validateInput($_POST['variable_one_unit']);
                            $val_two_name_graph = validateInput($_POST['variable_two_name']);
                            $val_two_unit_graph = validateInput($_POST['variable_two_unit']);
                            $create_date_graph = date("Y-m-d");
                            
                            //* Add data to database
                            $create_graph_sql = $connect->prepare("INSERT INTO graphs(id_graph, id_user, name_graph, file_name_graph, val_one_name_graph, val_one_unit_graph, val_two_name_graph, val_two_unit_graph, created_date_graph, status_graph) VALUES (NULL, ? , ? , ? , ? , ? , ? , ? , ? , 1)");
                            $create_graph_sql->execute([
                                $id_user,
                                $name_graph,
                                $file_name_graph,
                                $val_one_name_graph,
                                $val_one_unit_graph,
                                $val_two_name_graph,
                                $val_two_unit_graph,
                                $create_date_graph
                            ]);
            
                            //* Redirect
                            $id_graph = $connect->lastInsertId();
                            alert_message("success", "Uploaded data");
                            log_activity_message("../log/user_activity_log", "User ($id_user) Created a graph ($id_graph)");
                            header("location:../user/graph.php?id_graph=$id_graph");
                        }
                    }
                }
                else{
                    //* No Image is given
                    alert_message("error", "File not found");
                    header("location:../user/upload.php");
                }
            }
            else{
                //* Variable not complete
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);

            }
        }

        //@ Delete Graph
        elseif(isset($_POST['delete'])){

            if(isset($_POST['id_graph']) && isset($_POST['id_user'])){

                //* Get variables
                $id_graph = validateInput($_POST['id_graph']);
                $id_user = validateInput($_POST['id_user']);

                //* Find graph info 
                $graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_graph = ?");
                $graph_sql->execute([$id_graph]);
                $graph = $graph_sql->fetch(PDO::FETCH_ASSOC);

                //* Check if user owns graph
                if($graph['id_user'] == $id_user){
                    
                    //* Delete Graph
                    $delete_graph_sql = $connect->prepare("DELETE FROM graphs WHERE id_graph = ?");
                    $delete_graph_sql->execute([$id_graph]);

                    //* Find Report info
                    $report_sql = $connect->prepare("SELECT * FROM reports WHERE id_graph = ?");
                    $report_sql->execute([$id_graph]);
                    $report = $report_sql->fetch(PDO::FETCH_ASSOC);

                    //* Check if report is available
                    if($report['id_graph'] == $id_graph){

                        //* Delete report
                        $delete_report_sql = $connect->prepare("DELETE FROM reports WHERE id_graph = ?");
                        $delete_report_sql->execute([$id_graph]);

                        //TODO delete picture graph
                        //* Delete picture graph
                        if(!unlink("../uploads/graphs/" . $report['file_prediction_report'])){
                            alert_message("error", "Image Prediction Not Found");
                            header("location:../user/all-graph.php");
                        }

                        if(!unlink("../uploads/graphs/" . $report['file_ts_report'])){
                            alert_message("error", "Image Time Series Not Found");
                            header("location:../user/all-graph.php");
                        }

                    }

                    //* Delete file data user
                    if(!unlink("../uploads/documents/" . $graph['file_name_graph'])){
                        alert_message("error", "File not Found");
                        header("location:../user/all-graph.php");
                    }

                    alert_message("success", "Deleted Data");
                    log_activity_message("../log/user_activity_log", "User ($id_user) Deleted a graph ($id_graph)");
                    header("location:../user/all-graph.php");
                }
                else{
                    //* Variable not complete
                    alert_message("error", "User Not Allowed To Delete");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);

                }
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