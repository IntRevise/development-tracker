<?php
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
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['username'], $_POST['password']) ) {
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
            updateLastSeen();
            // setcookie("loggedIn", true, time() + (86400 * 30), "/"); // 86400 seconds = 1 day
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

/*
CREATE TABLE IF NOT EXISTS `accounts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
  	`username` varchar(50) NOT NULL,
    `firstname` varchar(100) NOT NULL,
    `lastname` varchar(100) NOT NULL,
    `yeargroup` int(2) NOT NULL,
  	`password` varchar(255) NOT NULL,
  	`email` varchar(100) NOT NULL,
    `account_type` varchar(20) NOT NULL,
    `class_id` varchar(15) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
INSERT INTO `accounts` (`id`, `username`, `firstname`, `lastname`, `yeargroup`, `password`, `email`, `account_type`, `class_id`) VALUES (1, 'priroa', 'Roan', 'Price', '10', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'priroa@wootton.beds.sch.uk', 'admin', 'Qn3QkVn6');
INSERT INTO `accounts` (`id`, `username`, `firstname`, `lastname`, `yeargroup`, `password`, `email`, `account_type`, `class_id`) VALUES (2, 'deqmas', 'Mason', 'De Quincey', '10', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'deqmas@wootton.beds.sch.uk', 'teacher', 'Qn3QkVn6');
*/