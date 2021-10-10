<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
//  && !isset($_COOKIE['loggedIn']) || $_COOKIE['loggedIn'] == ""
if (!isset($_SESSION['loggedin'])) {
    header('Location: .');
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

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/_partials/scrollbar.php";
    updateLastSeen();
    isAccountDisabled();
    $asgn = $_GET['asgn'];
    if(getData("assignments", "title", "id", $asgn) == "null"){
        header("Location: ./");
    }
    if(getData("accounts", "class_id", "id", $_SESSION['id']) != getData("assignments", "assignedClassId", "id", $asgn)){
        header("Location: ./");
    }
    ?>
</head>

<body class="loggedin">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/_partials/navbar.php"; ?>

    <div class="banner-question">
        <div class="opacity-overlay " data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="question-title">
                            <h3>Viewing Assignment</h3>
                            <h6>
                                Due for
                                <b><?= getData("accounts", "firstname", "username", getData("assignments", "teacher", "id", $asgn)) . " " . getData("accounts", "lastname", "username", getData("assignments", "teacher", "id", $asgn)) ?></b>,
                                on <b><?= convertDate(getData("assignments", "dueDate", "id", $asgn), 'l \t\h\e jS M') ?>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact pb-40 center" style="margin-top: 50px; border-style: solid; border-color: lightgray; border-width: 3px; max-width: 80em">
        <div class="container">

            <?php errorHandler(); ?>

            <div class="content">
                <br>
                <h2><?= getData("assignments", "title", "id", $asgn) ?></h2>
                <br>
                <p class="lead text-muted">
                    <?= getData("assignments", "description", "id", $asgn) ?>
                </p>
                <p class="lead text-muted">
                    Due for
                    <b><?= getData("accounts", "firstname", "username", getData("assignments", "teacher", "id", $asgn)) . " " . getData("accounts", "lastname", "username", getData("assignments", "teacher", "id", $asgn)) ?></b>,
                    on <b><?= convertDate(getData("assignments", "dueDate", "id", $asgn), 'l \t\h\e jS \o\f F') ?>.
                </p>
                <p class="lead text-muted">
                    This assignment was set for class <?= getData("classes", "className", "classId", getData("assignments", "assignedClassId", "id", $asgn)) ?>.
                </p>
                <br>
                <a href="<?= getData("assignments", "trackPath", "id", $asgn) ?>" class="btn btn-primary btn-round btn-simple center" style="color: white; background: #4c96e5; max-width:20em">Go to Assignment</a>
            </div>
        </div>
    </section>

    <br>
    <br>

    <div class="center">
        <a href="./" class="btn btn-secondary btn-round btn-simple center" style="color: white; background: gray; max-width:20em">Return to Dashboard</a>
    </div>

    <br>

</body>

</html>