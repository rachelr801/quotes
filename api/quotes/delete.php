<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

// check exists
$check = $db->prepare("SELECT id FROM quotes WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "No Quotes Found"]);
    return;
}

$quote->id = $data->id;

if ($quote->delete()) {
    echo json_encode(["id" => $data->id]);
}