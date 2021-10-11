<?php session_start();
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
require "activity-logger.php";
// Try and connect using the info above.
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$id = $_SESSION['id'];
$sql = "DELETE FROM `accounts` WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logAction(
        getData("accounts", "username", "id", $_SESSION['id']), // username
        getData("accounts", "firstname", "id", $_SESSION['id']), // firstname
        getData("accounts", "lastname", "id", $_SESSION['id']), // lastname
        getData("accounts", "id", "id", $_SESSION['id']), // user id
        date('Y-m-d H:i:s'), // timestamp
        "acc-deleted", // action log
        "false" // details
    );
    header("Location: ../login?success=accountDeleted");
} else {
    header("Location: ../profile?error=deleteAccountFail");
}

$conn->close();
