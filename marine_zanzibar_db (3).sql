-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2024 at 06:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marine_zanzibar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_contact`
--

CREATE TABLE `company_contact` (
  `id` int(11) NOT NULL,
  `meta_field` varchar(255) NOT NULL,
  `meta_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_contact`
--

INSERT INTO `company_contact` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'phone_number', '+255 676 783 840'),
(3, 'email', 'ibrahimraj@gmail.com'),
(4, 'twitter', 'https://www.suza.ac.tz'),
(5, 'youtube', 'https://www.youtube.com/watch?v=Mgr5kmBMa-Q'),
(6, 'address', 'Fuoni Chunga'),
(7, 'whatsapp', '+255 777 296 653');

-- --------------------------------------------------------

--
-- Table structure for table `management_contact`
--

CREATE TABLE `management_contact` (
  `id` int(11) NOT NULL,
  `staff_image` varchar(255) DEFAULT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_position` varchar(100) NOT NULL,
  `staff_email` varchar(100) NOT NULL,
  `staff_phone` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `management_contact`
--

INSERT INTO `management_contact` (`id`, `staff_image`, `staff_name`, `staff_position`, `staff_email`, `staff_phone`) VALUES
(23, 'uploads/hamad.jpg', 'Hamad Said Khatib', 'Director', 'hamadkhatib@gmail.com', '+255 658 420 065'),
(24, 'uploads/tum.jpg', 'Tumu Ali Mussa', 'Head of Logistics', 'mussa_tumu@yahoo.com', '+255 777 296 653'),
(25, 'uploads/mtu  1.jpeg', 'Miharbi Rajab Juma', 'Developer', 'ibrahim@yahoo.com', '+255 777 296 653');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_images`
--

CREATE TABLE `portfolio_images` (
  `id` int(11) NOT NULL,
  `portfolio_item_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio_images`
--

INSERT INTO `portfolio_images` (`id`, `portfolio_item_id`, `image_path`, `created_at`) VALUES
(21, 10, 'uploads/6766a0d4c3182_pexels-asadphoto-457882.jpg', '2024-12-20 21:41:31'),
(22, 10, 'uploads/zanzibar beach 1.jpg', '2024-12-20 21:41:31'),
(23, 11, 'uploads/676691047d2b4_istockphoto-498283106-612x612.jpg', '2024-12-20 21:42:26'),
(24, 11, 'uploads/676691047e958_pexels-asadphoto-457882.jpg', '2024-12-20 21:42:26'),
(25, 11, 'uploads/676691047fbf3_pexels-francesco-ungaro-3390587.jpg', '2024-12-20 21:42:26'),
(26, 12, 'uploads/6766a0582e8cb_pexels-bella-white-201200-635279.jpg', '2024-12-20 21:43:25'),
(27, 12, 'uploads/img01.jpg', '2024-12-20 21:43:25'),
(28, 12, 'uploads/20240125_112622_06naru.jpg', '2024-12-20 21:43:25'),
(29, 12, 'uploads/with womesapic.jpg', '2024-12-20 21:43:25'),
(34, 10, 'uploads/clean12.jpg', '2024-12-21 11:56:39'),
(35, 10, 'uploads/fish.jpeg', '2024-12-21 11:56:39'),
(46, 14, 'uploads/6766a030c3856_pexels-jeremy-bishop-1260133-2765872.jpg', '2024-12-21 13:08:54'),
(47, 14, 'uploads/photo-1682687982502-1529b3b33f85.jpeg', '2024-12-21 13:08:54'),
(48, 14, 'uploads/pexels-jeremy-bishop-1260133-2765872.jpg', '2024-12-21 13:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_items`
--

