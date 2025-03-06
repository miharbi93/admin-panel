<?php
session_start();
require '../Database.php'; // Include the Database class

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $blocked = isset($_POST['blocked']) ? (int)$_POST['blocked'] : 0; // Default to 0 if not set
    $password = trim($_POST['password']); // Get the password field

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: update_user_form.php?id=" . $id);
        exit();
    }

    // Check if the email already exists
    $query = "SELECT id FROM tb_users WHERE email = :email AND id != :id"; // Check for existing email excluding the current user
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists.";
        header("Location: update_user_form.php?id=" . $id);
        exit();
    }

    // Fetch existing data for comparison
    $fetchStmt = $db->prepare("SELECT username, email, role, blocked FROM tb_users WHERE id = :id");
    $fetchStmt->bindParam(':id', $id);
    $fetchStmt->execute();
    $existingData = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // Prepare the update query
    $query = "UPDATE tb_users SET username = :username, email = :email, role = :role, blocked = :blocked";

    // Check if the password is provided
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query .= ", password = :password"; // Add password to the query
    }

    $query .= " WHERE id = :id";

    // Prepare the statement
    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':blocked', $blocked);
    $stmt->bindParam(':id', $id);

    // Bind the password if it is provided
    if (!empty($password)) {
        $stmt->bindParam(':password', $hashedPassword);
    }

    // Execute the query
    if ($stmt->execute()) {
        // Prepare to log changes
        $logMessages = [];

        // Check for changes and prepare log messages
        if ($existingData['username'] !== $username) {
            $logMessages[] = "Updated username from '{$existingData['username']}' to '$username'";
        }
        if ($existingData['email'] !== $email) {
            $logMessages[] = "Updated email from '{$existingData['email']}' to '$email'";
        }
        if ($existingData['role'] !== $role) {
            $logMessages[] = "Updated role from '{$existingData['role']}' to '$role'";
        }
        if ($existingData['blocked'] !== $blocked) {
            $logMessages[] = "Updated blocked status from '{$existingData['blocked']}' to '$blocked'";
        }

        // Log the activity if there are changes
        if (!empty($logMessages) && isset($_SESSION['user_id'])) {
            $log_entry = "User  ID $id: " . implode(', ', $logMessages);
            $stmt_log = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
            $stmt_log->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
            $stmt_log->bindParam(':action', $log_entry);
            if (!$stmt_log->execute()) {
                error_log("Failed to log activity: " . implode(", ", $stmt_log->errorInfo())); // Log the error
            }
        }

        $_SESSION['success'] = "User  updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update user: " . implode(", ", $stmt->errorInfo());
    }

    // Redirect back to the list page
    header("Location: list_manage_users");
    exit();
}