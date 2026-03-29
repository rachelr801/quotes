<?php
header("Content-Type: application/json");

include_once '../config/Database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->connect();
    
$quote = new Quote($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
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
        break;

        // check author exists
		$checkAuthor = $db->prepare("SELECT id FROM authors WHERE id = ?");
		$checkAuthor->execute([$data->author_id]);

		if ($checkAuthor->rowCount() == 0) {
   			echo json_encode(["message" => "author_id Not Found"]);
    		return;
		}

		// check category exists
		$checkCategory = $db->prepare("SELECT id FROM categories WHERE id = ?");
		$checkCategory->execute([$data->category_id]);

		if ($checkCategory->rowCount() == 0) {
    		echo json_encode(["message" => "category_id Not Found"]);
    		return;
		}
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if ($quote->create()) {
            echo json_encode($data);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $quote->id = $data->id;
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if ($quote->update()) {
            echo json_encode($data);
        }
        break;

        echo json_encode([
   			"id" => $quote->id,
    		"quote" => $quote->quote,
    		"author_id" => $quote->author_id,
    		"category_id" => $quote->category_id
		]);
        
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id)) {
            echo json_encode(["message" => "Missing Required Parameters"]);
            return;
        }

        $quote->id = $data->id;

        if ($quote->delete()) {
            echo json_encode(["id" => $data->id]);
        } else {
            echo json_encode(["message" => "No Quotes Found"]);
        }
        break;