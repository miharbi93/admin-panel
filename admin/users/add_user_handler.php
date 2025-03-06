<?php
session_start();
require '../Database.php'; // Include your Database class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $blocked = isset($_POST['blocked']) ? (int)$_POST['blocked'] : 0; // Default to 0 (not blocked)

    // Create a new instance of the Database class
    $db = new Database();

    try {
        // Check if the email already exists
        $query = "SELECT COUNT(*) FROM tb_users WHERE email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $emailExists = $stmt->fetchColumn();

        if ($emailExists) {
            // Email already exists, set an error message
            $_SESSION['error'] = "Email already exists. Please use a different email.";
            header("Location: add_user_form"); // Redirect back to the form
            exit();
        }

        // Check if the username already exists
        $query = "SELECT COUNT(*) FROM tb_users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $usernameExists = $stmt->fetchColumn();

        if ($usernameExists) {
            // Username already exists, set an error message
            $_SESSION['error'] = "Username already exists. Please choose a different username.";
            header("Location: add_user_form"); // Redirect back to the form
            exit();
        }

        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement for insertion
        $query = "INSERT INTO tb_users (username, password, email, role, blocked) VALUES (:username, :password, :email, :role, :blocked)";
        $stmt = $db->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':blocked', $blocked, PDO::PARAM_INT);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "User  created successfully!";

            // Log the user creation action
            if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
                $log_entry = "Created user: $username with email: $email and role: $role";
                $stmt_log = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
                $stmt_log->bindParam(':user_id', $_SESSION['user_id']); // Assuming user_id is stored in session
                $stmt_log->bindParam(':action', $log_entry);
                if (!$stmt_log->execute()) {
                    error_log("Failed to log activity: " . implode(", ", $stmt_log->errorInfo())); // Log the error
                }
            }
        } else {
            $_SESSION['error'] = "Failed to create user.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    // Redirect back to the user list page
    header("Location: list_manage_users");
    exit();
} else {
    // If the request method is not POST, redirect to the user list page
    header("Location: list_manage_users");
    exit();
}