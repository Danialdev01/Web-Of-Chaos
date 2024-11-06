<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">

    <main>
        <?php $no_button = true; $location_index = ".."; require("../components/admin/navbar.php")?>

        <?php 

            $id_user = htmlspecialchars($_GET['id_user']);
            $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = ?");
            $user_sql->execute([$id_user]);
            $user = $user_sql->fetch(PDO::FETCH_ASSOC);

        ?>

        <section class="bg-white dark:bg-gray-900">
            <div class="max-w-2xl px-4 py-8 mx-auto lg:py-16">
                <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">User Information</h2>
                <form action="../backend/user.php" method="post">

                    <input type="hidden" name="token" value="<?php echo $token?>">

                    <div class="md:grid gap-4 mb-4 md:grid-cols-2 md:gap-6 sm:mb-5">

                        <!-- name_user -->
                        <div class="col-span-2">
                            <label for="name_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input readonly type="text" name="name_user" id="name_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo htmlspecialchars($user['name_user'])?>" placeholder="Type your username" required="">
                        </div>

                        <!-- email_user -->
                        <div class="md:w-full pt-3 md:pt-0">
                            <label for="email_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input readonly type="text" name="email_user" id="email_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo htmlspecialchars($user['email_user']) ?>" placeholder="Type your email" required="">
                        </div>

                        <!-- company_name_user -->
                        <div class="w-full pt-3 md:pt-0">
                            <label for="company_name_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Company Name</label>
                            <input readonly type="text" name="company_name_user" id="company_name_user" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php 
                                if($user['company_name_user'] != "" && $user['company_name_user'] != NULL){
                                    echo htmlspecialchars($user['company_name_user']);
                                } 
                                else{
                                    echo "";
                                }
                            ?>" placeholder="Not Filled" required="">
                        </div>

                        <!-- desc_user -->
                        <div class="col-span-2 pt-3 md:pt-0">
                            <label for="desc_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <?php 
                                    if($user['desc_user'] != NULL || $user['desc_user'] != ""){
                                        $desc_user = htmlspecialchars($user['desc_user']);
                                    }
                                    else{
                                        $desc_user = "";
                                    }
                                ?>
                            <textarea readonly id="desc_user" name="desc_user" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Not Filled"><?php echo $desc_user?></textarea>
                        </div>

                    </div>
                    <div class="flex items-center space-x-4">

                        <!-- update_user -->
                        <!-- <button type="submit" name="update_user" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update
                        </button> -->

                        <!-- delete model button -->
                        <!-- <button type="button" data-modal-target="deleteModal" data-modal-toggle="deleteModal" class="text-red-600 inline-flex items-center hover:text-red-500 border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            Delete
                        </button> -->
                        
                    </div>
                </form>
                <!-- Main modal -->
                <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                    <div style="margin-top: 600px;" class="lg:hidden">

                    </div>
                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                        <!-- Modal content -->
                        <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                            <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <br>
                            <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete your account?</p>
                            <div class="flex justify-center items-center space-x-4">
                                <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    No, cancel
                                </button>

                                <form action="../backend/user.php" method="post">

                                    <input type="hidden" name="token" value="<?php echo $token?>">

                                    <input type="hidden" name="user_login_value" value="<?php echo $_SESSION['user_login_value']?>">

                                    <button type="submit" name="delete_user" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        Yes, I'm sure
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    
        
    </main>
    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>