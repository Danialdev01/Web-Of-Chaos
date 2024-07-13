<?php
    session_start();

    require_once('../config/connect.php');
    require_once('../config/csrf-token.php');

    if(isset($_POST['token']) && verifyCSRFToken($_POST['token'])){

        //@ Insert new graph
        if(isset($_POST['upload_data'])){

            //* Find info about graph
            if(
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

                        //TODO
                        $_SESSION['prompt'] = "Maaf Gambar Tidak Boleh Dijumpai";
                        header("location:../");
                    }

                    else{

                        //* Identify file extention
                        $fileName = $_FILES["image"]["name"];
                        $fileSize = $_FILES["image"]["size"];
                        $TmpName = $_FILES["image"]["tmp_name"];
                        $validImageExtension = ['txt'];
                        $imageExtension = explode('.', $fileName);
                        $imageExtension = strtolower(end($imageExtension));
            
                        //* Wrong file extention
                        if(!in_array($imageExtension, $validImageExtension)){

                            $_SESSION['prompt'] = "Maaf Gambar Tidak Valid";
                            header("location:../");               
                        }

                        else{
                            //* Image is correct
                            $newImageName = uniqid();
                            $newImageName .= '.' . $imageExtension;
                            $destination = __DIR__ . "/../uploads/" . $newImageName;
                            move_uploaded_file($TmpName, $destination);
                            
                            // echo $TmpName;
                            // echo "<br>";
                            // echo $newImageName;
                            // echo "<br>";
                            // echo $nama_file = $newImageName;
                            
                            //TODO Buat query
                            // $tambah_aduan_kerosakan_umum = mysqli_query($connect, "INSERT INTO aduan_kerosakan_umum VALUES (NULL,'$nama_pelapor','$lokasi_terperinci_aduan','$butiran_kerosakan','$tarikh_aduan', NULL, NULL, NULL, '$nama_file', '1')");
            
                            // $_SESSION['prompt'] = "Berjaya Hantar Aduan";
                            // header("location:../");
                        }
                    }
                }
                else{
                    //* No Image is given
                    // $tambah_aduan_kerosakan_umum = mysqli_query($connect, "INSERT INTO aduan_kerosakan_umum VALUES (NULL,'$nama_pelapor','$lokasi_terperinci_aduan','$butiran_kerosakan','$tarikh_aduan', NULL, NULL, NULL, NULL, '1')");
    
                    // $_SESSION['prompt'] = "Berjaya Hantar Aduan";
                    // header("location:../");
                }
            }
        }

    }
    else{
        $_SESSION['prompt'] = "Invalid Token";
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }

?>