//A base model class that other models can extend. It provides access to the database connection.


<?php
// model/BaseModel.php

/**
 * BaseModel class
 * Provides a base for all models that interact with the database.
 */
class BaseModel {
    // PDO instance for database connection
    protected $db;

    public function __construct() {
        // Retrieve the database connection using the Database class
        $this->db = Database::getConnection();
    }
}
