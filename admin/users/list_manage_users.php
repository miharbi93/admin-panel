<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php'; // Include your header
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

// Fetch data from users table
$query = "SELECT * FROM tb_users ORDER BY id DESC;";
$stmt = $db->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Website User List</h3>
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
                        <h4 class="card-title">Manage User Information</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="ms-md-auto py-2 mt-4 mb-5 py-md-0 text-end">
                                <a href="add_user_form" class="btn btn-primary btn-round">Add New User</a>
                            </div>
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Blocked</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $index => $user): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['role']); ?></td>

                                            <td>
                                                <span
                                                    class="badge <?php echo $user['blocked'] ? 'bg-danger' : 'bg-info'; ?>">
                                                    <?php echo $user['blocked'] ? 'Yes' : 'No'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="update_user_form.php?id=<?php echo htmlspecialchars($user['id']); ?>"
                                                    class="btn btn-success btn-sm"> <i class="fas fa-pen-square"></i>
                                                    Edit</a>
                                                <a href="delete_user_handler.php?id=<?php echo htmlspecialchars($user['id']); ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                                    <i class="fas fa-trash"></i> Delete</a>
                                                <a href="block_user_handler.php?id=<?php echo htmlspecialchars($user['id']); ?>"
                                                    class="btn <?php echo $user['blocked'] ? 'btn-warning' : 'btn-primary'; ?> btn-sm">
                                                    <?php echo $user['blocked'] ? 'Unblock' : 'Block'; ?></a>
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