<?php
session_start();
require '../Database.php'; // Include your database connection file
$db = new Database();
$conn = $db->getConnection(); // Get the PDO connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables
    $title = $_POST['title'];
    $description = $_POST['description'];
    $slideimages = $_FILES['slideimage']; // This will be an array of files
    $target_dir = "uploads/"; // Directory to save uploaded images

    // Ensure the uploads directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Get the number of images selected by the user
    $image_count = intval($_POST['image_count']); // Assuming you have a hidden input for this
    $uploaded_count = 0;

    // Prepare SQL statement to insert portfolio item
    $stmt = $conn->prepare("INSERT INTO portfolio_items (title, description) VALUES (:title, :description)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);

    // Execute the statement
    if ($stmt->execute()) {
        $portfolio_item_id = $conn->lastInsertId(); // Get the last inserted ID

        // Loop through each uploaded image
        foreach ($slideimages['name'] as $key => $slideimage) {
            // Check for upload errors
            if ($slideimages['error'][$key] === UPLOAD_ERR_NO_FILE) {
                // Skip this input if no file was uploaded
                continue; // Skip to the next iteration
            } elseif ($slideimages['error'][$key] !== UPLOAD_ERR_OK) {
                $_SESSION['error'] = "Error uploading file for image " . ($key + 1) . ": " . $slideimages['error'][$key];
                header("Location: add_portfolio_info");
                exit();
            }

            // Check if the temporary file path is not empty
            if (empty($slideimages['tmp_name'][$key])) {
                $_SESSION['error'] = "No file uploaded for image " . ($key + 1);
                header("Location: add_portfolio_info");
                exit();
            }

            // Check if image file is an actual image
            if (getimagesize($slideimages['tmp_name'][$key]) === false) {
                $_SESSION['error'] = "File is not an image for image " . ($key + 1);
                header("Location: add_portfolio_info");
                exit();
            }

            // Check file size (limit to 5MB)
            if ($slideimages['size'][$key] > 5000000) {
                $_SESSION['error'] = "Sorry, your file is too large for image " . ($key + 1);
                header("Location: add_portfolio_info");
                exit();
            }

            // Allow certain file formats
            $imageFileType = strtolower(pathinfo($slideimage, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed for image " . ($key + 1);
                header("Location: add_portfolio_info");
                exit();
            }

            // Move the uploaded file to the target directory
            $target_file = $target_dir . basename($slideimage);
            if (move_uploaded_file($slideimages['tmp_name'][$key], $target_file)) {
                // Insert image details into the database
                $stmt_image = $conn->prepare("INSERT INTO portfolio_images (portfolio_item_id, image_path) VALUES (:portfolio_item_id, :image_path)");
                $stmt_image->bindParam(':portfolio_item_id', $portfolio_item_id);
                $stmt_image->bindParam(':image_path', $target_file);
                $stmt_image->execute();
                $uploaded_count++; // Increment the count of successfully uploaded images
            } else {
                $_SESSION['error'] = "Error moving uploaded file for image " . ($key + 1);
                header("Location: add_portfolio_info");
                exit();
            }
        }

        // Set a success message if at least one image was uploaded
        if ($uploaded_count > 0) {
            $_SESSION['success'] = "Portfolio  added successfully with " . $uploaded_count . " images uploaded.";
        } else {
            $_SESSION['error'] = "Portfolio item added, but no images were uploaded.";
        }

        header("Location: add_portfolio_info"); // Redirect to the portfolio list page
        exit();
    } else {
        $_SESSION['error'] = "Error adding portfolio item.";
        header("Location: add_portfolio_info");
        exit();
    }
}
?>