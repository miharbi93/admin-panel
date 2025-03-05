<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Initialize variables
$system_name = '';
$system_short_name = '';
$logo_path = ''; // Path to the uploaded logo
$id_name = null; // Initialize ID for system name
$id_short_name = null; // Initialize ID for system short name
$id_logo = null; // Initialize ID for system logo

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM system_info WHERE meta_field IN ('system_name', 'system_short_name', 'system_logo')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    if ($row['meta_field'] === 'system_name') {
        $system_name = $row['meta_value'];
        $id_name = $row['id']; // Store the ID for system name
    } elseif ($row['meta_field'] === 'system_short_name') {
        $system_short_name = $row['meta_value'];
        $id_short_name = $row['id']; // Store the ID for system short name
    } elseif ($row['meta_field'] === 'system_logo') {
        $logo_path = $row['meta_value'];
        $id_logo = $row['id']; // Store the ID for system logo
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $new_system_name = $_POST['system_name'] ?? '';
    $new_system_short_name = $_POST['system_short_name'] ?? '';
    
    // Handle file upload
    if (isset($_FILES['system_logo']) && $_FILES['system_logo']['error'] === UPLOAD_ERR_OK) {
        $file_type = $_FILES['system_logo']['type'];
        $allowed_types = ['image/png', 'image/jpeg', 'image/jpg']; // Allowed MIME types

        // Check if the uploaded file is of an allowed type
        if (in_array($file_type, $allowed_types)) {
            $target_dir = "uploads/"; // Directory to save uploaded files
            $target_file = $target_dir . basename($_FILES["system_logo"]["name"]);
            
            // Attempt to move the uploaded file
            if (move_uploaded_file($_FILES["system_logo"]["tmp_name"], $target_file)) {
                $new_logo_path = $target_file; // Set the logo path if upload is successful
            } else {
                $_SESSION['error'] = 'File upload failed.';
                header("Location: system_info");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Only PNG and JPEG images are allowed.';
            header("Location: system_info");
            exit;
        }
    } else {
        $new_logo_path = $logo_path; // Keep the existing logo path if no new logo is uploaded
    }

    // Initialize a flag to track if any changes were made
    $changes_made = false;
    $log_message = []; // Array to hold log messages

    // Check if we are updating or inserting
    if ($id_name) { // If ID for system name is set, we are updating
        // Check if the new system name is different from the existing one
        if ($new_system_name !== $system_name) {
            // Update existing record for system name
            $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_name' AND id = ?");
            $stmt->bindParam(1, $new_system_name);
            $stmt->bindParam(2, $id_name);
            if (!$stmt->execute()) {
                error_log("Failed to update system name: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update system name.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Updated system name to: ' . $new_system_name; // Add to log message
        }

        // Check if the new system short name is different from the existing one
        if ($id_short_name && $new_system_short_name !== $system_short_name) {
            $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_short_name' AND id = ?");
            $stmt->bindParam(1, $new_system_short_name);
            $stmt->bindParam(2, $id_short_name);
            if (!$stmt->execute()) {
                error_log("Failed to update system short name: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update system short name.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Updated system short name to: ' . $new_system_short_name; // Add to log message
        }

        // Check if the new logo path is different from the existing one
        if ($new_logo_path !== $logo_path) {
            $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_logo' AND id = ?");
            $stmt->bindParam(1, $new_logo_path);
            $stmt->bindParam(2, $id_logo);
            if (!$stmt->execute()) {
                error_log("Failed to update logo path: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update logo path.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Updated system logo path to: ' . $new_logo_path; // Add to log message
        }
    } else { // If ID is not set, we are inserting
        // Insert new record for system name if it is new
        if ($new_system_name !== '') {
            $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_name', ?)");
            $stmt->bindParam(1, $new_system_name);
            if (!$stmt->execute()) {
                error_log("Failed to insert system name: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to insert system name.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Inserted system name: ' . $new_system_name; // Add to log message
        }

        // Insert new record for system short name if it is new
        if ($new_system_short_name !== '') {
            $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_short_name', ?)");
            $stmt->bindParam(1, $new_system_short_name);
            if (!$stmt->execute()) {
                error_log("Failed to insert system short name: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to insert system short name.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Inserted system short name: ' . $new_system_short_name; // Add to log message
        }

        // Insert logo path if it has been set and is new
        if ($new_logo_path !== '') {
            $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_logo', ?)");
            $stmt->bindParam(1, $new_logo_path);
            if (!$stmt->execute()) {
                error_log("Failed to insert logo path: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to insert logo path.';
                header("Location: system_info");
                exit;
            }
            $changes_made = true; // Mark that a change was made
            $log_message[] = 'Inserted system logo path: ' . $new_logo_path; // Add to log message
        }
    }

    // Log the changes if any were made
    if ($changes_made) {
        $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
        $action = implode(', ', $log_message); // Combine log messages into a single string
        $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
        $activityStmt->bindParam(':action', $action);
        $activityStmt->execute();
    }

    // Set success message and redirect
    $_SESSION['success'] = 'System information updated successfully.';
    header("Location: system_info");
    exit;
}

// Close the database connection
$db = null;
?>