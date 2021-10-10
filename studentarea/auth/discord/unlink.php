<?php session_start();
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
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
function encode($data)
{
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
// Try and connect using the info above.
$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$id = $_SESSION['id'];
$username = getData("discord_links", "username", "account_id", $id);
$userid = getData("discord_links", "id", "account_id", $id);
$discriminator = getData("discord_links", "discriminator", "account_id", $id);

$sql = "DELETE FROM `discord_links` WHERE `account_id`=$id";
if ($conn->query($sql) === TRUE) {
    header("Location: ../unauthorized?link_type=" . encode("Discord") . "&username=" . encode($username) . "&avatar=" . encode('../../assets/usercontent/discord/' . $userid . '.gif') . "&discriminator=" . encode($discriminator) . "&accountName=" . encode(getData("accounts", "username", "id", $_SESSION['id'])));
} else {
    header("Location: ../../");
}

$conn->close();
