<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login");
    exit();
}

include '../components/header.php';

// Initialize variables
$whoami = '';
$youtube_video_link = '';
$ids = []; // Array to hold IDs for each field

require '../Database.php'; // Include the Database class
$db = new Database();

// Fetch existing data
$stmt = $db->prepare("SELECT id, meta_field, meta_value FROM who_we_are WHERE meta_field IN ('whoami', 'youtube_video_link')");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    if ($row['meta_field'] === 'whoami') {
        $whoami = $row['meta_value'];
        $ids['whoami'] = $row['id'];
    } elseif ($row['meta_field'] === 'youtube_video_link') {
        $youtube_video_link = $row['meta_value'];
        $ids['youtube_video_link'] = $row['id'];
    }
}

// Function to extract YouTube video ID from URL
function getYouTubeVideoID($url) {
    preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
    return isset($matches[1]) ? $matches[1] : null;
}

$videoID = getYouTubeVideoID($youtube_video_link);

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
            <h3 class="fw-bold mb-3">Manage Who We Are</h3>
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
                        <div class="card-title">Who Am I and YouTube Video Link Info</div>
                    </div>

                    <form method="POST" action="whoami_handler.php">
                        <input type="hidden" name="id_whoami" value="<?php echo $ids['whoami'] ?? ''; ?>" />
                        <input type="hidden" name="id_youtube_video_link" value="<?php echo $ids['youtube_video_link'] ?? ''; ?>" />

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="whoami">Who We Are</label>
                                    <textarea
                                        class="form-control"
                                        id="whoami"
                                        name="whoami"
                                        rows="4"
                                        placeholder="Enter Who We Are"><?php echo htmlspecialchars($whoami); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <div class="form-group">
                                    <label for="youtube_video_link">YouTube Video Link</label>
                                    <input
                                        type="url"
                                        class="form-control"
                                        id="youtube_video_link"
                                        name="youtube_video_link"
                                        placeholder="Enter YouTube Video Link"
                                        value="<?php echo htmlspecialchars($youtube_video_link); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-lg-12">
                                <?php if ($videoID): ?>
                                    <div class="video-preview">
                                        <div class="video-responsive">
                                            <iframe src="https://www.youtube.com/embed/<?php echo $videoID; ?>" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="video-preview">
                                        <h5>No Video Preview Available</h5>
                                    </div>
                                <?php endif; ?>
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