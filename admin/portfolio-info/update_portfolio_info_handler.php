<?php
session_start();
require '../Database.php'; // Include your database connection file
$db = new Database();
$conn = $db->getConnection(); // Get the PDO connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables
    $portfolio_item_id = intval($_POST['portfolio_item_id']); // Get the portfolio item ID
    $title = $_POST['title'] ?? null; // Use null coalescing to handle unset values
    $description = $_POST['description'] ?? null; // Use null coalescing to handle unset values
    $slideimages = $_FILES['slideimage']; // This will be an array of files
    $target_dir = "uploads/"; // Directory to save uploaded images

    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Fetch existing data for comparison
    $stmt = $conn->prepare("SELECT title, description FROM portfolio_items WHERE id = :portfolio_item_id");
    $stmt->bindParam(':portfolio_item_id', $portfolio_item_id);
    $stmt->execute();
    $existingData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Prepare SQL statement to update portfolio item
    $updateFields = [];
    if ($title && $existingData['title'] !== $title) {
        $updateFields[] = "title = :title";
    }
    if ($description && $existingData['description'] !== $description) {
        $updateFields[] = "description = :description";
    }

    // If no fields to update, redirect with an error
    if (empty($updateFields)) {
        $_SESSION['error'] = "No fields to update.";
        header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
        exit();
    }

    $sql = "UPDATE portfolio_items SET " . implode(", ", $updateFields) . " WHERE id = :portfolio_item_id";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    if ($title && $existingData['title'] !== $title) {
        $stmt->bindParam(':title', $title);
    }
    if ($description && $existingData['description'] !== $description) {
        $stmt->bindParam(':description', $description);
    }
    $stmt->bindParam(':portfolio_item_id', $portfolio_item_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Prepare to log changes
        $logMessages = [];

        // Log title change
        if ($title && $existingData['title'] !== $title) {
            $logMessages[] = "Updated title from '{$existingData['title']}' to '$title'";
        }

        // Log description change
        if ($description && $existingData['description'] !== $description) {
            $logMessages[] = "Updated description from '{$existingData['description']}' to '$description'";
        }

        // Fetch existing images for the portfolio item
        $stmt = $conn->prepare("SELECT image_path FROM portfolio_images WHERE portfolio_item_id = :portfolio_item_id");
        $stmt->bindParam(':portfolio_item_id', $portfolio_item_id);
        $stmt->execute();
        $existing_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through each uploaded image
        foreach ($slideimages['name'] as $key => $slideimage) {
            // Check for upload errors
            if ($slideimages['error'][$key] === UPLOAD_ERR_NO_FILE) {
                // Skip this input if no file was uploaded
                continue; // Skip to the next iteration
            } elseif ($slideimages['error'][$key] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Error uploading file for image " . ($key + 1) . ": " . $slideimages['error'][$key];
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }

            // Check if the temporary file path is not empty
            if (empty($slideimages['tmp_name'][$key])) {
                $_SESSION['error'] = "No file uploaded for image " . ($key + 1);
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }

            // Check if image file is an actual image
            if (getimagesize($slideimages['tmp_name'][$key]) === false) {
                $_SESSION['error'] = "File is not an image for image " . ($key + 1);
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }

            // Check file size (limit to 5MB)
            if ($slideimages['size'][$key] > 5000000) {
                $_SESSION['error'] = "Sorry, your file is too large for image " . ($key + 1);
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }

            // Allow certain file formats
            $imageFileType = strtolower(pathinfo($slideimage, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image " . ($key + 1);
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }

            // Move the uploaded file to the target directory
            $target_file = $target_dir . uniqid() . '_' . basename($slideimage); // Use unique filename to avoid overwriting
            if (move_uploaded_file($slideimages['tmp_name'][$key], $target_file)) {
                // Update the existing image path in the database
                if (isset($existing_images[$key])) {
                    $stmt_image = $conn->prepare("UPDATE portfolio_images SET image_path = :image_path WHERE portfolio_item_id = :portfolio_item_id AND image_path = :old_image_path");
                    $stmt_image->bindParam(':portfolio_item_id', $portfolio_item_id);
                    $stmt_image->bindParam(':image_path', $target_file);
                    $stmt_image->bindParam(':old_image_path', $existing_images[$key]['image_path']);
                    $stmt_image->execute();

                    // Log image change
                    $logMessages[] = "Updated image from '{$existing_images[$key]['image_path']}' to '$target_file'";
                }
            } else {
                $_SESSION['error'] = "Error moving uploaded file for image " . ($key + 1);
                header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
                exit();
            }
        }

        // Log all changes if any
        if (!empty($logMessages) && isset($_SESSION['user_id'])) {
            $log_entry = "Updated portfolio item ID: $portfolio_item_id. " . implode(', ', $logMessages);
            $stmt_log = $conn->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
            $stmt_log->bindParam(':user_id', $_SESSION['user_id']);
            $stmt_log->bindParam(':action', $log_entry);
            if (!$stmt_log->execute()) {
                error_log("Failed to log activity: " . implode(", ", $stmt_log->errorInfo())); // Log the error
            }
        }

        $_SESSION['success'] = "Portfolio item updated successfully.";
        header("Location: manage_portfolio_info"); // Redirect to the portfolio list page
        exit();
    } else {
        $_SESSION['error'] = "Error updating portfolio item.";
        header("Location: update_portfolio_info.php?id=" . $portfolio_item_id);
        exit();
    }
}
?>