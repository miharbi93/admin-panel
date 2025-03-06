<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // First, fetch the staff details to log them later
    $stmt = $db->prepare("SELECT staff_name, staff_position FROM management_contact WHERE id = ?");
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($staff) {
        $staff_name = $staff['staff_name'];
        $staff_position = $staff['staff_position'];

        // Prepare the delete statement
        $deleteStmt = $db->prepare("DELETE FROM management_contact WHERE id = ?");
        $deleteStmt->bindParam(1, $id);

        if ($deleteStmt->execute()) {
            $_SESSION['success'] = 'Management staff information deleted successfully.';

            // Log the activity
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id,  :action)");
                $action = "Deleted management staff: $staff_name (Position: $staff_position, ID: $id)";
                $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                // $activityStmt->bindParam(':username', $_SESSION['username']); // Assuming username is stored in session
                $activityStmt->bindParam(':action', $action);
                $activityStmt->execute();
            }
        } else {
            error_log("Failed to delete management staff: " . implode(", ", $deleteStmt->errorInfo()));
            $_SESSION['error'] = 'Failed to delete management staff information.';
        }
    } else {
        $_SESSION['error'] = 'Staff not found.';
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

// Redirect back to the management contact page
header("Location: list_management_contact"); // Change this to your actual list page
exit;
?>