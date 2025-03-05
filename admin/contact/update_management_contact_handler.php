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

    // Fetch existing data to compare
    $stmt = $db->prepare("SELECT staff_name, staff_position, staff_email, staff_phone, staff_image FROM management_contact WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $existing_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Initialize a flag to track if any changes were made
    $changes_made = false;
    $log_message = []; // Array to hold log messages

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
            $changes_made = true; // Mark that a change was made
            $log_message[] = "Updated staff image to: $target_file"; // Add to log message
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
        // Check for changes and log them
        if ($existing_data['staff_name'] !== $staff_name) {
            $log_message[] = "Updated staff name to: $staff_name";
            $changes_made = true;
        }
        if ($existing_data['staff_position'] !== $staff_position) {
            $log_message[] = "Updated staff position to: $staff_position";
            $changes_made = true;
        }
        if ($existing_data['staff_email'] !== $staff_email) {
            $log_message[] = "Updated staff email to: $staff_email";
            $changes_made = true;
        }
        if ($existing_data['staff_phone'] !== $staff_phone) {
            $log_message[] = "Updated staff phone to: $staff_phone";
            $changes_made = true;
        }
        if (isset($target_file) && $existing_data['staff_image'] !== $target_file) {
            $log_message[] = "Updated staff image to: $target_file";
            $changes_made = true;
        }

        if ($changes_made) {
            $_SESSION['success'] = "Contact updated successfully!";
        } else {
            $_SESSION['success'] = "No changes were made.";
        }
    } else {
        $_SESSION['error'] = "Failed to update contact: " . implode(", ", $stmt->errorInfo());
    }

    // Log the changes if any were made
    if ($changes_made) {
        $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
        $action = implode(', ', $log_message); // Combine log messages into a single string
        $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
        $activityStmt->bindParam(':action', $action);
        $activityStmt->execute();
    }

    // Redirect back to the list page
    header("Location: list_management_contact");
    exit();
}

// Close the database connection
$db = null;
?>