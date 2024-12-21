<?php
session_start(); // Start the session
require '../Database.php'; // Include the Database class

$db = new Database();

// Initialize variables
$system_name = '';
$system_short_name = '';
$logo_path = ''; // Path to the uploaded logo
$id = null; // Initialize ID for update

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM system_info WHERE meta_field IN ('system_name', 'system_short_name', 'system_logo')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    if ($row['meta_field'] === 'system_name') {
        $system_name = $row['meta_value'];
        $id = $row['id']; // Store the ID for updates
    } elseif ($row['meta_field'] === 'system_short_name') {
        $system_short_name = $row['meta_value'];
    } elseif ($row['meta_field'] === 'system_logo') {
        $logo_path = $row['meta_value'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $system_name = $_POST['system_name'] ?? '';
    $system_short_name = $_POST['system_short_name'] ?? '';
    
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
                $logo_path = $target_file; // Set the logo path if upload is successful
            } else {
                $_SESSION['error'] = 'File upload failed.';
                header("Location: system_info.php");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Only PNG and JPEG images are allowed.';
            header("Location: system_info.php");
            exit;
        }
    }

    // Check if we are updating or inserting
    if ($id) { // If ID is set, we are updating
        // Update existing record for system name
        $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_name' AND id = ?");
        $stmt->bindParam(1, $system_name);
        $stmt->bindParam(2, $id);
        if (!$stmt->execute()) {
            error_log("Failed to update system name: " . implode(", ", $stmt->errorInfo()));
            $_SESSION['error'] = 'Failed to update system name.';
            header("Location: system_info.php");
            exit;
        }

        // Update existing record for system short name
        $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_short_name' AND id = (SELECT id FROM system_info WHERE meta_field = 'system_short_name' LIMIT 1)");
        $stmt->bindParam(1, $system_short_name); // Corrected variable name
        if (!$stmt->execute()) {
            error_log("Failed to update system short name: " . implode(", ", $stmt->errorInfo()));
            $_SESSION['error'] = 'Failed to update system short name.';
            header("Location: system_info.php");
            exit;
        }

        // Update logo path if it has been set
        if ($logo_path) {
            $stmt = $db->prepare("UPDATE system_info SET meta_value = ? WHERE meta_field = 'system_logo' AND id = (SELECT id FROM system_info WHERE meta_field = 'system_logo' LIMIT 1)");
            $stmt->bindParam(1, $logo_path);
            if (!$stmt->execute()) {
                error_log("Failed to update logo path: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update logo path.';
                header("Location: system_info.php");
                exit;
            }
        }
    } else { // If ID is not set, we are inserting
        // Insert new record for system name
        $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_name', ?)");
        $stmt->bindParam(1, $system_name);
        if (!$stmt->execute()) {
            error_log("Failed to insert system name: " . implode(", ", $stmt->errorInfo()));
            $_SESSION['error'] = 'Failed to insert system name.';
            header("Location: system_info.php");
            exit;
        }

        // Insert new record for system short name
        $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_short_name', ?)");
        $stmt->bindParam(1, $system_short_name);
        if (!$stmt->execute()) {
            error_log("Failed to insert system short name: " . implode(", ", $stmt->errorInfo()));
            $_SESSION['error'] = 'Failed to insert system short name.';
            header("Location: system_info.php");
            exit;
        }

        // Insert logo path if it has been set
        if ($logo_path) {
            $stmt = $db->prepare("INSERT INTO system_info (meta_field, meta_value) VALUES ('system_logo', ?)");
            $stmt->bindParam(1, $logo_path);
            if (!$stmt->execute()) {
                error_log("Failed to insert logo path: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to insert logo path.';
                header("Location: system_info.php");
                exit;
            }
        }
    }

    // Set success message and redirect
    $_SESSION['success'] = 'System information updated successfully.';
    header("Location: system_info.php");
    exit;
}

// Close the database connection
$db = null;
?>