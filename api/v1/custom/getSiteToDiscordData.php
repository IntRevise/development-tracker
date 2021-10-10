<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['id'] . ", " . $_GET['data']);
}
$id = $_GET['id'];
$data = $_GET['data'];
require "../../db_login.php";

if ($_GET['id'] == "" || isset($_GET['id']) == false || $_GET['data'] == "" || isset($_GET['data']) == false) {
    echo jsonSerialize("error", "Error! Missing parameters!");
} else {
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $query = "SELECT * FROM discord_links WHERE account_id='$id'";
    $results = mysqli_query($con, $query);
    $row_count = mysqli_num_rows($results);

    if ($row_count == 0) {
        echo jsonSerialize("success", "This account is not linked");
    } else {
        while ($row = mysqli_fetch_array($results)) {
            echo jsonSerialize("success", getData("discord_links", $data, "account_id", $id));
        }
    }

    // if (mysqli_num_rows($results) == 0) {
    //     echo "false";
    // } else {
    //     echo "true";
    // }
    mysqli_query($con, $query);
    mysqli_close($con);
}
