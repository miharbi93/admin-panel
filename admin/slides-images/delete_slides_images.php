<?php
session_start();
require '../Database.php'; // Include the Database class

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Get the ID and convert it to an integer

    // Create a new instance of the Database class
    $db = new Database();

    // Fetch the title of the slide image to log
    $fetchStmt = $db->prepare("SELECT title FROM slides_images WHERE id = :id");
    $fetchStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $fetchStmt->execute();
    $slide = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    if ($slide) {
        // Prepare the delete query
        $query = "DELETE FROM slides_images WHERE id = :id";
        $stmt = $db->prepare($query);

        // Bind the ID parameter
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            // Set a success message in the session
            $_SESSION['success'] = "Slide image deleted successfully.";

            // Log the activity
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $action = "Deleted slide image: " . $slide['title'] . " ( [ ID: $id ])";
                $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                $activityStmt->bindParam(':action', $action);
                
                if (!$activityStmt->execute()) {
                    error_log("Failed to log activity: " . implode(", ", $activityStmt->errorInfo()));
                }
            }
        } else {
            // Set an error message in the session
            $_SESSION['error'] = "Failed to delete slide image.";
        }
    } else {
        // Set an error message if the slide does not exist
        $_SESSION['error'] = "Slide image not found.";
    }
} else {
    // Set an error message if ID is not provided
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the management page
header("Location: manage_slide_image.php"); // Change this to the appropriate page
exit();
?>