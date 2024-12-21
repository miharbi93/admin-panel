<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $db->prepare("DELETE FROM management_contact WHERE id = ?");
    $stmt->bindParam(1, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Management staff information deleted successfully.';
    } else {
        error_log("Failed to delete management staff: " . implode(", ", $stmt->errorInfo()));
        $_SESSION['error'] = 'Failed to delete management staff information.';
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

// Redirect back to the management contact page
header("Location: list_management_contact.php"); // Change this to your actual list page
exit;
?>