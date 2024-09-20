<?php $location_index = ".."; include("../components/header.php")?>

<body class="dark:bg-gray-900">

    <?php $no_button = true; $location_index = ".."; require("../components/admin/navbar.php")?>
    <main>

        <center>
            <div class="max-w-7xl pt-10">
                <h3 class="font-bold text-lg">All Uploads</h3>
                <table id="all-uploads" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                            $graph_sql = $connect->prepare("SELECT * FROM graphs WHERE status_graph = 1");
                            $graph_sql->execute();

                            while($graph = $graph_sql->fetch(PDO::FETCH_ASSOC)){

                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($graph['name_graph'])?></td>
                                    <td><?php echo htmlspecialchars($graph['created_date_graph'])?></td>

                                    <td>
                                        <?php
                                            $id_user = $graph['id_user'];
                                            $user_graph_sql = $connect->prepare("SELECT name_user FROM users WHERE id_user = ?");
                                            $user_graph_sql->execute([$id_user]);
                                            $user_graph = $user_graph_sql->fetch(PDO::FETCH_ASSOC);
                                            echo htmlspecialchars($user_graph['name_user']);
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>

            </div>

        </center>

        <script>
            new DataTable('#all-uploads');
        </script>
    </main>

    <?php require("../components/footer.php");?>


    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>