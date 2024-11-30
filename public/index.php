<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once __DIR__ . "/../src/config/database.php";
require_once __DIR__ . "/../src/controllers/InventoryController.php";

// For debugging
if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_SERVER['PATH_INFO'])) {
    echo json_encode([
        "status" => "success",
        "message" => "API is working",
        "debug" => [
            "request_uri" => $_SERVER['REQUEST_URI'],
            "method" => $_SERVER['REQUEST_METHOD'],
            "server" => $_SERVER
        ]
    ]);
    exit();
}

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

$controller = new InventoryController($db);

// Get the request path
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/InventoryTrackFlow-API/public';
$path = str_replace($base_path, '', $request_uri);
$path = trim($path, '/');

try {
    if ($path === 'products') {
        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $controller->getProducts();
                break;
            case 'POST':
                $data = json_decode(file_get_contents("php://input"));
                $controller->createProduct($data);
                break;
            default:
                throw new Exception("Method not allowed");
        }
    } else {
        throw new Exception("Invalid endpoint: " . $path);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "debug" => [
            "request_uri" => $_SERVER['REQUEST_URI'],
            "path" => $path,
            "method" => $_SERVER['REQUEST_METHOD']
        ]
    ]);
}