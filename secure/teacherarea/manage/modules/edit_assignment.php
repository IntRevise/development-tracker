<?php
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
function getData($table, $field, $col, $val)
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
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

session_start();
$classid = $_GET['asgn_class'];
$description = $_GET['asgn_desc'];
$teacher = getData("accounts", "username", "id", $_SESSION['id']);
$date = $_GET['asgn_date'];
$title = $_GET['asgn_title'];

if ($stmt = $con->prepare('SELECT assignedClassId FROM assignments WHERE assignedClassId = ?')) {
    $stmt->bind_param('s', $_GET['asgn_class']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt = $con->prepare('UPDATE assignments SET (assignedClassId, description, teacher, dueDate, title, trackPath) = (?, ?, ?, ?, ?, "#")')) {
        $stmt->bind_param('sssss', $classid, $description, $teacher, $date, $title);
        $stmt->execute();
        // header("Location: ../manage/assignments?success=assignmentSaved");
    } else {
        // header("Location: ../assignment?error=internalservererror1");
    }

    $stmt->close();
} else {
    // header("Location: ../assignment?error=internalservererror1");
}
$con->close();