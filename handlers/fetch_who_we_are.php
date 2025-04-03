<?php
// fetch_who_we_are_info.php

// Include the Database class
require_once 'admin/Database.php';

// Create an instance of the Database class
$db = new Database();

// Prepare and execute the query to fetch data from the who_we_are table
$conn = $db->prepare("SELECT meta_field, meta_value FROM who_we_are");
$conn->execute();
$result = $conn->fetchAll(PDO::FETCH_ASSOC);

// Initialize an array to hold the information
$whoWeAreInfo = [];

// Fetch information from the result
foreach ($result as $row) {
    $whoWeAreInfo[$row['meta_field']] = $row['meta_value'];
}

// Return the information array
return $whoWeAreInfo;
?>