<?php
// index.php

// Enable error reporting for debugging (disable these settings in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include global configuration and utility functions
require_once 'global.php';

// Get the request URI and method
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// A simple router to handle API endpoints
switch ($requestUri) {
    case '/api/example':
        // Load the example controller for handling '/api/example'
        require_once 'controller/ExampleController.php';
        $controller = new ExampleController();
        if ($requestMethod === 'GET') {
            $controller->getExample();
        } elseif ($requestMethod === 'POST') {
            $controller->createExample();
        } else {
            // If the method is not supported, return a 405 error
            header('HTTP/1.1 405 Method Not Allowed');
            echo json_encode(['error' => 'Method Not Allowed']);
        }
        break;

    default:
        // Return a 404 error for unknown endpoints
        header('HTTP/1.1 404 Not Found');
        echo json_encode(['error' => 'Endpoint Not Found']);
        break;
}
