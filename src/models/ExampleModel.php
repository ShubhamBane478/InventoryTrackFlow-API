//A sample model that interacts with an example table (e.g., "examples"). You can replace or extend this with your own models.


<?php
// model/ExampleModel.php

require_once 'BaseModel.php';

/**
 * ExampleModel class
 * Represents a sample model for interacting with the 'examples' table.
 */
class ExampleModel extends BaseModel {
    // Define the table name
    private $table = 'examples';

    /**
     * Retrieve all records from the examples table.
     *
     * @return array List of records.
     */
    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create a new record in the examples table.
     *
     * @param array $data Associative array of column names and values.
     * @return bool True on success, false otherwise.
     */
    public function create($data) {
        // Dynamically build the query based on provided data
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
}
