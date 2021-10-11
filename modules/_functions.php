<?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
date_default_timezone_set('Europe/London');
error_reporting(0);

function jsondecode($id, $item)
{
    $json = file_get_contents('./assets/site/team-members.json');
    $data = json_decode($json, true);
    echo $data[$id][0][$item]; // echoes not returns
}

function jsondecodeReturn($id, $item)
{
    $json2 = file_get_contents('./assets/site/team-members.json');
    $data2 = json_decode($json2, true);
    return $data2[$id][0][$item]; // returns not echoes
}

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
    } elseif ($_GET['error'] == "emailInvalid") {
        $error = "true";
        $msg = "You have entered an invalid email address! Please try again!";
    } elseif ($_GET['error'] == "usernameInvalid") {
        $error = "true";
        $msg = "You have entered an invalid username! Please try again!";
    } elseif ($_GET['error'] == "usernameTaken") {
        $error = "true";
        $msg = "The username you have entered is already taken! Please try again!";
    } elseif ($_GET['error'] == "internalservererror1") {
        $error = "true";
        $msg = "An internal server error occurred! Please contact a developer! ";
    } elseif ($_GET['error'] == "internalservererror2") {
        $error = "true";
        $msg = "An internal server error occurred! Please contact a developer!";
    } elseif ($_GET['error'] == "passwordRequirements") {
        $error = "true";
        $msg = "Password must be a minimum of 5 and a maximum of 20 characters long!";
    } elseif ($_GET['error'] == "classNotFound") {
        $error = "true";
        $msg = "That class was not found! Please try again, ensuring you have typed the class code correctly!";
    } elseif ($_GET['error'] == "usernameSpace") {
        $error = "true";
        $msg = "The username provided contains a space. You can only use A-Z characters!";
    } elseif ($_GET['error'] == "usernameCharacters") {
        $error = "true";
        $msg = "The username provided contains invalid characters. You can only use A-Z characters!";
    } elseif ($_GET['error'] == "uploadError") {
        $error = "true";
        $msg = "An error occurred whilst uploading your profile picture! (Accepted file types: PNG, JPG, GIF)";
    } elseif ($_GET['error'] == "emailConfirmationError") {
        $error = "true";
        $msg = "An error occurred whilst sending the email. Please verify your email address, and contact an admin.";
    } elseif ($_GET['error'] == "ratelimited") {
        $error = "true";
        $msg = "You are being rate limited! Please try again later. ERR: RL_SIGNUP";
    } elseif (isset($_GET['disabled'])) {
        $error = "true";
        $msg = "This account has been suspended! Please contact a site Administrator to unlock the account.";
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
    } elseif ($_GET['success'] == "emailVerified") {
        $error = "false";
        $msg = "Successfully verified your email!";
    } elseif ($_GET['success'] == "confirmationEmailResent") {
        $error = "false";
        $msg = "The confirmation email has been re-sent to " . getData("accounts", "email", "id", $_SESSION['id']) . "!";
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
        <text>
            Good Morning, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun-cloud"></i>
        </text>
    <?php
    } else
if ($time >= "12" && $time < "17") {
    ?>
        <text>
            Good Afternoon, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun"></i>
        </text>
    <?php
    } else
if ($time >= "17" && $time < "24") {
    ?>
        <text>
            Good Evening, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-moon-stars"></i>
        </text>
    <?php
    }
}

