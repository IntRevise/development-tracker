<?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
date_default_timezone_set('Europe/London');
error_reporting(0);

function determineAccountType($type)
{
    if ($type == "student" || $type == "") {
        return "Student";
    } elseif ($type == "teacher") {
        return "Teacher";
    } elseif ($type == "admin") {
        return "Administrator";
    } else {
        return "Account Type Undefined";
    }
}

function determineClass($class)
{
    if ($class) {
        echo 'value="' . $class . '"';
    }
}

function errorHandler()
{
    if ($_GET['error'] == "incomplete") {
        $error = "true";
        $msg = "You must fill in all form fields before continuing!";
    } elseif ($_GET['error'] == "incorrectpassword") {
        $error = "true";
        $msg = "You have entered an incorrect password! Please try again!";
    } elseif ($_GET['error'] == "incorrectusername") {
        $error = "true";
        $msg = "You have entered an incorrect username! Please try again!";
    } elseif ($_GET['error'] == "emailinvalid") {
        $error = "true";
        $msg = "You have entered an invalid email address! Please try again!";
    } elseif ($_GET['error'] == "usernameinvalid") {
        $error = "true";
        $msg = "You have entered an invalid username! Please try again!";
    } elseif ($_GET['error'] == "usernametaken") {
        $error = "true";
        $msg = "The username you have entered is already taken! Please try again!";
    } elseif ($_GET['error'] == "internalservererror1") {
        $error = "true";
        $msg = "An internal server error occurred! Please contact a developer! ";
    } elseif ($_GET['error'] == "internalservererror2") {
        $error = "true";
        $msg = "An internal server error occurred! Please contact a developer!";
    } elseif ($_GET['error'] == "passwordrequirements") {
        $error = "true";
        $msg = "Password must be a minimum of 5 and a maximum of 20 characters long!";
    } elseif ($_GET['error'] == "classNotFound") {
        $error = "true";
        $msg = "That class was not found! Please try again, ensuring you have typed the class code correctly!";
    } elseif ($_GET['error'] == "uploadError") {
        $error = "true";
        $msg = "An error occurred whilst uploading your profile picture! (Accepted file types: PNG, JPG, GIF)";
    } elseif ($_GET['success'] == "signedSuccess") {
        $error = "false";
        $msg = "You have successfully created a new account! You can now login with the details you signed up with!";
    } elseif ($_GET['success'] == "leftClass") {
        $error = "false";
        $msg = "You have successfully left your class! You can rejoin a class with a class code given by your teacher";
    } elseif ($_GET['success'] == "upload") {
        $error = "false";
        $msg = "Successfully uploaded profile picture!";
    } elseif ($_GET['success'] == "editedprofile") {
        $error = "false";
        $msg = "Successfully updated your profile!";
    }

    if ($error == "true") { ?>
        <div class="alert alert-danger">
            <strong>Error!</strong> <?= $msg ?>
        </div><br>
    <?php
    } elseif ($error == "false") { ?>
        <div class="alert alert-success">
            <strong>Success!</strong> <?= $msg ?>
        </div><br>
    <?php
    }
}

function determineYearGroup($yeargroup)
{
    if ($yeargroup) {
        if ($yeargroup != 0) {
            echo 'value="' . $yeargroup . '"';
        }
    }
}

function determineGreeting()
{
    $id = $_SESSION['id'];
    date_default_timezone_set('Europe/London');
    $time = date("H");
    $timezone = date("e");
    if ($time < "12") {
    ?>
        <text title="The time is <?= date('h:i A') ?>">
            Good Morning, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun-cloud"></i>
        </text>
    <?php
    } else
    if ($time >= "12" && $time < "17") {
    ?>
        <text title="The time is <?= date('h:i A') ?>">
            Good Afternoon, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun"></i>
        </text>
    <?php
    } else
    if ($time >= "17" && $time < "24") {
    ?>
        <text title="The time is <?= date('h:i A') ?>">
            Good Evening, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-moon-stars"></i>
        </text>
    <?php
    }
}

function onerror($image)
{
    echo 'onerror="this.onerror=null;this.src=`'.$image.'`"';
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getProfilePicture($id)
{

    if (file_exists("../../assets/usercontent/" . $id . ".png")) {
        return "../../assets/usercontent/" . $id . ".png?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".jpg")) {
        return "../../assets/usercontent/" . $id . ".jpg?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".jpeg")) {
        return "../../assets/usercontent/" . $id . ".jpeg?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".gif")) {
        return "../../assets/usercontent/" . $id . ".gif?update=" . date('s-ms');
    }
}

function backgroundImage()
{
    $input = array("https://intrevise.axtonprice.com/assets/img/banners/banner1.jpg", "https://intrevise.axtonprice.com/assets/img/banners/banner2.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner3.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner4.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner5.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner6.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner7.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner8.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner9.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner10.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner11.webp", "https://intrevise.axtonprice.com/assets/img/banners/banner12.webp");
    echo $input[array_rand($input)];
}

function getData($table, $field, $col, $val)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    // Create connection
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    $sql = "SELECT $field FROM $table WHERE $col='$val'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            return $row[$field];
        }
    } else {
        return "null";
    }

    $conn->close();
}

