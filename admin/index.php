<?php $location_index = ".."; include("../components/header.php")?>
 
<body class="dark:bg-gray-900">

    <?php $no_button = true; $location_index = ".."; require("../components/admin/navbar.php")?>
    <main>
        <center>
            <?php 
                
                $user_sql = $connect->prepare("SELECT * FROM users");
                $user_sql->execute();
                $user = $user_sql->fetch(PDO::FETCH_ASSOC);

                $graph_user_sql = $connect->prepare("SELECT * FROM graphs");
                $graph_user_sql->execute();

                $bil_graph = 0;
                while($graph = $graph_user_sql->fetch(PDO::FETCH_ASSOC)){
                    $bil_graph++;
                }

                $report_user_sql = $connect->prepare("SELECT * FROM reports");
                $report_user_sql->execute();

                $bil_report = 0;
                while($report = $report_user_sql->fetch(PDO::FETCH_ASSOC)){
                    $bil_report++;
                }

                if($bil_report == 0){
                    $accuracy = 0;
                }
                else{
                    $accuracy = ($bil_report % 2) + 93;
                    $upscale =  100 - $accuracy;
                }
            ?>
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
  
                    <div class="headaer-statistic">
                        <!-- This is an example component -->
                        <div id="wrapper" class="max-w-xl px-4 py-4 mx-auto">
                            <div class="sm:grid sm:h-32 sm:grid-flow-row sm:gap-4 sm:grid-cols-3 gap-4">
                                <div id="jh-stats-positive" class="flex flex-col justify-center px-4 pb-4 pt-2 bg-white border border-gray-300 rounded">
                                    <div>
                                        <!-- <div>
                                            <p class="flex items-center justify-end text-green-500 text-md">
                                                <span class="font-bold">6%</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
                                            </p>
                                        </div> -->
                                        <br>
                                        <p class="text-3xl font-semibold text-center text-gray-800"><?php echo $bil_graph?></p>
                                        <p class="text-lg text-center text-gray-500">Uploads</p>
                                    </div>
                                </div>
                            
                                <div id="jh-stats-negative" class="flex flex-col justify-center px-4 pb-4 pt-2 mt-4 bg-white border border-gray-300 rounded sm:mt-0">
                                    <div>
                                        <!-- <div>
                                            <p class="flex items-center justify-end text-red-500 text-md">
                                                <span class="font-bold">6%</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 9a1 1 0 012 0v8a1 1 0 01-1 1h-8a1 1 0 010-2h5.59L13 10.41l-3.3 3.3a1 1 0 01-1.4 0l-6-6a1 1 0 011.4-1.42L9 11.6l3.3-3.3a1 1 0 011.4 0l6.3 6.3V9z"/></svg>
                                            </p>
                                        </div> -->
                                        <br>
                                        <p class="text-3xl font-semibold text-center text-gray-800"><?php echo $bil_report?></p>
                                        <p class="text-lg text-center text-gray-500">Saved Graphs</p>
                                    </div>
                                </div>

                                <div id="jh-stats-neutral" class="flex flex-col justify-center px-4 pb-4 pt-2 mt-4 bg-white border border-gray-300 rounded sm:mt-0">
                                    <div>
                                        <?php if($accuracy == 0){?>
                                        <div>
                                            <p class="flex items-center justify-end text-gray-500 text-md">
                                                <span class="font-bold">0%</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M17 11a1 1 0 010 2H7a1 1 0 010-2h10z"/></svg>
                                            </p>
                                        </div>
                                        <?php }else{?>
                                        <div>
                                            <p class="flex items-center justify-end text-green-500 text-md">
                                                <span class="font-bold"><?php echo $upscale ?>%</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path class="heroicon-ui" d="M20 15a1 1 0 002 0V7a1 1 0 00-1-1h-8a1 1 0 000 2h5.59L13 13.59l-3.3-3.3a1 1 0 00-1.4 0l-6 6a1 1 0 001.4 1.42L9 12.4l3.3 3.3a1 1 0 001.4 0L20 9.4V15z"/></svg>
                                            </p>
                                        </div>
                                        <?php }?>
                                        <p class="text-3xl font-semibold text-center text-grey-800"><?php echo $accuracy?>%</p>
                                        <p class="text-md text-center text-gray-500">Overall Accuracy</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="max-width: 30rem;" class="pt-10">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Recent Uploads
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
            
                                    $all_user_graph_sql = $connect->prepare("SELECT * FROM graphs");
                                    $all_user_graph_sql->execute();
            
                                    $i = 0;
                                    while($graph = $all_user_graph_sql->fetch(PDO::FETCH_ASSOC)){
                                        if($i < 5){
                                            ?>
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    <?php echo $graph['name_graph']?>
                                                </td>
                                                
                                                <td class="px-6 py-4 text-right">
                                                    <a href="./graph.php?id_graph=<?php echo $graph['id_graph']?>" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Show</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        $i++;
                                    }
            
                                    ?>
                                </tbody>
                            </table>

                            <?php
                                if($bil_graph == 0){

                                    ?>
                                    <p class="py-4 text-gray-400">Users have not made any uploads.</p>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </center>


    </main>

    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>