<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->category)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();
$category = new Category($db);

$category->category = $data->category;

if ($category->create()) {
    echo json_encode(["category" => $data->category]);
}