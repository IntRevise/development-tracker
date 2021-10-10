<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['u']);
}
$id = $_GET['id'];


if (getData("accounts", "is_email_verified", "id", $_SESSION['id']) == 0) {
?>
    <div class="alert alert-warning">
        <strong>Hey!</strong> Your email has not yet been verified! Check your inbox to verify your email, or <a href="modules/resendEmailConfirmation">resend the email</a>!
    </div><br>
<?php
}

?>