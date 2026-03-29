<?php

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();

$quote = new Quote($db);

// filters
$params = $_GET;

$stmt = $quote->read($params);

if ($stmt->rowCount() > 0) {

    $quotes_arr = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $quotes_arr[] = $row;
    }

    echo json_encode($quotes_arr);

} else {
    echo json_encode(["message" => "No Quotes Found"]);
}