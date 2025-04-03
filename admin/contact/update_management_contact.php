<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php';

include '../lock_screen.php';

require '../Database.php'; // Include the Database class

$db = new Database();

// Initialize variables
$staff = null;

// Check if an ID is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM management_contact WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $staff = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check for success message
if (isset($_SESSION['success'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: '" . $_SESSION['success'] . "',
              });
          </script>";
    unset($_SESSION['success']);
}

// Check for error message
if (isset($_SESSION['error'])) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
          <script>
              Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: '" . $_SESSION['error'] . "',
              });
          </script>";
    unset($_SESSION['error']);
}
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Management Contact</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="#">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Admin Panel</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Update Management Staff Information</div>
                    </div>

                    <!-- Start of the form -->
                    <form method="POST" action="update_management_contact_handler.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($staff['id']); ?>" /> <!-- Hidden field for ID -->

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_image"> Staff Image</label>
                                    <input type="file" class="form-control" id="staff_image" name="staff_image" accept="image/*" onchange="previewImage(event)" />
                                    <?php if (!empty($staff['staff_image'])): ?>
                                        <div id="image_preview_container" style="margin-top: 10px; display: flex; justify-content: center; align-items: center;">
                                            <img id="image_preview" src="<?php echo htmlspecialchars($staff['staff_image']); ?>" alt="Current Image" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%;" />
                                        </div>
                                    <?php else: ?>
                                        <p>No image uploaded.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_name">Full Name</label>
                                    <input type="text" class="form-control" id="staff_name" name="staff_name" placeholder="Enter Staff Name" value="<?php echo htmlspecialchars($staff['staff_name']); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_position">Position</label>
                                    <input type="text" class="form-control" id="staff_position" name="staff_position" placeholder="Enter Position. Eg Manager/Director" value="<?php echo htmlspecialchars($staff['staff_position']); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_email">Email</label>
                                    <input type="email" class="form-control" id="staff_email" name="staff_email" placeholder="Enter Email Address" value="<?php echo htmlspecialchars($staff['staff_email']); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_phone">Phone Number</label>
                                    <input type="text" class="form-control" id="staff_phone" name="staff_phone" placeholder="Enter Phone Number" value="<?php echo htmlspecialchars($staff['staff_phone']); ?>" required />
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='list_management_contact'">Cancel</button>
                        </div>
                    </form> <!-- End of the form -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('image_preview');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block'; // Show the image
        }

        if (file) {
            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            imagePreview.src = ""; // Clear the preview if no file is selected
            imagePreview.style.display = 'none'; // Hide the image
        }
    }
</script>

<?php
include '../components/footer.php';
?>