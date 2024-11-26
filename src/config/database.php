<?php
class Database {
    private $host = "localhost:3307";  // Updated port number
    private $database = "inventorytrackflow";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->database,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $e) {
            echo json_encode(array("message" => "Connection error: " . $e->getMessage()));
            return null;
        }
    }
}