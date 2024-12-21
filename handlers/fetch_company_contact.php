<?php
// fetch_company_contact.php

// Include the Database class
require_once 'admin/Database.php';

// Create an instance of the Database class
$db = new Database();
$conn = $db->prepare("SELECT meta_field, meta_value FROM company_contact");
$conn->execute();
$result = $conn->fetchAll(PDO::FETCH_ASSOC);

// Initialize an array to hold contact information
$contactInfo = [];

// Fetch contact information from the result
foreach ($result as $row) {
    $contactInfo[$row['meta_field']] = $row['meta_value'];
}

// Return the contact information array
return $contactInfo;
?>