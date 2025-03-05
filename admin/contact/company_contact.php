<?php
session_start(); // Start the session to handle success/error messages
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}
include '../components/header.php';
require '../Database.php'; // Include your database connection file

// Initialize variables
$phone_number = '';
$whatsapp = '';
$email = '';
$twitter = '';
$youtube = '';
$address = '';

// Create a new Database instance
$db = new Database();

// Fetch existing contact information
$stmt = $db->prepare("SELECT meta_field, meta_value FROM company_contact WHERE meta_field IN ('phone_number', 'whatsapp', 'email', 'twitter', 'youtube', 'address')");
$stmt->execute();
$contactData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize an associative array to hold the contact information
$contact = [];
foreach ($contactData as $row) {
    $contact[$row['meta_field']] = $row['meta_value'];
}

// Now you can safely access the contact information
$phone_number = isset($contact['phone_number']) ? $contact['phone_number'] : '';
$whatsapp = isset($contact['whatsapp']) ? $contact['whatsapp'] : '';
$email = isset($contact['email']) ? $contact['email'] : '';
$twitter = isset($contact['twitter']) ? $contact['twitter'] : '';
$youtube = isset($contact['youtube']) ? $contact['youtube'] : '';
$address = isset($contact['address']) ? $contact['address'] : '';
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['success'])): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '<?php echo $_SESSION['success']; ?>',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['success']); // Clear the message after displaying ?>
        <?php elseif (isset($_SESSION['error'])): ?>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '<?php echo $_SESSION['error']; ?>',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['error']); // Clear the message after displaying ?>
        <?php endif; ?>
    });
</script>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Contact Information</h3>
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
                        <div class="card-title">Contact Info</div>
                    </div>

                    <!-- Start of the form -->
                    <form method="POST" action="company_contact_handler.php"> <!-- Set the action to your handler -->
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="phone_number">Phone Number</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="phone_number"
                                        id="phone_number"
                                        placeholder="Enter Phone Number +255"
                                        value="<?php echo htmlspecialchars($phone_number); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="whatsapp">WhatsApp</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="whatsapp" 
                                        id="whatsapp"
                                        placeholder="Enter WhatsApp Number"
                                        value="<?php echo htmlspecialchars($whatsapp); ?>" />
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
                                        name="email" 
                                        id="email"
                                        placeholder="Enter Email Address"
                                        value="<?php echo htmlspecialchars($email); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="twitter" 
                                        id="twitter"
                                        placeholder="Enter Twitter Handle"
                                        value="<?php echo htmlspecialchars($twitter); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="youtube">YouTube</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="youtube" 
                                        id="youtube"
                                        placeholder="Enter YouTube Channel Link"
                                        value="<?php echo htmlspecialchars($youtube); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="address">Location / Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        name="address" 
                                        id="address"
                                        placeholder="Enter Street Name"
                                        value="<?php echo htmlspecialchars($address); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    <!-- End of the form -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../components/footer.php';
?> ⬤