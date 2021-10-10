<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>IntRevise</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="manifest.json">
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
    require "studentarea/modules/functions.php";
    require "_partials/scrollbar.php";
    ?>
</head>

<body>

    <?php require "_partials/navbar.php"; ?>
    <div class="banner-question">
        <div class="opacity-overlay " data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="question-title">
                            <h3>Meet the Team</h3>
                            <h6>Meet the small team who develop and maintain IntRevise</h6>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section class="mentor pt-60 pb-60">
        <div class="container profile-page">
            <div class="row">

                <div class="col-xl-6 col-lg-7 col-md-12 noclick">
                    <div class="card profile-header">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="profile-image float-md-right">
                                        <img src="<?= file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatar?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=deqmas") ?>" draggable="false" alt="Mason de Quincey">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-12">
                                    <h4 class="m-t-0 m-b-0">Mason de Quincey</h4>
                                    <span class="job_post">Programming</span>
                                    <p>Year 11, GCSE Student</p>
                                    <div>
                                        <a href="mailto:deqmas@wootton.beds.sch.uk" style="color: white; background: #4c96e5" class="btn btn-primary btn-round btn-simple">Contact</a>
                                    </div>
                                    <p class="social-icon mt-10">
                                        <a title="Github" target="_blank" href="https://github.com/masondq?ref=intrevise"><i class="fab fa-github"></i></a>
                                        <a title="Portfolio" target="_blank" href="https://lab.surge-networks.co.uk/mason?ref=intrevise"><i class="fas fa-user"></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-6 col-lg-7 col-md-12 noclick">
                    <div class="card profile-header">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="profile-image float-md-right">
                                        <img src="<?= file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatar?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=priroa") ?>" draggable="false" alt="Roan Price">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-12">
                                    <h4 class="m-t-0 m-b-0">Roan Price</h4>
                                    <span class="job_post">Programming, Web Development</span>
                                    <p>Year 11, GCSE Student</p>
                                    <div>
                                        <a href="mailto:priroa@wootton.beds.sch.uk" style="color: white; background: #4c96e5" class="btn btn-primary btn-round btn-simple">Contact</a>
                                    </div>
                                    <p class="social-icon mt-10">
                                        <a title="Website" target="_blank" href="https://axtonprice.com?ref=intrevise"><i class="fas fa-globe"></i></a>
                                        <a title="Github" target="_blank" href="https://github.com/axtonprice?ref=intrevise"><i class="fab fa-github"></i></a>
                                        <a title="Spotify" target="_blank" href="https://open.spotify.com/user/4vaxa6cb9diyaj9741lwu307m?ref=intrevise"><i class="fab fa-spotify"></i></a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <br>
    <?php require "_partials/footer.php"; ?>

    <!-- JS here -->
    <script src="assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="assets/js/vendor/jquery-3.2.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/ajax-form.js"></script>
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>