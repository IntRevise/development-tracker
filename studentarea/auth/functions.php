<?php
if ($_SERVER['HTTP_HOST'] == "axtonprice.cf") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'global';
    $DATABASE_PASS = 'global';
    $DATABASE_NAME = 'int_revise';
} elseif ($_SERVER['HTTP_HOST'] == "localhost") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'global';
    $DATABASE_PASS = 'global';
    $DATABASE_NAME = 'int_revise';
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.surge-networks.co.uk") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'surgenet_intrevise';
    $DATABASE_PASS = 'Z7r@0vv4';
    $DATABASE_NAME = 'surgenet_intrevise';
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.axtonprice.com") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'surgenet_axtonintrevise';
    $DATABASE_PASS = '1xfB&17h';
    $DATABASE_NAME = 'axton_intrevise';
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.axtonprice.com") {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'surgenet_axtonintrevise';
    $DATABASE_PASS = '1xfB&17h';
    $DATABASE_NAME = 'axton_intrevise';
}else{
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'global';
    $DATABASE_PASS = 'global';
    $DATABASE_NAME = 'int_revise';
}
if ($_SERVER['HTTP_HOST'] == "axtonprice.cf") {
    $domain = "http://axtonprice.cf/lab/int-revise";
} elseif ($_SERVER['HTTP_HOST'] == "localhost") {
    $domain = "http://localhost/lab/int-revise";
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.surge-networks.co.uk") {
    $domain = "https://intrevise.surge-networks.co.uk";
}
date_default_timezone_set('Europe/London');

function determineAccountType($type)
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

function onerror($image)
{
    echo 'onerror="this.onerror=null;this.src=`' . $image . '`"';
}

function singleParamApiRequest($data, $paramAt, $paramAp)
{
    return file_get_contents("https://intrevise.axtonprice.com/api/v1/$data?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&$paramAt=$paramAp");
}
function doubleParamApiRequest($data, $paramAt, $paramAp, $paramBt, $paramBp)
{
    return file_get_contents("https://intrevise.axtonprice.com/api/v1/$data?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&$paramAt=$paramAp&$paramBt=$paramBp");
}