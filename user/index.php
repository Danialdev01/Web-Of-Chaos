<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">

    <main>

        <?php $no_button = true; $location_index = ".."; require("../components/user/navbar.php")?>
    
        <center>
            <?php 
                
                $user_value_hash = $_SESSION['user_login_value'];
                $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
                parse_str($user_value_txt, $user_value);

                $user_sql = $connect->prepare("SELECT * FROM user WHERE id_user = ?");
                $user_sql->execute([$user_value['id_user']]);
                $user = $user_sql->fetch(PDO::FETCH_ASSOC);
            ?>
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                        <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Hi <?php echo htmlspecialchars(ucfirst(strtolower(strtok($user['name_user'], " "))))?></h2>
                        <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">Our company is committed to excellence, utilizing advanced mathematical models and machine learning algorithms to optimize data processing.</p>
                    </div> 
                    <div class="max-w-2xl">
                                <center>
                            <article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex justify-between items-center mb-5 text-gray-500">
                                    <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                        <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>
                                        Article
                                    </span>
                                    <!-- <span class="text-sm">14 days ago</span> -->
                                </div>
                                <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">Read Our Documentation</a></h2>
                                <p class="mb-5 font-light text-gray-500 dark:text-gray-400">Our comprehensive documentation provides step-by-step guides and detailed explanations to help you master our system, ensuring accurate and reliable output that drives informed decision-making and maximizes results.</p>
                                <div class="flex justify-between items-center">
                                    <a href="./documentation.php" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
                                        Read more
                                        <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </a>
                                </div>
                            </article>                  
                        </center>
                        </div>  
                </div>
            </section>
        </center>
    </main>


    <?php require("../components/footer.php");?>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>