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

    <title>IntRevise - Teacher Area</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="https://intrevise.axtonprice.com/assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="../../../assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v6.0.0-beta1/css/all.css">
    <link rel="stylesheet" href="../../../assets/css/default.css">
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/responsive.css">

    <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

    <!-- PHP -->
    <?php
    require "modules/new_functions.php";
    require "../../../_partials/scrollbar.php";
    $stat = new getStat();
    checkAuthentication($id);
    updateLastSeen();
    error_reporting(0);
    ?>
</head>

<body>

    <?php require "../../../_partials/navbar_teacher.php"; ?>

    <div class="banner-question">
        <div class="opacity-overlay" data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="question-title">
                            <h3>Create New Assignment</h3>
                            <h6>Create and assign a task for one of your classes</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact pb-60" style="margin-top: 50px">
        <div class="container">

            <?= errorHandler(); ?>
            <?= noClassesCheck("You do not have any classes! You must have at least one class before creating assignments!") ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <form action="modules/new_assignment.php">

                    <label for="classname">Assignment Title:‎‎ <required title="This field is required">*</required></label>
                    <br>
                    <input class="form-input" type="text" id="asgn_title" name="asgn_title" placeholder="Example: Data Representation" required>
                    <br><br>

                    <label for="classname">Assignment Description:‎‎ <required title="This field is required">*</required></label>
                    <br>
                    <textarea class="form-textarea" type="text" id="asgn_desc" name="asgn_desc" placeholder="Example: Please complete this task before next lesson." required></textarea>
                    <br><br>

                    <label for="classname">Due Date:‎‎ <required title="This field is required">*</required></label>
                    <br>
                    <input class="form-input" type="date" id="asgn_date" name="asgn_date" value="<?= date('Y-m-d') ?>" required>
                    <br><br>

                    <label for="classname">Set For Class:‎‎ <required title="This field is required">*</required></label>
                    <br>
                    <select class="form-input" name="asgn_class" id="asgn_class" required>
                        <option disabled>Please select a class</option>
                        <?php error_reporting(2);
                        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                        $username = getData("accounts", "username", "id", $_SESSION['id']);
                        $query = "SELECT * FROM classes WHERE teacher='$username'";
                        $results = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_array($results)) {
                        ?>
                            <option name="asgn_class" value="<?= $row['classId'] ?>"><?= $row['className'] . " • " . $stat->countClassUsers($row['classId']) . " Students" ?></option>
                        <?php
                        }
                        mysqli_query($con, $query);
                        mysqli_close($con);
                        ?>
                    </select>
                    <br><br>

                    <input type="submit" value="Save & Post Assignment" style="color: white" class="btn btn-primary btn-round btn-simple"></a>
                </form>

            </div>
        </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
        <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>