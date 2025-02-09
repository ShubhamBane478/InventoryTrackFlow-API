<?php
// config/database.php

// Define your database credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');

/**
 * Database class to manage the PDO connection.
 */
class Database {
    // Singleton instance of the database connection
    private static $instance = null;
    private $connection;

    /**
     * Private constructor to prevent multiple instances.
     */
    private function __construct() {
        try {
            // Create the DSN string for PDO
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
            // Create a new PDO connection
            $this->connection = new PDO($dsn, DB_USER, DB_PASS);
            // Set error mode to exceptions for better error handling
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Terminate the script if a connection error occurs
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Get the PDO database connection.
     *
     * @return PDO The PDO connection instance.
     */
    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
