<?php
header("Content-type: application/vnd.api+json");
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['id']);
}
$id = $_GET['id'];

if($_GET['id'] == "" || isset($_GET['id']) == false){
    echo jsonSerialize("error", "Error! You need to provide a user ID!");
}else{
    echo jsonSerialize("success", getData("accounts", "username", "id", $id));
}
?>