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

foreach ($result as $row) {
    if ($row['meta_field'] === 'whoami') {
        $whoami = $row['meta_value'];
        $ids['whoami'] = $row['id']; // Store the ID for whoami
    } elseif ($row['meta_field'] === 'youtube_video_link') {
        $youtube_video_link = $row['meta_value'];
        $ids['youtube_video_link'] = $row['id']; // Store the ID for youtube_video_link
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
        header("Location: whoami.php");
        exit;
    }

    try {
        // Update existing records
        $fields = [
            'whoami' => $whoami,
            'youtube_video_link' => $youtube_video_link,
        ];

        foreach ($fields as $field => $value) {
            $stmt = $db->prepare("UPDATE who_we_are SET meta_value = ? WHERE meta_field = ? AND id = ?");
            $stmt->bindParam(1, $value);
            $stmt->bindParam(2, $field);
            $stmt->bindParam(3, $ids[$field]); // Use the correct ID for each field

            if (!$stmt->execute()) {
                error_log("Failed to update $field: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update ' . $field . '.';
                header("Location: whoami.php");
                exit;
            }
        }

        // Set success message and redirect
        $_SESSION['success'] = 'Who Am I information updated successfully.';
        header("Location: whoami.php");
        exit;
    } catch (Exception $e) {
        error_log("An error occurred: " . $e->getMessage());
        $_SESSION['error'] = 'An unexpected error occurred. Please try again later.';
        header("Location: whoami.php");
        exit;
    }
}

// Close the database connection
$db = null;
?>