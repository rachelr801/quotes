<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Author.php';

$database = new Database();
$db = $database->connect();

$author = new Author($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        $id = $_GET['id'] ?? null;

        $stmt = $author->read($id);

        if ($stmt->rowCount() > 0) {
            $authors = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $authors[] = $row;
            }

            echo json_encode($authors);
        } else {
            echo json_encode(["message" => "author_id Not Found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $author->author = $data->author;

        if ($author->create()) {
            echo json_encode([
                "author" => $data->author
            ]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->author)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $author->id = $data->id;
        $author->author = $data->author;

        if ($author->update()) {
            echo json_encode([
                "id" => $data->id,
                "author" => $data->author
            ]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $author->id = $data->id;

        if ($author->delete()) {
            echo json_encode(["id" => $data->id]);
        } else {
            echo json_encode(["message" => "No Authors Found"]);
        }
        break;
}