<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->author)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Author.php';

$db = (new Database())->connect();
$author = new Author($db);

$author->author = $data->author;

if ($author->create()) {
    echo json_encode(["author" => $data->author]);
}