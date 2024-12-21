<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format. Please enter a valid email.";
    } else {
        // Email details
        $to = "arafaseed2000@gmail.com"; // Your email address
        $subject = "New Contact Form Submission";

        // Message content
        $body = "You have received a new message from the contact form.\n\n";
        $body .= "First Name: $firstName\n";
        $body .= "Last Name: $lastName\n";
        $body .= "Email: $email\n";
        $body .= "Message: \n$message\n";

        // Headers
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/plain;charset=UTF-8" . "\r\n";
        $headers .= "From: noreply@yourdomain.com\r\n";  // Use a valid email domain
        $headers .= "Reply-To: $email\r\n";

        // Debugging: Show what will be sent
        echo "To: $to<br>";
        echo "Subject: $subject<br>";
        echo "Body:<br><pre>$body</pre><br>";
        echo "Headers:<br><pre>$headers</pre><br>";

        // Send the email
        if (mail($to, $subject, $body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Failed to send message.";
        }
    }
} else {
    echo "Invalid request method.";
}
?>
