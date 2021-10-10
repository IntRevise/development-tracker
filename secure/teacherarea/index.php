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
    $stat = new getStat();
    checkAuthentication($id);
    updateLastSeen();
    ?>
</head>

<body>
    <?php require "../../_partials/navbar_teacher.php"; ?>

    <div class="banner-question">
        <div class="opacity-overlay" data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="question-title">
                            <h3><?= determineGreeting() ?></h3>
                            <h6><?= date('l jS \of F, h:i A') ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-2 text-center container">
        <div class="row py-lg-4">
            <div class="col-lg-6 col-md-2 mx-auto">
                <h1 class="fw-light" id="logs">Your Statistics</h1>
                <p class="lead text-muted">Automatically updated statistics based on all database tables and data entries across the site</p>
                <small class="text-muted">N/A = Coming Soon</small>
            </div>
        </div>
    </section>

    <section class="py-1 text-center container hori-align">
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-users icon-4x"></i>
                    </div>
                    <div class="col-lg-4">
                        <h3>N/A</h3>
                        <span class="subtextamdin">Users</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-users-class icon-4x"></i>
                    </div>
                    <div class="col-lg-4">
                        <h3><?= $stat->getMyClasses() ?></h3>
                        <span class="subtextamdin">Classes</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-newspaper icon-4x"></i>
                    </div>
                    <div class="col-lg-4">
                        <h3><?= $stat->getMyAssignments() ?></h3>
                        <span class="subtextamdin">Assignments</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>

    <hr class="mini-breakline">

    <?php error_reporting(2);
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con2 = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $username2 = getData("accounts", "username", "id", $_SESSION['id']);
    $query2 = "SELECT * FROM classes WHERE teacher='$username2'";
    $results2 = mysqli_query($con2, $query2);
    $row_count2 = mysqli_num_rows($results2);

    if ($row_count2 !== 0) {
    ?>
        <section class="py-3 text-center container">
            <div class="row py-lg-4">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light" id="logs">My Classes</h1>
                    <p class="lead text-muted">Listing all classes created by you.</p>
                </div>
            </div>
        </section>

        <div class="album">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                    <table class="center">
                        <tr>
                            <th>Class UID</th>
                            <th>Class Code</th>
                            <th>Class Name</th>
                            <th>Class Creator</th>
                            <th>Students</th>
                            <th>Created</th>
                        </tr>
                        <?php error_reporting(2);
                        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                        $username = getData("accounts", "username", "id", $_SESSION['id']);

                        $query = "SELECT * FROM classes WHERE teacher='$username'";
                        $results = mysqli_query($con, $query);
                        $row_count = mysqli_num_rows($results);

                        while ($row = mysqli_fetch_array($results)) {
                        ?>
                            <tr class="adminpagedata adminpagetableentry">
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['classId'] ?></td>
                                <td><?= $row['className'] ?></td>
                                <td><?= getData("accounts", "firstname", "username", $row['teacher']) . " " . getData("accounts", "lastname", "username", $row['teacher']) ?></td>
                                <td><?= $stat->countClassUsers($row['classId']) ?> <a href="manage/classusers?classid=<?= $row['classId'] ?>">(View)</a></td>
                                <td title="<?= convertDate($row['dateCreated'], 'g:ia, l jS F Y') ?>"><?= convertDate($row['dateCreated'], 'd/m/Y') ?></td>
                            </tr>
                        <?php
                        }

                        mysqli_query($con, $query);
                        mysqli_close($con);
                        ?>
                    </table>

                    <a class="tableundertext" href="manage/myclasses"><i class="fas fa-external-link"></i> View full class list</a>
                    <br><br>

                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <section class="py-3 text-center container">
            <div class="row py-lg-4">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light" id="logs">You have no classes!</h1>
                    <p class="lead text-muted">It appears you have not created a class yet! Create one below, and start tracking students progress!</p>
                    <div>
                        <a href="new/newclass" class="btn btn-primary btn-round btn-simple fa-beat" style="--fa-animation-duration: 5s; --fa-beat-scale: 1.1;color: white; background: #4c96e5">Create new Class</a>
                    </div>
                </div>
            </div>
        </section>
        <br>
    <?php
    }
    ?>
    <br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>

</body>

</html>