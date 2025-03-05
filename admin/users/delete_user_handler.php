<?php
session_start();
require '../Database.php'; // Include the Database class

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID and convert it to an integer

    // Create a new instance of the Database class
    $db = new Database();

    // Prepare the delete query
    $query = "DELETE FROM tb_users WHERE id = :id";
    $stmt = $db->prepare($query);

    // Bind the ID parameter
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Set a success message in the session
        $_SESSION['success'] = "User  deleted successfully.";
    } else {
        // Set an error message in the session
        $_SESSION['error'] = "Failed to delete user.";
    }
} else {
    // Set an error message if ID is not provided
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the user management page
header("Location: list_manage_users"); // Change this to the appropriate page
exit();
?>