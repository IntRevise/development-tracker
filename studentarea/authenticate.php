<?php
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/util/webhook-sender.php";
function updateLastSeen()
{
    session_start();
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    $id = $_SESSION['id'];
    $query = "SELECT * FROM accounts WHERE id='$userid'";
    $results = mysqli_query($conn, $query);
    $date = date('Y-m-d H:i:s');
    $sql = "UPDATE accounts SET last_seen='$date' WHERE id=$id";
    if ($conn->query($sql) === TRUE);
    $conn->close();
}

session_start();
// Change this to your connection info.
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    header('Location: login?error=incomplete');
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT id, password, firstname, lastname FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $firstname, $lastname);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['id'] = $id;
            // setcookie("loggedIn", true, time() + (86400 * 30), "/"); // 86400 seconds = 1 day
            updateLastSeen();
            checkLeaderboardPresence($_SESSION['id']);
            webhookLog("865399419184218143", "JEy289OP5n23n2sW5_N-onPd6dtn8K_MQIWIoFa6Rgef_WioBePchInJ3R5K7H7N6PqG", "log-in");
            header('Location: .');
        } else {
            // Incorrect password
            header('Location: login?error=incorrectpassword');
        }
    } else {
        // Incorrect username
        header('Location: login?error=incorrectusername');
    }

    $stmt->close();
}