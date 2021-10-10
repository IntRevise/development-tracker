<!doctype html>
<html class="no-js" lang="English" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="manifest" href="manifest.json">

    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>IntRevise</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/_partials/scrollbar.php";
    ?>

</head>

<body>

    <section class="header-section">

        <?php require "_partials/navbar.php"; ?>

        <div class="header-content version_2">
            <div class="opacity-overlay " data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row row-padding">
                        <div class="col-xl-7 col-lg-6 col-md-6">
                            <div class="header-content-body" style="padding-bottom: 80px;">
                                <h1>The <span class="bold-color">Wootton Upper<br></span>
                                    <span class="txt-rotate" data-period="2000" data-rotate='["Computing", "Revision"]'> </span>
                                    Platform
                                </h1>
                                <p>Woottons very own, all-in-one platform for the Computer Science curriculum and more. Containing all the
                                    perfect & necessary GCSE topics for revision and teaching. Also including
                                    perfect live quizzes inspired by <b>
                                        <a href="https://kahoot.com?ref=intrevise" target="_blank">Kahoot</a></b> and
                                    <b><a href="https://spiral.ac/?ref=intrevise" target="_blank">Spiral</a></b>, encouraging students to get
                                    more involved in lessons.
                                </p>
                                <br>
                                <div>
                                    <a href="studentarea/" class="btn btn-primary btn-round btn-simple fa-beat" style="--fa-animation-duration: 5s; --fa-beat-scale: 1.1;color: white; background: #4c96e5">Get Started</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /row -->
                </div>
            </div>
        </div>
    </section>

    <!-- block wrapper -->
    <section class="block-wrapper pb-60">
        <div class="container">
            <div class="row col-no-margin">
                <div class="col-xl-4 pl-0 pr-0">
                    <div class="block-all-text" style="background: #4c96e5">
                        <div class="img-inner-block">
                            <img src="./assets/img/teacher.png" draggable="false" />
                        </div>
                        <div class="block-lower-text">
                            <h5>Perfect Courses</h5>
                            <p>Perfect for all year groups, from KS3 to KS4, tailored for the GCSE Computer Science curriculum.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 pl-0 pr-0">
                    <div class="block-all-text" style="background: #29cddd">
                        <div class="img-inner-block">
                            <img src="./assets/img/study.png" draggable="false" />
                        </div>
                        <div class="block-lower-text">
                            <h5>Variety of Subjects</h5>
                            <p>A number of suitable topics. From Data Representation, to Boolean Logic and System Architecture.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 pl-0 pr-0">
                    <div class="block-all-text" style="background: #4c96e5">
                        <div class="img-inner-block">
                            <img src="./assets/img/medal.png" draggable="false" />
                        </div>
                        <div class="block-lower-text">
                            <h5>Programming pathways</h5>
                            <p>The perfect way to revise for your Computing lessons and assignments. From Beginner level, to Advanced.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="what-we pt-60 pb-60" style="background-color: #d3d3d3;">
        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="what-we-do">
                        <div class="what-we-do-content">
                            <h1>The best <span class="bold-color">Learning</span> tool</h1>
                            <p>The best way to show your knowledge in lessons, and ace those exams. With the courses being tailored
                                specifically to the GCSE curriculum, you have no need to worry about wasting time with difficult to
                                understand and unnecessary content!</p>

                            <p>Start learning now, and find fun in your revision. Expanding your knowledge, without the boredom!</p>
                        </div>
                        <div>
                            <a href="studentarea/" class="btn btn-primary btn-round btn-simple fa-beat" style="--fa-animation-duration: 5s; --fa-beat-scale: 1.1">Get Started</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php require "_partials/footer.php"; ?>



    <!-- JS here -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="assets/js/vendor/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/site.js"></script>
</body>

</html>