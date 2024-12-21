<?php
session_start();
require '../Database.php'; // Include the Database class

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $staff_name = $_POST['staff_name'];
    $staff_position = $_POST['staff_position'];
    $staff_email = $_POST['staff_email'];
    $staff_phone = $_POST['staff_phone'];

    // Validate staff phone length
    if (strlen($staff_phone) > 16) {
        $_SESSION['error'] = "Phone number cannot exceed 16 characters.";
        header("Location: update_management_contact.php?id=" . $id);
        exit();
    }

    // Prepare the update query
    $query = "UPDATE management_contact SET staff_name = :staff_name, staff_position = :staff_position, staff_email = :staff_email, staff_phone = :staff_phone";
    
    // Check if a new image is uploaded
    if (!empty($_FILES['staff_image']['name'])) {
        // Handle the image upload
        $target_dir = "uploads/"; // Specify your upload directory
        $target_file = $target_dir . basename($_FILES["staff_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["staff_image"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['error'] = "File is not an image.";
            header("Location: update_management_contact.php?id=" . $id);
            exit();
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["staff_image"]["tmp_name"], $target_file)) {
            $query .= ", staff_image = :staff_image WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':staff_image', $target_file);
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            header("Location: update_management_contact.php?id=" . $id);
            exit();
        }
    } else {
        $query .= " WHERE id = :id";
        $stmt = $db->prepare($query);
    }

    // Bind parameters
    $stmt->bindParam(':staff_name', $staff_name);
    $stmt->bindParam(':staff_position', $staff_position);
    $stmt->bindParam(':staff_email', $staff_email);
    $stmt->bindParam(':staff_phone', $staff_phone);
    $stmt->bindParam(':id', $id);

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['success'] = "Contact updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update contact: " . implode(", ", $stmt->errorInfo());
    }

    // Redirect back to the list page
    header("Location: list_management_contact.php");
    exit();
}
?>