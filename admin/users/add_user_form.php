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
            <h3 class="fw-bold mb-3">User  Management</h3>
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
                        <div class="card-title">User  Information</div>
                    </div>

                    <!-- Start of the form -->

                    <form method="POST" action="add_user_handler.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="username"
                                        name="username" 
                                        placeholder="Enter Username" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password" 
                                        placeholder="Enter Password" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input
                                        type="email" 
                                        class="form-control"
                                        id="email"
                                        name="email" 
                                        placeholder="Enter Email Address" required />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="user">User </option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field for blocked status -->
                        <input type="hidden" name="blocked" value="0" />

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='list_manage_users'">Cancel</button>
                        </div>
                    </form> <!-- End of the form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../components/footer.php';
?>