<?php
// fetch_system_info.php

// Include the Database class
require_once 'admin/Database.php';

// Create an instance of the Database class
$db = new Database();
$conn = $db->prepare("SELECT meta_field, meta_value FROM system_info WHERE meta_field IN ('system_logo', 'system_name')");
$conn->execute();
$result = $conn->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables for logo and title
$logo = '';
$title = '';

// Fetch logo and title from the result
foreach ($result as $row) {
    if ($row['meta_field'] === 'system_logo') {
        $logo = $row['meta_value'];
    } elseif ($row['meta_field'] === 'system_name') {
        $title = $row['meta_value'];
    }
}

// Return the logo and title as an associative array
return [
    'logo' => $logo,
    'title' => $title,
];
?>