<?php
session_start();
include '../components/header.php';

// Initialize variables
$mission = '';
$vision = '';
$motto = '';
$opening_day = '';
$closing_day = '';
$opening_time = '';
$closing_time = '';
$ids = []; // Array to hold IDs for each field

require '../Database.php'; // Include the Database class
$db = new Database();

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM vmm_info WHERE meta_field IN ('mission', 'vision', 'motto', 'opening_day', 'closing_day', 'opening_time', 'closing_time')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    if ($row['meta_field'] === 'mission') {
        $mission = $row['meta_value'];
        $ids['mission'] = $row['id']; // Store the ID for mission
    } elseif ($row['meta_field'] === 'vision') {
        $vision = $row['meta_value'];
        $ids['vision'] = $row['id']; // Store the ID for vision
    } elseif ($row['meta_field'] === 'motto') {
        $motto = $row['meta_value'];
        $ids['motto'] = $row['id']; // Store the ID for motto
    } elseif ($row['meta_field'] === 'opening_day') {
        $opening_day = $row['meta_value'];
        $ids['opening_day'] = $row['id']; // Store the ID for opening day
    } elseif ($row['meta_field'] === 'closing_day') {
        $closing_day = $row['meta_value'];
        $ids['closing_day'] = $row['id']; // Store the ID for closing day
    } elseif ($row['meta_field'] === 'opening_time') {
        $opening_time = $row['meta_value'];
        $ids['opening_time'] = $row['id']; // Store the ID for opening time
    } elseif ($row['meta_field'] === 'closing_time') {
        $closing_time = $row['meta_value'];
        $ids['closing_time'] = $row['id']; // Store the ID for closing time
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
            <h3 class="fw-bold mb-3">Manage Vision, Mission and Motto</h3>
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
                        <div class="card-title">Vision, Mission and Motto Info</div>
                    </div>

                    <form method="POST" action="vmm_info_handler.php">
                        <input type="hidden" name="id" value="<?php echo $ids['mission']; ?>" />

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="mission">Mission</label>
                                    <textarea
                                        class="form-control"
                                        id="mission"
                                        name="mission"
                                        rows="4"
                                        placeholder="Enter Mission"><?php echo htmlspecialchars($mission); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="vision">Vision</label>
                                    <textarea
                                        class="form-control"
                                        id="vision"
                                        name="vision"
                                        rows="4"
                                        placeholder="Enter Vision"><?php echo htmlspecialchars($vision); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="motto">Motto</label>
                                    <textarea
                                        class="form-control"
                                        id="motto"
                                        name="motto"
                                        rows="4"
                                        placeholder="Enter Motto"><?php echo htmlspecialchars($motto); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-6">
                                <div class="form-group">
                                    <label for="opening_day">Opening Day</label>
                                    <select class="form-control" id="opening_day" name="opening_day">
                                        <option value="">Select Opening Day</option>
                                        <?php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        foreach ($days as $day) {
                                            $selected = ($day === $opening_day) ? 'selected' : '';
                                            echo "<option value=\"$day\" $selected>$day</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8 col-lg-6">
                                <div class="form-group">
                                    <label for="closing_day">Closing Day</label>
                                    <select class="form-control" id="closing_day" name="closing_day">
                                        <option value="">Select Closing Day</option>
                                        <?php
                                        foreach ($days as $day) {
                                            $selected = ($day === $closing_day) ? 'selected' : '';
                                            echo "<option value=\"$day\" $selected>$day</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-6">
                                <div class="form-group">
                                    <label for="opening_time">Opening Time</label>
                                    <input
                                        type="time"
                                        class="form-control"
                                        id="opening_time"
                                        name="opening_time"
                                        value="<?php echo htmlspecialchars($opening_time); ?>" />
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-6">
                                <div class="form-group">
                                    <label for="closing_time">Closing Time</label>
                                    <input
                                        type="time"
                                        class="form-control"
                                        id="closing_time"
                                        name="closing_time"
                                        value="<?php echo htmlspecialchars($closing_time); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="card-action">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger" onclick="window.location.href='your_cancel_url_here';">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../components/footer.php';
?>