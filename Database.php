<?php
class Database {
    private $host = "localhost"; // Your database host
    private $username = "root"; // Your database username
    private $password = ""; // Your database password
    private $dbname = "marine_zanzibar_db"; // Your database name
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4", $this->username, $this->password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           // echo "Database connection successful."; // Success message
        } catch (PDOException $e) {
            // Log the error message instead of dying
            error_log("Connection failed: " . $e->getMessage());
            echo "Database connection failed. Please try again later."; // User-friendly message
        }
    }

    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function close() {
        $this->conn = null; // Close the connection
    }
}

// Example usage

?>