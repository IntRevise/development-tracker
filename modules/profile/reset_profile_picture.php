<?php
session_start();
require "activity-logger.php";

$id = $_SESSION['id'];

function getProfilePicture($id)
{
    $u = getData("accounts", "username", "id", $id);
    return file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatarHash?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $u);
}
$oldpfp = getProfilePicture($id);

unlink("../../assets/usercontent/" . getProfilePicture($id) . ".gif");
logAction(
    getData("accounts", "username", "id", $id), // username
    getData("accounts", "firstname", "id", $id), // firstname
    getData("accounts", "lastname", "id", $id), // lastname
    getData("accounts", "id", "id", $id), // user id
    date('Y-m-d H:i:s'), // timestamp
    "pfp_remove", // action log
    "false" // details
);

require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$n = "";
if ($stmt = $con->prepare('SELECT profile_picture FROM accounts WHERE id = ?')) {
    $stmt->bind_param('s', $_SESSION['id']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt = $con->prepare('UPDATE accounts SET profile_picture=? WHERE id = ?')) {
        $stmt->bind_param('ss', $n, $_SESSION['id']);
        $stmt->execute();
    } else {
        header("Location: ../profile?error=internalservererror1");
    }
    $stmt->close();
} else {
    header("Location: ../profile?error=internalservererror1");
}
$con->close();

function removeOldIcon()
{
    $befpfp = file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatarHash?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . getData("accounts", "username", "id", $_SESSION['id']));
    unlink("../../assets/usercontent/" . $befpfp . ".gif");
}
removeOldIcon();
header("Location: ../profile");
