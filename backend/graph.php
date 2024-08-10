<?php
    session_start();

    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

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