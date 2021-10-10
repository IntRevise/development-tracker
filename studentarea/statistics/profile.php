    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
    $user = $_GET['user'];
    if (isset($user) == false || $user == "" || getData("accounts", "username", "username", $user) == "null") {
        header("Location: ../");
    }
    // We need to use sessions, so you should always start sessions using the below code.
    session_start();
    // Update last logged in
    updateLastSeen($_SESSION['id']);
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['loggedin'])) {
        header('Location: ../../login');
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
        <meta property="og:image" content="../../../assets/img/embed-logo.png" />
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
        <link rel="stylesheet" href="../../../assets/css/studentarea.css">

        <link href="https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    </head>

    <body>
        <?php require "../../_partials/navbar.php"; ?>

        <div class="banner-question">
            <div class="opacity-overlay" data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="question-title">
                                <div class="hori-align">
                                    <img style="cursor:default" id="profilepicture" src="<?= getProfilePicture(getData("accounts", "id", "username", $user)) ?>" draggable="false" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>>
                                    <!-- <a target="_blank" href="https://outlook.office.com/mail/deeplink/compose?to=<?= getData("accounts", "email", "username", $user) ?>"> -->
                                    <h3 id="up-al-item"><?= getData("accounts", "firstname", "username", $user) . " " . getData("accounts", "lastname", "username", $user) ?> (<?= getData("accounts", "username", "username", $user) ?>)</h3>
                                    <!-- </a> -->
                                    <h3 id="profile-icons">
                                        <?php
                                        if (getData("accounts", "is_bot", "username", $user) == 0) {
                                            if (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Student") {
                                        ?>
                                                <div class="tooltipProfileInfo">
                                                    <i class="fas fa-user-graduate pro-ico-blurple pro-ico"></i>
                                                    <span class="tooltipProfileInfoText">This user is a Student</span>
                                                </div>
                                            <?php
                                            } elseif (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Teacher") {
                                            ?>
                                                <div class="tooltipProfileInfo">
                                                    <i class="fas fa-user-tie pro-ico-red pro-ico"></i>
                                                    <span class="tooltipProfileInfoText">This user is a Teacher</span>
                                                </div>
                                            <?php
                                            } elseif (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Administrator") {
                                            ?>
                                                <div class="tooltipProfileInfo">
                                                    <i class="fas fa-user-graduate pro-ico-blurple pro-ico"></i>
                                                    <span class="tooltipProfileInfoText">This user is a Student</span>
                                                </div>
                                                <div class="tooltipProfileInfo">
                                                    <i class="fas fa-tools pro-ico-orange pro-ico"></i>
                                                    <span class="tooltipProfileInfoText">This user is a site Administrator & Developer</span>
                                                </div>
                                            <?php
                                            } elseif (true) {
                                            ?>
                                                asd
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="tooltipProfileInfo">
                                                <i class="fas fa-user-robot pro-ico-blue pro-ico"></i>
                                                <span class="tooltipProfileInfoText">This account is system bot</span>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </h3>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <main>
            <div class="row stats-td" style="margin-top:5x;margin-left: auto; margin-right: auto">
                <div class="col-sm-6" style="padding-top:20px">
                    <div class="card card-stats" style="max-height:771px;">
                        <div class="panel-body" style="padding:20px;">
                            <h2 class="title-hero sta-h2" style="font-size:1.8em;">
                                Account Information
                            </h2>
                            <br>
                            <h6>Account Type:
                                <b>
                                    <?= determineAccountType(getData("accounts", "account_type", "username", $user)) ?>
                                </b>
                            </h6>
                            <h6 title="<?= getData("accounts", "date_created", "username", $user) ?>">Account Created:
                                <b>
                                    <?= convertDate(getData("accounts", "date_created", "username", $user), "D, d M Y h:ia") ?>
                                </b>
                            </h6>
                            <?php
                            if (determineAccountType(getData("accounts", "account_type", "username", $user)) != "Teacher") {
                            ?>
                                <h6>Class:
                                    <b>
                                        <?php
                                        if (getData("classes", "className", "classId", getData("accounts", "class_id", "username", $user)) != "null") {
                                            echo getData("classes", "className", "classId", getData("accounts", "class_id", "username", $user));
                                        } else {
                                            echo "Not in a class!";
                                        }
                                        ?>
                                        </i>
                                    </b>
                                </h6>
                                <h6 title="<?= getData("accounts", "last_seen", "username", $user) ?>">Last Seen:
                                    <b>
                                        <?= convertDate(getData("accounts", "last_seen", "username", $user), "F j, g:i a") ?>
                                        </i>
                                    </b>
                                </h6>
                            <?php
                            }
                            ?>
                            <h6>Badges:
                                <?php
                                if (getData("accounts", "is_bot", "username", $user) == 0) {
                                    if (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Student") {
                                ?>
                                        <i title="Student" class="fas fa-user-graduate pro-ico-blurple"></i>
                                    <?php
                                    } elseif (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Teacher") {
                                    ?>
                                        <i title="Teacher" class="fas fa-user-tie pro-ico-red"></i>
                                    <?php
                                    } elseif (determineAccountType(getData("accounts", "account_type", "username", $user)) == "Administrator") {
                                    ?>
                                        <i title="Student" class="fas fa-user-graduate pro-ico-blurple"></i>
                                        <i title="Site Administrator" class="fas fa-user-hard-hat pro-ico-red"></i>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <i class="fas fa-user-robot pro-ico-blue"></i>
                                <?php
                                }
                                ?>
                            </h6>
                            <?php
                            if (determineAccountType(getData("accounts", "account_type", "username", $user)) != "Teacher") {
                            ?>
                                <h6>Level:
                                    <?= strstr(getPointsStatus($user), ' <') ?>
                                </h6>
                                <?php
                                if (getData("classes", "className", "classId", getData("accounts", "class_id", "username", $user)) != "null") {
                                ?>
                                    <h6>Teacher:
                                        <b>
                                            <?= getData("accounts", "firstname", "username", getData("classes", "teacher", "classId", getData("accounts", "class_id", "username", $user)))[0] . ". " . getData("accounts", "lastname", "username", getData("classes", "teacher", "classId", getData("accounts", "class_id", "username", $user))) ?>
                                        </b>
                                        </i>
                                    </h6>
                            <?php
                                }
                            }
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
                                            <i class="far fa-atom-alt text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Activity Points</p>
                                            <p class="card-title"><?= getPoints($user) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <hr>
                                <div class="stats">
                                    <i class="far fa-atom-alt"></i>Total Activity Points
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
                </div>
            </div>
        </main>

    </body>

    </html>