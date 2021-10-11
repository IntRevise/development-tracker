<?php
session_start();
require "activity-logger.php";

function removeOldIcon()
{
    $befpfp = file_get_contents("https://intrevise.axtonprice.com/api/v1/userAvatarHash?token=RLVGjdlGdRbDDUaktppVTUvnhmNadRMOZbrkBUcV&u=" . getData("accounts", "username", "id", $_SESSION['id']));
    unlink("../../assets/usercontent/" . $befpfp . ".gif");
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

// function resize_image($file, $w, $h, $crop=FALSE) {
//     list($width, $height) = getimagesize($file);
//     $r = $width / $height;
//     if ($crop) {
//         if ($width > $height) {
//             $width = ceil($width-($width*abs($r-$w/$h)));
//         } else {
//             $height = ceil($height-($height*abs($r-$w/$h)));
//         }
//         $newwidth = $w;
//         $newheight = $h;
//     } else {
//         if ($w/$h > $r) {
//             $newwidth = $h*$r;
//             $newheight = $h;
//         } else {
//             $newheight = $w/$r;
//             $newwidth = $w;
//         }
//     }
//     $src = imagecreatefromjpeg($file);
//     $dst = imagecreatetruecolor($newwidth, $newheight);
//     imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
//     return $dst;
// }

$target_dir = "../../assets/usercontent/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if ($imageFileType != "gif") {
    if (file_exists("../../assets/usercontent/" . $_SESSION['id'] . ".gif")) {
        unlink("../../assets/usercontent/" . $_SESSION['id'] . "_" . generateString() . "." . "gif");
    }
}

// Check file size
// if ($_FILES["fileToUpload"]["size"] > 900000) {
//     header("Location: ../profile?error=imagetoolarge");
//     $uploadOk = 0;
// }

// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
) {
    header("Location: ../profile?error=invalidFileType");
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    header("Location: ../profile?error=uploadError");
    // if everything is ok, try to upload file
} else {
    rename($_FILES["fileToUpload"]["tmp_name"], $target_dir . $str . ".gif");
    // resize_image($target_dir . $str . ".gif", 200, 200);

    logAction(
        getData("accounts", "username", "id", $_SESSION['id']), // username
        getData("accounts", "firstname", "id", $_SESSION['id']), // firstname
        getData("accounts", "lastname", "id", $_SESSION['id']), // lastname
        getData("accounts", "id", "id", $_SESSION['id']), // user id
        date('Y-m-d H:i:s'), // timestamp
        "pfp_upload", // action log
        basename($_FILES["fileToUpload"]["name"]) // details
    );

    require $_SERVER['DOCUMENT_ROOT'] . "/lab/int-revise/modules/_dblogin.php";
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if (mysqli_connect_errno()) {
        die('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
    if ($stmt = $con->prepare('SELECT profile_picture FROM accounts WHERE id = ?')) {
        $stmt->bind_param('s', $_SESSION['id']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt = $con->prepare('UPDATE accounts SET profile_picture=? WHERE id = ?')) {
            $stmt->bind_param('ss', $str, $_SESSION['id']);
            $stmt->execute();
        } else {
            header("Location: ../profile?error=internalservererror1");
        }

        $stmt->close();
    } else {
        header("Location: ../profile?error=internalservererror1");
    }
    $con->close();


    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) { // moves to uploads directory
        header("Location: ../profile?success=upload");
    } else {
        header("Location: ../profile?success=upload");
    }
}
