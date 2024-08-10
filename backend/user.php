<?php

    session_start();
    include '../config/connect.php';
    include '../config/security.php';
    include '../config/functions.php';
    include '../config/csrf-token.php';

    //* Check token
    if(isset($_POST['token']) && verifyCSRFToken($_POST['token'])){

        //@ Sign Up
        if(isset($_POST['signup'])){

            //* Check values
            if(
                isset($_POST['name_user']) && 
                isset($_POST['email_user']) && 
                isset($_POST['password_user']) && 
                isset($_POST['password_confirm_user']) 
            ){

                //* Make sure password confirm is the same
                if($_POST['password_user'] == $_POST['password_confirm_user']){

                    $name_user = validateInput($_POST['name_user']);
                    $password_user = validateInput($_POST['password_user']);
                    $email_user = validateInput($_POST['email_user']);
                    
                    //* Find email in database
                    $user_sql = $connect->prepare("SELECT * FROM users WHERE email_user = ?");
                    $user_sql->execute([$email_user]);
                    $user = $user_sql->fetch(PDO::FETCH_ASSOC);

                    //* Check if email already exits
                    if(!isset($user['email_user'])){

                        //* Hash password
                        $password_user_hash = password_hash($password_user, PASSWORD_DEFAULT);
                        $created_date_user = date("Y-m-d");
   
                        //* Create user inside database
                        $create_user_sql = $connect->prepare("INSERT INTO users (id_user, name_user, email_user, password_user, type_user, logo_user, company_name_user, desc_user, created_date_user, status_user) VALUES (NULL , ? , ? , ? , 1 , NULL , NULL , NULL , ? , 1)");
                        $create_user_sql->execute([
                            $name_user,
                            $email_user,
                            $password_user_hash,
                            $created_date_user
                        ]);
    
                        //* Set hash value
                        $id_user = $connect->lastInsertId();
                        $password = $_POST['password_user'];
                        $user_value_txt = "id_user=$id_user&password_user=$password";
                        $user_value_hash = openssl_encrypt($user_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
    
                        //* Set Session
                        $_SESSION['user_login_value'] = $user_value_hash;
    
                        //* Set cookie
                        setcookie("WebOfChaosUser", $user_value_hash, time() + (86400 * 30), "/");
    
                        //* Redirect to user dashboard
                        log_activity_message("../log/user_activity_log", "User($id_user) Successfully Sign Up");
                        alert_message("success", "Successfully Sign Up");
                        header("Location:../user/");

                    }
                    else{
                        log_activity_message("../log/error_log", "Email already exists");
                        alert_message("error", "Email already exists");
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    log_activity_message("../log/error_log", "Password confirm not correct");
                    alert_message("error", "Password confirm not correct");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }

            }
            else{
                log_activity_message("error","../log/error_log", "Data not complete");
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        //@ Sign In
        elseif(isset($_POST['signin'])){
            
            if(
                isset($_POST['email']) && 
                isset($_POST['password'])
            ){

                $email_input = validateInput($_POST['email']);
                $password_input = validateInput($_POST['password']);
                
                //* Find user from database
                $find_user_sql = $connect->prepare("SELECT * FROM users WHERE email_user = ?");
                $find_user_sql->execute([$email_input]);
                $user = $find_user_sql->fetch(PDO::FETCH_ASSOC);
                
                //* Make sure user existents
                if(isset($user['email_user']) && $_POST['email'] == $user['email_user']){

                    //* Make sure password is correct
                    if(password_verify($password_input, $user['password_user'])){

                        //* Set hash value
                        $id_user = $user['id_user'];
                        $user_value_txt = "id_user=$id_user&password_user=$password_input";
                        $user_value_hash = openssl_encrypt($user_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');

                        //* Set Session
                        $_SESSION['user_login_value'] = $user_value_hash;

                        //* Set cookie
                        setcookie("WebOfChaosUser", $user_value_hash, time() + (86400 * 30), "/");

                        log_activity_message("../log/user_activity_log", "User($id_user) Successfully Log In");
                        alert_message("success", "Successfully Log In");
                        header("Location:../user/");

                    }
                    else{
                        log_activity_message("../log/error_log", "Password is incorrect");
                        alert_message("error", "Password or Username is incorrect");
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    log_activity_message("../log/error_log", "Username is incorrect");
                    alert_message("error", "Password or Username is incorrect");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }

            }
            else{
                log_activity_message("../log/error_log", "Data not complete");
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

        }

        //@ Sign Out
        elseif(isset($_POST['signout'])){

            $user_value_hash = $_SESSION['user_login_value'];
            $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
            parse_str($user_value_txt, $user_value);
            $id_user = $user_value['id_user'];

            log_activity_message("../log/user_activity_log", "User ($id_user) Log Out");

            //* Sign Out
            session_destroy();
            setcookie('WebOfChaosUser', 2, time() - 3600 , "/");
            header("location:../");
            exit();

        }

        //@ Update user
        elseif(isset($_POST['update_user'])){

            if(
                isset($_POST['name_user']) && 
                isset($_POST['email_user']) && 
                isset($_POST['company_name_user']) && 
                isset($_POST['desc_user']) 
            ){

                //* Find current user value
                $user_value_hash = $_SESSION['user_login_value'];
                $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
                parse_str($user_value_txt, $user_value);

                //* Validate data
                $name_user = validateInput($_POST['name_user']);
                $email_user = validateInput($_POST['email_user']);
                $company_name_user = validateInput($_POST['company_name_user']);
                $desc_user = validateInput($_POST['desc_user']);

                //* Update user info in database
                $user_sql = $connect->prepare("UPDATE user SET name_user = ? , email_user = ? , company_name_user = ? , desc_user = ? WHERE id_user = ?");
                $user_sql->execute([
                    $name_user,
                    $email_user,
                    $company_name_user,
                    $desc_user,
                    $user_value['id_user']
                ]);

                //* Redirect user 
                log_activity_message("../log/user_activity_log", "Successfully Updated User");
                alert_message("success", "Successfully Updated User");
                header("location:../user/user.php");

            }
            else{

                log_activity_message("../log/error_log", "Data not complete");
                alert_message("error", "Data not complete");
                header("Location: " . $_SERVER["HTTP_REFERER"]);   
            }
        }

        //@ Delete user
        elseif(isset($_POST['delete_user'])){

            //* Make sure the right user isset
            if(isset($_POST['user_login_value'])){

                //* Find user info from session
                $user_value_hash = $_POST['user_login_value'];
                $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
                parse_str($user_value_txt, $user_value);

                //* Find user info from database
                $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = ?");
                $user_sql->execute([$user_value['id_user']]);
                $user = $user_sql->fetch(PDO::FETCH_ASSOC);

                //* Verify if user password is valid
                if(password_verify($user_value['password_user'], $user['password_user'])){

                    //* Deactivate user
                    $deactivate_user_sql = $connect->prepare("UPDATE users SET status_user = '0' WHERE id_user = ?");
                    $deactivate_user_sql->execute([$user_value['id_user']]);

                   
                    $id_user = $user_value['id_user'];

                    log_activity_message("../log/user_activity_log", "User ($id_user) Deactivate Account");

                    //* Destroy sesssion
                    session_destroy();
                    setcookie('WebOfChaosUser', 2, time() - 3600 , "/");
                    header("location:../");
                    exit();
                    
                }
                else{
                    log_activity_message("../log/error_log", "Password user not valid");
                    alert_message("error", "Password user not valid");
                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                }

            }    
            else{
                log_activity_message("../log/error_log", "User value not set");
                alert_message("error", "User value not set");
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