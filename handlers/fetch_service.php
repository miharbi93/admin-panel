<?php
// fetch_services.php

// Include the Database class
require_once 'admin/Database.php';

try {
    // Create a new instance of the Database class
    $database = new Database();
    
    // Prepare and execute the SQL statement to fetch available services
    $stmt = $database->prepare("SELECT * FROM services WHERE availability = :availability");
    $availability = 'Available'; // Set the availability parameter
    $stmt->bindParam(':availability', $availability);
    $stmt->execute();
    
    // Fetch all available services
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Optionally, you can output the services for debugging
    // print_r($services);
} catch (PDOException $e) {
    echo "Error fetching services: " . $e->getMessage();
    exit;
}
?>