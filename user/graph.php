<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">

    <?php $no_button = true; $location_index = ".."; require("../components/user/navbar.php")?>

    <?php

        if(isset($_GET['id_graph'])){

            //* Get user info
            $user_value_hash = $_SESSION['user_login_value'];
            $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
            parse_str($user_value_txt, $user_value);

            //* Find graph in database
            $id_graph = htmlspecialchars($_GET['id_graph']);
            $graph_sql = $connect->prepare("SELECT * FROM graph WHERE id_graph = ? AND id_user = ?");
            $graph_sql->execute([
                $id_graph,
                $user_value['id_user']
            ]);

            //* If graph not found
            if(!$graph = $graph_sql->fetch(PDO::FETCH_ASSOC)){
                $_SESSION['alert-message'] = "Graph not found";
                $_SESSION['alert-error'] = TRUE;
                echo "<script>window.location = './'</script>";
            }
        }
        else{
            //* Id not set
            $_SESSION['alert-message'] = "Id graph not set";
            $_SESSION['alert-error'] = TRUE;
            echo "<script>window.location = './'</script>";
        }

    ?>

    <center>

        
    </center>

    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>