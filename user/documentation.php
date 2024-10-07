<?php $location_index = ".."; include("../components/header.php")?>
<body class="dark:bg-gray-900">

    <style>
        .container-doc {
            justify-content: center;
            display: flex;
        }
        .img-sec {
            display: block;
            height: 500px;
            width: 800px;
            overflow-y: scroll;
            scroll-behavior: smooth;
            margin-bottom: 5px;
            border: solid 1px;
        }
        .img-doc {
            height: 500px;
            width: 100%;
        }
        .section {
            width: 800px;
            display: block;
            margin-bottom: 50px;
        }
        .NoteBox{
            padding: 15px 20px 15px;
            background-color: #ddddec;
            border-left: 5px solid #514082;
        }
    </style>

    <main>

        <?php $no_button = true; $location_index = ".."; require("../components/user/navbar.php")?>
    
        <center>

            <div class="container-doc">
                <div class="sub-con">
                    <div class="header1-doc">
                        <!-- <br><br> -->
                        <!-- Welcome to "Web Of Chaos" documentation. Do you know how to use this system? This page will explain how to use our system. -->
                    </div>
                    <br><br>
                    <section class="section" id="1">
                        <div class="section-con">
                            <div class="header2-doc" style="display: flex;">
                                <h1>1.</h1>
                                <h2>Login / Signup</h2>
                            </div>
                            <div class="text">
                                <div class="NoteBox">
                                    <h3>Explanation:</h3>
                                <p>First thing first, you need to register to our website if you don't have any account in "Web Of Chaos". After you register your account, you need to log in to this system with your email and your password.</p>
                                </div>
                            </div>
                            <div class="img-sec" id="1">
                                <img class="img-doc" src="../documentation/img/img1.png" alt="1">
                                <img class="img-doc" src="../documentation/img/img2.png" alt="2">
                                <img class="img-doc" src="../documentation/img/img3.png" alt="3">
                                <img class="img-doc" src="../documentation/img/img4.png" alt="4">
                            </div>
                        </div>
                    </section>
                    <section class="section" id="2">
                        <div class="section-con">
                            <div class="header2-doc" style="display: flex;">
                                <h1>2.</h1>
                                <h2>Upload Data / Processing Data</h2>
                            </div>
                            <div class="text">
                                <div class="NoteBox"><h3>Explanation:</h3>
                                    <p>After you created your account, you can use the system. You need to click the nav bar at the top-right and click the new graph to change your data to graph. Next, complete the information needed and upload your file in CSV format. Then you can click the submit button.</p></div>
                            </div>
                            <div class="img-sec" id="2">
                                <img class="img-doc" src="../documentation/img/img5.png" alt="1">
                                <img class="img-doc" src="../documentation/img/img6.png" alt="2">
                                <img class="img-doc" src="../documentation/img/img7.png" alt="3">
                            </div>
                        </div>
                    </section>
                    <section class="section" id="3">
                        <div class="section-con">
                            <div class="header2-doc" style="display: flex;">
                                <h1>3.</h1>
                                <h2>Result / Download Result</h2>
                            </div>
                            <div class="text">
                                <div class="NoteBox"><h3>Explanation:</h3>
                                    <p>After you clicked the submit button, you need to wait for the data processing until the system completes and produces the output of the graph. The system will output a timeseries graph, prediction graph, and correlation coefficient (accuracy on graph prediction). You can also download the result by clicking the button on the top-right of the timeseries graph.</p></div>
                            </div>
                            <div class="img-sec" id="3">
                                <img class="img-doc" src="../documentation/img/img8.png" alt="1">
                                <img class="img-doc" src="../documentation/img/img9.png" alt="2">
                            </div>
                        </div>
                    </section>

                    <section class="section" id="3">
                        <div class="section-con">
                            <div class="header2-doc" style="display: flex;">
                                <h1>4.</h1>
                                <h2>Data Format</h2>
                            </div>
                            <div class="text">
                                <div class="NoteBox"><h3>CSV:</h3>
                                    <p>Make sure your data only contain its value. Make sure its separated using commas. The data needs to have 3 columns that is date, time and data value.</p></div>
                            </div>
                            <div class="img-sec" id="3">
                                <img class="img-doc" src="../documentation/img/data example.png" alt="2">
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            
        </center>
    </main>


    <?php require("../components/footer.php");?>

    <script>
        const containers = document.getElementsByClassName('img-sec');
        let scrollInterval;

        function autoScrollImages() {
            for (let container of containers) {
                container.scrollBy(0, 3);
                if (container.scrollTop + container.clientHeight >= container.scrollHeight) {
                    container.scrollTop = 0;
                }
            }
        }

        function startScrolling() {
            scrollInterval = setInterval(autoScrollImages, 20);
        }
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startScrolling();
                }
            });
        });

        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            observer.observe(section);
        });
    </script>

    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>