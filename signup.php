<?php $location_index = "."; include("./components/header.php")?>
<body class="dark:bg-gray-900">

    <?php $location_index = "."; require("./components/navbar.php")?>

    <center>
        <section class="max-w-lg pt-10 bg-gray-50 dark:bg-gray-900">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div class="text-left w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                            Create your account
                        </h1>
                        <form class="space-y-4 md:space-y-6" method="post" action="./backend/user.php">
                            <input type="hidden" name="token" value="<?php echo $token?>">
                            <div>
                                <label for="name_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Name</label>
                                <input type="text" name="name_user" id="name_user" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Someone" required="">
                            </div>
                            <div>
                                <label for="email_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                <input type="email" name="email_user" id="email_user" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="someone@mail.com" required="">
                            </div>
                            <div>
                                <label for="password_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password_user" id="password_user" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            </div>
                            <div>
                                <label for="password_confirm_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Your Password</label>
                                <input type="password" name="password_confirm_user" id="password_confirm_user" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            </div>
                            <input type="submit" name="signup" value="Sign Up" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                Already have an account ?
                                <a href="signin.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </center>


    <?php require("./components/footer.php");?>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>