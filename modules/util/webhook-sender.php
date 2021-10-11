
<?php
function webhookLog($credentialId, $credentialToken, $type)
{
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
    function getProfilePicture($id)
    {
        return "https://intrevise.axtonprice.com/assets/usercontent/" . $id;
    }

    $username = getData("accounts", "username", "id", $_SESSION['id']);
    $fullname = getData("accounts", "firstname", "id", $_SESSION['id']) . " " . getData("accounts", "lastname", "id", $_SESSION['id']);
    $userId = $_SESSION['id'];
    $pfp = getProfilePicture($_SESSION['id']);

    if ($type == "log-in") {
        $msg = "A user just logged in!";
    } elseif ($type == "log-out") {
        $msg = "A user just logged out!";
    }

    // https://discord.com/api/webhooks/865399419184218143/JEy289OP5n23n2sW5_N-onPd6dtn8K_MQIWIoFa6Rgef_WioBePchInJ3R5K7H7N6PqG
    $url = "https://discord.com/api/webhooks/$credentialId/$credentialToken";
    $hookObject = json_encode([
        "content" => "",
        "username" => "IntRevise",
        "avatar_url" => "https://intrevise.axtonprice.com/assets/img/embed-logo.png",
        "tts" => false,
        // "file" => "",
        "embeds" => [
            [
                "title" => "IntRevise Activity Log",
                "type" => "rich",
                "description" => "$msg",
                "url" => "https://intrevise.axtonprice.com/",
                "timestamp" => date('Y-m-d H:i:s'),
                "color" => hexdec("#37B6DF"),
                // Thumbnail object
                // "thumbnail" => [
                //     "url" => "https://intrevise.axtonprice.com/assets/img/embed-logo.png"
                // ],
                // Footer object
                "footer" => [
                    "text" => "$username",
                    "icon_url" => "$pfp"
                ],

                "fields" => [
                    [
                        "name" => "Username",
                        "value" => "$username",
                        "inline" => true
                    ],
                    [
                        "name" => "Full Name",
                        "value" => "$fullname",
                        "inline" => true
                    ],
                    [
                        "name" => "User ID",
                        "value" => "$userId",
                        "inline" => true
                    ],
                    [
                        "name" => "Timestamp",
                        "value" => date('Y-m-d H:i:s'),
                        "inline" => false
                    ],
                ]
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $hookObject,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ]
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
}
