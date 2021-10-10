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

function getPointsBadgeTemp()
{
    $points = file_get_contents("https://intrevise.axtonprice.com/api/v1/userPoints?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $_GET['u']);
    if ($points <= 50) {
        return "0";
    } elseif ($points > 50 && $points <= 100) {
        return "1";
    } elseif ($points > 100 && $points <= 150) {
        return "2";
    } elseif ($points > 150 && $points <= 200) {
        return "3";
    } elseif ($points > 200 && $points <= 250) {
        return "4";
    } elseif ($points > 250 && $points <= 300) {
        return "5";
    } elseif ($points > 300 && $points <= 350) {
        return "6";
    } elseif ($points > 350 && $points <= 400) {
        return "7";
    } elseif ($points > 400 && $points <= 450) {
        return "8";
    } elseif ($points > 450 && $points <= 500) {
        return "9";
    } elseif ($points >= 750) {
        return "10";
    }
}

if($_GET['u'] == "" || isset($_GET['u']) == false){
    echo jsonSerialize("error", "Error! You need to provide a user!");
}else{
    echo jsonSerialize("success", getPointsBadgeTemp($user));
}
?>

