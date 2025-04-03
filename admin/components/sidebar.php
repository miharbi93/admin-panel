<?php 

$role = $_SESSION['role'];

$systemLogo = $_SESSION['system_logo'] ?? 'default_logo.png';

$systemName = $_SESSION['system_name'] ?? 'Default System Name';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?php echo $systemName ?></title>

  <meta
    content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
    name="viewport" />
  <link
    rel="icon"
    href="<?php echo $systemLogo ?>"
    type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="../assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["../assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/plugins.min.css" />
  <link rel="stylesheet" href="../assets/css/kaiadmin.min.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <script src="../assets/js/core/jquery-3.7.1.min.js"></script>

  <script src="../assets/js/plugin/sweetalert/sweetalert.min.js"></script>


  <style>
    label {
      font-weight: bold;
    }

    .video-responsive {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%; /* 16:9 Aspect Ratio */
    height: 0;
}

.video-responsive iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="../system-settings/system_info" class="logo">
            <img
              alt=" [  <?php echo $role ; ?> Navigation Panel ]"
              class="navbar-brand"
              height="20" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a
                data-bs-toggle="collapse"
                href="#dashboard"
                class="collapsed"
                aria-expanded="false">
                <i class="fas fa-home"></i>
                <p>Dashboard </p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="dashboard">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="../dashboard/dashboard">
                      <span class="sub-item">Dashboard</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-section">
              <span class="sidebar-mini-icon">
                <i class="fa fa-ellipsis-h"></i>
              </span>
              <h4 class="text-section">Components</h4>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#base">
                <i class="fas fa-cogs"></i>
                <p>System Settings</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="base">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="../system-settings/system_info">
                      <span class="sub-item">System Information</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#sidebarLayouts">
                <i class="fas fa-signal"></i>
                <p>Contact Information</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="sidebarLayouts">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="../contact/company_contact">
                      <span class="sub-item">Company Contact</span>
                    </a>
                  </li>
                  <li>
                    <a href="../contact/list_management_contact">
                      <span class="sub-item">Management Contacts</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#forms">
                <i class="fas fa-pen-square"></i>
                <p>About Us Information</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="forms">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="../vmm/vmm_info">
                      <span class="sub-item">Manage VMM</span>
                    </a>
                  </li>

                  <li>
                    <a href="../who-we-are/whoami">
                      <span class="sub-item">Who we are </span>
                    </a>
                  </li>

                  <li>
                    <!-- <a href="forms/forms.html">
                      <span class="sub-item">Basic Form</span>
                    </a> -->
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#maps">
                <i class="fas fa-list"></i>
                <p>Service Information</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="maps">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="../service/list_manage_service.php">
                      <span class="sub-item">Manage Service</span>
                    </a>
                  </li>
                  <!-- <li>
                    <a href="maps/jsvectormap.html">
                      <span class="sub-item">Jsvectormap</span>
                    </a>
                  </li> -->
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#submenu">
                <i class="fas fa-bars"></i>
                <p>Manage  Images </p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="submenu">
                <ul class="nav nav-collapse">

                  <li>
                    <a href="../slides-images/manage_slide_image">
                      <span class="sub-item">Manage Slide Images</span>
                    </a>
                  </li>
            </li>
            <li>
              <a href="../portfolio-info/manage_portfolio_info">
                <span class="sub-item">Manage Portfolio Information</span>
              </a>
            </li>
          </ul>
        </div>
        </li>
        <?php if ($role === 'admin'): ?>
              <li class="nav-item">
                <a href="../users/list_manage_users">
                  <i class="fas fa-users"></i>
                  <p>Manage Users</p>
                </a>
              </li>
            <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
