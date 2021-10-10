<?php require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_presets.php";
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

function onerror($image)
{
    echo 'onerror="this.onerror=null;this.src=`' . $image . '`"';
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

function getProfilePicture($id)
{

    if (file_exists("../../assets/usercontent/" . $id . ".png")) {
        return "../../assets/usercontent/" . $id . ".png?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".jpg")) {
        return "../../assets/usercontent/" . $id . ".jpg?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".jpeg")) {
        return "../../assets/usercontent/" . $id . ".jpeg?update=" . date('s-ms');
    }
    if (file_exists("../../assets/usercontent/" . $id . ".gif")) {
        return "../../assets/usercontent/" . $id . ".gif?update=" . date('s-ms');
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


$import = new import();
class import
{
    public function noClassFound()
    { ?>
        <section class="contact pb-60" style="margin-top: 50px">
            <div class="container">

                <div class="content">
                    <br>
                    <?= errorHandler() ?>
                    <h2><i class="fas fa-exclamation-circle"></i> You are not in a class!</h2>
                    <br>
                    <p>Join a class to start tracking your statistics, notifications and upcoming assignments set by your
                        teacher!</p>
                    <p>You can join a class by entering a class code given by your teacher below.</p>
                    <br>
                    <h4>Enter class code</h4>
                    <br>
                    <form action="modules/join_class" method="post">
                        <input class="form-input" type="text" id="joining_class" name="joining_class" placeholder="Enter class code supplied by teacher" required>
                        <br><br>
                        <button type="submit" style="color: white" class="btn btn-primary btn-round btn-simple"><i class="fas fa-sign-in-alt"></i> Join Class</button>
                    </form>
                </div>
            </div>
        </section>
<?php
    }
}

function determineResetPfpButton($id)
{
    if (getProfilePicture($id)) {
        echo 'href="modules/reset_profile_picture"';
    } else {
        echo 'style="color:#2BA3DC; cursor: not-allowed"';
    }
}

function convertDate($givenDate, $format)
{
    $date = $givenDate;
    $date = date($format, strtotime($date));
    return $date;
}

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

function getPoints()
{
    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $user = getData("accounts", "username", "id", $_SESSION['id']);
    $query = "SELECT * FROM points WHERE username='$user'";
    $results = mysqli_query($con, $query);
    $row_count = mysqli_num_rows($results);
    $num = 0;
    while ($row = mysqli_fetch_array($results)) {
        $num = $num + 10;
    }
    return $num;
    mysqli_query($con, $query);
    mysqli_close($con);
}
function getPointsStatus()
{
    $points = getPoints();
    if ($points <= 50) {
        return 'You are a <strong>Traveler</strong>';
    } elseif ($points > 50 || $points <= 100) {
        return 'You are a <strong>Pathfinder</strong>';
    } elseif ($points > 100 || $points <= 150) {
        return 'You are a <strong>Sightseer</strong>';
    } elseif ($points > 150 || $points <= 200) {
        return 'You are an <strong>Explorer</strong>';
    } elseif ($points > 200 || $points <= 250) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 250 || $points <= 300) {
        return 'You are a <strong>Patroller</strong>';
    } elseif ($points > 300 || $points <= 400) {
        return 'You are a <strong>Crusader</strong>';
    } elseif ($points > 400 || $points <= 500) {
        return 'You are an <strong></strong>';
    } elseif ($points > 500 || $points <= 600) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 600 || $points <= 700) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 700 || $points <= 800) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 800 || $points <= 1000) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1000 || $points <= 1200) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1200 || $points <= 1400) {
        return 'You are an <strong>Expeditioner</strong>';
    } elseif ($points > 1400 || $points <= 1600) {
        return 'You are a <strong></strong>';
    } elseif ($points > 2000) {
        return 'You are a <strong>Sussy Baka</strong>';
    }
}

function getPointsBadge()
{
    $points = getPoints();
    if ($points <= 50) {
        return "b1.png";
    } elseif ($points > 50 || $points <= 100) {
        return "b2.png";
    } elseif ($points > 100 || $points <= 150) {
        return "b3.png";
    } elseif ($points > 150 || $points <= 200) {
        return "b4.png";
    } elseif ($points > 200 || $points <= 250) {
        return "b5.png";
    } elseif ($points > 250 || $points <= 300) {
        return "b6.png";
    } elseif ($points > 300 || $points <= 400) {
        return "b7.png";
    } elseif ($points > 400 || $points <= 500) {
        return "b8.png";
    } elseif ($points > 500 || $points <= 600) {
        return "b9.png";
    } elseif ($points > 600 || $points <= 700) {
        return "b10.png";
    } elseif ($points > 700 || $points <= 800) {
        return "b11.png";
    } elseif ($points > 800 || $points <= 1000) {
        return "b12.png";
    } elseif ($points > 1000 || $points <= 1200) {
        return "b13.png";
    } elseif ($points > 1200 || $points <= 1400) {
        return "b14.png";
    } elseif ($points > 1400 || $points <= 1600) {
        return "b15.png";
    } elseif ($points > 2000) {
        return "medal.gif";
    }
}