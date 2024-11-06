<?php $location_index = ".."; include("../components/header.php")?>

<body class="dark:bg-gray-900">

    <?php $no_button = true; $location_index = ".."; require("../components/admin/navbar.php")?>
    <main>

        <center>
            <div class="max-w-7xl pt-10">
                <h3 class="font-bold text-lg">Active User</h3>
                <table id="user-active" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Graph Bil</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php 
                            $user_sql = $connect->prepare("SELECT * FROM users WHERE status_user = 1");
                            $user_sql->execute();

                            while($user = $user_sql->fetch(PDO::FETCH_ASSOC)){

                                ?>
                                <tr>
                                    <td>
                                        <a href="./user-info.php?id_user=<?php echo $user['id_user']?>">
                                            <?php echo htmlspecialchars($user['name_user'])?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email_user'])?></td>
                                    <td><?php echo htmlspecialchars($user['type_user'])?></td>

                                    <td>
                                        <?php
                                            $bil_graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_user = ?");
                                            $bil_graph_sql->execute([$user['id_user']]);

                                            for($x = 0; $bil_graph = $bil_graph_sql->fetch(PDO::FETCH_ASSOC); $x++){}
                                            echo $x;
                                        ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>

                <h3 class="font-bold text-lg pt-10">Diactivated User</h3>
                <table id="user-deactivate" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Graph Bil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $user_sql = $connect->prepare("SELECT * FROM users WHERE status_user = 0");
                            $user_sql->execute();

                            while($user = $user_sql->fetch(PDO::FETCH_ASSOC)){

                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['name_user'])?></td>
                                    <td><?php echo htmlspecialchars($user['email_user'])?></td>
                                    <td><?php echo htmlspecialchars($user['type_user'])?></td>

                                    <td>
                                        <?php
                                            $bil_graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_user = ?");
                                            $bil_graph_sql->execute([$user['id_user']]);

                                            for($x = 0; $bil_graph = $bil_graph_sql->fetch(PDO::FETCH_ASSOC); $x++){}
                                            echo $x;
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
            new DataTable('#user-active');
            new DataTable('#user-deactivate');
        </script>
    </main>

    <?php require("../components/footer.php");?>


    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>