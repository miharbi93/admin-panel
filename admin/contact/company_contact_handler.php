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

    $changes_made = false; // Flag to track if any changes were made
    $log_message = []; // Array to hold log messages

    try {
        foreach ($fields as $meta_field => $meta_value) {
            // Check if the record exists
            $stmt = $db->prepare("SELECT id, meta_value FROM company_contact WHERE meta_field = ?");
            $stmt->execute([$meta_field]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                // Update existing record
                if ($existing['meta_value'] !== $meta_value) { // Check if the value has changed
                    $stmt = $db->prepare("UPDATE company_contact SET meta_value = ? WHERE meta_field = ?");
                    $stmt->execute([$meta_value, $meta_field]);
                    $changes_made = true; // Mark that a change was made
                    $log_message[] = "Updated $meta_field to: $meta_value"; // Add to log message
                }
            } else {
                // Insert new record
                $stmt = $db->prepare("INSERT INTO company_contact (meta_field, meta_value) VALUES (?, ?)");
                $stmt->execute([$meta_field, $meta_value]);
                $changes_made = true; // Mark that a change was made
                $log_message[] = "Inserted $meta_field: $meta_value"; // Add to log message
            }
        }

        // Log the changes if any were made
        if ($changes_made) {
            $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
            $action = implode(', ', $log_message); // Combine log messages into a single string
            $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
            $activityStmt->bindParam(':action', $action);
            $activityStmt->execute();
        }

        // Set success message
        $_SESSION['success'] = 'Contact updated successfully.';
    } catch (Exception $e) {
        // Set error message
        $_SESSION['error'] = 'An error occurred: ' . $e->getMessage();
    }

    // Redirect to the same page to avoid resubmission
    header("Location: company_contact"); // Change to your form page
    exit;
}

// Close the database connection
$db = null;
?>