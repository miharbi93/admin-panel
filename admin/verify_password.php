<?php
session_start();
require 'Database.php'; // Include your database connection

// Create a new instance of the Database class
$db = new Database();
$conn = $db->getConnection(); // Get the PDO connection

$response = ['status' => 'error', 'message' => '']; // Initialize response

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT password FROM tb_users WHERE username = :username AND blocked = 0");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Fetch the result
    if ($stmt->rowCount() > 0) {
        $hashedPassword = $stmt->fetchColumn(); // Fetch the hashed password

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, unlock the screen
            $_SESSION['username'] = $username; // Store the username in session
            $response['status'] = 'success';
            $response['message'] = 'Unlock successful!';
        } else {
            $response['message'] = 'Incorrect password.';
        }
    } else {
        $response['message'] = 'User  not found or account is blocked.';
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$db->close();
?>