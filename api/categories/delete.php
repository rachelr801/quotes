<?php
$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    echo json_encode(["message" => "Missing Required Parameters"]);
    return;
}

include_once '../config/Database.php';
include_once '../models/Category.php';

$db = (new Database())->connect();
$category = new Category($db);

$check = $db->prepare("SELECT id FROM categories WHERE id=?");
$check->execute([$data->id]);

if ($check->rowCount() == 0) {
    echo json_encode(["message" => "category_id Not Found"]);
    return;
}

$category->id = $data->id;

if ($category->delete()) {
    echo json_encode(["id" => $data->id]);
}