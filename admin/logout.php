<?php
session_start();
require 'Database.php'; // Include your database connection

if (isset($_SESSION['user_id'])) {
    $db = new Database();
    
    // Log user logout activity
    $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
    $action = 'logged out';
    $activityStmt->bindParam(':user_id', $_SESSION['user_id']);
    $activityStmt->bindParam(':action', $action);
    $activityStmt->execute();
}

// Clear the session
session_unset();
session_destroy();

// Clear local storage (if applicable)
// You can include a script to clear local storage if you're using it for session management
echo "<script>
        console.log('clear data');
        localStorage.removeItem('username'); // Clear username from local storage
        localStorage.removeItem('isLocked'); // Clear lock state from local storage
        window.location.href = 'login.php'; // Redirect to the login page
      </script>";
exit();
?>