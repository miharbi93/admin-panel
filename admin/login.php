<?php
session_start();
require 'Database.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginInput = $_POST['username']; // This will accept either email or username
    $password = $_POST['password'];

    $db = new Database();
    // Modify the query to check both username and email
    $stmt = $db->prepare("SELECT * FROM tb_users WHERE username = :loginInput OR email = :loginInput");
    $stmt->bindParam(':loginInput', $loginInput);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists and verify the password
    if ($user) {
        // Check if the account is blocked
        if ($user['blocked'] == 1) {
            $_SESSION['login_error'] = "This account is blocked.";
            header("Location: login.php?status=error");
            exit();
        }

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['login_success'] = true; // Set session variable for success

            // Log user login activity
            $activityStmt = $db->prepare("INSERT INTO user_activity (user_id, action) VALUES (:user_id, :action)");
            $action = 'logged in';
            $activityStmt->bindParam(':user_id', $user['id']);
            $activityStmt->bindParam(':action', $action);
            $activityStmt->execute();

            header("Location: login.php?status=success");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: login.php?status=error");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: login.php?status=error");
        exit();
    }

    $db->close();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login</title>
        <link rel="stylesheet" href="assets/style/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/style/css/style.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    </head>
    <body>
        <main>
            <article>
                <div class="wrapper">
                    <form class="form-signin" action="" method="POST">       
                        <h2 class="form-signin-heading">Login</h2>
                        <input type="text" class="form-control" name="username" placeholder="Email or Username" required autofocus />
                        <input type="password" class="form-control" style="margin-top: 30px;" name="password" placeholder="Password" required />      
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-8" style="margin-bottom: 40px;">
                                <a href="../index">Go to Website</a>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </main>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(document).ready(function() {
                const urlParams = new URLSearchParams(window.location.search);
                const status = urlParams.get('status');

                if (status === 'success') {
                    // Store username in local storage
                    localStorage.setItem('username', '<?php echo $_SESSION['username']; ?>');

                    toastr.success('Login successful!', 'Success', {
                        positionClass: 'toast-top-right',
                        timeOut: 1000 // Display for 30 seconds
                    });
                    setTimeout(function() {
                        window.location.href = 'system-settings/system_info'; // Redirect after 30 seconds
                    }, 1000); // 30000 milliseconds = 30 seconds
                } else if (status === 'error') {
                    toastr.error('<?php echo isset($_SESSION['login_error']) ? $_SESSION['login_error'] : ''; ?>', 'Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 1000
                    });
                    <?php unset($_SESSION['login_error']); ?>
                }
            });
        </script>
    </body>
    </html>
    <?php
}
?>