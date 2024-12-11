<?php
session_start();
require '../Database.php';

$db = new Database();

// Initialize variables
$mission = '';
$vision = '';
$motto = '';
$opening_day = '';
$closing_day = '';
$opening_time = '';
$closing_time = '';

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM vmm_info WHERE meta_field IN ('mission', 'vision', 'motto', 'opening_day', 'closing_day', 'opening_time', 'closing_time')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$ids = []; // Array to hold IDs for each field

foreach ($result as $row) {
    if ($row['meta_field'] === 'mission') {
        $mission = $row['meta_value'];
        $ids['mission'] = $row['id']; // Store the ID for mission
    } elseif ($row['meta_field'] === 'vision') {
        $vision = $row['meta_value'];
        $ids['vision'] = $row['id']; // Store the ID for vision
    } elseif ($row['meta_field'] === 'motto') {
        $motto = $row['meta_value'];
        $ids['motto'] = $row['id']; // Store the ID for motto
    } elseif ($row['meta_field'] === 'opening_day') {
        $opening_day = $row['meta_value'];
        $ids['opening_day'] = $row['id']; // Store the ID for opening day
    } elseif ($row['meta_field'] === 'closing_day') {
        $closing_day = $row['meta_value'];
        $ids['closing_day'] = $row['id']; // Store the ID for closing day
    } elseif ($row['meta_field'] === 'opening_time') {
        $opening_time = $row['meta_value'];
        $ids['opening_time'] = $row['id']; // Store the ID for opening time
    } elseif ($row['meta_field'] === 'closing_time') {
        $closing_time = $row['meta_value'];
        $ids['closing_time'] = $row['id']; // Store the ID for closing time
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $mission = $_POST['mission'] ?? '';
    $vision = $_POST['vision'] ?? '';
    $motto = $_POST['motto'] ?? '';
    $opening_day = $_POST['opening_day'] ?? '';
    $closing_day = $_POST['closing_day'] ?? '';
    $opening_time = $_POST['opening_time'] ?? '';
    $closing_time = $_POST['closing_time'] ?? '';

    // Validate input data
    if (empty($mission) || empty($vision) || empty($motto) || empty($opening_day) || empty($closing_day) || empty($opening_time) || empty($closing_time)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("Location: vmm_info.php");
        exit;
    }

    try {
        // Update existing records
        $fields = [
            'mission' => $mission,
            'vision' => $vision,
            'motto' => $motto,
            'opening_day' => $opening_day,
            'closing_day' => $closing_day,
            'opening_time' => $opening_time,
            'closing_time' => $closing_time,
        ];

        foreach ($fields as $field => $value) {
            $stmt = $db->prepare("UPDATE vmm_info SET meta_value = ? WHERE meta_field = ? AND id = ?");
            $stmt->bindParam(1, $value);
            $stmt->bindParam(2, $field);
            $stmt->bindParam(3, $ids[$field]); // Use the correct ID for each field

            if (!$stmt->execute()) {
                error_log("Failed to update $field: " . implode(", ", $stmt->errorInfo()));
                $_SESSION['error'] = 'Failed to update ' . $field . '.';
                header("Location: vmm_info.php");
                exit;
            }
        }

        // Set success message and redirect
        $_SESSION['success'] = 'Vision, Mission, and Motto information updated successfully.';
        header("Location: vmm_info.php");
        exit;
    } catch (Exception $e) {
        error_log("An error occurred: " . $e->getMessage());
        $_SESSION['error'] = 'An unexpected error occurred . Please try again later.';
        header("Location: vmm_info.php");
        exit;
    }
}

// Close the database connection
$db = null;
?>