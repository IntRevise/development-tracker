<?php
date_default_timezone_set('Europe/London');

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

function determineYearGroup($yeargroup)
{
    if ($yeargroup) {
        if ($yeargroup != 0) {
            echo 'value="' . $yeargroup . '"';
        }
    }
}

function convertDate($givenDate, $format)
{
    $date = $givenDate;
    $date = date($format, strtotime($date));
    return $date;
}

function getProfilePicture($id)
{
    return "https://intrevise.axtonprice.com/assets/usercontent/" . $id;
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

function getPoints($user)
{
    return getData("points", "value", "username", $user);
}
function getPointsStatus($user)
{
    $points = getPoints($user);
    if ($points <= 50) {
        return 'You are a <strong>Traveler</strong>';
    } elseif ($points > 50 && $points <= 100) {
        return 'You are a <strong>Pathfinder</strong>';
    } elseif ($points > 100 && $points <= 150) {
        return 'You are a <strong>Sightseer</strong>';
    } elseif ($points > 150 && $points <= 200) {
        return 'You are an <strong>Explorer</strong>';
    } elseif ($points > 200 && $points <= 250) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 250 && $points <= 300) {
        return 'You are a <strong>Patroller</strong>';
    } elseif ($points > 300 && $points <= 400) {
        return 'You are a <strong>Crusader</strong>';
    } elseif ($points > 400 && $points <= 500) {
        return 'You are a <strong>Warrior</strong>';
    } elseif ($points > 500 && $points <= 600) {
        return 'You are a <strong>Warlock</strong>';
    } elseif ($points > 600 && $points <= 700) {
        return 'You are a <strong>Guardian</strong>';
    } elseif ($points > 700 && $points <= 800) {
        return 'You are a <strong>Peace Keeper</strong>';
    } elseif ($points > 800 && $points <= 1000) {
        return 'You are a <strong>Sorcerer</strong>';
    } elseif ($points > 1000 && $points <= 1200) {
        return 'You are a <strong>Wizard</strong>';
    } elseif ($points > 1200 && $points <= 1400) {
        return 'You are an <strong>Enchanter</strong>';
    } elseif ($points > 1400 && $points <= 1600) {
        return 'You are a <strong>Spellcaster</strong>';
    } elseif ($points > 2000) {
        return 'You are a <strong>Champion</strong>';
    }
}

function getPointsBadge()
{
    $points = getPoints($_SESSION['id']);
    if ($points <= 50) {
        return "b1.png";
    } elseif ($points > 50 && $points <= 100) {
        return "b2.png";
    } elseif ($points > 100 && $points <= 150) {
        return "b3.png";
    } elseif ($points > 150 && $points <= 200) {
        return "b4.png";
    } elseif ($points > 200 && $points <= 250) {
        return "b5.png";
    } elseif ($points > 250 && $points <= 300) {
        return "b6.png";
    } elseif ($points > 300 && $points <= 400) {
        return "b7.png";
    } elseif ($points > 400 && $points <= 500) {
        return "b8.png";
    } elseif ($points > 500 && $points <= 600) {
        return "b9.png";
    } elseif ($points > 600 && $points <= 700) {
        return "b10.png";
    } elseif ($points > 700 && $points <= 800) {
        return "b11.png";
    } elseif ($points > 800 && $points <= 1000) {
        return "b12.png";
    } elseif ($points > 1000 && $points <= 1200) {
        return "b13.png";
    } elseif ($points > 1200 && $points <= 1400) {
        return "b14.png";
    } elseif ($points > 1400 && $points <= 1600) {
        return "b15.png";
    } elseif ($points > 2000) {
        return "sussy.gif";
    }
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

    if(validateAdminToken($token) == true){
        $ar = 1;
    } else{
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
