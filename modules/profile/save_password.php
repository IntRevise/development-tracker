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
$password = password_hash($_POST['save_password'], PASSWORD_DEFAULT);
$sql = "UPDATE accounts SET password='$password' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  logAction(
    getData("accounts", "username", "id", $_SESSION['id']), // username
    getData("accounts", "firstname", "id", $_SESSION['id']), // firstname
    getData("accounts", "lastname", "id", $_SESSION['id']), // lastname
    getData("accounts", "id", "id", $_SESSION['id']), // user id
    date('Y-m-d H:i:s'), // timestamp
    "acc_pswdupd", // action log
    "false"  // details
  );
  header("Location: ../profile?success=changedpassword");
} else {
  header("Location: ../profile?error=changedpassword");
}

$conn->close();
