<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['u']);
}
$id = $_GET['id'];

date_default_timezone_set('Europe/London');
$time = date("H");
$timezone = date("e");
if ($time < "12") {
?>
    <text>
        Good Morning, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun-cloud"></i>
    </text>
<?php
} else
if ($time >= "12" && $time < "17") {
?>
    <text>
        Good Afternoon, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-sun"></i>
    </text>
<?php
} else
if ($time >= "17" && $time < "24") {
?>
    <text>
        Good Evening, <?= getData("accounts", "firstname", "id", $id) ?>! <i class="fad fa-moon-stars"></i>
    </text>
<?php
}

?>