<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id) || !isset($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();
$author = new Author($db);

$check = $db->prepare("SELECT id FROM authors WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "author_id Not Found"]);
    return;
}

$author->id = $data->id;
$author->author = $data->author;

if ($author->update()) {
    echo json_encode($data);
}