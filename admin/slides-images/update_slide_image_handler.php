<?php
ob_start(); // Start output buffering
session_start();
require '../Database.php'; // Include the Database class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $slideImage = $_FILES['slideimage'];

    // Create a new instance of the Database class
    $db = new Database();

    // Fetch existing data for comparison
    $fetchStmt = $db->prepare("SELECT title, description, slideimage FROM slides_images WHERE id = :id");
    $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchStmt->execute();
    $existingData = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // Prepare the update query
    $query = "UPDATE slides_images SET title = :title, description = :description";
    if ($slideImage['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $targetDir = "uploads/"; // Specify your upload directory
        $targetFile = $targetDir . basename($slideImage["name"]);
        move_uploaded_file($slideImage["tmp_name"], $targetFile);
        $query .= ", slideimage = :slideimage";
    }
    $query .= " WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    if ($slideImage['error'] === UPLOAD_ERR_OK) {
        $stmt->bindParam(':slideimage', $targetFile);
    }
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Prepare to log changes
        $logMessages = [];

        // Check for changes and prepare log messages
        if ($existingData['title'] !== $title) {
            $logMessages[] = "Updated title from '{$existingData['title']}' to '$title'";
        }
        if ($existingData['description'] !== $description) {
            $logMessages[] = "Updated description from '{$existingData['description']}' to '$description'";
        }
        if ($slideImage['error'] === UPLOAD_ERR_OK && $existingData['slideimage'] !== $targetFile) {
            $logMessages[] = "Updated slide image from '{$existingData['slideimage']}' to '$targetFile'";
        }

        // Log the activity if there are changes
        if (!empty($logMessages)) {
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $activityStmt = $db->prepare("INSERT INTO user_activity (user_id,  action) VALUES (:user_id,  :action)");
                $action = implode(', ', $logMessages); // Combine log messages into a single string
                $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                // $activityStmt->bindParam(':username', $_SESSION['username']); // Assuming username is stored in session
                $activityStmt->bindParam(':action', $action);
                $activityStmt->execute();
            }
        }

        $_SESSION['success'] = "Updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update image.";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the management page
header("Location: manage_slide_image"); // Change this to the appropriate page
exit();
ob_end_flush(); // Flush the output buffer
?>