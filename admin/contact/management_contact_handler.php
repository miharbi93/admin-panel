<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $staff_name = $_POST['staff_name'] ?? '';
    $staff_position = $_POST['staff_position'] ?? '';
    $staff_email = $_POST['staff_email'] ?? '';
    $staff_phone = $_POST['staff_phone'] ?? '';
    $staff_image_path = ''; // Path to the uploaded image

    // Validate required fields
    if (empty($staff_name) || empty($staff_position) || empty($staff_email) || empty($staff_phone)) {
        $_SESSION['error'] = 'All fields are required.';
        header("Location: management_contact.php");
        exit;
    }

    // Handle file upload
    if (isset($_FILES['staff_image']) && $_FILES['staff_image']['error'] === UPLOAD_ERR_OK) {
        $file_type = $_FILES['staff_image']['type'];
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg']; // Allowed MIME types

        // Check if the uploaded file is of an allowed type
        if (in_array($file_type, $allowed_types)) {
            $target_dir = "uploads/"; // Directory to save uploaded files
            $target_file = $target_dir . basename($_FILES["staff_image"]["name"]);
            
            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES["staff_image"]["tmp_name"], $target_file)) {
                $staff_image_path = $target_file; // Set the image path if upload is successful
            } else {
                $_SESSION['error'] = 'File upload failed.';
                header("Location: management_contact.php");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Only PNG and JPEG images are allowed.';
            header("Location: management_contact.php");
            exit;
        }
    } else {
        $_SESSION['error'] = 'Image upload is required.';
        header("Location: management_contact.php");
        exit;
    }

    // Check for duplicate email
    $stmt = $db->prepare("SELECT COUNT(*) FROM management_contact WHERE staff_email = ?");
    $stmt->bindParam(1, $staff_email);
    $stmt->execute();
    $email_count = $stmt->fetchColumn();

    if ($email_count > 0) {
        $_SESSION['error'] = 'This email address is already in use.';
        header("Location: management_contact.php");
        exit;
    }

    // Insert new record for management staff
    $stmt = $db->prepare("INSERT INTO management_contact (staff_image, staff_name, staff_position, staff_email, staff_phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $staff_image_path);
    $stmt->bindParam(2, $staff_name);
    $stmt->bindParam(3, $staff_position);
    $stmt->bindParam(4, $staff_email);
    $stmt->bindParam(5, $staff_phone);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Management staff information added successfully.';
    } else {
        error_log("Failed to insert management staff: " . implode(", ", $stmt->errorInfo()));
        $_SESSION['error'] = 'Failed to add management staff information.';
    }

    header("Location: management_contact.php");
    exit;
}

// Close the database connection
$db = null;
?>