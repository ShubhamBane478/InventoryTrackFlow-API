<?php
// controller/ExampleController.php

require_once 'BaseController.php';
require_once 'model/ExampleModel.php';

/**
 * ExampleController class
 * Handles API requests related to example resources.
 */
class ExampleController extends BaseController {
    private $model;

    public function __construct() {
        // Instantiate the ExampleModel to interact with the database
        $this->model = new ExampleModel();
    }

    /**
     * Handle a GET request to retrieve all examples.
     */
    public function getExample() {
        try {
            $data = $this->model->getAll();
            $this->response($data);
        } catch (Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }

    /**
     * Handle a POST request to create a new example.
     */
    public function createExample() {
        // Retrieve JSON input from the request body
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            $this->errorResponse("Invalid JSON input", 400);
        }

        try {
            $result = $this->model->create($input);
            if ($result) {
                $this->response(["message" => "Example created successfully"], 201);
            } else {
                $this->errorResponse("Failed to create example", 500);
            }
        } catch (Exception $e) {
            $this->errorResponse($e->getMessage(), 500);
        }
    }
}
