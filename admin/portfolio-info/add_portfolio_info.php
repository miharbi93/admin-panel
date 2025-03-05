<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}
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
            <h3 class="fw-bold mb-3">Add New Portfolio</h3>
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
                        <div class="card-title">Portfolio Info</div>
                    </div>

                    <form method="POST" action="add_portfolio_info_handler" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="title">Portfolio Title</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="title"
                                        name="title"
                                        required
                                        placeholder="Enter Slide Title" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="description">Portfolio Description</label>
                                    <textarea
                                        class="form-control"
                                        id="description"
                                        name="description"
                                        required
                                        placeholder="Enter Slide Description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="image_count">Number of Images</label>
                                    <select id="image_count" class="form-control" onchange="showImageInputs()">
                                        <option value="0">Select Number of Images</option>
                                        <option value="2">2 Images</option>
                                        <option value="3">3 Images</option>
                                        <option value="4">4 Images</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input to store the selected image count -->
                        <input type="hidden" id="selected_image_count" name="image_count" value="0">

                        <div id="image_inputs" style="display: none;">
                            <div class="row">
                                <div class="col-md-8 col-lg-12">
                                    <div class="form-group">
                                        <label for="slideimage1">Portfolio Image 1</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="slideimage1"
                                            name="slideimage[]"
                                            accept="image/*"
                                            onchange="previewImage(this, 'preview1')" />
                                        <div id="preview1" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="image_input_2" style="display: none;">
                                <div class="col-md-8 col-lg-12">
                                    <div class="form-group">
                                        <label for="slideimage2">Portfolio Image 2</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="slideimage2"
                                            name=" slideimage[]"
                                            accept="image/*"
                                            onchange="previewImage(this, 'preview2')" />
                                        <div id="preview2" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="image_input_3" style="display: none;">
                                <div class="col-md-8 col-lg-12">
                                    <div class="form-group">
                                        <label for="slideimage3">Portfolio Image 3</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="slideimage3"
                                            name="slideimage[]"
                                            accept="image/*"
                                            onchange="previewImage(this, 'preview3')" />
                                        <div id="preview3" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="image_input_4" style="display: none;">
                                <div class="col-md-8 col-lg-12">
                                    <div class="form-group">
                                        <label for="slideimage4">Portfolio Image 4</label>
                                        <input
                                            type="file"
                                            class="form-control"
                                            id="slideimage4"
                                            name="slideimage[]"
                                            accept="image/*"
                                            onchange="previewImage(this, 'preview4')" />
                                        <div id="preview4" class="image-preview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='manage_portfolio_info'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showImageInputs() {
        const count = parseInt(document.getElementById('image_count').value);
        document.getElementById('selected_image_count').value = count; // Update hidden input
        const inputs = ['image_input_2', 'image_input_3', 'image_input_4'];
        document.getElementById('image_inputs').style.display = 'block';
        for (let i = 0; i < inputs.length; i++) {
            document.getElementById(inputs[i]).style.display = (i < count - 1) ? 'block' : 'none';
        }
    }

    function previewImage(input, previewId) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        preview.innerHTML = ''; // Clear previous preview

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '500px'; // Maintain aspect ratio
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<?php
include '../components/footer.php';
?>