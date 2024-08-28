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
                        $id_admin = $connect->lastInsertId();
                        log_activity_message("../log/admin_activity_log", "Admin($id_admin) Successfully Sign Up");
                        alert_message("success", "Successfully Created User");
                        header("location:../admin/user.php");

                    }
                    else{
                        alert_message("error", "User is already in database");
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    alert_message("error", "Password confirm is wrong");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }

            }
            else{
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        //@ Signin Admin
        elseif(isset($_POST['signin_admin'])){

            if(
                isset($_POST['name_admin']) &&
                isset($_POST['password_admin'])
            ){

                $name_admin = validateInput($_POST['name_admin']);
                $admin_sql = $connect->prepare("SELECT * FROM admins WHERE name_admin = ?");
                $admin_sql->execute([$name_admin]);
                $admin = $admin_sql->fetch(PDO::FETCH_ASSOC);

                if(isset($admin['name_admin']) && $_POST['name_admin'] == $admin['name_admin']){

                    $password_admin = validateInput($_POST['password_admin']);

                    if(password_verify($password_admin, $admin['password_admin'])){

                        //* Set hash value
                        $id_admin = $admin['id_admin'];
                        $admin_value_txt = "id_user=$id_admin&password_user=$password_admin";
                        $admin_value_hash = openssl_encrypt($admin_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');

                        //* Set Session
                        $_SESSION['admin_login_value'] = $admin_value_hash;

                        //* Set cookie
                        setcookie("WebOfChaosAdmin", $admin_value_hash, time() + (86400 * 30), "/");

                        log_activity_message("../log/admin_activity_log", "Admin($id_admin) Successfully Log In");
                        alert_message("success", "Successfully Log In");
                        header("Location:../admin/");
                    }
                    else{
                        log_activity_message("../log/admin_activity_log", "Wrong Password ($name_admin)");
                        alert_message("error", "Wrong Password / Username");
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }
                }
                else{
                    log_activity_message("../log/admin_activity_log", "Username not found");
                    alert_message("error", "Wrong Password / Username");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }
                
            }
            else{
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
        }

        //@ Sign Out
        elseif(isset($_POST['signout'])){

            //* Get user info
            $admin_value_hash = $_SESSION['admin_login_value'];
            $admin_value_txt = openssl_decrypt($admin_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
            parse_str($admin_value_txt, $admin_value);
            $id_admin = $admin_value['id_admin'];

            log_activity_message("../log/admin_activity_log", "Admin ($id_admin) Log Out");

            //* Sign Out
            session_destroy();
            setcookie('WebOfChaosAdmin', 2, time() - 3600 , "/");
            header("location:../");
            exit();
        }

        else{
            log_activity_message("../log/admin_activity_log", "Wrong Function");
            alert_message("error", "Wrong Function");
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }

    }
    else{
        log_activity_message("../log/admin_activity_log", "Invalid Token");
        alert_message("error", "");
        header("Location:../");
        exit();
    }

?>