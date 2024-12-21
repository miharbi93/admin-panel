<?php
session_start();
require '../Database.php'; // Include your database connection file
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Initialize variables
    $title = $_POST['title'];
    $description = $_POST['description'];
    $slideimage = $_FILES['slideimage']['name'];
    $target_dir = "uploads/"; // Directory to save uploaded images
    $target_file = $target_dir . basename($slideimage);
    $uploadOk = 1; // Flag to check if upload is successful
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES['slideimage']['tmp_name']);
    if ($check === false) {
        $_SESSION['error'] = "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES['slideimage']['size'] > 5000000) {
        $_SESSION['error'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header("Location: add_slide_image_form"); // Redirect back to the form
        exit();
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES['slideimage']['tmp_name'], $target_file)) {
            // Prepare SQL statement to insert slide data
            $stmt = $db->prepare("INSERT INTO slides_images (title, description, slideimage) VALUES (:title, :description, :slideimage)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':slideimage', $target_file);

            // Execute the statement
            if ($stmt->execute()) {
                $_SESSION['success'] = "Data added successfully!";
            } else {
                $_SESSION['error'] = "Error adding slide to the database.";
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        }
    }

    // Redirect back to the form
    header("Location: add_slide_image_form");
    exit();
}
?>