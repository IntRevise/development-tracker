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
                            <h3>Full Activity Logs</h3>
                            <h6>View all past activity logs of all users across the site</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main>

        <div class="album py-5">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    <a href="#bottom" class="center"><i class="fas fa-long-arrow-down"></i> Jump to bottom of page</a>
                    <br><br>

                    <?php
                    error_reporting(2);
                    $data = file_get_contents('modules/activity-logs.json');
                    $key = json_decode($data, true);

                    if (count($key) == 0) {
                    ?>
                        <div class="col-sm-12">
                            <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                <i class="start-icon fas fa-exclamation-triangle fa-fade"></i>
                                <strong class="font__weight-semibold">Error!</strong> There are no logs to display! Wait for a user to generate a log to start displaying action history.
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>

                        <table class="center">
                            <tr>
                                <th></th>
                                <th>Username</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>User ID</th>
                                <th>Timestamp</th>
                                <th>Action</th>
                                <th>Details</th>
                                <th>Delete Entry</th>
                            </tr>
                            <?php
                            foreach ($key as $key => $value) {
                            ?> <tr class="adminpagedata adminpagetableentry">
                                    <td><a href="../../studentarea/statistics/profile/<?= jsondecode($key, "username") ?>"><img draggable="false" width="35" height="35" style="border-radius:50%;object-fit: cover" src="<?= getProfilePicture(getData("accounts", "id", "username", jsondecodeReturn($key, "username"))) ?>" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>></a></td>
                                    <td><?= jsondecode($key, "username") ?></td>
                                    <td><?= jsondecode($key, "firstname") ?></td>
                                    <td><?= jsondecode($key, "lastname") ?></td>
                                    <td><?= jsondecode($key, "userId") ?></td>
                                    <td><?= jsondecode($key, "timestamp") ?></td>
                                    <td><?= jsondecode($key, "action") ?></td>
                                    <td id="tabledetails" title="<?= jsondecode($key, "details") ?>"><?= jsondecode($key, "details") ?></td>
                                    <td><a href="modules/delete_entry.php?id=<?= $key ?>">Delete <i class="fad fa-trash"></i></a></td>
                                </tr>
                            <?php } ?>
                        </table>

                    <?php } ?>

                    

                </div>
            </div>
        </div>

    </main>

<div id="bottom"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>