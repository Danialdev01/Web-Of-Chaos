<?php

    session_start();
    include '../config/connect.php';
    include '../config/security.php';
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
                    $user_sql = $connect->prepare("SELECT * FROM user WHERE email_user = ?");
                    $user_sql->execute([$email_user]);
                    $user = $user_sql->fetch(PDO::FETCH_ASSOC);

                    //* Check if email already exits
                    if(!isset($user['email_user'])){

                        //* Hash password
                        $password_user_hash = password_hash($password_user, PASSWORD_DEFAULT);
   
                        //* Create user inside database
                        $create_user_sql = $connect->prepare("INSERT INTO user (id_user, name_user, email_user, password_user, type_user, logo_user, status_user) VALUES (NULL, ? , ? , ? , 1 , NULL , 1)");
                        $create_user_sql->execute([
                            $name_user,
                            $email_user,
                            $password_user_hash
                        ]);
    
                        //* Set hash value
                        $id_user = $connect->lastInsertId();
                        $password = $_POST['password_user'];
                        $user_value_txt = "id_user=$id_user&password_user=$password";
                        $user_value_hash = openssl_encrypt($user_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
    
                        //* Set Session
                        $_SESSION['user_login_value'] = $user_value_hash;
    
                        //* Set cookie
                        setcookie("ChaosRandSeer", $user_value_hash, time() + (86400 * 30), "/");
    
                        //* Redirect to user dashboard
                        $_SESSION['alert-message'] = "Successfully Sign Up";
                        $_SESSION['alert-success'] = TRUE;
                        header("Location:../user/");

                    }
                    else{
                        $_SESSION['alert-message'] = "Email already exits";
                        $_SESSION['alert-error'] = TRUE;
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    $_SESSION['alert-message'] = "Please confirm your password";
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

        //@ Sign In
        elseif(isset($_POST['signin'])){
            
            if(
                isset($_POST['email']) && 
                isset($_POST['password'])
            ){

                $email_input = validateInput($_POST['email']);
                $password_input = validateInput($_POST['password']);
                
                //* Find user from database
                $find_user_sql = $connect->prepare("SELECT * FROM user WHERE email_user = ?");
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
                        setcookie("ChaosRandSeer", $user_value_hash, time() + (86400 * 30), "/");

                        $_SESSION['alert-message'] = "Successfully Logged In";
                        $_SESSION['alert-success'] = TRUE;
                        header("location:../user/");

                        // echo "Berjaya";

                    }
                    else{
                        $_SESSION['alert-message'] = "Password Or Username is incorrect";
                        $_SESSION['alert-error'] = TRUE;
                        header("Location: " . $_SERVER["HTTP_REFERER"]);
                    }

                }
                else{
                    $_SESSION['alert-message'] = "Password Or Username is incorrect";
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

        //@ Sign Out
        elseif(isset($_POST['signout'])){

            //* Sign Out
            session_destroy();
            setcookie('ChaosRandSeer', 2, time() - 3600 , "/");
            header("location:../");
            exit();

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