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
    $stat = new getStat();
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
                            <h3><?= determineGreeting() ?></h3>
                            <h6><?= date('l jS \of F, h:i A') ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-3 text-center container">
        <div class="row py-lg-4">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light" id="logs">Live Statistics</h1>
                <p class="lead text-muted">Automatically updated statistics based on all database tables and data entries across the site</p>
            </div>
        </div>
    </section>

    <section class="py-2 text-center container hori-align">
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-users icon-4x"></i>
                    </div>
                    <div class="col-lg-4">
                        <h3><?= $stat->getUsers() ?></h3>
                        <span class="subtextamdin">
                            <?php
                            if ($stat->getUsers() == 1) {
                                echo "User";
                            } else {
                                echo "Users";
                            }
                            ?>
                        </span>
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
                        <h3><?= $stat->getClasses() ?></h3>
                        <span class="subtextamdin">
                            <?php
                            if ($stat->getClasses() == 1) {
                                echo "Class";
                            } else {
                                echo "Classes";
                            }
                            ?>
                        </span>
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
                        <h3><?= $stat->getAssignments() ?></h3>
                        <span class="subtextamdin">
                            <?php
                            if ($stat->getAssignments() == 1) {
                                echo "Assignment";
                            } else {
                                echo "Assignments";
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-2 text-center container hori-align">
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-ballot icon-4x"></i>
                    </div>
                    <div class="col-lg-3">
                        <h3><?php
                            $jsonData = file_get_contents("modules/activity-logs.json");
                            $data = json_decode($jsonData, true);
                            $total = count($data);
                            echo $total;
                            ?></h3>
                        <span class="subtextamdin">
                            <?php
                            if ($total == 1) {
                                echo "Activity Log";
                            } else {
                                echo "Activities";
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-user-hard-hat icon-4x"></i>
                    </div>
                    <div class="col-lg-3">
                        <h3>
                            <?php error_reporting(2);
                            require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                            $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                            $query = "SELECT * FROM accounts WHERE account_type = 'admin'";
                            $results = mysqli_query($con, $query);
                            $row_count = mysqli_num_rows($results);
                            echo $row_count;
                            ?>
                        </h3>
                        <span class="subtextamdin">
                            <?php
                            if ($row_count == 1) {
                                echo "Administrator";
                            } else {
                                echo "Administrators";
                            }
                            mysqli_query($con, $query);
                            mysqli_close($con);
                            ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="stat-outline">
                <div class="row">
                    <div class="col-lg-5">
                        <i class="fad fa-chalkboard-teacher icon-4x"></i>
                    </div>
                    <div class="col-lg-3">
                        <h3>
                            <?php error_reporting(2);
                            require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                            $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                            $query = "SELECT * FROM accounts WHERE account_type = 'teacher'";
                            $results = mysqli_query($con, $query);
                            $row_count = mysqli_num_rows($results);
                            echo $row_count;
                            ?>
                        </h3>
                        <span class="subtextamdin">
                            <?php
                            if ($row_count == 1) {
                                echo "Teacher";
                            } else {
                                echo "Teachers";
                            }
                            mysqli_query($con, $query);
                            mysqli_close($con);
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>

    <hr class="mini-breakline">

    <section class="py-3 text-center container">
        <div class="row py-lg-4">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light" id="logs">User Accounts</h1>
                <p class="lead text-muted">View all user accounts on the database</p>
            </div>
        </div>
    </section>

    <div class="album">
        <div class="container">

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                <table class="center">
                    <tr>
                        <th></th>
                        <th>Username</th>
                        <th>Firstname</th>
                        <th>Lastname</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Class</th>
                        <th>Last Seen</th>
                        <th>ID</th>
                    </tr>
                    <?php error_reporting(2);
                    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

                    $query = "SELECT * FROM accounts ORDER BY id";
                    $results = mysqli_query($con, $query);
                    $row_count = mysqli_num_rows($results);

                    while ($row = mysqli_fetch_array($results)) {
                    ?>
                        <tr class="adminpagedata adminpagetableentry">
                            <td><a href="../../studentarea/statistics/profile/<?= $row['username'] ?>"><img draggable="false" class="mini-pfp-35" src="<?= getProfilePicture($row['id']) ?>" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>></a></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['firstname'] ?></td>
                            <td><?= $row['lastname'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= determineAccountType($row['account_type']) ?></td>
                            <td><?= $row['class_id'] ?></td>
                            <td title="<?= convertDate($row['last_seen'], "F j, Y, g:i a") ?>"><?= convertDate($row['last_seen'], 'h:ma - d/m/y') ?></td>
                            <td><?= $row['id'] ?></td>
                        </tr>
                    <?php
                    }

                    mysqli_query($con, $query);
                    mysqli_close($con);
                    ?>
                </table>

                <a class="tableundertext" href="users"><i class="fas fa-external-link"></i> View full user list</a>
                <br><br>

            </div>
        </div>

        <hr class="mini-breakline">

        <section class="py-3 text-center container">
            <div class="row py-lg-4">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <h1 class="fw-light" id="logs">Activity History</h1>
                    <p class="lead text-muted">View and manage activity history of all users across the website</p>
                </div>
            </div>
        </section>

        <main>

            <style>
                .adminpagedata:nth-child(n+8) {
                    display: none;
                }
            </style>

            <div class="album">
                <div class="container">

                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">

                        <table class="center">
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Username</th>
                                <th scope="col">Firstname</th>
                                <th scope="col">Lastname</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Timestamp</th>
                                <th scope="col">Action</th>
                                <th scope="col">Details</th>
                            </tr>
                            <?php error_reporting(2);
                            $data = file_get_contents('modules/activity-logs.json');
                            $key = json_decode($data, true);

                            foreach ($key as $key => $value) {
                            ?> <tr class="adminpagedata adminpagetableentry" title="<?= jsondecode($key, "firstname") ?> <?= jsondecode($key, "lastname") ?>">
                                    <td><a href="../../studentarea/statistics/profile/<?= jsondecode($key, "username") ?>"><img draggable="false" class="mini-pfp-35" src="<?= getProfilePicture(getData("accounts", "id", "username", jsondecodeReturn($key, "username"))) ?>" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>></a></td>
                                    <td><?= jsondecode($key, "username") ?></td>
                                    <td><?= jsondecode($key, "firstname") ?></td>
                                    <td><?= jsondecode($key, "lastname") ?></td>
                                    <td><?= jsondecode($key, "userId") ?></td>
                                    <td title="<?= jsondecodeReturn($key, "timestamp") ?>"><?= convertDate(jsondecodeReturn($key, "timestamp"), "h:ma - d/m/y") ?></td>
                                    <td><?= jsondecode($key, "action") ?></td>
                                    <td id="tabledetails" title="<?= jsondecode($key, "details") ?>"><?= jsondecode($key, "details") ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                        <a class="tableundertext" href="activity"><i class="fas fa-external-link"></i> View all activity logs</a>
                        <br><br><br><br>

                    </div>
                </div>
            </div>

        </main>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
        <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>

</body>

</html>