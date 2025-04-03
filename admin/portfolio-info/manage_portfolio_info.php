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

// Fetch data from slides_images and portfolio_items tables
// $query = "SELECT * FROM portfolio_items , portfolio_images WHERE portfolio_items.id = portfolio_images.portfolio_item_id";
// $query = "SELECT p.*, 
//        (SELECT pi.image_path 
//         FROM portfolio_images pi 
//         WHERE pi.portfolio_item_id = p.id 
//         LIMIT 1) AS image_path FROM portfolio_items p;" ;

$query = "SELECT p.*, 
       (SELECT pi.image_path 
        FROM portfolio_images pi 
        WHERE pi.portfolio_item_id = p.id 
        LIMIT 1) AS image_path 
        FROM portfolio_items p 
        ORDER BY p.created_at DESC;";
$stmt = $db->prepare($query);
$stmt->execute();
$slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Portfolio Items</h3>
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
                        <h4 class="card-title">Portfolio Items Information List</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="ms-md-auto py-2 mt-4 mb-5 py-md-0 text-end">
                                <a href="add_portfolio_info" class="btn btn-primary btn-round">Add New</a>
                            </div>
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($slides as $index => $slide): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($slide['title']); ?></td>
                                            <td><?php echo htmlspecialchars($slide['description']); ?></td>
                                            <td><img src="<?php echo htmlspecialchars($slide['image_path']); ?>" alt="Slide Image" style="width: 150px; height: 70px; border-radius: 5%;"></td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Action buttons">
                                                    <a href="update_portfolio_info.php?id=<?php echo htmlspecialchars($slide['id']); ?>" class="btn btn-success btn-sm">
                                                        <i class="fas fa-pen-square"></i> Edit
                                                    </a>
                                                    <a href="delete_portfolio_info.php?id=<?php echo htmlspecialchars($slide['id']); ?>"
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
    $(document).ready(function() {
        $("#basic-datatables").DataTable({});
    });
</script>

<?php
include '../components/footer.php';
?>