<?php
// fetch_slides.php

// Include the Database class
require_once 'admin/Database.php';

try {
    // Create a new instance of the Database class
    $database = new Database();
    
    // Prepare and execute the SQL statement
    $stmt = $database->prepare("SELECT * FROM slides_images");
    $stmt->execute();
    
    // Fetch all slides
    $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching slides: " . $e->getMessage();
    exit;
}
?>