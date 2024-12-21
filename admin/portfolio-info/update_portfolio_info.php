<?php
session_start();
include '../components/header.php';
require '../Database.php'; // Include the Database class

// Check if portfolio_item_id is set
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Portfolio item ID is missing.";
    header("Location: manage_portfolio_info");
    exit();
}

$portfolio_item_id = intval($_GET['id']);
$db = new Database();
$conn = $db->getConnection();

// Fetch the current number of images for the given portfolio_item_id
$stmt = $conn->prepare("SELECT COUNT(*) as image_count FROM portfolio_images WHERE portfolio_item_id = :portfolio_item_id");
$stmt->bindParam(':portfolio_item_id', $portfolio_item_id);
$stmt->execute();
$image_count = $stmt->fetch(PDO::FETCH_ASSOC)['image_count'];

// Fetch the portfolio item details
$stmt = $conn->prepare("SELECT * FROM portfolio_items WHERE id = :portfolio_item_id");
$stmt->bindParam(':portfolio_item_id', $portfolio_item_id);
$stmt->execute();
$portfolio_item = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch existing images for the portfolio item
$stmt = $conn->prepare("SELECT image_path FROM portfolio_images WHERE portfolio_item_id = :portfolio_item_id");
$stmt->bindParam(':portfolio_item_id', $portfolio_item_id);
$stmt->execute();
$existing_images = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <h3 class="fw-bold mb-3">Update Portfolio Info</h3>
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

                    <form method="POST" action="update_portfolio_info_handler" enctype="multipart/form-data">
                        <input type="hidden" name="portfolio_item_id" value="<?= $portfolio_item_id ?>">
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
                                        value="<?= htmlspecialchars($portfolio_item['title']) ?>"
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
                                        placeholder="Enter Slide Description"><?= htmlspecialchars($portfolio_item['description']) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="image_count">Current Number of Images</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="image_count"
                                        name="image_count"
                                        value="<?= $image_count ?>"
                                        readonly />
                                </div>
                            </div>
                        </div>

                        <div id="image_inputs">
                            <?php
                                foreach ($existing_images as $index => $image): ?>
                                <div class="row" id="image_input_<?= $index + 1 ?>">
                                    <div class="col-md-8 col-lg-12">
                                        <div class="form-group">
                                            <label for="slideimage<?= $index + 1 ?>">Portfolio Image <?= $index + 1 ?></label>
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="slideimage<?= $index + 1 ?>"
                                                name="slideimage[]"
                                                accept="image/*"
                                                onchange="previewImage(this, 'preview<?= $index + 1 ?>', '<?= htmlspecialchars($image['image_path']) ?>')" />
                                            <div id="preview<?= $index + 1 ?>" class="image-preview">
                                                <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="Existing Image" style="width: 100%; height: 450px; border-radius: 5%; margin-top: 10px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='manage_portfolio_info'">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input, previewId, existingImagePath) {
        const file = input.files[0];
        const preview = document.getElementById(previewId);
        preview.innerHTML = ''; // Clear previous preview

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '450px'; // Maintain aspect ratio
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        } else {
            // If no file is selected, show the existing image
            const img = document.createElement('img');
            img.src = existingImagePath;
            img.style.width = '100%';
            img.style.height = '450px'; // Maintain aspect ratio
            preview.appendChild(img);
        }
    }
</script>

<?php
include '../components/footer.php';
?>