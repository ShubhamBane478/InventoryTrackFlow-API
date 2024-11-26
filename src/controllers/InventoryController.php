<?php
class InventoryController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getProducts() {
        try {
            $query = "SELECT * FROM products";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($products) {
                http_response_code(200);
                echo json_encode([
                    "status" => "success",
                    "data" => $products
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    "status" => "error",
                    "message" => "No products found"
                ]);
            }
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . $e->getMessage()
            ]);
        }
    }

    public function createProduct($data) {
        try {
            if (!isset($data->name) || !isset($data->price) || !isset($data->quantity)) {
                throw new Exception("Missing required fields");
            }

            $query = "INSERT INTO products (name, description, price, quantity) 
                     VALUES (:name, :description, :price, :quantity)";
            
            $stmt = $this->conn->prepare($query);
            
            // Set description to null if not provided
            $description = isset($data->description) ? $data->description : null;
            
            $stmt->bindParam(":name", $data->name);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":price", $data->price);
            $stmt->bindParam(":quantity", $data->quantity);
            
            if($stmt->execute()) {
                http_response_code(201);
                echo json_encode([
                    "status" => "success",
                    "message" => "Product created successfully",
                    "id" => $this->conn->lastInsertId()
                ]);
            }
        } catch(Exception $e) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }
}