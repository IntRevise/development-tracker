<?php
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
// Statement to try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if ($_GET['token'] == "") {
	header("Location: ./");
}
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ./login');
	exit();
}

$id = $_SESSION['id'];

$sql = "UPDATE accounts SET is_email_verified='1' WHERE id=$id";

if ($con->query($sql) === TRUE) {
	header("Location: ./?success=emailVerified");
} else {
	echo "Error updating record: " . $con->error;
}

$con->close();
