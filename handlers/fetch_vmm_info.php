<?php
// fetch_vmm_info.php

// Include the Database class
require_once 'admin/Database.php';

// Create an instance of the Database class
$db = new Database();
$conn = $db->prepare("SELECT meta_field, meta_value FROM vmm_info");
$conn->execute();
$result = $conn->fetchAll(PDO::FETCH_ASSOC);

// Initialize an array to hold the information
$vmmInfo = [];

// Fetch information from the result
foreach ($result as $row) {
    $vmmInfo[$row['meta_field']] = $row['meta_value'];
}

// Return the information array
return $vmmInfo;
?>