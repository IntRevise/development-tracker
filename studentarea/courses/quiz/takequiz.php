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

    <title>IntRevise - Take a Quiz</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="../../assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../../../../assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <link rel="stylesheet" href="../../../../assets/css/default.css">
    <link rel="stylesheet" href="../../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../../../assets/css/courses.css">
    <link rel="stylesheet" href="../../../../assets/css/quiz.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require "../../../_partials/scrollbar.php";
    $quiz = $_GET['id'];
    if (getData("course_items", "name", "id", $quiz) == "null") {
        header("Location: ../");
    }
    ?>
</head>

<body>

    <?php require "../../../_partials/navbar.php"; ?>

    <main>
        <div class="container py-4" style="margin-top: 50px">

            <div class="quiz-form">
                <header class="form-header center">
                    <div class="form-title">
                        <?= getData("course_items", "name", "id", $quiz) ?> Quiz
                    </div>
                    <div class="form-description">
                        <?php
                        function secondsToTime($seconds)
                        {
                            $dtF = new \DateTime('@0');
                            $dtT = new \DateTime("@$seconds");
                            return $dtF->diff($dtT)->format('%i Minutes'); # %a days, %h hours, %i minutes and %s seconds
                        }
                        echo secondsToTime(getData("course_items", "time_limit", "id", $quiz))
                        ?>
                        <br>
                        <br>
                        <a href="../takequiz/<?= $quiz ?>" class="btn btn-primary btn-round btn-simple fa-beat" style="--fa-animation-duration: 5s; --fa-beat-scale: 1.05;color: white; background: #4c96e5">Begin Quiz Now</a>
                        <br>
                        <br>
                        <a href="../../" class="btn btn-primary btn-round btn-simple" style="color: white; background: #A40202">Go Back</a>
                    </div>
                </header>
                <hr class="quiz-break center">
                </h2>
                <form action="?">
                </form>
            </div>

        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../../../assets/js/quiz-scripts.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>