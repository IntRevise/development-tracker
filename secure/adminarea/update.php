<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: https://intrevise.axtonprice.com/studentarea/login');
    exit();
}
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT yeargroup, password, email, account_type, class_id, id FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($yeargroup, $password, $email, $type, $class, $id);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html class="no-js" lang="English" prefix="og: https://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale = 1.0, user-scalable = no">

    <title>IntRevise - Admin Area</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="https://intrevise.axtonprice.com/assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <link rel="stylesheet" href="../../assets/css/default.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
    checkAuthentication($id);

    ?>
</head>

<body>

    <?php require "../../_partials/navbar_admin.php"; ?>

    <div class="banner-question">
        <div class="opacity-overlay" data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="question-title">
                            <h3>Check for Updates</h3>
                            <h6>Update version directly from the development site</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #Progress_Status {
            width: 50%;
            background-color: #ddd;
        }

        #myprogressBar {
            display: none;
            width: 0%;
            height: 35px;
            background-color: #4CAF50;
            text-align: center;
            line-height: 32px;
            color: black;
        }

        #updateButton {
            display: none;
        }
    </style>

    <main>

        <div class="album py-5">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    <div id="Progress_Status">
                        <div id="myprogressBar">Checking..</div>
                    </div>

                    <br>
                    <button onclick="updateCheck()" id="buttonCheck">check for updates</button>

                    <div id="id01">old heading</div>

                    <button id="updateButton" onclick="downloadUpdate()">download update</button>


                    <?php
                    function latestVersion()
                    {
                        $json = file_get_contents('https://intrevise.axtonprice.com/secure/adminarea/updater/versionQuery?v=1.0.0');
                        // $obj = json_decode($json);
                        echo $json;
                    }
                    ?>

                    <script>
                        function updateCheck() {
                            var element = document.getElementById("myprogressBar");
                            var width = 0;
                            var identity = setInterval(scene, 10);

                            element.style.display = 'block';

                            function scene() {
                                if (width >= 100) {
                                    clearInterval(identity);
                                } else {
                                    width++;
                                    element.style.width = width + '%';
                                    element.innerHTML = width * 1 + '%';
                                }
                            }

                            setTimeout(
                                function() {
                                    const btnHide = document.getElementById("buttonCheck");
                                    btnHide.style.display = 'none';

                                    const text = document.getElementById("id01");
                                    text.innerHTML = "<?=latestVersion()?>";

                                    const button = document.getElementById("updateButton");
                                    button.style.display = 'block';

                                }, 1000);
                        }
                    </script>

                </div>

            </div>
        </div>

    </main>

    <div id="bottom"></div>

    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>