<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php';



// Initialize variables
$system_name = '';
$system_short_name = '';
$logo_path = ''; // Path to the uploaded logo
$id = null; // Initialize ID for update

require '../Database.php'; // Include the Database class
$db = new Database();

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM system_info WHERE meta_field IN ('system_name', 'system_short_name', 'system_logo')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    if ($row['meta_field'] === 'system_name') {
        $system_name = $row['meta_value'];
        $id = $row['id']; // Store the ID for updates
    } elseif ($row['meta_field'] === 'system_short_name') {
        $system_short_name = $row['meta_value'];
    } elseif ($row['meta_field'] === 'system_logo') {
        $logo_path = $row['meta_value'];
    }
}

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
                  title: 'error!',
                  text: '" . $_SESSION['error'] . "',
              });
          </script>";
    unset($_SESSION['error']);
}
?>
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">System Information</h3>
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
                        <div class="card-title">System Info</div>
                    </div>

                    <form method="POST" action="system_info_handler.php" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="name">System Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="system_name"
                                        name="system_name"
                                        required
                                        value="<?php echo htmlspecialchars($system_name); ?>"
                                        placeholder="Enter System Name" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="name">System Short Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="system_short_name"
                                        name="system_short_name"
                                        required
                                        value="<?php echo htmlspecialchars($system_short_name); ?>"
                                        placeholder="Enter System Short Name" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="logo">System Logo</label>
                                    <input
                                        type="file"
                                        class="form-control"
                                        id="system_logo"
                                        name="system_logo"
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group d-flex justify-content-center">
                                    <div id="logo_preview" style="border: 1px solid #ccc; padding: 10px; text-align: center; border-radius: 50%; overflow: hidden; width: 200px; height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img id="logo_image" src="<?php echo htmlspecialchars($logo_path); ?>" alt="Logo Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: <?php echo $logo_path ? 'block' : 'none'; ?>;" />
                                        <p id="no_logo" style="display: <?php echo $logo_path ? 'none' : 'block'; ?>;">No logo uploaded.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <!-- <button type="button" class="btn btn-danger" onclick="window.location.href='your_cancel_url_here';">Cancel</button> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle logo preview
    document.getElementById('system_logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logo_image');
        const noLogoText = document.getElementById('no_logo');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                noLogoText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
            noLogoText.style.display = 'block';
        }
    });
</script>

<?php
include '../components/footer.php';
?>