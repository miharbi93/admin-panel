<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php'; // Include your header
require '../Database.php'; // Include the Database class

// Create a new instance of the Database class
$db = new Database();

// Get the current user's role
$currentUserId = $_SESSION['user_id'];
$currentUserRole = $_SESSION['role']; // Assuming you store the user's role in the session

// Prepare the query based on the user's role
if ($currentUserRole === 'admin') {
    // Admin can see all logs, ordered by latest first
    $query = "
        SELECT 
            u.id AS user_id,
            u.username,
            u.email,
            u.role,
            u.blocked,
            a.action,
            a.timestamp AS activity_timestamp
        FROM 
            tb_users u
        INNER JOIN 
            user_activity a ON u.id = a.user_id
        ORDER BY 
            a.timestamp DESC;  // Order by timestamp descending
    ";
} else {
    // Other roles can only see their own logs, ordered by latest first
    $query = "
        SELECT 
            a.action,
            a.timestamp AS activity_timestamp
        FROM 
            user_activity a
        WHERE 
            a.user_id = :user_id
        ORDER BY 
            a.timestamp DESC;  // Order by timestamp descending
    ";
}

// Prepare and execute the query
$stmt = $db->prepare($query);
if ($currentUserRole !== 'admin') {
    $stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_INT);
}
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h3 class="fw-bold mb-3">Website User Access Logs</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View User Logs Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <?php if ($currentUserRole === 'admin'): ?>
                                            <th>Fullname</th>
                                            <th>Role</th>
                                        <?php endif; ?>
                                        <th>Activity</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $index => $log): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <?php if ($currentUserRole === 'admin'): ?>
                                                <td><?php echo htmlspecialchars($log['username']); ?></td>
                                                <td><?php echo htmlspecialchars($log['role']); ?></td>
                                            <?php endif; ?>
                                            <td><?php echo htmlspecialchars($log['action']); ?></td>
                                            <td>
                                                <?php
                                                // Convert the timestamp to a DateTime object
                                                $activityDateTime = new DateTime($log['activity_timestamp']);
                                                $currentDate = new DateTime();
                                                $yesterdayDate = (clone $currentDate)->modify('-1 day');

                                                // Check if the activity date is today or yesterday
                                                if ($activityDateTime->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                                                    echo "Today";
                                                } elseif ($activityDateTime->format('Y-m-d') === $yesterdayDate->format('Y-m-d')) {
                                                    echo "Yesterday";
                                                } else {
                                                    // Display the actual date if it's neither today nor yesterday
                                                    echo $activityDateTime->format('Y-m-d H:i:s'); // Adjust format as needed
                                                }
                                                ?>
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