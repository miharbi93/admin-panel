<?php
session_start();
require 'Database.php'; // Include your database connection

// Enable error reporting for debugging
$db = new Database();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging output
    echo "Username: $username<br>";
    echo "Password: $password<br>";

    $db = new Database();
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Debugging output
    if ($user) {
        echo "User  found: " . print_r($user, true) . "<br>";
    } else {
        echo "No user found.<br>";
    }

    // Check if user exists and validate password
    if ($user && $user['password'] === $password) { // Check plain text password
        // Authentication successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect with success message
        echo "<script>
                alert('Login successful! Redirecting...');
                window.location.href = 'contact.php'; // Redirect to a protected page
              </script>";
    } else {
        // Authentication failed
        echo "<script>
                alert('Invalid username or password.');
                window.location.href = 'login.php'; // Redirect back to login
              </script>";
    }

    $db->close();
} else {
    // If the request method is not POST, redirect to login
    header('Location: login.php');
    exit();
}
?>