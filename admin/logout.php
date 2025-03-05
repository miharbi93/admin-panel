<?php
session_start();
require 'Database.php'; // Include your database connection

if (isset($_SESSION['user_id'])) {
    $db = new Database();
    
    // Log user logout activity
    $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
    $action = 'User  logged out';
    $activityStmt->bindParam(':user_id', $_SESSION['user_id']);
    $activityStmt->bindParam(':action', $action);
    $activityStmt->execute();
}

// Clear the session
session_unset();
session_destroy();

// Redirect to the login page
header("Location: login.php");
exit();
?>