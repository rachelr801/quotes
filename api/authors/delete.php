<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
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

if ($author->delete()) {
    echo json_encode(["id" => $data->id]);
}