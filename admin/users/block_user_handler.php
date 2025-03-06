<?php
session_start();
require '../Database.php'; // Include the Database class

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID and convert it to an integer

    // Create a new instance of the Database class
    $db = new Database();

    // Fetch the current blocked status
    $query = "SELECT username, blocked FROM tb_users WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Toggle the blocked status
        $newBlockedStatus = $user['blocked'] ? 0 : 1;

        // Prepare the update query
        $updateQuery = "UPDATE tb_users SET blocked = :blocked WHERE id = :id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(':blocked', $newBlockedStatus, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the update statement
        if ($updateStmt->execute()) {
            $_SESSION['success'] = $newBlockedStatus ? "User  blocked successfully." : "User  unblocked successfully.";

            // Log the action
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $action = $newBlockedStatus ? "Blocked user: {$user['username']} ( UserID: [ $id ] )" : "Unblocked user: {$user['username']} ( UserID: [ $id ] )";
                $stmt_log = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $stmt_log->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                $stmt_log->bindParam(':action', $action);
                if (!$stmt_log->execute()) {
                    error_log("Failed to log activity: " . implode(", ", $stmt_log->errorInfo())); // Log the error
                }
            }
        } else {
            $_SESSION['error'] = "Failed to update user status.";
        }
    } else {
        $_SESSION['error'] = "User  not found.";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the user management page
header("Location: list_manage_users"); // Change this to the appropriate page
exit();
?>