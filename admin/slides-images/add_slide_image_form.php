<?php
session_start(); // Start the session
include '../components/header.php';


// Success and error messages
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
            <h3 class="fw-bold mb-3">Add New Slide</h3>
            <ul class="breadcrumbs mb -3">
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
                        <div class="card-title">Slide Info</div>
                    </div>

                    <form method="POST" action="add_slide_image_handler.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="title">Slide Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        required
                                        placeholder="Enter Slide Title" /> <!-- Removed value attribute -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="description">Slide Description</label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        required
                                        placeholder="Enter Slide Description"></textarea> <!-- Removed content -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="slideimage">Slide Image</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="slideimage"
                                        required
                                        name="slideimage"
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group d-flex justify-content-center">
                                    <div id="image_preview" style="border: 1px solid #ccc; padding: 10px; text-align: center; border-radius: 5px; overflow: hidden; width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img id="slide_image" src="" alt="Slide Image Preview" style="width: 100%; height: 100%; object-fit: cover; display: none;" />
                                        <p id="no_image" style="display: block;">No image uploaded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='manage_slide_image'">Cancel</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle slide image preview
    document.getElementById('slideimage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('slide_image');
        const noImageText = document.getElementById('no_image');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                noImageText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            noImageText.style.display = 'block';
        }
    });
</script>


<?php
include '../components/footer.php';
?>