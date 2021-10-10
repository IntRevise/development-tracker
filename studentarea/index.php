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

    <title>IntRevise - Student Area</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="https://intrevise.axtonprice.com/assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <link rel="stylesheet" href="../assets/css/default.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/studentarea.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script type="text/javascript">
        function display_c() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct()', refresh)
        }
        function display_ct() {
            let now = new Date();
            var dateString = now.toLocaleDateString('en-gb', { weekday:"long", month:"long", day:"numeric", hour:"numeric", minute:"numeric", hour12:true})
            document.getElementById('ct').innerHTML = dateString;
            display_c();
        }
    </script>

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/_partials/scrollbar.php";
    updateLastSeen();
    checkLeaderboardPresence($_SESSION['id']);
    isAccountDisabled();
    ?>
</head>

<body onload=display_ct();>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/_partials/navbar.php"; ?>

    <div class="banner-question">
        <div class="opacity-overlay" data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="question-title">
                            <h3><?= determineGreeting() ?></h3>
                            <h6><span id='ct'></span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact" style="margin-top: 50px">
        <div class="container">
            <?= errorHandler(); ?>
            <?= isEmailVerified() ?>
        </div>
    </section>

    <?php
    if (getData("accounts", "class_id", "id", $id) !== "") {
    ?>

        <section class="py-1 text-center container">
            <div class="row py-lg-4">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h3 class="sta-h3" style="margin-bottom: 0px;">You are <?= singleParamApiRequest("userStatus", "u", getData("accounts", "username", "id", $_SESSION['id'])) ?> <img src="<?= getPointsBadge(getData("accounts", "username", "id", $_SESSION['id'])) ?>" draggable="false" style="height:30px; width:30px;margin-left: 5px;margin-right: 5px"> with <strong><?= singleParamApiRequest("userPoints", "u", getData("accounts", "username", "id", $_SESSION['id'])) ?></strong> Activity Points </h3>
                </div>
            </div>
        </section>

        <div class="row stats-td">
            <div class="row">
                <div class="row" style="margin-top:5x;margin-left:0px;margin-right:0px;">
                    <div class="col-sm-6" style="padding-top:20px">
                        <div class="card card-stats" style="max-height:771px;">
                            <div class="panel-body" style="padding:20px;">
                                <h2 class="title-hero sta-h2" style="font-size:1.8em;">
                                    Notifications and Assignments
                                </h2>
                                <br>
                                <?php
                                $myClass = getData("accounts", "class_id", "id", $_SESSION['id']);
                                $query = "SELECT * FROM assignments WHERE assignedClassId='$myClass'";
                                $results = mysqli_query($con, $query);
                                $row_count = mysqli_num_rows($results);

                                while ($row = mysqli_fetch_array($results)) {
                                ?>
                                    <a href="viewassignment?asgn=<?= $row['id'] ?>">
                                        <div class="col-sm-12">
                                            <div class="alert fade alert-simple alert-info alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                                <strong class="font__weight-semibold"><?= $row['title'] ?> - </strong> Due on <?= convertDate($row['dueDate'], "D d M, Y") ?>, for <?= getData("accounts", "username", "username", $row['teacher']) ?>.
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }

                                if (mysqli_num_rows($results) == 0) {
                                ?>
                                    <div class="col-sm-12">
                                        <div class="alert fade alert-simple alert-success alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                            <i class="fas fa-bells"></i> <strong class="font__weight-semibold">Hooray!</strong> You have no upcoming assignments due!
                                        </div>
                                    </div>
                                <?php
                                }

                                mysqli_query($con, $query);
                                mysqli_close($con);
                                ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding-top:20px">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="far fa-chart-line text-success"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Completed / Tries</p>
                                                <p class="card-title">0 / 0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fal far fa-chart-line"></i>Total Tests attempted
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="fal fa-analytics text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Topics Covered</p>
                                                <p class="card-title">0</p>
                                                <p>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fal fa-analytics"></i>Topics covered
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="far fa-stopwatch text-danger"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Time Spent</p>
                                                <p class="card-title">00:00:00</p>
                                                <p>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="far fa-stopwatch"></i> Completing Assignments
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-5 col-md-4">
                                            <div class="icon-big text-center icon-warning">
                                                <i class="far fa-wave-square text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-7 col-md-8">
                                            <div class="numbers">
                                                <p class="card-category">Average % Score</p>
                                                <p class="card-title">0</p>
                                                <p>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="far fa-wave-square"></i>Average Score
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php
    } else {
        $import->noClassFound();
    }
    ?>

</body>

</html>