CREATE TABLE `portfolio_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `portfolio_items`
--

INSERT INTO `portfolio_items` (`id`, `title`, `description`, `created_at`) VALUES
(10, 'Welcome Again', 'popoz', '2024-12-20 21:41:31'),
(11, 'Hi Ibrahim Rajab', 'kkkkk vvvvvv', '2024-12-20 21:42:26'),
(12, 'Hi Ibrahim Welcome to the Marine Science', 'zaza', '2024-12-20 21:43:25'),
(14, 'Mambo', 'The Importance of Portfolio Management\r\n', '2024-12-21 13:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `slides_images`
--

CREATE TABLE `slides_images` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `slideimage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slides_images`
--

INSERT INTO `slides_images` (`id`, `title`, `description`, `slideimage`) VALUES
(3, 'Hi Ibrahim Welcome to the Marine Science ', 'The Institute envisions a sustainable, inclusive, and resilien t world, aiming to accelerate the transition and eliminate obstacles toward this goal.', 'uploads/Zanzibar_Island_Stone_Town.jpg'),
(4, 'Welcome', 'syuicde nd kitu gan', 'uploads/pexels-richard-segal-732340-1618606.jpg'),
(6, 'Hi Ibrahim', 'At its core, creativity involves the ability to think outside the box and approach challenges from unique angles. When faced with a problem, a creative thinker is not limited to conventional solutions', 'uploads/picha5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(44, 'system_name', 'Zanzi Marine Science Website'),
(45, 'system_short_name', 'ZMSH'),
(46, 'system_logo', 'uploads/web logo_processed.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '123', '2024-12-16 08:25:54'),
(2, 'Miharbi', '123', '2024-12-17 14:34:37');

-- --------------------------------------------------------

--
-- Table structure for table `vmm_info`
--

CREATE TABLE `vmm_info` (
  `id` int(11) NOT NULL,
  `meta_field` varchar(255) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vmm_info`
--

INSERT INTO `vmm_info` (`id`, `meta_field`, `meta_value`) VALUES
(8, 'mission', 'The Institute envisions a sustainable, inclusive, and resilient world, aiming to accelerate the transition and eliminate obstacles toward this goal.'),
(9, 'vision', 'The Institute’s vision is a sustainable, inclusive, and resilient world with the purpose is to accelerating the transition and removing obstacles, to a sustainable, inclusive, and resilient world.'),
(10, 'motto', '\"Empower. Inspire. Transform.\"'),
(11, 'opening_day', 'Monday'),
(12, 'closing_day', 'Friday'),
(13, 'opening_time', '08:00'),
(14, 'closing_time', '04:30');

-- --------------------------------------------------------

--
-- Table structure for table `who_we_are`
--

CREATE TABLE `who_we_are` (
  `id` int(11) NOT NULL,
  `meta_field` varchar(255) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `who_we_are`
--

INSERT INTO `who_we_are` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'whoami', 'Hasina Haji Mati'),
(2, 'youtube_video_link', 'https://youtu.be/K1SiPYgZDG0?list=TLGGs5GdTRtzPPExMDEyMjAyNA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_contact`
--
ALTER TABLE `company_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meta_field` (`meta_field`);

--
-- Indexes for table `management_contact`
--
ALTER TABLE `management_contact`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `staff_email` (`staff_email`);

--
-- Indexes for table `portfolio_images`
--
ALTER TABLE `portfolio_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolio_item_id` (`portfolio_item_id`);

--
-- Indexes for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides_images`
--
ALTER TABLE `slides_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `vmm_info`
--
ALTER TABLE `vmm_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `who_we_are`
--
ALTER TABLE `who_we_are`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_contact`
--
ALTER TABLE `company_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `management_contact`
--
ALTER TABLE `management_contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `portfolio_images`
--
ALTER TABLE `portfolio_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `portfolio_items`
--
ALTER TABLE `portfolio_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `slides_images`
--
ALTER TABLE `slides_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vmm_info`
--
ALTER TABLE `vmm_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `who_we_are`
--
ALTER TABLE `who_we_are`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `portfolio_images`
--
ALTER TABLE `portfolio_images`
  ADD CONSTRAINT `portfolio_images_ibfk_1` FOREIGN KEY (`portfolio_item_id`) REFERENCES `portfolio_items` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
