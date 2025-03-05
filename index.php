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


include 'handlers/portfolio_queries.php'; // Include the queries file


// Fetch portfolio items with images

$portfolioItems = getPortfolioItemsWithImages();
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

	<style>
		.custom-slider .text {
			position: relative;
			/* Position relative to ensure it is above the overlay */
			z-index: 2;
			/* Ensure the text is above the overlay */
			color: white;
			/* Set text color */
		}

		.custom-slider .text .description {
			background-color: rgba(0, 0, 0, 0.5);
			/* Semi-transparent black background */
			padding: 10px;
			/* Add padding for better readability */
			border-radius: 5px;
			/* Optional: Add rounded corners */
			display: inline-block;
			/* Make the background only cover the text */
		}
	</style>

</head>

<body>

	<!-- Header Area -->
	<header class="header">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container d-flex flex-column flex-md-row align-items-center"> <!-- Use column on small screens and row on medium and above -->
				<img src="admin/system-settings/<?php echo htmlspecialchars($logo); ?>" alt="No image" style="height: 80px; width: auto; margin-bottom: 10px; margin-right: 10px;"> <!-- Changed margin to bottom for small screens -->

				<div class="col-lg-6 col-md-7 col-12 text-center text-md-left"> <!-- Center text on small screens -->
					<label class="responsive-heading"><?php echo htmlspecialchars($title); ?></label>
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
										<li class="active"><a href="index">Home</a></li>
										<li><a href="about">About us</a></li>
										<li><a href="service">Services </a></li>
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
	<!-- End Header Area -->

	<!-- Slider Area -->
	<section class="slider custom-slider">
		<div class="hero-slider">
			<?php include 'handlers/fetch_slides.php'; ?>
			<?php foreach ($slides as $slide): ?>
				<!-- Start Single Slider -->
				<div class="single-slider" style="background-image:url('admin/slides-images/<?php echo htmlspecialchars($slide['slideimage']); ?>')">
					<div class="container">
						<div class="row">
							<div class="col-lg-7">
								<div class="text">
									<h1><?php echo htmlspecialchars($slide['title']); ?></h1>
									<p class="description" style="color: white;"><?php echo htmlspecialchars($slide['description']); ?></p> <!-- Added class for styling -->
									<div class="button">
										<a href="service" class="btn">Make Appointment</a>
										<a href="about" class="btn primary">Learn More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End Single Slider -->
			<?php endforeach; ?>
		</div>
	</section>
	<!--/ End Slider Area -->

	<!-- Start Schedule Area -->
	<section class="schedule">
		<div class="container">
			<div class="schedule-inner">
				<div class="row">
					<div class="col-lg-4 col-md-6 col-12 ">
						<!-- single-schedule -->
						<div class="single-schedule first">
							<div class="inner">
								<div class="icon">
									<i class="fa fa-ambulance"></i>
								</div>
								<div class="single-content">

									<h4>Vision</h4>
									<p><?php echo $vision; ?></p>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-12">
						<!-- single-schedule -->
						<div class="single-schedule middle">
							<div class="inner">
								<div class="icon">
									<i class="icofont-prescription"></i>
								</div>
								<div class="single-content">

									<h4>Mision</h4>
									<p><?php echo $mission; ?></p>

								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-12">
						<!-- single-schedule -->
						<div class="single-schedule last">
							<div class="inner">
								<div class="icon">
									<i class="icofont-ui-clock"></i>
								</div>
								<div class="single-content">

									<h4>Mottor</h4>
									<p><?php echo $motto; ?></p>
									<ul class="time-sidual">
										<span>Working Hours</span>
										<li class="day"><?php echo $openingDay; ?> - <?php echo $closingDay ?> <span><?php echo $openingTime; ?> am - <?php echo $closingTime; ?> pm </span></li>


									</ul>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/End Start schedule Area -->

	<!-- Start Feautes -->
	<section class="Feautes section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>We Are Always Ready to Help You & Your Friends</h2>
						<img src="img/section-img.png" alt="#">
						<p>The Institute provides consultation and training to overcome obstacles, promoting sustainable and resilient practices.</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-12">
					<!-- Start Single features -->
					<div class="single-features">
						<div class="signle-icon">
							<i class="icofont-users-alt-5"></i>
						</div>
						<h3>Consultation</h3>
						<p>The Institute provides consultation by offering expert guidance, strategic solutions, and actionable insights to drive sustainability and resilience initiatives.</p>
					</div>
					<!-- End Single features -->
				</div>
				<div class="col-lg-4 col-12">
					<!-- Start Single features -->
					<div class="single-features">
						<div class="signle-icon">
							<i class="icofont-excavator"></i>
						</div>
						<h3>Removing Obstacle</h3>
						<p>The Institute removes obstacles by identifying barriers, offering tailored solutions, fostering collaboration, and driving policy changes to enable sustainable and inclusive progress.</p>
					</div>
					<!-- End Single features -->
				</div>
				<div class="col-lg-4 col-12">
					<!-- Start Single features -->
					<div class="single-features last">
						<div class="signle-icon">
							<i class="icofont-learn"></i>
						</div>
						<h3>Training</h3>
						<p>The Institute provides training by equipping individuals and organizations with the skills, knowledge, and tools needed to implement sustainable, inclusive, and resilient practices..</p>
					</div>
					<!-- End Single features -->
				</div>
			</div>
		</div>
	</section>
	<!--/ End Feautes -->

	<!-- Start Fun-facts -->
	<div id="fun-facts" class="fun-facts section overlay">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Fun -->
					<div class="single-fun">
						<i class="icofont icofont-home"></i>
						<div class="content">
							<span class="counter">1</span>
							<p></p>
						</div>
					</div>
					<!-- End Single Fun -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Fun -->
					<div class="single-fun">
						<i class="icofont icofont-user-alt-3"></i>
						<div class="content">
							<span class="counter">5</span>
							<p>Specialist </p>
						</div>
					</div>
					<!-- End Single Fun -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Fun -->
					<div class="single-fun">
						<i class="icofont-simple-smile"></i>
						<div class="content">
							<span class="counter">43</span>
							<p>Happy Customer</p>
						</div>
					</div>
					<!-- End Single Fun -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Fun -->
					<div class="single-fun">
						<i class="icofont icofont-table"></i>
						<div class="content">
							<span class="counter">2</span>
							<p>Years of Experience</p>
						</div>
					</div>
					<!-- End Single Fun -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Fun-facts -->

	<!-- Start Why choose -->
	<section class="why-choose section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>We Offer Different Services To Provide Best Solution</h2>
						<img src="img/section-img.png" alt="#">
						<p>Unlock tailored solutions with our expert services designed to overcome challenges and drive your success, ensuring a sustainable, efficient, and resilient future for your solution..</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6 col-12">
					<!-- Start Choose Left -->
					<div class="choose-left">
						<h3>Who We Are</h3>
						<p>Our company specializes in providing expert research-based services, academic support, and consultation on marine-related issues. With a strong foundation in marine science and environmental research, we offer comprehensive solutions tailored to meet the needs of industries, governments, and academic institutions. Our services encompass marine resource management, environmental impact assessments, and sustainable marine practices, ensuring data-driven insights and strategies for ocean and coastal stewardship." </p>
						<p>We are focusing on:- </p>
						<div class="row">

							<div class="col-lg-12">
								<ul class="list">
									<li><i class="fa fa-caret-right"></i>Increasing knowledge and understanding . </li>
									<li><i class="fa fa-caret-right"></i>Community engagement, .</li>
									<li><i class="fa fa-caret-right"></i>Promoting better informed decision-.</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- End Choose Left -->
				</div>
				<div class="col-lg-6 col-12">
					<!-- Start Choose Rights -->
					<div class="choose-right">
						<div class="video-image">
							<!-- Video Animation -->
							<div class="promo-video">
								<div class="waves-block">
									<div class="waves wave-1"></div>
									<div class="waves wave-2"></div>
									<div class="waves wave-3"></div>
								</div>
							</div>
							<!--/ End Video Animation -->
							<a href="<?php echo $youtube; ?>" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
						</div>
					</div>
					<!-- End Choose Rights -->
				</div>
			</div>
		</div>
	</section>
	<!--/ End Why choose -->

	<!-- Start Call to action -->
	<section class="call-action overlay" data-stellar-background-ratio="0.5">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-12">
					<div class="content">
						<h2>Do you need Comprehensive Solution? Call @ <?php echo $phoneNumber; ?></h2>
						<p>
							"Feel free to reach out to me anytime! We are here to assist you with any questions or concerns you may have.".</p>
						<div class="button">
							<a href="contact" class="btn">Contact Now</a>
							<a href="about" class="btn">Learn More <i class="fa fa-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--/ End Call to action -->

	<!-- Start portfolio -->
	<section class="portfolio section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>We Maintain Best Rules Inside Our services</h2>
						<img src="img/section-img.png" alt="#">
						<p>"We uphold the highest standards of excellence, integrity, and sustainability in all our services, ensuring that our solutions are research-driven, environmentally responsible, and tailored to the unique needs of our clients."</p>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid">
			
			<div class="row">

				<div class="col-lg-12 col-12">

					<div class="owl-carousel portfolio-slider">

						<?php foreach ($portfolioItems as $item): ?>

							<div class="single-pf">

								<img src="admin/portfolio-info/<?php echo $item['image_path']; ?>" loading="lazy" alt="<?php echo htmlspecialchars($item['title']); ?>">

								<a href="portfolio?id=<?php echo $item['portfolio_item_id']; ?>" class="btn">View Details</a>
							</div>

						<?php endforeach; ?>

					</div>

				</div>

			</div>
		</div>
	</section>
	<!--/ End portfolio -->



	<!-- Pricing Table -->
	<section class="pricing-table section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>We Provide You The Best Solution In Resonable Price</h2>
						<img src="img/section-img.png" alt="#">
						<p>"We specialize in comprehensive marine and coastal solutions, offering expert services that extend beyond research to include practical applications for sustainable management and conservation."</p>
					</div>
				</div>
			</div>
			<div class="row">
				<!-- Single Table -->
				<div class="col-lg-4 col-md-12 col-12">
					<div class="single-table">
						<!-- Table Head -->
						<div class="table-head">
							<div class="icon">
								<i class="icofont-book-alt"></i>
							</div>
							<h4 class="title">Research Based Service</h4>

						</div>
						<!-- Table List -->
						<ul class="table-list">
							<li>1. Marine Resource Management</li>
							<li>2. Environmental Assessments</li>
							<li>3. Sustainable Marine Practices</li>
							<li>4. Climate Change Research</li>
							<li>5. Community Engagement</li>
						</ul>
						<div class="table-bottom">
							<a class="btn" href="service">Book Now</a>
						</div>
						<!-- Table Bottom -->
					</div>
				</div>
				<!-- End Single Table-->
				<!-- Single Table -->
				<div class="col-lg-4 col-md-12 col-12">
					<div class="single-table">
						<!-- Table Head -->
						<div class="table-head">
							<div class="icon">
								<i class="icofont-education"></i>
							</div>
							<h4 class="title">Academic support</h4>

						</div>
						<!-- Table List -->
						<ul class="table-list">
							<li>1. Academic Writing</li>
							<li>2. Research Guidance</li>
							<li>3. Thesis Editing</li>
							<li>4. Data Analysis</li>
							<li>5. Statistical Consulting </li>
						</ul>
						<div class="table-bottom">
							<a class="btn" href="service">Book Now</a>
						</div>
						<!-- Table Bottom -->
					</div>
				</div>
				<!-- End Single Table-->
				<!-- Single Table -->
				<div class="col-lg-4 col-md-12 col-12">
					<div class="single-table">
						<!-- Table Head -->
						<div class="table-head">
							<div class="icon">
								<i class="icofont-handshake-deal"></i>
							</div>
							<h4 class="title">Consaltation</h4>

						</div>
						<!-- Table List -->
						<ul class="table-list">
							<li>1. Policy Consultation</li>
							<li>2. Industry Consultation</li>
							<li>3. Community Consultation</li>
							<li>4. Stakeholder Engagement</li>
							<li>5. Expert Advice</li>
						</ul>
						<div class="table-bottom">
							<a class="btn" href="service">Book Now</a>
						</div>
						<!-- Table Bottom -->
					</div>
				</div>
				<!-- End Single Table-->
			</div>
		</div>
	</section>
	<!--/ End Pricing Table -->

	<!-- Start Blog Area -->
	<section class="blog section" id="blog">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="section-title">
						<h2>Get Most Recently Activity.</h2>
						<img src="img/section-img.png" alt="#">
						<p>"The Institute is actively researching climate change, engaging communities, and empowering women to promote sustainable marine conservation and decision-making."</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-md-6 col-12">
					<!-- Single Blog -->
					<div class="single-news">
						<div class="news-head">
							<img src="img/picha1.png" alt="Activity Image" loading="lazy">
						</div>
						<div class="news-body">
							<div class="news-content">

								<h2><a href="about">Empowering Villagers with Marine and Coastal Conservation Solutions</a></h2>
								<p class="text">The activity involves educating villagers on marine and coastal solutions, focusing on sustainable practices to protect the environment. The aim is to raise awareness about preserving marine ecosystems and managing coastal resources responsibly. Community workshops and hands-on training empower locals to take action for a healthier coastline.</p>
							</div>
						</div>
					</div>
					<!-- End Single Blog -->
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<!-- Single Blog -->
					<div class="single-news">
						<div class="news-head">
							<img src="img/picha2.png" alt="Activity Image" loading="lazy">
						</div>
						<div class="news-body">
							<div class="news-content">

								<h2><a href="about">Research Support for Sustainable Marine and Coastal Solutions.</a></h2>
								<p class="text">Providing research assistance on marine and coastal solutions helps individuals find reliable information on environmental conservation. This support includes guiding them through data analysis, best practices, and sustainable methods. The goal is to aid in informed decision-making for protecting marine ecosystems and coastal areas.</p>
							</div>
						</div>
					</div>
					<!-- End Single Blog -->
				</div>
				<div class="col-lg-4 col-md-6 col-12">
					<!-- Single Blog -->
					<div class="single-news">
						<div class="news-head">
							<img src="img/picha3.png" alt="Activity Image" loading="lazy">
						</div>
						<div class="news-body">
							<div class="news-content">

								<h2><a href="about">Expert Consultancy for Sustainable Marine and Coastal Solutions</a></h2>
								<p class="text">We provide expert consultancy to help individuals and communities address marine and coastal
									challenges effectively. Our solutions focus on sustainable practices, ensuring the protection and
									restoration of these vital ecosystems. Whether it's coastal erosion, marine conservation we offer tailored guidance to promote long-term environmental and economic benefits.</p>
							</div>
						</div>
					</div>
					<!-- End Single Blog -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Blog Area -->

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
								<li><a href="<?php echo $youtube; ?> " target="_blank""><i class=" icofont-youtube"></i></a></li>
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
								<li class="day"><?php echo $openingDay; ?> - <?php echo $closingDay; ?></li>
								<li class="day"><?php echo $openingTime ?> am - <?php echo $closingTime ?> pm</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<div class="single-footer">
							<h2>Newsletter</h2>
							<p>subscribe to our newsletter to get all our news in your inbox..</p>
							<form action="" method="get" target="_blank" class="newsletter-inner">
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