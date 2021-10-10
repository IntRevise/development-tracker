<?php
// require "mail.php";
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
// Try and connect using the info above.

/*
	require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
	$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	$ip = $SERVER['REMOTE_ADDR'];
	$query = "SELECT * FROM rate_limits WHERE ip='$ip'";
	$results = mysqli_query($conn, $query);
	$source = "signup";
	if (mysqli_num_rows($results) == 0) {
		$sql = "INSERT INTO `rate_limits` (`source`, `ip`) VALUES ('$source', '$ip');";
	} elseif (mysqli_num_rows($results) > 2) {
		header("Location ../login?error=ratelimited");
	}
	$conn->close();
*/
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
function isRateLimited()
{
	require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
	$ip = $_SERVER['REMOTE_ADDR'];
	$uid = generateRandomString();
	$conn = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
	$query = "SELECT * FROM rate_limits WHERE ip='$ip'";
	$results = mysqli_query($conn, $query);
	if (mysqli_num_rows($results) >= 2) {
		header("Location: .?error=ratelimited");
	} else {
		$sql = "INSERT INTO `rate_limits` (`source`, `ip`, `uid`) VALUES ('signup', '$ip', '$uid');";
		$conn->query($sql);
	}
	$conn->close();
}

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	header("Location: .?error=incomplete");
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['firstname']) || empty($_POST['lastname'])) {
	// One or more values are empty.
	header("Location: .?error=incomplete");
}
// Check to see if the email is valid.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	header("Location: .?error=emailInvalid");
}
// Username must contain only characters and numbers.
if (preg_match('/[A-Za-z]+/', $_POST['username']) == 0) {
	header("Location: .?error=usernameCharacters");
}
// Password must be between 5 and 20 characters long.
if (strlen($_POST['password']) < 4) {
	header("Location: .?error=passwordRequirements");
}
// Changes username to lowercase
$username = strtolower($_POST['username']);
// If username contains a space
if (strpos($username, ' ') !== false) {
	header("Location: .?error=usernameSpace");
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		header("Location: .?error=usernametaken");
	} else {
		// Username doesnt exists, insert new account
		if ($stmt = $con->prepare('INSERT INTO accounts (username, firstname, lastname, yeargroup, password, email, account_type, class_id) VALUES (?, ?, ?, ?, ?, ?, "student", "")')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$stmt->bind_param('ssssss', $username, $_POST['firstname'], $_POST['lastname'], $_POST['yeargroup'], $password, $_POST['email']);
			$stmt->execute();
			// sendMail($_POST['email'], $_POST['firstname']);
			header("Location: ../login?success=signedSuccess");
		} else {
			// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
			header("Location: .?error=internalservererror");
		}
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	header("Location: .?error=internalservererror");
}
$con->close();
