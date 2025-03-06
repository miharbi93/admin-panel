<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the portfolio_item_id is provided
if (isset($_GET['id'])) {
    $portfolio_item_id = intval($_GET['id']); // Ensure the ID is an integer

    try {
        // Begin a transaction
        // $db->beginTransaction();

        // Fetch existing data for logging
        $stmtFetch = $db->prepare("SELECT title FROM portfolio_items WHERE id = ?");
        $stmtFetch->bindParam(1, $portfolio_item_id);
        $stmtFetch->execute();
        $existingItem = $stmtFetch->fetch(PDO::FETCH_ASSOC);

        // Prepare the delete statement for portfolio_images
        $stmtImages = $db->prepare("DELETE FROM portfolio_images WHERE portfolio_item_id = ?");
        $stmtImages->bindParam(1, $portfolio_item_id);
        $stmtImages->execute();

        // Prepare the delete statement for portfolio_items
        $stmtItem = $db->prepare("DELETE FROM portfolio_items WHERE id = ?");
        $stmtItem->bindParam(1, $portfolio_item_id);
        $stmtItem->execute();

        // Commit the transaction
        // $db->commit();

        // Log the deletion
        if ($existingItem) {
            $log_entry = "Deleted portfolio item ID: $portfolio_item_id, Title: '{$existingItem['title']}'";
            $stmt_log = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
            $stmt_log->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
            $stmt_log->bindParam(':action', $log_entry);
            $stmt_log->execute();
        }

        $_SESSION['success'] = 'Deleted successfully.';
    } catch (Exception $e) {
        // Rollback the transaction if something failed
        // $db->rollBack();
        error_log("Failed to delete portfolio item and images: " . $e->getMessage());
        $_SESSION['error'] = 'Failed to delete portfolio item and images.';
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

// Redirect back to the portfolio items list page
header("Location: manage_portfolio_info"); // Change this to your actual list page
exit;
?>