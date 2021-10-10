<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
require "../../db_login.php";

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
function genToken($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

session_start();
$token = genToken(40);
$date_created = date('Y-m-d H:i:s');
$creator = $_GET['creator'];
if ($_GET['origin'] == "mysql" || $_GET['origin'] == "discord") {
    $origin = $_GET['origin'];
} else {
    echo jsonSerialize("error", "An error occurred!");
    return;
}
if ($creator == "360832097495285761" || $creator == "86.2.10.33") {
    $token_type = "Admin";
} else {
    $token_type = "Standard";
}

$resetIncrement = "ALTER TABLE api_keys AUTO_INCREMENT = 0";
if (mysqli_query($con, $resetIncrement)) {
    // success
} else {
    echo jsonSerialize("error", "Error: " . $resetIncrement . "" . mysqli_error($con));
}

$sql = "INSERT INTO api_keys (token, token_type, origin, creator) VALUES ('$token', '$token_type', '$origin', '$creator')";
if (mysqli_query($con, $sql)) {
    // echo "New record created successfully !";
    echo $token;
} else {
    echo jsonSerialize("error", "Error: " . $sql . "" . mysqli_error($con));
    return;
}

mysqli_close($con);
