<?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";

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
    error_reporting(0); //turns off error messages for undefined URL variables

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
    } elseif ($_GET['success'] == "signedSuccess") {
        $error = "false";
        $msg = "You have successfully created a new account! You can now login with the details you signed up with!";
    } elseif ($_GET['success'] == "leftClass") {
        $error = "false";
        $msg = "You have successfully left your class! You can rejoin a class with a class code given by your teacher";
    } elseif ($_GET['success'] == "upload") {
        $error = "false";
        $msg = "Successfully uploaded profile picture! If the image does not load, press CTRL + F5 at the same time.";
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
    /*
    Key:
    Less than 12pm - Morning
    More than or equal to 12pm AND less than 5pm - Afternoon
    More than or equal to 6pm AND less than 11pm - Evening
    */
    date_default_timezone_set('Europe/London');
    $time = date("H");
    $timezone = date("e");
    if ($time < "12") {
        echo "Good Morning";
    } else
    if ($time >= "12" && $time < "17") {
        echo "Good Afternoon";
    } else
    if ($time >= "17" && $time < "24") {
        echo "Good Evening";
    }
}

function onerror($image)
{
    echo 'onerror="this.onerror=null;this.src=`' . $image . '`"';
}

function resizeImage($file, $w, $h, $crop = FALSE)
{
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function getProfilePicture($id)
{
    $u = getData("accounts", "username", "id", $id);
    $pfp = file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatarHash?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $u);
    echo "https://intrevise.axtonprice.com/assets/usercontent/" . $pfp . ".gif";
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

function convertDate($givenDate, $format)
{
    return date($format, strtotime($givenDate));
}

function getPoints($user)
{
    return getData("points", "value", "username", $user);
}
function getPointsStatus($user)
{
    $points = getPoints($user);
    $body = file_get_contents("https://intrevise.axtonprice.com/api/v1/userStatus?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $user);
    $output = ucfirst($body);
    echo "<b>$output</b>";
}

function getPointsBadge($id)
{
    $user = getData("accounts", "username", "id", $id);
    $badgeid = file_get_contents("https://intrevise.axtonprice.com/studentarea/api/v1/getBadge?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $user);
    echo "assets/badges/?b=" . $badgeid;
}

function updateLastSeen($id)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE accounts SET last_seen='$date' WHERE id=$id";
    if ($conn->query($sql) === TRUE);
    $conn->close();
}

function isDiscordLinked($id)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $sql = "SELECT * FROM discord_links WHERE account_id='$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return false;
    } else {
        return true;
    }
}