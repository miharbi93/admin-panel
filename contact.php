<?php

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

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Title -->
        <!-- <title>www.zanzi-marine-solution</title> -->
		<title><?php echo $title; ?></title>
		
		<!-- Favicon -->
        <link rel="icon" href="admin/system-settings/<?php echo $logo; ?>">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">
		
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
			<header class="header" >
				<!-- Topbar -->
				<div class="topbar">
					<div class="container d-flex flex-column flex-md-row align-items-center"> <!-- Use column on small screens and row on medium and above -->
						<img src="admin/system-settings/<?php echo htmlspecialchars($logo); ?>" style="height: 120px; width: auto; margin-bottom: 10px; margin-right: 10px;"> <!-- Changed margin to bottom for small screens -->
						
						<div class="col-lg-6 col-md-7 col-12 text-center text-md-left"> <!-- Center text on small screens -->
							<label class="responsive-heading"><?php echo $title;?></label>
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
												<li><a href="about">About us</a></li>
												<li><a href="service.html">Services </a></li>
												<li class="active"><a href="contact">Contact Us</a></li>
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
							<h2>Contact Us</h2>
							<ul class="bread-list">
								<li><a href="index">Home</a></li>
								<li><i class="icofont-simple-right"></i></li>
								<li class="active">Contact Us</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
				
		<!-- Start Contact Us -->
		<section class="contact-us section">
			<div class="container">
				<div class="inner">
					<div class="row"> 
						<div class="col-lg-6">
							<div class="contact-us-left">
								<!--Start Google-map -->
								<div >
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819123115465!2d39.22356485000001!3d-6.2519237!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185cdc09091c396f%3A0x880daa38ef7d3b87!2sBuyu%20Mosque!5e0!3m2!1sen!2stz!4v1664671111111!5m2!1sen!2stz" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
								</div>
								<!--/End Google-map -->
							</div>
						</div>
						<div class="col-lg-6">
							<div class="contact-us-form">
								<h2>Contact With Us</h2>
								<p>If you have any questions please fill free to contact with us.</p>
								<!-- Form -->
								<form class="form" method="post" action="mail/mail.php">
									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<input type="text" name="name" placeholder="Name" required="">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input type="email" name="email" placeholder="Email" required="">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input type="text" name="phone" placeholder="Phone" required="">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input type="text" name="subject" placeholder="Subject" required="">
											</div>
										</div>
										<div class="col-lg-12">
											<div class="form-group">
												<textarea name="message" placeholder="Your Message" required=""></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group login-btn">
												<button class="btn" type="submit">Send</button>
											</div>
											
										</div>
									</div>
								</form>
								<!--/ End Form -->
							</div>
						</div>
					</div>
				</div>
				<div class="contact-info">
					<div class="row">
						<!-- single-info -->
						<div class="col-lg-4 col-12 ">
							<div class="single-info">
								<i class="icofont icofont-ui-call"></i>
								<div class="content">
									<h3><?php echo $phoneNumber ;?></h3>
									<p><?php echo $email ;?></p>
								</div>
							</div>
						</div>
						<!--/End single-info -->
						<!-- single-info -->
						<div class="col-lg-4 col-12 ">
							<div class="single-info">
								<i class="icofont-google-map"></i>
								<div class="content">
									<h3><?php echo $address ?></h3>
									<p>Zanzibar</p>
								</div>
							</div>
						</div>
						<!--/End single-info -->
						<!-- single-info -->
						<div class="col-lg-4 col-12 ">
							<div class="single-info">
								<i class="icofont icofont-wall-clock"></i>
								<div class="content">
									<h3><?php echo $openingDay;?> - <?php echo $closingDay;?> </h3>
									 <p><?php echo $openingTime;?> am - <?php echo $closingTime;?> pm</p>
									<!-- <p>Sunday & Sunday Closed</p> -->
								</div>
							</div>
						</div>
						<!--/End single-info -->
					</div>
				</div>
			</div>
		</section>
		<!--/ End Contact Us -->
		
		<!-- Footer Area -->
		<footer id="footer" class="footer ">
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
											<li><a href="index"><i class="fa fa-caret-right" aria-hidden="true"></i>Home</a></li>
											<li><a href="about"><i class="fa fa-caret-right" aria-hidden="true"></i>About Us</a></li>
											<li><a href="service.html"><i class="fa fa-caret-right" aria-hidden="true"></i>Services</a></li>
											<li><a href="contact"><i class="fa fa-caret-right" aria-hidden="true"></i>Contact Us</a></li>
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
								<p>© Copyright 2024 |  All Rights Reserved by <a href="https://www.wpthemesgrid.com" target="_blank">zanzimarinesolution.com</a> </p>
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
		<!-- Google Map API Key JS -->
		<script src="https://maps.google.com/maps/api/js?key=AIzaSyDGqTyqoPIvYxhn_Sa7ZrK5bENUWhpCo0w"></script>
		<!-- Gmaps JS -->
		<script src="js/gmaps.min.js"></script>
		<!-- Map Active JS -->
		<script src="js/map-active.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>
    </body>
</html>