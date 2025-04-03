<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $service_name = $_POST['service_name'] ?? '';
    $description = $_POST['description'] ?? '';
    $availability = $_POST['availability'] ?? '';

    // Validate required fields
    if (empty($service_name) || empty($description) || empty($availability)) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: add_service.php"); // Redirect to the form page
        exit;
    }

    // Insert new record for the service
    $stmt = $db->prepare("INSERT INTO services (service_name, description, availability) VALUES (?, ?, ?)");
    $stmt->bindParam(1, $service_name);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $availability);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Service added successfully.';

        // Log the activity
        $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
        $action = "Added service: $service_name, Availability: $availability";
        $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
        $activityStmt->bindParam(':action', $action);
        $activityStmt->execute();
    } else {
        error_log("Failed to insert service: " . implode(", ", $stmt->errorInfo()));
        $_SESSION['error'] = 'Failed to add service.';
    }

    header("Location: list_manage_service"); // Redirect back to the form page
    exit;
}

// Close the database connection
$db = null;
?>