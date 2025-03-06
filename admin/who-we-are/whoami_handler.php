<?php
session_start();
require '../Database.php';

$db = new Database();

// Initialize variables
$whoami = '';
$youtube_video_link = '';

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM who_we_are WHERE meta_field IN ('whoami', 'youtube_video_link')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ids = []; // Array to hold IDs for each field
$current_values = []; // Array to hold current values for comparison

foreach ($result as $row) {
    if ($row['meta_field'] === 'whoami') {
        $whoami = $row['meta_value'];
        $ids['whoami'] = $row['id']; // Store the ID for whoami
        $current_values['whoami'] = $row['meta_value']; // Store current value
    } elseif ($row['meta_field'] === 'youtube_video_link') {
        $youtube_video_link = $row['meta_value'];
        $ids['youtube_video_link'] = $row['id']; // Store the ID for youtube_video_link
        $current_values['youtube_video_link'] = $row['meta_value']; // Store current value
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $whoami = $_POST['whoami'] ?? '';
    $youtube_video_link = $_POST['youtube_video_link'] ?? '';

    // Validate input data
    if (empty($whoami) || empty($youtube_video_link)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("Location: whoami");
        exit;
    }

    try {
        // Update existing records
        $fields = [
            'whoami' => $whoami,
            'youtube_video_link' => $youtube_video_link,
        ];

        $log_messages = []; // Array to hold log messages

        foreach ($fields as $field => $value) {
            // Check if the new value is different from the current value
            if ($current_values[$field] !== $value) {
                $stmt = $db->prepare("UPDATE who_we_are SET meta_value = ? WHERE meta_field = ? AND id = ?");
                $stmt->bindParam(1, $value);
                $stmt->bindParam(2, $field);
                $stmt->bindParam(3, $ids[$field]); // Use the correct ID for each field

                if ($stmt->execute()) {
                    // Log the update
                    $log_messages[] = "Updated $field to: $value";
                } else {
                    error_log("Failed to update $field: " . implode(", ", $stmt->errorInfo()));
                    $_SESSION['error'] = 'Failed to update ' . $field . '.';
                    header("Location: whoami");
                    exit;
                }
            }
        }

        // Log the activity only if there are changes
        if (!empty($log_messages)) {
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $action = implode(', ', $log_messages); // Combine log messages into a single string
                $activityStmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                // $activityStmt->bindParam(':username', $_SESSION['username']); // Assuming username is stored in session
                $activityStmt->bindParam(':action', $action);
                $activityStmt->execute();
            }
        }

        // Set success message and redirect
        $_SESSION['success'] = 'Who Am I information updated successfully.';
        header("Location: whoami");
        exit;
    } catch (Exception $e) {
        error_log("An error occurred: " . $e->getMessage());
        $_SESSION['error'] = 'An unexpected error occurred. Please try again later.';
        header("Location: whoami");
        exit;
    }
}

// Close the database connection
$db = null;
?>