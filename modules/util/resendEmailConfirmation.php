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

session_start();
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'plesk.oxide.host';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'axton@axtonprice.com';                 //SMTP username
    $mail->Password   = 'Binky7777#';                           //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom('axton@axtonprice.com', 'IntRevise');
    $mail->addAddress(getData("accounts", "email", "id", $_SESSION['id']), getData("accounts", "firstname", "id", $_SESSION['id']));  // Add a recipient

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('image0.jpg', 'image0.jpg');     //Optional name

    $mail->isHTML(true);
    $mail->Subject = 'Welcome to IntRevise, ' . getData("accounts", "firstname", "id", $_SESSION['id']);
    $mail->Body = file_get_contents("_mailtemplate.html");
    $mail->AltBody = 'This email is not viewable as this device does not support HTML.';

    $mail->send();
    echo 'Message has been sent';
    header("Location: ../../../studentarea/?success=confirmationEmailResent");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location: ../../../studentarea/?error=emailConfirmationError");
}
// header("Location: ../?success=confirmationEmailResent");