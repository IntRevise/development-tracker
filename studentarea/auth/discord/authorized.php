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
    <link rel="manifest" href="manifest.json">

    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>Account Linked - IntRevise</title>
    <meta name="og:description" content="Woottons very own, all-in-one platform for Computer Science and IT. Containing all the perfect & necessary GCSE topics for computer science revision and teaching. Also including perfect live class teaching resources inspired by Kahoot and Spiral.">
    <meta property="og:image" content="https://intrevise.axtonprice.com/assets/img/embed-logo.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property='og:type' content='article' />
    <meta property='og:site_name' content='IntRevise <?php echo date("Y") ?>' />

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

    <!-- Highlight JS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.1.0/styles/default.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.1.0/highlight.min.js"></script>
    <script>
        hljs.highlightAll();
    </script>

    <!-- PHP -->
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
    function decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    ?>

</head>

<body>

    <section class="header-section">

        <?php require "../../../_partials/navbar.php"; ?>

        <div class="header-content version_2">
            <div class="opacity-overlay " data-opacity-mask="rgba(0, 0, 0, 0.8)" style="background-color: rgba(0, 0, 0, 0.8);">
                <div class="container">
                    <div class="row row-padding">
                        <div class="col-xl-7 col-lg-6 col-md-6">
                            <div class="header-content-body" style="padding-bottom: 80px;">
                                <h1><img draggable="false" src="https://cdn.discordapp.com/avatars/<?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "id") ?>/<?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "avatar") ?>.png" style="max-height:80px;border-radius:50px" <?= onError("https://cdn.surge-networks.co.uk/uploads/default-discord-avatar.png") ?>> Thank You!</h1>
                                <p>Your Discord account, <b><?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "username") . "#" . doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "discriminator") ?></b>, has successfully been linked to your IntRevise account, <b><?= getData("accounts", "username", "id", doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "account_id")) ?></b>.</p>
                                <br>
                                <pre><code>Username: <b><?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "username") . "#" . doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "discriminator") ?></b><br>
Avatar: <b><?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "avatar") ?></b><br>
User ID: <b><?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "id") ?></b><br>
Linked To: <b><?= getData("accounts", "username", "id", doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "account_id")) ?> (<?= doubleParamApiRequest("custom/getSiteToDiscordData", "id", $_SESSION['id'], "data", "account_id") ?>)</b><br>
Timestamp: <b><?= date("Y-m-d H:i:s") ?></b>
</code></pre>
                                <br>
                                <div>
                                    <a href="../" class="btn btn-primary btn-round btn-simple">Student Area</a>
                                </div>

                                <br>
                                <p class="text-muted">- IntRevise Development Team</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>

</html>