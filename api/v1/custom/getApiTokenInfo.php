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
echo jsonSerialize("success", getData("api_keys", $_GET['data'], "token", $_GET['token']));
