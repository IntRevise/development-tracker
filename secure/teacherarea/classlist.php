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
    updateLastSeen();
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
                            <h3>User Accounts</h3>
                            <h6>View and manage user accounts from the database</h6>
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

                    <table class="center">
                        <tr>
                            <th></th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                            <th>Account Type</th>
                            <th>Class</th>
                            <th>ID</th>
                            <th>Delete User</th>
                        </tr>
                        <?php
                        error_reporting(2);
                        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
                        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

                        $class = $_GET['class'];
                        $query = "SELECT * FROM accounts WHERE class_id='$class'";
                        $results = mysqli_query($con, $query);
                        $row_count = mysqli_num_rows($results);

                        while ($row = mysqli_fetch_array($results)) {
                        ?>
                            <form method="post" name="<?= $row['id'] ?>">
                                <tr class="adminpagedata adminpagetableentry">
                                    <td><img draggable="false" class="mini-pfp-50" src="<?= getProfilePicture($row['id']) ?>" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>></td>
                                    <td><a href="../../studentarea/statistics/profile/<?= $row['username'] ?>"><?= $row['username'] ?></td></a>
                                    <td><?= $row['firstname'] ?></td>
                                    <td><?= $row['lastname'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= determineAccountType($row['account_type']) ?></td>
                                    <td><?= $row['class_id'] ?></td>
                                    <td><?= $row['id'] ?></td>
                                    <td><a href2="modules/delete_account?id=<?= $row['id'] ?>" href="#delete-account"><i class="fad fa-trash"></i> Delete</a></td>
                                </tr>
                            </form>
                        <?php
                        }

                        mysqli_query($con, $query);
                        mysqli_close($con);
                        ?>
                    </table>

                    <empty name="bottom" id="bottom"></empty>

                    <script>
                        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                            anchor.addEventListener('click', function(e) {
                                e.preventDefault();

                                document.querySelector(this.getAttribute('href')).scrollIntoView({
                                    behavior: 'smooth'
                                });
                            });
                        });
                    </script>

                    <br><br>

                </div>
            </div>
        </div>

    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothScroll.js"></script>
    <script src="https://cdn.surge-networks.co.uk/assets/javascript/SmoothAnchor.js"></script>
</body>

</html>