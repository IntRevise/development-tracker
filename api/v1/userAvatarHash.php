<?php
header("Content-type: application/vnd.api+json");
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['u']);
}
$user = $_GET['u'];

if ($_GET['u'] == "" || isset($_GET['u']) == false) {
    echo jsonSerialize("error", "Error! You need to provide a user!");
} else {
    if (file_exists("../../assets/usercontent/" . getData("accounts", "profile_picture", "username", $_GET['u']) . ".gif"))
    {
        echo jsonSerialize("success", getData("accounts", "profile_picture", "username", $user));
    } else{
        echo jsonSerialize("success", "null");
    }
}
