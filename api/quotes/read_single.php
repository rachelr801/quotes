<?php

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

$params = ['id' => $_GET['id']];
$stmt = $quote->read($params);

if ($stmt->rowCount() > 0) {
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
} else {
    echo json_encode(["message" => "No Quotes Found"]);
}