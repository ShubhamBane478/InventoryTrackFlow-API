<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once __DIR__ . "/../src/config/database.php";
require_once __DIR__ . "/../src/controllers/InventoryController.php";

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
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

// Get the request URI and remove query string
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path
$base_path = '/InventoryTrackFlow-API/public';
$path = substr($request_uri, strlen($base_path));
$path = trim($path, '/');

// Debug information
if (empty($path)) {
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "API is working",
        "debug" => [
            "request_uri" => $_SERVER['REQUEST_URI'],
            "path" => $path,
            "method" => $_SERVER['REQUEST_METHOD']
        ]
    ]);
    exit();
}

// Split the path into segments
$segments = explode('/', $path);
$endpoint = $segments[0] ?? '';

try {
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if ($endpoint === 'products') {
                $controller->getProducts();
            } else {
                throw new Exception("Invalid endpoint: " . $endpoint);
            }
            break;
            
        case 'POST':
            if ($endpoint === 'products') {
                $data = json_decode(file_get_contents("php://input"));
                $controller->createProduct($data);
            } else {
                throw new Exception("Invalid endpoint: " . $endpoint);
            }
            break;
            
        default:
            throw new Exception("Method not allowed: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "debug" => [
            "request_uri" => $_SERVER['REQUEST_URI'],
            "path" => $path,
            "endpoint" => $endpoint,
            "method" => $_SERVER['REQUEST_METHOD']
        ]
    ]);
}
