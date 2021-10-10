<?php
header("Content-type: application/vnd.api+json");
require "../../functions.php";
error_reporting(0);
if (validateAdminToken($_GET['token']) == false) {
    echo jsonSerialize("error", "Error! You have provided an invalid token variation!");
    return;
} else {
    appendRequestLog($_GET['token'], basename($_SERVER['PHP_SELF'], ".php"), $_GET['u']);
}
$user = $_GET['u'];
$src = $_GET['src'];
$id = getData("accounts", "id", "username", $user);

function removeOldIcon()
{
    $a = file_get_contents("http://axtonprice.cf/api/v1/userAvatarHash?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . $_GET['u']);
    unlink("../../../assets/usercontent/" . $a . ".gif");
}
removeOldIcon();
function generateString($length = 40)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$str = generateString();
// function resize_image($file, $w, $h, $crop = FALSE)
// {
//     list($width, $height) = getimagesize($file);
//     $r = $width / $height;
//     if ($crop) {
//         if ($width > $height) {
//             $width = ceil($width - ($width * abs($r - $w / $h)));
//         } else {
//             $height = ceil($height - ($height * abs($r - $w / $h)));
//         }
//         $newwidth = $w;
//         $newheight = $h;
//     } else {
//         if ($w / $h > $r) {
//             $newwidth = $h * $r;
//             $newheight = $h;
//         } else {
//             $newheight = $w / $r;
//             $newwidth = $w;
//         }
//     }
//     $src = imagecreatefromjpeg($file);
//     $dst = imagecreatetruecolor($newwidth, $newheight);
//     imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//     return $dst;
// }

if ($_GET['u'] == "" || isset($_GET['u']) == false || $_GET['src'] == "" || isset($_GET['src']) == false) {
    echo jsonSerialize("error", "Error! Missing parameters!");
} else {
    // Download new pfp
    file_put_contents("../../../assets/usercontent/" . $str . ".gif", file_get_contents($src));
    // resize_image("../../../assets/usercontent/" . $str . ".gif", 200, 200);

    // Re-register avatar on DB
    require "../../db_login.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    if ($stmt = $con->prepare('SELECT profile_picture FROM accounts WHERE id = ?')) {
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt = $con->prepare('UPDATE accounts SET profile_picture=? WHERE id = ?')) {
            $stmt->bind_param('ss', $str, $id);
            $stmt->execute();
        } else {
            // header("Location: ../profile?error=internalservererror1");
            echo jsonSerialize("success", "error");
        }
        $stmt->close();
    } else {
        // header("Location: ../profile?error=internalservererror1");
        echo jsonSerialize("success", "error");
    }
    $con->close();
}
