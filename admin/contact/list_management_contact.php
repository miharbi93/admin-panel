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

// Fetch data from management_contact table
// $query = "SELECT * FROM management_contact";
$query = "SELECT * FROM management_contact ORDER BY id DESC;";
$stmt = $db->prepare($query);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Management List</h3>
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
                        <h4 class="card-title">Management Contact Information</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="ms-md-auto py-2 mt-4 mb-5 py-md-0 text-end">
                                <a href="management_contact" class="btn btn-primary btn-round">Add New</a>
                            </div>
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Image</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Email</th>
                                        <th>Phonenumber</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $index => $contact): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><img src="<?php echo htmlspecialchars($contact['staff_image']); ?>" alt="Image" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                                        <td><?php echo htmlspecialchars($contact['staff_name']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['staff_position']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['staff_email']); ?></td>
                                        <td><?php echo htmlspecialchars($contact['staff_phone']); ?></td>
                                        <td>
                                            <!-- <button class="btn btn-success btn-sm">Edit</button>
                                              -->
                                              <a href="update_management_contact.php?id=<?php echo htmlspecialchars($contact['id']); ?>" class="btn btn-success btn-sm"> <i class="fas fa-pen-square"></i> Edit</a>
                                            <!-- <button class="btn btn-danger btn-sm">Delete</button> -->
                                            <a href="delete_management_contact.php?id=<?php echo htmlspecialchars($contact['id']); ?>" 
                                            class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">
                                            
                                            <i class="fas fa-trash"></i> Delete</a>
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

        $("#multi-filter-select").DataTable({
            pageLength: 5,
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function() {
                        var column = this;
                        var select = $(
                                '<select class="form-select"><option value=""></option></select>'
                            )
                            .appendTo($(column.footer()).empty())
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                column
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function(d, j) {
                                select.append(
                                    '<option value="' + d + '">' + d + "</option>"
                                );
                            });
                    });
            },
        });

        // Add Row
        $("#add-row").DataTable({
            pageLength: 5,
        });

        var action =
            '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function() {
            $("#add-row")
                .dataTable()
                .fnAddData([
                    $("#addName").val(),
                    $("#addPosition").val(),
                    $("#addOffice").val(),
                    action,
                ]);
            $("#addRowModal").modal("hide");
        });
    });
</script>

<?php
include '../components/footer.php';
?>