<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['data']);
}
$data = $_GET['data'];
require "../../db_login.php";

function data($key, $count)
{
    require "../../db_login.php";
    // Create connection
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $sql =  "SELECT * FROM points ORDER BY value DESC LIMIT $count,1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo jsonSerialize("success", $row[$key]);
        }
    } else {
        echo jsonSerialize("success", "No Data!");
        return;
    }
    $conn->close();
}

if ($_GET['data'] == "" || isset($_GET['data']) == false) {
    echo jsonSerialize("error", "Error! Missing parameters!");

    // names:
} elseif ($data == "name_0") {
    echo jsonSerialize("success", data("username", 0));
} elseif ($data == "name_1") {
    echo jsonSerialize("success", data("username", 1));
} elseif ($data == "name_2") {
    echo jsonSerialize("success", data("username", 2));
} elseif ($data == "name_3") {
    echo jsonSerialize("success", data("username", 3));
} elseif ($data == "name_4") {
    echo jsonSerialize("success", data("username", 4));
} elseif ($data == "name_5") {
    echo jsonSerialize("success", data("username", 5));

    // Points:
} elseif ($data == "points_0") {
    echo jsonSerialize("success", data("value", 0));
} elseif ($data == "points_1") {
    echo jsonSerialize("success", data("value", 1));
} elseif ($data == "points_2") {
    echo jsonSerialize("success", data("value", 2));
} elseif ($data == "points_3") {
    echo jsonSerialize("success", data("value", 3));
} elseif ($data == "points_4") {
    echo jsonSerialize("success", data("value", 4));
} elseif ($data == "points_5") {
    echo jsonSerialize("success", data("value", 5));
}
