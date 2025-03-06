<?php
session_start();
require '../Database.php'; // Include the Database class

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID and convert it to an integer

    // Create a new instance of the Database class
    $db = new Database();

    // Fetch the user's role and username before deletion
    $fetchStmt = $db->prepare("SELECT username, role FROM tb_users WHERE id = :id");
    $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchStmt->execute();
    $user = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Prepare the delete query
        $query = "DELETE FROM tb_users WHERE id = :id";
        $stmt = $db->prepare($query);

        // Bind the ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Set a success message in the session
            $_SESSION['success'] = "User  deleted successfully.";

            // Log the deletion action
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $log_entry = "Deleted user: " . $user['username'] . " ( [Role: " . $user['role'] . ", ID: [ $id ] ) ]";
                $stmt_log = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $stmt_log->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                $stmt_log->bindParam(':action', $log_entry);
                if (!$stmt_log->execute()) {
                    error_log("Failed to log activity: " . implode(", ", $stmt_log->errorInfo())); // Log the error
                }
            }
        } else {
            // Set an error message in the session
            $_SESSION['error'] = "Failed to delete user.";
        }
    } else {
        // Set an error message if the user is not found
        $_SESSION['error'] = "User  not found.";
    }
} else {
    // Set an error message if ID is not provided
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the user management page
header("Location: list_manage_users"); // Change this to the appropriate page
exit();
?>