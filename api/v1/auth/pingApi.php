<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
require "../../db_login.php";

if($con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME)){
    $query = "SELECT * FROM accounts WHERE username='priroa'";
    $results = mysqli_query($con, $query);
    $row_count = mysqli_num_rows($results);
    if (mysqli_num_rows($results) == 0) {
        echo jsonSerialize("success", "error");
    } else {
        echo jsonSerialize("success", "success");
    }
    mysqli_query($con, $query);
    mysqli_close($con);
} else{
    echo jsonSerialize("success", "error");
}
