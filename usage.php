<?php $location_index = "."; include("./components/header.php")?>
<body class="dark:bg-gray-900">

    <?php $no_link = true; $location_index = "."; require("./components/client/navbar.php")?>

    <center>
        <div class="upload-data">
            <div class="max-w-2xl pt-8 md:px-0 px-5">

                <form action="./backend/graph.php" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="token" value="<?php echo $token?>">

                    <!-- variable_one_name -->
                    <div class="grid gap-6 mb-6 text-left">
                        <div>
                            <label for="variable_one_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variable 1 Name</label>
                            <input name="variable_one_name" type="text" id="variable_one_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Water Level" required />
                        </div>
                    </div>
    
                    <!-- variable_one_unit -->
                    <div class="grid gap-6 mb-6 text-left">
                        <div>
                            <label for="variable_one_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variable 1 Unit</label>
                            <input name="variable_one_unit" type="text" id="variable_one_unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="m" required />
                        </div>
                    </div>
    
                    <div class="grid gap-6 mb-6 text-left">
                        <div>
                            <label for="variable_two_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variable 2 Name</label>
                            <input name="variable_two_name" type="text" id="variable_two_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Time (Hour)" required />
                        </div>
                    </div>
    
                    <div class="grid gap-6 mb-6 text-left">
                        <div>
                            <labe for="variable_two_unit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Variable 1 Unit</label>
                            <input name="variable_two_unit" type="text" id="varible_two_unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="h" required />
                        </div>
                    </div>
    
                    <input name="image" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file" accept=".txt" required>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">.TXT (MAX. 100MB).</p><br>
                        
                    <input type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" name="upload_data" value="Submit">
                </form>
            </div>


        </div>
    </center>

    <?php require("./components/footer.php");?>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>