function onerror($image)
{
    echo 'onerror="this.onerror=null;this.src=`' . $image . '`"';
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
    $u = getData("accounts", "username", "id", $id);
    $pfp = file_get_contents("http://axtonprice.cf/lab/int-revise/api/v1/userAvatar?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $u);
    $obj = json_decode($pfp);
    return $obj->data;
}

function backgroundImage()
{
    $input = array("http://axtonprice.cf/lab/int-revise/assets/img/banners/banner1.jpg", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner2.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner3.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner4.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner5.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner6.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner7.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner8.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner9.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner10.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner11.webp", "http://axtonprice.cf/lab/int-revise/assets/img/banners/banner12.webp");
    echo $input[array_rand($input)];
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
    if (getProfilePicture($id) === "null") {
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
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE accounts SET last_seen='$date' WHERE id=$id";
    if ($conn->query($sql) === TRUE);
    $conn->close();
}

function getPoints($user)
{
    return getData("points", "value", "username", $user);
}
function getPointsStatus($user)
{
    $points = getPoints($user);
    $json = file_get_contents("http://axtonprice.cf/lab/int-revise/api/v1/userStatus?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=priroa");
    $obj = json_decode($json);
    echo ucfirst($obj->data);
}

function getPointsBadge($id)
{
    $user = getData("accounts", "username", "id", $id);
    $badgeid = file_get_contents("http://axtonprice.cf/lab/int-revise/api/v1/getBadge?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $user);
    $obj = json_decode($badgeid);
    echo "../assets/badges/?b=" . $obj->data;
}

function checkLeaderboardPresence($id)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $user = getData("points", "value", "username", getData("accounts", "username", "id", $id));
    $query = "SELECT * FROM points WHERE username='$user'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) == 0) {
        $sql = "INSERT INTO `points` (`username`, `value`) VALUES ('$user', '0');";
        $conn->query($sql);
    }
    $conn->close();
}

function isAccountDisabled()
{
    session_start();
    $id = $_SESSION['id'];
    if (getData("accounts", "is_disabled", "id", $id) == 1) {
        header("Location: logout?disabled");
    }
}

function isEmailVerified()
{
    if (getData("accounts", "is_email_verified", "id", $_SESSION['id']) == 0) {
    ?>
        <div class="alert alert-warning">
            <strong>Hey!</strong> Your email has not yet been verified! Check your inbox to verify your email, or <a href="../modules/util/resendEmailConfirmation">resend the email</a>!
        </div><br>
<?php
    }
}

function singleParamApiRequest($data, $paramAt, $paramAp)
{
    $json = file_get_contents("http://axtonprice.cf/lab/int-revise/api/v1/$data?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&$paramAt=$paramAp");
    $obj = json_decode($json);
    return $obj->data;
}
function doubleParamApiRequest($data, $paramAt, $paramAp, $paramBt, $paramBp)
{
    $json = file_get_contents("http://axtonprice.cf/lab/int-revise/api/v1/$data?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&$paramAt=$paramAp&$paramBt=$paramBp");
    $obj = json_decode($json);
    return $obj->data;
}

function insertInto($table, $cond1, $cond2, $inpc1, $inpc2, $inp1, $inp2)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $query = "SELECT * FROM $table WHERE $cond1='$cond2'";
    $results = mysqli_query($conn, $query);
    if (mysqli_num_rows($results) == 0) {
        $sql = "INSERT INTO `$table` (`$inpc1`, `$inpc2`) VALUES ('$inp1', '$inp2');";
    }
    $conn->close();
}

function validateToken($token)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $query = "SELECT * FROM api_keys WHERE token='$token'";
    $results = mysqli_query($con, $query);
    $row = mysqli_num_rows($results);
    if ($row == 0) {
        return false;
    } else {
        return true;
    }
    mysqli_query($con, $query);
    mysqli_close($con);
}
function validateAdminToken($token)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $query = "SELECT * FROM api_keys WHERE token='$token'";
    $results = mysqli_query($con, $query);
    $row = mysqli_num_rows($results);
    if (getData("api_keys", "token_type", "token", $token) == "Admin") {
        return true;
    } else {
        return false;
    }
    mysqli_query($con, $query);
    mysqli_close($con);
}
function appendRequestLog($token, $request, $param)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    $resetIncrement = "ALTER TABLE api_requests AUTO_INCREMENT = 0";
    if (mysqli_query($con, $resetIncrement)) {
        // success
    } else {
        echo "Error: " . $resetIncrement . "" . mysqli_error($con);
    }

    if (validateAdminToken($token) == true) {
        $ar = 1;
    } else {
        $ar = 0;
    }

    $date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO `api_requests` (`token`, `request`, `parameters`, `timestamp`, `admin_request`) VALUES ('$token', '$request', '$param', '$date', '$ar')";
    if (mysqli_query($con, $sql)) {
        // echo "New record created successfully !";
    } else {
        echo "Error: " . $sql . "" . mysqli_error($con);
        return;
    }
    mysqli_close($con);
}

function jsonSerialize($response, $data)
{
    date_default_timezone_set("Europe/London");
    return '{
    "response": "' . $response . '",
    "timestamp": "' . date("Y-m-d H:i:s") . '",
    "data": "' . $data . '"
}';
}
