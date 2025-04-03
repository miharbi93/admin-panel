<?php
session_start();
require '../Database.php'; // Include the Database class

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $availability = $_POST['availability'];

    // Validate required fields
    if (empty($service_name) || empty($description) || empty($availability)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: update_service.php?id=" . $id);
        exit();
    }

    // Fetch existing data to compare
    $stmt = $db->prepare("SELECT service_name, description, availability FROM services WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $existing_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Initialize a flag to track if any changes were made
    $changes_made = false;
    $log_message = []; // Array to hold log messages

    // Prepare the update query
    $query = "UPDATE services SET service_name = :service_name, description = :description, availability = :availability";

    // Check if any changes are needed
    if ($existing_data['service_name'] !== $service_name) {
        $log_message[] = "Updated service name to: $service_name";
        $changes_made = true;
    }
    if ($existing_data['description'] !== $description) {
        $log_message[] = "Updated service description.";
        $changes_made = true;
    }
    if ($existing_data['availability'] !== $availability) {
        $log_message[] = "Updated service availability to: $availability";
        $changes_made = true;
    }

    // Finalize the query
    $query .= " WHERE id = :id";
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':service_name', $service_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':availability', $availability);
    $stmt->bindParam(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
        if ($changes_made) {
            $_SESSION['success'] = "Service updated successfully!";
        } else {
            $_SESSION['success'] = "No changes were made.";
        }
    } else {
        $_SESSION['error'] = "Failed to update service: " . implode(", ", $stmt->errorInfo());
    }

    // Log the changes if any were made
    if ($changes_made) {
        $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
        $action = implode(', ', $log_message); // Combine log messages into a single string
        $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
        $activityStmt->bindParam(':action', $action);
        $activityStmt->execute();
    }

    // Redirect back to the list page
    header("Location: list_manage_service");
    exit();
}

// Close the database connection
$db = null;
?>