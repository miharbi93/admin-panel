<?php
session_start();
require '../Database.php'; // Include the Database class

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $blocked = $_POST['blocked'];
    $password = $_POST['password']; // Get the password field

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
        $_SESSION['success'] = "User  updated successfully!";
    } else {
        $_SESSION['error'] = "Failed to update user: " . implode(", ", $stmt->errorInfo());
    }

    // Redirect back to the list page
    header("Location: list_manage_users");
    exit();
}
?>