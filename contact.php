<?php $location_index = "."; include("./components/header.php")?>
<body class="dark:bg-gray-900">

    <?php $no_link = true; $location_index = "."; require("./components/navbar.php")?>

    <center>
        <div class="upload-data">
            <div class="max-w-2xl md:px-0 px-5">
                <section class="bg-white dark:bg-gray-900 text-left">
                    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                        <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Contact Us</h2>
                        <p class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">Got a technical issue? Help us improve the world</p>
                        <form action="./backend/feedback.php" method="post" class="space-y-8">

                            <input type="hidden" name="token" value="<?php echo $token?>">
                            <input type="text" name="name" class="hidden" value="">

                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Your email</label>
                                <input type="email" name="email_feedback" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="someone@gmail.com" required>
                            </div>
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                                <input type="text" name="subject_feedback" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Let us know how we can help you" required>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Your message</label>
                                <textarea id="message" name="message_feedback" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a comment..." required></textarea>
                            </div>
                            <button type="submit" name="new_feedback" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send comment</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </center>

    <?php require("./components/footer.php");?>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>