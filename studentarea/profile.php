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
                            <h3>Account Settings</h3>
                            <h6>Manage and view your account details</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact pb-60" style="margin-top: 50px">
        <div class="container">

            <?= errorHandler(); ?>
            <?= isEmailVerified() ?>

            <div class="content">
                <br>
                <h2>Account Settings - <a style="color:#2BA3DA" href="statistics/profile/<?= getData("accounts", "username", "id", $id) ?>">My Stats</a></h2>
                <br>
                <div>
                    <form id="imageuploadform" method="post" action="modules/file_upload" enctype="multipart/form-data">
                        <div id="profilepictureupload">
                            <div id="profilepicture">
                                <div class="image-upload">
                                    <label for="fileToUpload">
                                        <img id="profilepicture" src="<?= getProfilePicture($_SESSION['id']) ?>" draggable="false" <?= onerror("https://cdn.surge-networks.co.uk/assets/content/uploads/noimg.png") ?>>
                                    </label>
                                    <input name="fileToUpload" id="fileToUpload" type="file" hidden onchange="form.submit()">
                                </div>
                            </div>
                            <div id="profilepicturetext">
                                <span id="profilepicturetext"><i class="fas fa-angle-left"></i> Click to upload profile picture</span>
                                <a href="modules/reset_profile_picture"><span id="profilepicturetext reset">Reset profile picture</span></a><br>
                                <span id="profilepicturetextsmall">Recommended: 200x200 - 400x400</span>
                            </div>
                        </div>
                    </form>

                    <form method="post" action="modules/save_profile">

                        <label for="save_email">Email:‎‎ <required title="This field is required">*</required></label>
                        <br>
                        <input class="form-input" type="email" id="save_email" name="save_email" value="<?= getData("accounts", "email", "id", $id) ?>" required>
                        <?php if (getData("accounts", "is_email_verified", "id", $_SESSION['id']) == 0) {
                            echo '<x style="color:red">Unverified</x>';
                        } ?>
                        <br><br>

                        <label for="save_username">Username: <required title="This field is required">*</required></label>
                        <br>
                        <input class="form-input" type="text" id="save_username" name="save_username" value="<?= getData("accounts", "username", "id", $id) ?>" required>
                        <br><br>

                        <label for="save_firstname">First Name: <required title="This field is required">*</required></label>
                        <br>
                        <input class="form-input" type="text" id="save_firstname" name="save_firstname" value="<?= getData("accounts", "firstname", "id", $id) ?>" required>
                        <br><br>

                        <label for="save_lastname">Last Name: <required title="This field is required">*</required></label>
                        <br>
                        <input class="form-input" type="text" id="save_lastname" name="save_lastname" value="<?= getData("accounts", "lastname", "id", $id) ?>" required>
                        <br><br>

                        <label for="save_yeargroup">Yeargroup:</label>
                        <br>
                        <input class="form-input" type="number" min="9" max="11" id="save_yeargroup" name="save_yeargroup" <?= determineYearGroup(getData("accounts", "yeargroup", "id", $id)); ?> placeholder="You have not set your year group!">
                        <br><br>

                        <input type="submit" value="Save" style="color: white" class="btn btn-primary btn-round btn-simple"></a>
                    </form>

                    <br><br>

                    <?php
                    if(singleParamApiRequest("custom/isAccountLinkedDiscord", "id", $_SESSION['id']) === "true"){
                    ?>
                    <h2 class="zone-text" id="connections">My Connections</h2>
                    <br>
                    <div id="conectionbox">
                        <img src="https://intrevise.axtonprice.com/assets/img/uploads/discord-logo-color.png" style="height: 80px">
                        <name class="connectiontitle">Discord • 
                            <small class="connectiondetail">
                                <?=doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "username")?>#<?=doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "discriminator")?>
                            </small></name>
                        <a href="https://intrevise.axtonprice.com/studentarea/auth/discord/unlink" class="btn btn-round btn-simple danger-button"><i class="fas fa-sign-out-alt"></i> Disconnect</a>
                    </div>
                    <br><br>
                    <?php
                    }
                    ?>

                    <h2 class="danger zone-text">Danger Zone</h2>

                    <form method="post" action="modules/save_password">
                        <br>
                        <label for="save_password">Password:‏‏‎</label>
                        <br>
                        <input class="form-input" type="password" id="save_password" name="save_password" placeholder="Set new account password">
                        <br><br>
                        <input type="submit" value="Update Password" style="color: white" class="btn btn-primary btn-round btn-simple"></a>
                    </form>

                    <br><br>

                    <button <?php
                            if (getData("accounts", "account_type", "id", $id) == "admin") {
                                echo "onclick=\"confirmationPopup('leave');\" style='color: white'";
                            } else {
                                echo "onclick2=\"confirmationPopup('leave');\" style='color: white; cursor: not-allowed'";
                            } ?> class="btn btn-round btn-simple danger-button"><i class="fas fa-sign-out-alt"></i> Leave Class
                    </button>
                    <button <?php
                            if (getData("accounts", "account_type", "id", $id) == "admin") {
                                echo "onclick=\"confirmationPopup('delete');\" style='color: white'";
                            } else {
                                echo "onclick2=\"confirmationPopup('delete');\" style='color: white; cursor: not-allowed'";
                            } ?> class="btn btn-round btn-simple danger-button"><i class="fas fa-trash-alt"></i> Delete Account
                    </button>
                </div>

                <?php if (getData("accounts", "account_type", "id", $id) == "admin") { ?>
                    <script>
                        function confirmationPopup(type) {
                            if (type == "delete") {
                                if (confirm("Are you sure you want to delete your account? This cannot be undone, and you will lose all your progress!")) {
                                    window.location.replace("modules/delete_account");
                                }
                            }
                            if (type == "leave") {
                                if (confirm("Are you sure you want to leave your class? You can rejoin a class on the student dashboard")) {
                                    window.location.replace("modules/leave_class");
                                }
                            }
                        }
                    </script>
                <?php
                } ?>


            </div>
        </div>
    </section>

</body>

</html>