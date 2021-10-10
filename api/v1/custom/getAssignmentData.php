<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['data'] . ", " . $_GET['u']);
}
$data = $_GET['data'];
$user = $_GET['u'];
require "../../db_login.php";

function data($key, $count)
{
    require "../../db_login.php";
    // Create connection
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $classId = getData("accounts", "class_id", "username", $_GET['u']);
    $sql =  "SELECT * FROM assignments WHERE assignedClassId='$classId' LIMIT $count,1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$key];
        }
    } else {
        echo jsonSerialize("success", "null");
        return;
    }
    $conn->close();
}

if ($_GET['data'] == "" || isset($_GET['data']) == false) {
    echo jsonSerialize("error", "Error! Missing parameters!");
    // 
} elseif ($data == "title0") {
    echo jsonSerialize("success", data("title", 0));
} elseif ($data == "title1") {
    echo jsonSerialize("success", data("title", 1));
} elseif ($data == "title2") {
    echo jsonSerialize("success", data("title", 2));
    // 
} elseif ($data == "id0") {
    echo jsonSerialize("success", data("id", 0));
} elseif ($data == "id1") {
    echo jsonSerialize("success", data("id", 1));
} elseif ($data == "id2") {
    echo jsonSerialize("success", data("id", 2));
    // 
} elseif ($data == "desc0") {
    echo jsonSerialize("success", data("description", 0));
} elseif ($data == "desc1") {
    echo jsonSerialize("success", data("description", 1));
} elseif ($data == "desc2") {
    echo jsonSerialize("success", data("description", 2));
    // 
} elseif ($data == "due0") {
    echo jsonSerialize("success", convertDate(data("dueDate", 0), "l jS \of F Y"));
} elseif ($data == "due1") {
    echo jsonSerialize("success", convertDate(data("dueDate", 1), "l jS \of F Y"));
} elseif ($data == "due2") {
    echo jsonSerialize("success", convertDate(data("dueDate", 2), "l jS \of F Y"));
    // 
} elseif ($data == "check0") {
    if (data("title", 0) == "") {
        echo jsonSerialize("success", "false");
    }
} elseif ($data == "check1") {
    if (data("title", 1) == "") {
        echo jsonSerialize("success", "false");
    }
} elseif ($data == "check2") {
    if (data("title", 2) == "") {
        echo jsonSerialize("success", "false");
    }
}
