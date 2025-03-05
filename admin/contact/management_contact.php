<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}
include '../components/header.php';


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
                        <div class="card-title">Management Staff Information</div>
                    </div>

                    <!-- Start of the form -->

                    <form method="POST" action="management_contact_handler.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_image">Staff Image</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="staff_image"
                                        name="staff_image" 
                                        accept="image/*"
                                        onchange="previewImage(event)" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group d-flex justify-content-center">
                                    <div id="image_preview_container" style="border: 1px solid #ccc; padding: 10px; text-align: center; border-radius: 50%; overflow: hidden; width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img id="image_preview" src="" alt="Logo Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: none;" />
                                        <p id="no_logo" style="display: block;">No logo uploaded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_name">Full Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="staff_name"
                                        name="staff_name" 
                                        placeholder="Enter Staff Name" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_position">Position</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="staff_position"
                                        name="staff_position" 
                                        placeholder="Enter Position. Eg Manager/Director" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_email">Email</label>
                                    <input
                                        type="email" 
                                        class="form-control"
                                        id="staff_email"
                                        name="staff_email" 
                                        placeholder="Enter Email Address" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="staff_phone">Phone Number</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="staff_phone"
                                        name="staff_phone" 
                                        placeholder="Enter Phone Number" required />
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
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
        const noLogoText = document.getElementById('no_logo');
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block'; // Show the image
            noLogoText.style.display = 'none'; // Hide the "No logo uploaded" text
        }

        if (file) {
            reader.readAsDataURL(file); // Convert the file to a data URL
        } else {
            imagePreview.src = ""; // Clear the preview if no file is selected
            imagePreview.style.display = 'none'; // Hide the image
            noLogoText.style.display = 'block'; // Show the "No logo uploaded" text
        }
    }
</script>

<?php
include '../components/footer.php';
?>