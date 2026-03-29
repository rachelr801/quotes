<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        $id = $_GET['id'] ?? null;

        $stmt = $category->read($id);

        if ($stmt->rowCount() > 0) {
            $categories = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categories[] = $row;
            }

            echo json_encode($categories);
        } else {
            echo json_encode(["message" => "category_id Not Found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->category)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $category->category = $data->category;

        if ($category->create()) {
            echo json_encode([
                "category" => $data->category
            ]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->category)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $category->id = $data->id;
        $category->category = $data->category;

        if ($category->update()) {
            echo json_encode([
                "id" => $data->id,
                "category" => $data->category
            ]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $category->id = $data->id;

        if ($category->delete()) {
            echo json_encode(["id" => $data->id]);
        } else {
            echo json_encode(["message" => "No Categories Found"]);
        }
        break;
}