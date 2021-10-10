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
    require "modules/manage_functions.php";
    require "../../../_partials/scrollbar.php";
    checkAuthentication($id);
    updateLastSeen();
    error_reporting(0);
    $c = $_GET['classid'];
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
                            <h3>Class Student List
                                <?php
                                if (isset($c) == true && $c != "") {
                                    echo "- " . getData("classes", "className", "classId", $c);
                                }
                                ?>
                            </h3>
                            <h6>Listing all users in the selected class</h6>
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

                    <?php
                    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                    $conPre = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
                    $queryPre = "SELECT * FROM accounts WHERE class_id='$c' ORDER BY username";
                    $resultsPre = mysqli_query($conPre, $queryPre);
                    $row_countPre = mysqli_num_rows($resultsPre);
                    ?>

                    <?php
                    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

                    $query = "SELECT * FROM accounts WHERE class_id='$c' ORDER BY username";

                    $results = mysqli_query($con, $query);
                    $row_count = mysqli_num_rows($results);

                    if ($row_count == 0) {
                    ?>
                        <div class="col-sm-12">
                            <div class="alert fade alert-simple alert-danger alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                <i class="start-icon far fa-times-circle"></i>
                                <strong class="font__weight-semibold">Oh snap!</strong> There are no users to list! If you are the owner of this class, invite students with the class code.
                            </div>
                        </div>
                    <?php
                        return;
                    }

                    if (getData("accounts", "class_id", "username", getData("classes", "teacher", "classId", $c)) != $c) {
                    ?>
                        <div class="col-sm-12">
                            <div class="alert fade alert-simple alert-warning alert-dismissible text-left font__family-montserrat font__size-16 font__weight-light brk-library-rendered rendered show" role="alert" data-brk-library="component__alert">
                                <i class="start-icon fad fa-exclamation-triangle"></i>
                                <strong class="font__weight-semibold">Warning!</strong> You are viewing a class you are not the owner of! You will not be able to manage users of this class.
                            </div>
                        </div>
                    <?php
                    }
                    ?>

                    <table class="center">
                        <tr>
                            <th></th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Last Seen</th>
                            <th>Class</th>
                            <th>Kick User</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($results)) {
                        ?>
                            <tr class="adminpagedata adminpagetableentry">
                                <td><a href="../../../studentarea/statistics/profile/<?= $row['username'] ?>" target="_blank"><img draggable="false" class="mini-pfp-50" src="<?= getProfilePicture($row['id']) ?>" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>></a></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['firstname'] ?></td>
                                <td><?= $row['lastname'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td title="<?= convertDate($row['last_seen'], 'g:ia, l jS F Y') ?>"><?= convertDate($row['last_seen'], 'd/m/Y') ?></td>
                                <td><?= $row['class_id'] ?></td>
                                <?php
                                if (getData("accounts", "id", "username", $row['username']) == $_SESSION['id']) {
                                ?>
                                    <td>
                                        <a href="#" style="cursor:not-allowed" title="You cannot remove yourself!"><i class="fad fa-user-times"></i> Remove</a>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td>
                                        <a href2="modules/delete_account?id=<?= $row['id'] ?>" href="#remove"><i class="far fa-user-times"></i> Remove</a>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>

                        <?php
                        }
                        mysqli_query($con, $query);
                        mysqli_close($con);
                        ?>
                    </table>

                </div>
            </div>
        </div>

    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>