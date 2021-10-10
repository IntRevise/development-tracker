<?php
function encode($data)
{
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)
error_reporting(E_ALL);
define('OAUTH2_CLIENT_ID', '867211933056761868'); //Your client Id
define('OAUTH2_CLIENT_SECRET', 'MO3BtKPCJ4vwHdqz_XR4G8ySSAAMfVE0'); //Your secret client code
$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
$tokenURL = 'https://discordapp.com/api/oauth2/token';
$apiURLBase = 'https://discordapp.com/api/users/@me';

session_start();

// Start the login process by sending the user to Discord's authorization page
if (get('action') == 'login') {

  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => 'https://intrevise.axtonprice.com/studentarea/auth/discord/callback',
    'response_type' => 'code',
    'scope' => 'identify guilds'
  );

  // Redirect the user to Discord's authorization page
  header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
  die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if (get('code')) {

  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    "grant_type" => "authorization_code",
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => 'https://intrevise.axtonprice.com/studentarea/auth/discord/callback',
    'code' => get('code')
  ));
  $logout_token = $token->access_token;
  $_SESSION['access_token'] = $token->access_token;

  header('Location: ' . $_SERVER['PHP_SELF']);
}

if (session('access_token')) {
  $user = apiRequest($apiURLBase);

  //   echo '<h3>Logged In</h3>';
  //   echo '<h4>Welcome, ' . $user->username . '</h4>';
  //   echo '<pre>';
  //     print_r($user);
  //   echo '</pre>';

} else {
  //   echo '<h3>Not logged in</h3>';
  //   echo '<p><a href="?action=login">Log In</a></p>';
}


if (get('action') == 'logout') {
  // This must to logout you, but it didn't worked(

  $params = array(
    'access_token' => $logout_token
  );

  // Redirect the user to Discord's revoke page
  header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
  die();
}

function apiRequest($url, $post = FALSE, $headers = array())
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

  $response = curl_exec($ch);


  if ($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

  $headers[] = 'Accept: application/json';

  if (session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');

  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default = NULL)
{
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}


/* Insert into database */


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

// We need to use sessions, so you should always start sessions using the below code.
session_start();
if ($_SERVER['HTTP_HOST'] == "axtonprice.cf") {
  $domain = "https://intrevise.axtonprice.com/studentarea";
} elseif ($_SERVER['HTTP_HOST'] == "intrevise.surge-networks.co.uk") {
  $domain = "https://intrevise.surge-networks.co.uk";
}

// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header('Location: ../../login?retunTo=' . $domain . '/studentarea/auth/discord/callback');
  exit();
}
require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
  die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions so instead we can get the results from the database.
$stmt = $con->prepare('SELECT yeargroup, password, email, account_type, class_id, id FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$accountId = $_SESSION['id'];
$username = $user->username;
$discriminator = $user->discriminator;
$id = $user->id;
$avatar = $user->avatar;

$query2 = "SELECT * FROM discord_links WHERE account_id='$accountId'";
$results2 = mysqli_query($con, $query2);
$row_count2 = mysqli_num_rows($results2);
if ($row_count2 > 0) {
  header("Location: ../failed?et=" . encode("Uh Oh!") . "&ed=" . encode("The account <b>" . getData("accounts", "username", "id", $_SESSION['id']) . "</b> has already been linked to the Discord account <b>" . getData("discord_links", "username", "account_id", $_SESSION['id']) . "</b>! If this was a mistake, please contact an IntRevise developer to unlink the account.") . "&avatarUrl=" . encode('../../assets/usercontent/discord/' . getData("discord_links", "id", "account_id", $_SESSION['id']) . '.gif') . "&ec=" . encode("Error: Account already linked to: " . getData("discord_links", "username", "account_id", $_SESSION['id'])));
} else {
  if ($stmt = $con->prepare('SELECT account_id FROM discord_links WHERE account_id = ?')) {
    $stmt->bind_param('s', $accountId);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt = $con->prepare('INSERT INTO discord_links (account_id, username, discriminator, id, avatar) VALUES (?, ?, ?, ?, ?)')) {
      $stmt->bind_param('sssss', $accountId, $username, $discriminator, $id, $avatar);
      $stmt->execute();
      // header("Location: ../manage/assignments?success=assignmentPosted");
      echo "success";
    } else {
      // header("Location: ../assignment?error=internalservererror1");
      echo "fail2";
    }

    $stmt->close();
  } else {
    // header("Location: ../assignment?error=internalservererror1");
    echo "fail1";
  }
  $con->close();

  $content = file_get_contents('https://cdn.discordapp.com/avatars/' . $user->id . '/' . $user->avatar);
  file_put_contents('../../../assets/usercontent/discord/' . $user->id . '.gif', $content);
  header("Location: authorized");
}
?>

<!-- 
    (
    [id] => 360832097495285761z
    [username] => Axton P.
    [avatar] => c6217decf71649bdd0968a78c5518855
    [discriminator] => 1234
    [public_flags] => 64
    [flags] => 64
    [banner] => 
    [banner_color] => 
    [accent_color] => 
    [locale] => en-US
    [mfa_enabled] => 1
    [premium_type] => 1
    )
-->