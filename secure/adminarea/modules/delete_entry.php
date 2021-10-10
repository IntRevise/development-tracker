<?php
$id = $_GET['id'];

// Main removal
$data = json_decode(file_get_contents('activity-logs.json'), true);
unset($data[$id]);
$json = json_encode($data, JSON_PRETTY_PRINT);
file_put_contents('activity-logs.json', $json);

header("Location: ../activity");
?>