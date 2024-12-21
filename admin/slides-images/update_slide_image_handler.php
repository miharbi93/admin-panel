
<?php
session_start();
require '../Database.php'; // Include the Database class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $description = $_POST['description'];
    $slideImage = $_FILES['slideimage'];

    // Create a new instance of the Database class
    $db = new Database();

    // Prepare the update query
    $query = "UPDATE slides_images SET title = :title, description = :description";
    if ($slideImage['error'] === UPLOAD_ERR_OK) {
        // Handle file upload
        $targetDir = "uploads/"; // Specify your upload directory
        $targetFile = $targetDir . basename($slideImage["name"]);
        move_uploaded_file($slideImage["tmp_name"], $targetFile);
        $query .= ", slideimage = :slideimage";
    }
    $query .= " WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    if ($slideImage['error'] === UPLOAD_ERR_OK) {
        $stmt->bindParam(':slideimage', $targetFile);
    }
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        $_SESSION['success'] = "Updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update  image.";
    }
} else {
    $_SESSION['error'] = "Invalid request.";
}

// Redirect back to the management page
header("Location: manage_slide_image"); // Change this to the appropriate page
exit();
?>