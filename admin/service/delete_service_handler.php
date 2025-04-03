<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, fetch the service details to log them later
    $stmt = $db->prepare("SELECT service_name, availability FROM services WHERE id = ?");
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $service = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($service) {
        $service_name = $service['service_name'];
        $availability = $service['availability'];

        // Prepare the delete statement
        $deleteStmt = $db->prepare("DELETE FROM services WHERE id = ?");
        $deleteStmt->bindParam(1, $id);

        if ($deleteStmt->execute()) {
            $_SESSION['success'] = 'Service deleted successfully.';

            // Log the activity
            if (isset($_SESSION['user_id'])) {
                $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $action = "Deleted service: $service_name (Availability: $availability, ID: $id)";
                $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                $activityStmt->bindParam(':action', $action);
                $activityStmt->execute();
            }
        } else {
            error_log("Failed to delete service: " . implode(", ", $deleteStmt->errorInfo()));
            $_SESSION['error'] = 'Failed to delete service.';
        }
    } else {
        $_SESSION['error'] = 'Service not found.';
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

// Redirect back to the services list page
header("Location: list_manage_service"); // Change this to your actual list page
exit;
?>