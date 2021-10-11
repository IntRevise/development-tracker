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
$username = $_POST['save_username'];
$firstname = $_POST['save_firstname'];
$lastname = $_POST['save_lastname'];
$email = $_POST['save_email'];
$yeargroup = $_POST['save_yeargroup'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE accounts SET username='$username', firstname='$firstname', lastname='$lastname', email='$email', yeargroup='$yeargroup' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    logAction(
        getData("accounts", "username", "id", $_SESSION['id']), // username
        getData("accounts", "firstname", "id", $_SESSION['id']), // firstname
        getData("accounts", "lastname", "id", $_SESSION['id']), // lastname
        getData("accounts", "id", "id", $_SESSION['id']), // user id
        date('Y-m-d H:i:s'), // timestamp
        "acc_edited", // action log
        "false" // details
    );
    header("Location: ../profile?success=editedprofile");
    echo "Record updated successfully";
} else {
    header("Location: ../profile?error=editedprofile");
    echo "Error updating record: " . $conn->error;
}

$conn->close();

echo "
$id <br>
$username <br>
$firstname <br>
$lastname <br>
$email <br>
$yeargroup";
