<?php

    session_start();
    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

    //* Check token
    if(isset($_POST['token']) && verifyCSRFToken($_POST['token'])){

        //@ Sign Up
        if(isset($_POST['create_new_admin'])){

            //* Check data
            if(
                isset($_POST['name_admin']) && 
                isset($_POST['password_admin']) && 
                isset($_POST['password_admin_confirm'])
            ){

                //* Check if confirm password is correct
                if($_POST['password_admin'] == $_POST['password_admin_confirm']){

                    //* Filter input
                    $name_admin = validateInput($_POST['name_admin']);
                    $password_admin = validateInput($_POST['password_admin']);
                    
                    //* Find user data in database
                    $find_admin_sql = $connect->prepare("SELECT * FROM admins WHERE name_admin = ?");
                    $find_admin_sql->execute([$name_admin]);
                    $find_admin = $find_admin_sql->fetch(PDO::FETCH_ASSOC);
                    
                    //* Check if username is already in database
                    if(!isset($find_admin['name_admin'])){
                        
                        $created_date_admin = date("Y-m-d");

                        $password_admin_hash = password_hash($password_admin, PASSWORD_DEFAULT);

                        //* Create user
                        $create_admin_sql = $connect->prepare("INSERT INTO admins(id_admin, name_admin, clearance_admin, password_admin, created_date_admin, status_admin) VALUES (NULL , ? , 1 , ? , ? , 1)");
                        $create_admin_sql->execute([
                            $name_admin,
                            $password_admin_hash,
                            $created_date_admin
                        ]);

                        //* Redirect
                        $_SESSION['alert-message'] = "Successfully Created User";
                        $_SESSION['alert-success'] = TRUE;
                        header("location:../admin/user.php");

                    }
                    else{
                        $_SESSION['alert-message'] = "User is already in database";
                        $_SESSION['alert-error'] = TRUE;
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    $_SESSION['alert-message'] = "Password confirm is wrong";
                    $_SESSION['alert-error'] = TRUE;
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }

            }
            else{
                $_SESSION['alert-message'] = "Data not complete";
                $_SESSION['alert-error'] = TRUE;
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        else{
            $_SESSION['alert-message'] = "Wrong Function";
            $_SESSION['alert-error'] = TRUE;
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

    }
    else{
        $_SESSION['alert-messsage'] = "Invalid Token";
        $_SESSION['alert-error'] = TRUE;
        header("Location:../");
        exit();
    }

?>