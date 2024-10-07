<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">
    <main>
        <?php $no_button = true; $location_index = ".."; require("../components/user/navbar.php")?>
    
        <center>
    
            <div style="max-width: 57rem;" class="pt-10">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    DELETE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    GRAPH NAME
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Date
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Unit
                                    </div>
                                </th>
                                
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        Report
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php 
    
                            $user_value_hash = $_SESSION['user_login_value'];
                            $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
                            parse_str($user_value_txt, $user_value);
    
                            $all_user_graph_sql = $connect->prepare("SELECT * FROM graphs WHERE id_user = ?");
                            $all_user_graph_sql->execute([$user_value['id_user']]);
    
                            while($graph = $all_user_graph_sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
    
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        <center>
                                            <?php
                                                ?>
                                                <form action="../backend/graph.php" method="post">
                                                    <input type="hidden" name="token" value="<?php echo $token?>">
                                                    <input type="hidden" name="id_user" value="<?php echo $user_value['id_user']?>">
                                                    <input type="hidden" name="id_graph" value="<?php echo $graph['id_graph']?>">
                                                    
                                                    <button name="delete" type="submit">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <?php
                                            ?>
                                        </center>
                                    </td>
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <?php echo htmlspecialchars($graph['name_graph'])?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo htmlspecialchars($graph['created_date_graph'])?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $category_str = $graph['val_one_name_graph'] . ' / ' . $graph['val_two_name_graph'];
                                            echo htmlspecialchars($category_str);
                                        ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <center>
                                            <?php
                                                $report_graph_sql = $connect->prepare("SELECT * FROM reports WHERE id_graph = ?");
                                                $report_graph_sql->execute([$graph['id_graph']]);
                                                $report_graph = $report_graph_sql->fetch(PDO::FETCH_ASSOC);

                                                if(isset($report_graph['id_graph'])){
                                                ?>
                                                    <a href="./graph-report.php?id_graph=<?php echo $graph['id_graph']?>">
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17v-5h1.5a1.5 1.5 0 1 1 0 3H5m12 2v-5h2m-2 3h2M5 10V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1v6M5 19v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1M10 3v4a1 1 0 0 1-1 1H5m6 4v5h1.375A1.627 1.627 0 0 0 14 15.375v-1.75A1.627 1.627 0 0 0 12.375 12H11Z"/>
                                                        </svg>
                                                    </a>
                                                <?php
                                                }
                                                else{
                                                    echo "-";
                                                }
                                            ?>
                                        </center>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="./graph.php?id_graph=<?php echo $graph['id_graph']?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Show</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <?php
                        $graph_user_sql = $connect->prepare("SELECT * FROM graphs WHERE id_user = ?");
                        $graph_user_sql->execute([$id_user]);

                        $bil_graph = 0;
                        while($graph = $graph_user_sql->fetch(PDO::FETCH_ASSOC)){
                            $bil_graph++;
                        }

                        if($bil_graph == 0){

                            ?>
                            <br><br>
                            <p class="py-4 text-gray-400">You have not made any uploads.</p>
                            <a href="./upload.php">
                                <button class="py-2 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Create New Upload</button>
                            </a>
                            <br><br><br>
                            <?php
                        }
                    ?>
                </div>
            </div>
    
        </center>

    </main>

    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>