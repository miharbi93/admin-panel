
<?php
session_start();
require '../Database.php'; // Include the Database class

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID and convert it to an integer

    // Create a new instance of the Database class
    $db = new Database();

    // Fetch the current blocked status
    $query = "SELECT blocked FROM tb_users WHERE id = :id";
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