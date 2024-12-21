<?php


// Fetch data from the management_contact table
require_once 'admin/Database.php';


// Create an instance of the Database class

$db = new Database();


// Prepare and execute the query to fetch management contacts

$query = "SELECT * FROM management_contact";

$stmt = $db->prepare($query);

$stmt->execute();

$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Close the database connection (optional, as it will close automatically at the end of the script)

$db->close();

$systemInfo = require 'handlers/fetch_system_info.php';
$logo = htmlspecialchars($systemInfo['logo']);
$title = htmlspecialchars($systemInfo['title']);


$contactInfo = require 'handlers/fetch_company_contact.php';

// Extract contact information
$phoneNumber = htmlspecialchars($contactInfo['phone_number'] ?? 'N/A');
$email = htmlspecialchars($contactInfo['email'] ?? 'N/A');
$twitter = htmlspecialchars($contactInfo['twitter'] ?? 'N/A');
$youtube = htmlspecialchars($contactInfo['youtube'] ?? 'N/A');
$address = htmlspecialchars($contactInfo['address'] ?? 'N/A');
$whatsapp = htmlspecialchars($contactInfo['whatsapp'] ?? 'N/A');


$vmmData = require 'handlers/fetch_vmm_info.php'; // Include the data fetching file

// Extract information with default values
$mission = htmlspecialchars($vmmData['mission'] ?? 'N/A');
$vision = htmlspecialchars($vmmData['vision'] ?? 'N/A');
$motto = htmlspecialchars($vmmData['motto'] ?? 'N/A');
$openingDay = htmlspecialchars($vmmData['opening_day'] ?? 'N/A');
$closingDay = htmlspecialchars($vmmData['closing_day'] ?? 'N/A');
$openingTime = htmlspecialchars($vmmData['opening_time'] ?? 'N/A');
$closingTime = htmlspecialchars($vmmData['closing_time'] ?? 'N/A');
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="keywords" content="Site keywords here" />
  <meta name="description" content="" />
  <meta name="copyright" content="" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Title -->
  <title><?php echo $title; ?></title>

  <!-- Favicon -->
  <link rel="icon" href="admin/system-settings/<?php echo $logo; ?>">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap"
    rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <!-- Nice Select CSS -->
  <link rel="stylesheet" href="css/nice-select.css" />
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="css/font-awesome.min.css" />
  <!-- icofont CSS -->
  <link rel="stylesheet" href="css/icofont.css" />
  <!-- Slicknav -->
  <link rel="stylesheet" href="css/slicknav.min.css" />
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="css/owl-carousel.css" />
  <!-- Datepicker CSS -->
  <link rel="stylesheet" href="css/datepicker.css" />
  <!-- Animate CSS -->
  <link rel="stylesheet" href="css/animate.min.css" />
  <!-- Magnific Popup CSS -->
  <link rel="stylesheet" href="css/magnific-popup.css" />

  <!-- Medipro CSS -->
  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="css/responsive.css" />
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <div class="loader">
      <div class="loader-outter"></div>
      <div class="loader-inner"></div>

      <div class="indicator">
        <svg width="16px" height="12px">
          <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
          <polyline
            id="front"
            points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
        </svg>
      </div>
    </div>
  </div>
  <!-- End Preloader -->

  <!-- Header Area -->
  <!-- Header Area -->
  <header class="header">
    <!-- Topbar -->
    <div class="topbar">
      <div class="container d-flex flex-column flex-md-row align-items-center"> <!-- Use column on small screens and row on medium and above -->
        <img src="admin/system-settings/<?php echo htmlspecialchars($logo); ?>" alt="No image" style="height: 80px; width: auto; margin-bottom: 10px; margin-right: 10px;"> <!-- Changed margin to bottom for small screens -->
        <!-- Changed margin to bottom for small screens -->

        <div class="col-lg-6 col-md-7 col-12 text-center text-md-left"> <!-- Center text on small screens -->
          <label class="responsive-heading"><?php echo $title; ?></label>
        </div>

        <div class="col-lg-6 col-md-5 col-12 text-center text-md-right"> <!-- Center text on small screens -->
          <ul class="top-contact list-unstyled d-flex flex-column flex-md-row justify-content-md-end"> <!-- Align contacts on larger screens -->
            <li class="mr-3"><i class="fa fa-phone"></i><a href="tel:<?php echo $phoneNumber; ?>"><?php echo $phoneNumber; ?></a></li>
            <li><i class="fa fa-envelope"></i><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li>
          </ul>
        </div>
      </div>
    </div>


    <!-- End Topbar -->
    <!-- Header Inner -->
    <div class="header-inner">
      <div class="container">
        <div class="inner">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-12">
              <!-- Start Logo -->
              <div class="logo">
                <span></span>
                <!-- <a href="index.html"><img src="img/logo.png" alt="#"></a> -->
              </div>
              <!-- End Logo -->
              <!-- Mobile Nav -->
              <div class="mobile-nav"></div>
              <!-- End Mobile Nav -->
            </div>
            <div class="col-lg-7 col-md-9 col-12">
              <!-- Main Menu -->
              <div class="main-menu">
                <nav class="navigation">
                  <ul class="nav menu">
                    <li><a href="index">Home</a></li>
                    <li class="active"><a href="about">About us</a></li>
                    <li><a href="service.html">Services </a></li>
                    <li><a href="contact">Contact Us</a></li>
                  </ul>
                </nav>
              </div>
              <!--/ End Main Menu -->
            </div>
            <div class="col-lg-2 col-12">

            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End Header Inner -->
  </header>

  <!-- Breadcrumbs -->
  <div class="breadcrumbs overlay">
    <div class="container">
      <div class="bread-inner">
        <div class="row">
          <div class="col-12">
            <h2><?php echo $title; ?></h2>
            <ul class="bread-list">
              <li><a href="index">Home</a></li>
              <li><i class="icofont-simple-right"></i></li>
              <li class="active"><?php echo $title; ?></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Breadcrumbs -->

  <!-- Single News -->
  <section class="news-single section">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-12">
          <div class="row">
            <div class="col-12">
              <div class="single-main">
                <!-- News Head -->
                <div class="news-head">
                  <img src="img/beaches/image_resize.jpeg" alt="#" />
                </div>
                <!-- News Title -->
                <h1 class="news-title">
                  <a href="news-single.html">Expert Solutions for Sustainable Marine and Coastal
                    Management</a>
                </h1>

                <!-- Meta -->

                <!-- News Text -->
                <div class="news-text">
                  <p>
                    Our company specializes in providing expert research-based
                    services, academic support, and consultation on
                    marine-related issues. With a strong foundation in marine
                    science and environmental research, we offer comprehensive
                    solutions tailored to meet the needs of industries,
                    governments, and academic institutions.
                  </p>
                  <p>
                    Our services encompass marine resource management,
                    environmental impact assessments, and sustainable marine
                    practices, ensuring data-driven insights and strategies
                    for ocean and coastal stewardship. We strive to make a
                    positive impact through innovative solutions, supporting a
                    future of sustainability and resilience in marine
                    environments.
                  </p>
                  <div class="image-gallery">
                    <div class="row">
                      <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-image">
                          <img
                            src="img/beaches/zanzi img/IMG-20241002-WA0066.jpg"
                            alt="#" />
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-image">
                          <img
                            src="img/beaches/zanzi img/with womesapic.jpg"
                            alt="#" />
                        </div>
                      </div>
                    </div>
                  </div>
                  <p>
                    At the heart of our mission is a dedication to promoting
                    better-informed decision-making about marine ecosystems by
                    engaging with stakeholders, empowering communities, and
                    offering guidance on the sustainable use and conservation
                    of marine resources. This includes working closely with
                    coastal communities, with a focus on women’s empowerment
                    in sustainable resource management.
                  </p>
                  <blockquote class="overlay">
                    <p>
                      "We envision a sustainable, inclusive, and resilient
                      world where oceans and coastlines thrive, and
                      communities are empowered to lead in marine
                      conservation."
                    </p>
                  </blockquote>
                  <p>
                    Our multidisciplinary research on climate change and its
                    effects on marine ecosystems helps to drive informed
                    policies and strategies. We collaborate with a range of
                    industries, governments, and academic institutions to
                    ensure that our work accelerates the transition to a
                    sustainable and resilient marine environment.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="comments-form">
                <h2>Leave Comments</h2>
                <!-- Contact Form -->
                <form action="mail/send_email.php" method="POST">
                  <div class="row">
                    <div class="col-lg-4 col-md-4 col-12">
                      <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="firstName" placeholder="First name" required />
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                      <div class="form-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="lastName" placeholder="Last name" required />
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                      <div class="form-group">
                        <i class="fa fa-envelope"></i>
                        <input type="email" name="email" placeholder="Your Email" required />
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group message">
                        <i class="fa fa-pencil"></i>
                        <textarea name="message" rows="7" placeholder="Type Your Message Here"></textarea>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group button">
                        <button type="submit" class="btn primary">
                          <i class="fa fa-send"></i>Submit Comment
                        </button>
                      </div>
                    </div>
                  </div>
                </form>

                <!--/ End Contact Form -->
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-12">
          <div class="main-sidebar">


            <div class="single-widget category">
              <h3 class="title">Blog Categories</h3>
              <ul class="categor-list">
                <li><a href="#">Our Company</a></li>
                <li><a href="#">Comment</a></li>
                <li><a href="#">Bags Categories</a></li>
                <li><a href="#">Management</a></li>

              </ul>
            </div>
            <!--/ End Single Widget -->
            <!-- Single Widget -->
            <div class="single-widget recent-post">

              <h3 class="title">Management</h3>


              <div class="row mb-2">

                <?php foreach ($contacts as $contact): ?>

                  <div class="col-lg-6 mb-4">

                    <!-- Single Post -->

                    <div class="single-post">

                      <div class="image">

                        <img src="admin/contact/<?php echo htmlspecialchars($contact['staff_image']); ?>" alt="<?php echo htmlspecialchars($contact['staff_name']); ?>" />

                      </div>

                      <div class="content">

                        <p class="bold"><?php echo htmlspecialchars($contact['staff_name']); ?></p>

                        <p><?php echo htmlspecialchars($contact['staff_position']); ?></p>

                        <p><?php echo htmlspecialchars($contact['staff_phone']); ?></p>

                        <p><?php echo htmlspecialchars($contact['staff_email']); ?></p>

                      </div>

                    </div>

                    <!-- End Single Post -->

                  </div>

                <?php endforeach; ?>

              </div>

            </div>




            <!--/ End Single Widget -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ End Single News -->

  <!-- Footer Area -->
  <footer id="footer" class="footer">
    <!-- Footer Top -->
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-footer">
              <h2>About Us</h2>
              <p>Specializing in marine research, consultation, community engagement, and women empowerment for sustainable conservation.</p>
              <!-- Social -->
              <ul class="social">

              <li><a href="<?php echo $youtube; ?> " target="_blank""><i class="icofont-youtube"></i></a></li>
									<li><a href="<?php echo $twitter; ?> " target="_blank"><i class="icofont-twitter"></i></a></li>
									<li><a href="mailto:<?php echo $email; ?>"><i class="icofont-email"></i></a></li>
									<li><a href="https://wa.me/<?php echo $phoneNumber; ?>" target="_blank"><i class="icofont-whatsapp"></i></a></li>
              </ul>
              <!-- End Social -->
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-footer f-link">
              <h2>Quick Links</h2>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <ul>
                    <li><a href="index.php"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a></li>
                    <li><a href="about.php"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a></li>
                    <li><a href="service.html"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a></li>
                    <li><a href="contact.html"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-footer">
            <h2>Open Hours</h2>
								<ul class="time-sidual">
									<li class="day"><?php echo $openingDay; ?> - <?php echo $closingDay ;?></li>
									<li class="day"><?php echo $openingTime ?> am - <?php echo $closingTime ?> pm</li>
								</ul>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-footer">
              <h2>Newsletter</h2>
              <p>subscribe to our newsletter to get all our news in your inbox..</p>
              <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                <input name="email" placeholder="Email Address" class="common-input" onfocus="this.placeholder = ''"
                  onblur="this.placeholder = 'Your email address'" required="" type="email">
                <button class="button"><i class="icofont icofont-paper-plane"></i></button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End Footer Top -->
    <!-- Copyright -->
    <div class="copyright">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <div class="copyright-content">
              <p>© Copyright 2024 | All Rights Reserved by <a href="https://www.wpthemesgrid.com" target="_blank">zanzimarinesolution.com</a> </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End Copyright -->
  </footer>

  <!--/ End Footer Area -->

  <!-- jquery Min JS -->
  <script src="js/jquery.min.js"></script>
  <!-- jquery Migrate JS -->
  <script src="js/jquery-migrate-3.0.0.js"></script>
  <!-- jquery Ui JS -->
  <script src="js/jquery-ui.min.js"></script>
  <!-- Easing JS -->
  <script src="js/easing.js"></script>
  <!-- Color JS -->
  <script src="js/colors.js"></script>
  <!-- Popper JS -->
  <script src="js/popper.min.js"></script>
  <!-- Bootstrap Datepicker JS -->
  <script src="js/bootstrap-datepicker.js"></script>
  <!-- Jquery Nav JS -->
  <script src="js/jquery.nav.js"></script>
  <!-- Slicknav JS -->
  <script src="js/slicknav.min.js"></script>
  <!-- ScrollUp JS -->
  <script src="js/jquery.scrollUp.min.js"></script>
  <!-- Niceselect JS -->
  <script src="js/niceselect.js"></script>
  <!-- Tilt Jquery JS -->
  <script src="js/tilt.jquery.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="js/owl-carousel.js"></script>
  <!-- counterup JS -->
  <script src="js/jquery.counterup.min.js"></script>
  <!-- Steller JS -->
  <script src="js/steller.js"></script>
  <!-- Wow JS -->
  <script src="js/wow.min.js"></script>
  <!-- Magnific Popup JS -->
  <script src="js/jquery.magnific-popup.min.js"></script>
  <!-- Counter Up CDN JS -->
  <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="js/bootstrap.min.js"></script>
  <!-- Main JS -->
  <script src="js/main.js"></script>
</body>

</html>