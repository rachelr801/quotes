<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Quote.php';

$db = (new Database())->connect();
$quote = new Quote($db);

// validate author
$check = $db->prepare("SELECT id FROM authors WHERE id=?");
$check->execute([$data->author_id]);
if ($check->rowCount() == 0) {
    echo json_encode(["message" => "author_id Not Found"]);
    return;
}

// validate category
$check = $db->prepare("SELECT id FROM categories WHERE id=?");
$check->execute([$data->category_id]);
if ($check->rowCount() == 0) {
    echo json_encode(["message" => "category_id Not Found"]);
    return;
}

$quote->quote = $data->quote;
$quote->author_id = $data->author_id;
$quote->category_id = $data->category_id;

if ($quote->create()) {
    echo json_encode([
        "quote" => $quote->quote,
        "author_id" => $quote->author_id,
        "category_id" => $quote->category_id
    ]);
}