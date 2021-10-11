<?php

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
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function logAction($username, $firstname, $lastname, $userId, $timestamp, $action, $details)
{
    $myArray[] = (object) [
        'username' => "$username",
        'firstname' => "$firstname",
        'lastname' => "$lastname",
        'userId' => "$userId",
        'timestamp' => "$timestamp",
        'action' => "$action",
        "details" => "$details"
    ];
    // echo json_encode($myArray);
    $data = json_decode(file_get_contents("../../secure/adminarea/modules/activity-logs.json"), true);
    $data["log-" . generateRandomString(15)] = $myArray;
    $json = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents("../../secure/adminarea/modules/activity-logs.json", $json);
}
