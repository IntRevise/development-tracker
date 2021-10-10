<?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
error_reporting(0);

function jsondecode($id, $item)
{
    $json = file_get_contents('modules/activity-logs.json');
    $data = array_reverse(json_decode($json, true));
    echo $data[$id][0][$item]; // echoes not returns
}

function jsondecodeReturn($id, $item)
{
    $json2 = file_get_contents('modules/activity-logs.json');
    $data2 = array_reverse(json_decode($json2, true));
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
        $msg = "An error occurred whilst uploading your profile picture! (Acceptable file types: PNG, JPG, GIF)";
    } elseif ($_GET['success'] == "signedSuccess") {
        $error = "false";
        $msg = "You have successfully created a new account! You can now login with the details you signed up with!";
    } elseif ($_GET['success'] == "leftClass") {
        $error = "false";
        $msg = "You have successfully left your class! You can rejoin a class with a class code given by your teacher";
    } elseif ($_GET['success'] == "upload") {
        $error = "false";
        $msg = "Successfully uploaded profile picture! The picture may take up to 5 minutes to update everywhere.";
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

class getStat
{
    public function getUsers()
    {
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if (mysqli_connect_errno()) {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        $sql = "SELECT * FROM accounts";
        if ($result = mysqli_query($con, $sql)) {
            $rowcount = mysqli_num_rows($result);
            echo $rowcount;
            mysqli_free_result($result);
        }
        mysqli_close($con);
    }

    public function getClasses()
    {
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if (mysqli_connect_errno()) {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        $sql = "SELECT * FROM classes";
        if ($result = mysqli_query($con, $sql)) {
            $rowcount = mysqli_num_rows($result);
            echo $rowcount;
            mysqli_free_result($result);
        }
        mysqli_close($con);
    }
    public function getAssignments()
    {
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        if (mysqli_connect_errno()) {
            die('Failed to connect to MySQL: ' . mysqli_connect_error());
        }
        $sql = "SELECT * FROM assignments";
        if ($result = mysqli_query($con, $sql)) {
            $rowcount = mysqli_num_rows($result);
            echo $rowcount;
            mysqli_free_result($result);
        }
        mysqli_close($con);
    }
    public function getMyClasses()
    {
        error_reporting(2);
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $username = getData("accounts", "username", "id", $_SESSION['id']);
        $query = "SELECT * FROM classes WHERE teacher='$username' ORDER BY id";
        $results = mysqli_query($con, $query);
        $row_count = mysqli_num_rows($results);
        echo $row_count;
        mysqli_query($con, $query);
        mysqli_close($con);
    }
    public function getMyUsers()
    {
        function getClassTeacher($classid)
        {
            error_reporting(2);
            require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
            $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
            $username = getData("accounts", "username", "id", $_SESSION['id']);
            $query = "SELECT * FROM classes WHERE class_id='$classid'";
            $results = mysqli_query($con, $query);
            $row_count = mysqli_num_rows($results);
            return $results;
            mysqli_query($con, $query);
            mysqli_close($con);
        }
        $stat = new getStat();
        error_reporting(2);
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $username = getData("accounts", "username", "id", $_SESSION['id']);
        $classTeacher = getClassTeacher(getData("classes", "class_id", "teacher", getData("accounts", "username", "id", $_SESSION['id'])));
        $query2 = "SELECT * FROM accounts WHERE class_id='$classId'";
        $results = mysqli_query($con, $query2);
        $row_count = mysqli_num_rows($results);
        echo $row_count;
        mysqli_query($con, $query2);
        mysqli_close($con);
    }
    public function getMyAssignments()
    {
        error_reporting(2);
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $username = getData("accounts", "username", "id", $_SESSION['id']);
        $query = "SELECT * FROM assignments WHERE teacher='$username' ORDER BY id";
        $results = mysqli_query($con, $query);
        $row_count = mysqli_num_rows($results);
        echo $row_count;
        mysqli_query($con, $query);
        mysqli_close($con);
    }
    public function countClassUsers($classId)
    {
        error_reporting(2);
        require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
        $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
        $query = "SELECT * FROM accounts WHERE class_id='$classId'";
        $results = mysqli_query($con, $query);
        $row_count = mysqli_num_rows($results);
        return $row_count;
        mysqli_query($con, $query);
        mysqli_close($con);
    }
}

function checkAuthentication($id)
{
    if (determineAccountType(getData("accounts", "account_type", "id", $id)) == "Administrator" || determineAccountType(getData("accounts", "account_type", "id", $id)) == "Teacher") {
        // keep empty
    } else {
        header("Location: ../../");
    }
}

function convertDate($givenDate, $format){
    $date = $givenDate;
    $date = date($format, strtotime($date)); 
    echo $date;
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