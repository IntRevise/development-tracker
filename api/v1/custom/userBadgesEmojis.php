<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['u']);
}
$user = $_GET['u'];

if ($_GET['u'] == "" || isset($_GET['u']) == false) {
    echo jsonSerialize("error", "Error! Missing parameters!");
} else {
    if (getData("accounts", "account_type", "username", $user) == "student") {
        echo jsonSerialize("success", "<:int_badgestudent:893569146351145002>");
    } elseif (getData("accounts", "account_type", "username", $user) == "teacher") {
        echo jsonSerialize("success", "<:int_badgeteacher:893569146648936500>");
    } elseif (getData("accounts", "account_type", "username", $user) == "admin") {
        echo jsonSerialize("success", "<:int_badgestudent:893569146351145002> <:int_badgeadmin:893569146611183678>");
    } else {
        echo jsonSerialize("success", ":no_entry_sign:");
    }
}