function getClassData($data)
{
    return getData("classes", $data, "classId", getData("accounts", "class_id", "id", $_SESSION['id']));
}

function daysUntil($date)
{
    return (isset($date)) ? floor((strtotime($date) - time()) / 60 / 60 / 24 + 1) : FALSE;
}

$import = new import();
class import
{
    public function noClassFound()
    { ?>
        <section class="contact pb-60" style="margin-top: 50px">
            <div class="container">

                <div class="content">
                    <br>
                    <?= errorHandler() ?>
                    <h2><i class="fas fa-exclamation-circle"></i> You are not in a class!</h2>
                    <br>
                    <p>Join a class to start tracking your statistics, notifications and upcoming assignments set by your
                        teacher!</p>
                    <p>You can join a class by entering a class code given by your teacher below.</p>
                    <br>
                    <h4>Enter class code</h4>
                    <br>
                    <form action="modules/join_class" method="post">
                        <input class="form-input" type="text" id="joining_class" name="joining_class" placeholder="Enter class code supplied by teacher" required>
                        <br><br>
                        <button type="submit" style="color: white" class="btn btn-primary btn-round btn-simple"><i class="fas fa-sign-in-alt"></i> Join Class</button>
                    </form>
                </div>
            </div>
        </section>
<?php
    }
}

function determineResetPfpButton($id)
{
    if (getProfilePicture($id)) {
        echo 'href="modules/reset_profile_picture"';
    } else {
        echo 'style="color:#2BA3DC; cursor: not-allowed"';
    }
}

function convertDate($givenDate, $format)
{
    $date = $givenDate;
    $date = date($format, strtotime($date));
    return $date;
}

function updateLastSeen()
{
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    $id = $_SESSION['id'];
    $query = "SELECT * FROM accounts WHERE id='$userid'";
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE accounts SET last_seen='$date' WHERE id=$id";
    if ($conn->query($sql) === TRUE);
    $conn->close();
}

function getPoints()
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $user = getData("accounts", "username", "id", $_SESSION['id']);
    $query = "SELECT * FROM points WHERE username='$user'";
    $results = mysqli_query($con, $query);
    $row_count = mysqli_num_rows($results);
    $num = 0;
    while ($row = mysqli_fetch_array($results)) {
        $num = $num + 10;
    }
    return $num;
    mysqli_query($con, $query);
    mysqli_close($con);
}
function getPointsStatus()
{
    $points = getPoints();
    if ($points <= 50) {
        return 'You are a <strong>Traveler</strong>';
    } elseif ($points > 50 || $points <= 100){
        return 'You are a <strong>Pathfinder</strong>';
    } elseif ($points > 100 || $points <= 150){
        return 'You are a <strong>Sightseer</strong>';
    } elseif ($points > 150 || $points <= 200){
        return 'You are an <strong>Explorer</strong>';
    } elseif ($points > 200 || $points <= 250){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 250 || $points <= 300){
        return 'You are a <strong>Patroller</strong>';
    } elseif ($points > 300 || $points <= 400){
        return 'You are a <strong>Crusader</strong>';
    } elseif ($points > 400 || $points <= 500){
        return 'You are an <strong></strong>';
    } elseif ($points > 500 || $points <= 600){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 600 || $points <= 700){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 700 || $points <= 800){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 800 || $points <= 1000){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1000 || $points <= 1200){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1200 || $points <= 1400){
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1400 || $points <= 1600){
        return 'You are a <strong></strong>';
    } elseif ($points > 2000){
        return 'You are a <strong>Sussy Baka</strong>';
    }
}

function getPointsBadge()
{
    $points = getPoints();
    if ($points <= 50) {
        return "b1.png";
    } elseif ($points > 50 || $points <= 100){
        return "b2.png";
    } elseif ($points > 100 || $points <= 150){
        return "b3.png";
    } elseif ($points > 150 || $points <= 200){
        return "b4.png";
    } elseif ($points > 200 || $points <= 250){
        return "b5.png";
    } elseif ($points > 250 || $points <= 300){
        return "b6.png";
    } elseif ($points > 300 || $points <= 400){
        return "b7.png";
    } elseif ($points > 400 || $points <= 500){
        return "b8.png";
    } elseif ($points > 500 || $points <= 600){
        return "b9.png";
    } elseif ($points > 600 || $points <= 700){
        return "b10.png";
    } elseif ($points > 700 || $points <= 800){
        return "b11.png";
    } elseif ($points > 800 || $points <= 1000){
        return "b12.png";
    } elseif ($points > 1000 || $points <= 1200){
        return "b13.png";
    } elseif ($points > 1200 || $points <= 1400){
        return "b14.png";
    } elseif ($points > 1400 || $points <= 1600){
        return "b15.png";
    } elseif ($points > 2000){
        return "medal.gif";
    }
    
}