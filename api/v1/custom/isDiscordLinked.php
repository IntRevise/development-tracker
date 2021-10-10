<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['id']);
}
$id = $_GET['id'];
require "../../db_login.php";

if($_GET['id'] == "" || isset($_GET['id']) == false){
    echo jsonSerialize("error", "Error! You need to provide a user ID!");
}else{
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $query = "SELECT * FROM discord_links WHERE id='$id'";
    $results = mysqli_query($con, $query);
    $row_count = mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 0) {
        echo jsonSerialize("success", "false");
    }else{
        echo jsonSerialize("success", "true");
    }
    mysqli_query($con, $query);
    mysqli_close($con);
}
