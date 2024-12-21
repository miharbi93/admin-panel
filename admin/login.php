<?php
session_start();
require 'Database.php'; // Include your database connection

// Enable error reporting for debugging
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
                window.location.href = 'contact/company_contact.php'; // Redirect to a protected page
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
    // If the request method is not POST, show the login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="assets/style/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style/css/style.css">
    </head>
    <body>
        <main>
            <article>
                <div class="wrapper">
                    <form class="form-signin" action="" method="POST">       
                        <h2 class="form-signin-heading">Login</h2>
                        <input type="text" class="form-control" name="username" placeholder="Email Address" required autofocus />
                        <input type="password" class="form-control" style="margin-top: 30px;" name="password" placeholder="Password" required />      
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-8" style="margin-bottom: 40px;">
                                <a href="">Go to Website</a>
                            </div>
                            <div class="col -4">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php
}
?>       