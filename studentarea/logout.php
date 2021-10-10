<?php
session_start();
require "modules/webhook-sender.php";
webhookLog("865399419184218143", "JEy289OP5n23n2sW5_N-onPd6dtn8K_MQIWIoFa6Rgef_WioBePchInJ3R5K7H7N6PqG", "log-out");
session_destroy();
if(isset($_GET['disabled'])){
    header('Location: login?disabled');
} else{
    header('Location: ../');
}