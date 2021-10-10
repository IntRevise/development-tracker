<?php
if ($_GET['error'] == "incomplete") {
    $error = "true";
    $msg = "You must fill in all form fields before continuing!";
} elseif ($_GET['error'] == "incorrectpassword") {
    $error = "true";
    $msg = "You have entered an incorrect password! Please try again!";
} elseif ($_GET['error'] == "incorrectusername") {
    $error = "true";
    $msg = "You have entered an incorrect username! Please try again!";
} elseif ($_GET['error'] == "emailInvalid") {
    $error = "true";
    $msg = "You have entered an invalid email address! Please try again!";
} elseif ($_GET['error'] == "usernameInvalid") {
    $error = "true";
    $msg = "You have entered an invalid username! Please try again!";
} elseif ($_GET['error'] == "usernameTaken") {
    $error = "true";
    $msg = "The username you have entered is already taken! Please try again!";
} elseif ($_GET['error'] == "internalservererror1") {
    $error = "true";
    $msg = "An internal server error occurred! Please contact a developer! ";
} elseif ($_GET['error'] == "internalservererror2") {
    $error = "true";
    $msg = "An internal server error occurred! Please contact a developer!";
} elseif ($_GET['error'] == "passwordRequirements") {
    $error = "true";
    $msg = "Password must be a minimum of 5 and a maximum of 20 characters long!";
} elseif ($_GET['error'] == "classNotFound") {
    $error = "true";
    $msg = "That class was not found! Please try again, ensuring you have typed the class code correctly!";
} elseif ($_GET['error'] == "usernameSpace") {
    $error = "true";
    $msg = "The username provided contains a space. You can only use A-Z characters!";
} elseif ($_GET['error'] == "usernameCharacters") {
    $error = "true";
    $msg = "The username provided contains invalid characters. You can only use A-Z characters!";
} elseif ($_GET['error'] == "uploadError") {
    $error = "true";
    $msg = "An error occurred whilst uploading your profile picture! (Accepted file types: PNG, JPG, GIF)";
} elseif ($_GET['error'] == "ratelimited") {
    $error = "true";
    $msg = "You are being rate limited! Please try again later. ERR: RL_SIGNUP";
} elseif (isset($_GET['disabled'])) {
    $error = "true";
    $msg = "This account has been suspended! Please contact a site Administrator to unlock the account.";
} elseif ($_GET['success'] == "signedSuccess") {
    $error = "false";
    $msg = "You have successfully created a new account! You can now login with the details you signed up with!";
} elseif ($_GET['success'] == "leftClass") {
    $error = "false";
    $msg = "You have successfully left your class! You can rejoin a class with a class code given by your teacher";
} elseif ($_GET['success'] == "upload") {
    $error = "false";
    $msg = "Successfully uploaded profile picture!";
} elseif ($_GET['success'] == "editedprofile") {
    $error = "false";
    $msg = "Successfully updated your profile!";
} elseif ($_GET['success'] == "emailVerified") {
    $error = "false";
    $msg = "Successfully verified your email!";
} elseif ($_GET['success'] == "confirmationEmailResent") {
    $error = "false";
    $msg = "The confirmation email has been sent to your email!";
}

if ($error == "true") { ?>
    <div class="alert alert-danger">
        <strong>Error!</strong> <?= $msg ?>
    </div><br>
<?php
} elseif ($error == "false") { ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?= $msg ?>
    </div><br>
<?php
}
