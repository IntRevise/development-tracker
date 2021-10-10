<?php session_start();
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
require "activity-logger.php";
$id = $_GET['id'];

function getData2($table, $field, $col, $val)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    // Create connection
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    $sql = "SELECT $field FROM $table WHERE $col='$val'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            return $row[$field];
        }
    } else {
        return "null";
    }

    $conn->close();
}
function determineAccountType2($type)
{
    if ($type == "student" || $type == "") {
        return "Student";
    } elseif ($type == "teacher") {
        return "Teacher";
    } elseif ($type == "admin") {
        return "Administrator";
    } else {
        return "Account Type Undefined";
    }
}
if (determineAccountType2(getData2("accounts", "account_type", "id", $id)) == "Administrator") {
    // keep empty
} else {
    header("Location: ../../");
}

// Try and connect using the info above.
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$query = "SELECT * FROM accounts WHERE id='$id'";
$results = mysqli_query($conn, $query);

if (mysqli_num_rows($results) == 0) {
    header("Location: ../users?error=notFound");
} else {
    logAction(
        getData("accounts", "username", "id", $id), // username
        getData("accounts", "firstname", "id", $id), // firstname
        getData("accounts", "lastname", "id", $id), // lastname
        getData("accounts", "id", "id", $id), // user id
        date('Y-m-d H:i:s'), // timestamp
        "acc_deleted", // action log
        "false" // details
    );
    $sql = "DELETE FROM accounts WHERE id='$id';";
}

if ($conn->query($sql) === TRUE) {
    header("Location: ../users?success=deletedAccount");
} else {
    header("Location: ../users?error");
}

$conn->close();


// DELETE FROM `accounts` WHERE `accounts`.`id` = 5;