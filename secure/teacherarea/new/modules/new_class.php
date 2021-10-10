<?php
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

function getData($table, $field, $col, $val)
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
function generateRandomString($length = 10)
{
    return substr(str_shuffle(str_repeat($x = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}

session_start();

$id = generateRandomString(8);
$classname = $_POST['class_name'];
$teacher = getData("accounts", "username", "id", $_SESSION['id']);
$date = date("Y-m-d h:i:s");

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['class_name']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt = $con->prepare('INSERT INTO classes (classId, className, teacher, dateCreated) VALUES (?, ?, ?, ?)')) {
        $stmt->bind_param('ssss', $id, $classname, $teacher, $date);
        $stmt->execute();
        header("Location: ../../manage/myclasses?success=classCreated");
    } else {
        header("Location: ../class?error=internalservererror");
    }

    $stmt->close();
} else {
    header("Location: ../class?error=internalservererror");
}
$con->close();
