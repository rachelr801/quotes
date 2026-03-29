<?php

// REQUIRED CORS HEADERS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// ROUTING
switch ($method) {

    case 'GET':
        if (isset($_GET['id'])) {
            require 'read_single.php';
        } else {
            require 'read.php';
        }
        break;

    case 'POST':
        require 'create.php';
        break;

    case 'PUT':
        require 'update.php';
        break;

    case 'DELETE':
        require 'delete.php';
        break;

    default:
        echo json_encode(["message" => "Invalid Request"]);
        break;
}