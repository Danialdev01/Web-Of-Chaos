<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">
    <main>
        <?php $no_button = true; $location_index = ".."; require("../components/admin/navbar.php")?>

        <?php

            if(isset($_GET['id_graph'])){

                //* Find graph in database
                $id_graph = htmlspecialchars($_GET['id_graph']);
                $graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_graph = ?");
                $graph_sql->execute([
                    $id_graph,
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
            <div class="graph-info">
                <div style="max-width: 56rem;" class=" pt-10">
                    <h2 class="text-4xl font-bold dark:text-white"><?php echo htmlspecialchars($graph['name_graph'])?></h2>
    
                    <?php include '../components/user/prediction-graph.php';?>
                    <?php include '../components/user/time-series-graph.php';?>
                    <?php 
                    // include '../components/user/generate-image.php';
                    ?>
                    
                </div>
            </div>
        </center>

    </main>



    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>