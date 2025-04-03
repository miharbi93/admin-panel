<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php'; // Include your header
include '../lock_screen.php';

require '../Database.php'; // Include the Database class

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

// Create a new instance of the Database class
$db = new Database();

// Fetch data from services table
$query = "SELECT * FROM services ORDER BY id DESC;";
$stmt = $db->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Services List</h3>
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
                        <h4 class="card-title">Services Information</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="ms-md-auto py-2 mt-4 mb-5 py-md-0 text-end">
                                <a href="add_service.php" class="btn btn-primary btn-round">Add New Service</a>
                            </div>
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Service Name</th>
                                        <th>Description</th>
                                        <th>Availability</th>
                                        <!-- <th>Created At</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($services as $index => $service): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                                            <td><?php echo htmlspecialchars($service['description']); ?></td>
                                            <td>
                                                <?php
                                                // Check the availability status and set the appropriate class and text
                                                if ($service['availability'] === 'Available') {
                                                    echo '<strong class="text-success">' . htmlspecialchars($service['availability']) . '</strong>';
                                                } else {
                                                    echo '<strong class="text-danger">' . htmlspecialchars($service['availability']) . '</strong>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action buttons">
                                                    <a href="update_service.php?id=<?php echo htmlspecialchars($service['id']); ?>"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-pen-square"></i> Edit
                                                    </a>
                                                    <a href="delete_service_handler.php?id=<?php echo htmlspecialchars($service['id']); ?>"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#basic-datatables").DataTable({});
    });
</script>

<?php
include '../components/footer.php';
?>