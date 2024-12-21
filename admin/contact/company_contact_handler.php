<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Initialize variables
$phone_number = '';
$whatsapp = '';
$email = '';
$twitter = '';
$youtube = '';
$address = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $phone_number = $_POST['phone_number'] ?? '';
    $whatsapp = $_POST['whatsapp'] ?? '';
    $email = $_POST['email'] ?? '';
    $twitter = $_POST['twitter'] ?? '';
    $youtube = $_POST['youtube'] ?? '';
    $address = $_POST['address'] ?? '';

    // Prepare the SQL statements for insert/update
    $fields = [
        'phone_number' => $phone_number,
        'whatsapp' => $whatsapp,
        'email' => $email,
        'twitter' => $twitter,
        'youtube' => $youtube,
        'address' => $address,
    ];

    try {
        foreach ($fields as $meta_field => $meta_value) {
            // Check if the record exists
            $stmt = $db->prepare("SELECT id FROM company_contact WHERE meta_field = ?");
            $stmt->execute([$meta_field]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                // Update existing record
                $stmt = $db->prepare("UPDATE company_contact SET meta_value = ? WHERE meta_field = ?");
                $stmt->execute([$meta_value, $meta_field]);
            } else {
                // Insert new record
                $stmt = $db->prepare("INSERT INTO company_contact (meta_field, meta_value) VALUES (?, ?)");
                $stmt->execute([$meta_field, $meta_value]);
            }
        }

        // Set success message
        $_SESSION['success'] = 'Contact  updated successfully.';
    } catch (Exception $e) {
        // Set error message
        $_SESSION['error'] = 'An error occurred: ' . $e->getMessage();
    }

    // Redirect to the same page to avoid resubmission
    header("Location: company_contact.php"); // Change to your form page
    exit;
}

// Close the database connection
$db = null;
?>