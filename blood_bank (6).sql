-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2025 at 07:25 PM
-- Server version: 8.4.2
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `last_action_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `user_type`, `last_action_time`) VALUES
(1, 'Admin1', 'Bishal@10', 'Admin', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `blood_requests`
--

CREATE TABLE `blood_requests` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `blood_group` varchar(10) NOT NULL,
  `requisition_file` varchar(255) NOT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL,
  `province` varchar(50) NOT NULL,
  `district` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `blood_requests`
--

INSERT INTO `blood_requests` (`id`, `name`, `email`, `phone`, `blood_group`, `requisition_file`, `note`, `created_at`, `user_id`, `province`, `district`) VALUES
(21, 'Aayush', 'bishal975@gmail.com', '1234567890', 'A-', 'uploads/675af385767af-Screenshot2024-12-11at8.20.06AM.png', '', '2024-12-12 14:30:29', 38, '', ''),
(22, 'Aayush', 'Ad@gmail.com', '9876543210', 'A+', 'uploads/675af935b5d76-Picture1.png', 'Nothing', '2024-12-12 14:54:45', 40, '', ''),
(23, 'Ram Bahadur', 'Ra@gmail.com', '9876543210', 'A-', 'uploads/675afcf3052bd-Screenshot2024-12-11at8.19.59AM.png', '', '2024-12-12 15:10:43', 40, '', ''),
(24, 'Aayush', 'bishal975@gmail.com', '1234567890', 'A-', 'uploads/675b0818bc7bd-Screenshot2024-12-11at8.20.06AM.png', 'hj', '2024-12-12 15:58:16', 40, '', ''),
(25, 'Bishal', 'bishal975@gmail.com', '1234567890', 'A-', 'uploads/675b18e7679fa-Screenshot2024-12-11at8.19.59AM.png', '', '2024-12-12 17:09:59', 38, '', ''),
(26, 'Aayush', 'bishal975@gmail.com', '9876543210', 'B+', 'uploads/676fa22d5b1f8-1.jpeg', '', '2024-12-28 07:01:01', 40, '', ''),
(27, 'Bishal', 'bishalaryal975@gmail.com', '9876543210', 'B+', 'uploads/6778e54fbd6eb-Coverpage4.pdf', '', '2025-01-04 07:37:51', 18, '', ''),
(28, 'Ramesh', 'ramesh@gmail.com', '1234567890', 'AB-', 'uploads/67b96bdaba43b-Screenshot2025-02-20at10.46.50PM.png', '', '2025-02-22 06:16:58', NULL, '', ''),
(29, 'Aayush', 'Cr@gmail.com', '9876543201', 'AB-', 'uploads/67bd78f07fb60-dfd.png', 'hello', '2025-02-25 08:01:52', 39, 'Madesh', 'Janakpur'),
(30, 'Bishal', 'Cr@gmail.com', '9876543210', 'B+', 'uploads/67bdf40fb838d-dfd.png', '', '2025-02-25 16:47:11', 39, 'Sudurpashchim', 'Doti'),
(31, 'Shyam', 'shyam@gmail.com', '9876543201', 'AB+', 'uploads/67be8fe3ab747-err.drawio1.png', '', '2025-02-26 03:52:03', 45, 'Karnali', 'Surkhet'),
(32, 'Aayush', 'Aayush@gmai.com', '1234567890', 'A+', 'uploads/67bf230fd3444-Screenshot2025-02-25at10.15.04PM.png', '', '2025-02-26 14:19:59', 39, 'Madesh', 'Janakpur'),
(33, 'Chris', 'Chris@gmail.com', '1234567890', 'A+', 'uploads/67bf3687cc2aa-Screenshot2025-02-24at12.00.47AM.png', '', '2025-02-26 15:43:03', 39, 'Koshi', 'Ilam'),
(34, 'Joe', 'koe@gmail.com', '987654322', 'B+', 'uploads/67bf3ec22e68d-schema.png', '', '2025-02-26 16:18:10', 18, 'Lumbini', 'Dang');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

CREATE TABLE `donors` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `blood_group` varchar(3) NOT NULL,
  `province` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_donation_date` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id`, `name`, `phone`, `email`, `blood_group`, `province`, `district`, `created_at`, `last_donation_date`, `is_active`, `user_id`) VALUES
(1, 'Ram Bahadur', '9876543201', 'Bss@gmail.com', 'O+', 'Sudurpashchim', 'Doti', '2025-02-19 05:05:24', NULL, 1, NULL),
(3, 'Bishal', '9876543201', 'bishalaryal975@gmail.com', 'B+', 'Bagmati', 'Kathmandu', '2025-02-22 06:23:19', NULL, 1, NULL),
(4, 'Shyam', '9876543210', 'shyam@gmail.com', 'B+', 'Gandaki', 'Pokhara', '2025-02-23 05:35:49', NULL, 1, NULL),
(5, 'Aayush', '1234567890', 'Ra@gmail.com', 'AB+', 'Lumbini', 'Dang', '2025-02-24 03:12:05', NULL, 1, NULL),
(6, 'Aayush', '9876543201', 'aayush@gmail.com', 'AB-', 'Gandaki', 'Pokhara', '2025-02-25 16:04:28', NULL, 1, NULL),
(7, 'Bishal', '9876543201', 'bishal@gmail.com', 'B+', 'Sudurpashchim', 'Doti', '2025-02-25 16:45:54', NULL, 1, NULL),
(8, 'Shyam', '9876543210', 'shyam@gmail.com', 'B+', 'Lumbini', 'Rupandehi', '2025-02-26 04:22:41', NULL, 1, 45),
(9, 'Chris', '1234567890', 'chris@gmail.com', 'A+', 'Koshi', 'Ilam', '2025-02-26 15:43:30', NULL, 1, 39),
(10, 'Joe', '9876543211', 'joe@gmail.com', 'B+', 'Lumbini', 'Dang', '2025-02-26 16:17:43', NULL, 1, 18);

-- --------------------------------------------------------

--
-- Table structure for table `donor_notifications`
--

CREATE TABLE `donor_notifications` (
  `id` int NOT NULL,
  `donor_id` int NOT NULL,
  `donor_email` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('read','unread') NOT NULL DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `donor_notifications`
--

INSERT INTO `donor_notifications` (`id`, `donor_id`, `donor_email`, `message`, `status`, `created_at`) VALUES
(2, 10, 'joe@gmail.com', 'Potential blood receivers found for your donation (B+). Receiver contacts: 987654322', 'read', '2025-02-26 17:22:46'),
(3, 10, 'joe@gmail.com', 'Potential blood receivers found for your donation (B+). Receiver contacts: 987654322', 'read', '2025-02-26 17:40:12');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `message` text NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `user_email`, `created_at`, `user_id`) VALUES
(2, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2024-12-12 16:04:00', NULL),
(3, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2024-12-13 01:29:40', NULL),
(4, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2024-12-13 01:31:36', NULL),
(5, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2024-12-13 01:32:42', NULL),
(6, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2024-12-13 01:32:45', NULL),
(7, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2024-12-13 01:34:52', NULL),
(8, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2024-12-13 01:35:25', NULL),
(9, 'The requested blood group B+ is now available.', 'bishalaryal975@gmail.com', '2025-01-04 07:39:04', NULL),
(10, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2025-01-18 11:25:40', NULL),
(11, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2025-02-13 15:33:02', NULL),
(12, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2025-02-18 03:24:05', NULL),
(13, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2025-02-18 03:24:26', NULL),
(14, 'The requested blood group B+ is now available.', 'bishalaryal975@gmail.com', '2025-02-18 03:24:50', NULL),
(15, 'The requested blood group A- is now available.', 'bishal975@gmail.com', '2025-02-18 05:43:59', NULL),
(16, 'The requested blood group A- is now available.', 'aaaaa@gmail.com', '2025-02-18 06:26:05', NULL),
(17, 'The requested blood group B+ is now available.', 'bishalaryal975@gmail.com', '2025-02-23 06:40:15', NULL),
(18, 'The requested blood group B+ is now available.', 'bishal975@gmail.com', '2025-02-23 06:40:19', NULL),
(19, 'The requested blood group B+ is now available.', 'bishal975@gmail.com', '2025-02-25 15:43:27', NULL),
(20, 'The requested blood group AB- is now available.', 'Cr@gmail.com', '2025-02-25 16:06:27', NULL),
(21, 'The requested blood group AB- is now available.', 'Cr@gmail.com', '2025-02-25 16:06:55', NULL),
(22, 'No AB- donors found in Madesh province. We\'ll keep searching.', 'Cr@gmail.com', '2025-02-25 16:26:25', 39),
(24, 'Urgent: B+ donors available in Doti district! Contact immediately.', 'Cr@gmail.com', '2025-02-25 16:47:18', 39),
(25, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 12:54:08', NULL),
(26, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 12:54:11', NULL),
(27, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:07:01', NULL),
(28, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:07:02', NULL),
(29, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:07:02', 38),
(30, 'No A+ donors found in  province. We\'ll keep searching.', 'Ad@gmail.com', '2025-02-26 13:07:03', 40),
(31, 'No A- donors found in  province. We\'ll keep searching.', 'Ra@gmail.com', '2025-02-26 13:07:04', 40),
(32, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:07:05', 40),
(33, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:08:58', NULL),
(34, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:09:01', 38),
(35, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:09:09', NULL),
(36, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:09:30', NULL),
(37, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:09:31', NULL),
(38, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:11:51', NULL),
(39, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:12:29', NULL),
(40, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:13:30', NULL),
(41, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:13:33', NULL),
(42, 'No A- donors found in  province. We\'ll keep searching.', 'bishal975@gmail.com', '2025-02-26 13:13:35', NULL),
(43, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:10:11', NULL),
(44, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:10:34', 40),
(45, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:14:32', NULL),
(46, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 14:20:33', 39),
(47, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:26:40', NULL),
(48, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:26:46', NULL),
(49, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:29:28', NULL),
(50, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:40:04', NULL),
(51, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:40:07', NULL),
(52, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:50:34', NULL),
(53, 'Still searching for A- donors for Bishal in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:55:08', NULL),
(54, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 14:55:35', 38),
(55, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:04:16', 38),
(56, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:04:19', 38),
(57, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:04:25', 39),
(58, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:06:51', 38),
(59, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:09:39', 38),
(60, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:09:57', 38),
(61, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:10:16', 39),
(62, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:17:05', 38),
(63, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:17:19', 39),
(65, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:20:28', 39),
(66, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:22:07', 38),
(67, 'Still searching for A- donors for Aayush in nearby areas.', 'bishal975@gmail.com', '2025-02-26 15:22:11', 38),
(68, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:24:20', 39),
(69, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:27:40', 39),
(70, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:27:49', 39),
(71, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:27:52', 39),
(72, 'Still searching for A+ donors for Aayush in nearby areas.', 'Aayush@gmai.com', '2025-02-26 15:31:16', 39),
(73, 'Still searching for B+ donors for Bishal in nearby areas.', 'bishalaryal975@gmail.com', '2025-02-26 15:31:54', 18),
(74, 'We found potential donors for Chris (A+). Donor contacts: 1234567890', 'Chris@gmail.com', '2025-02-26 15:44:06', 39),
(75, 'We found potential donors for Chris (A+). Donor contacts: 1234567890', 'Chris@gmail.com', '2025-02-26 15:50:35', 39),
(76, 'Blood group B+ is not available for Bishal.', 'bishalaryal975@gmail.com', '2025-02-26 15:50:38', 18),
(77, 'Blood group A+ is not available for Aayush.', 'Aayush@gmai.com', '2025-02-26 15:50:45', 39),
(78, 'Blood group B+ is not available for Bishal.', 'bishalaryal975@gmail.com', '2025-02-26 15:51:07', 18),
(79, 'We found potential donors for Joe (B+). Donor contacts: 9876543211', 'koe@gmail.com', '2025-02-26 16:18:20', 18);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `age` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_type` varchar(255) NOT NULL DEFAULT 'donor',
  `last_request_date` datetime DEFAULT NULL,
  `request_count` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `phone`, `blood_type`, `age`, `email`, `password`, `created_at`, `user_type`, `last_request_date`, `request_count`) VALUES
(18, 'Bishal', 'Butwal', '1234567890', 'B+', 23, 'bishalarx@gmail.com', 'Bishal@10', '2024-12-06 16:32:40', 'donor,receiver', NULL, 0),
(19, 'admin', 'dfg', '9876543210', 'A-', 23, 'aa@gmail.com', 'Admin@10', '2024-12-06 16:47:57', 'donor,receiver', NULL, 0),
(37, 'hari', 'ktm', '1234567890', 'B+', 23, 'hari@gmail.com', 'Hari@10', '2024-12-08 02:38:54', 'receiver,donor', NULL, 0),
(38, 'hari Bahadur', 'Ktm', '1234567890', 'A+', 45, 'harri@gmail.com', 'Hari@10', '2024-12-10 03:14:19', 'receiver,donor', NULL, 0),
(39, 'Aayush', 'Budhanilkantha', '9876543201', 'A-', 21, 'aaa@gmail.com', 'Aayush@10', '2024-12-11 02:27:32', 'donor', NULL, 0),
(40, 'Aayush', 'KTM', '9876543210', 'B+', 34, 'aaaa@gmail.com', 'Aayush@10', '2024-12-12 07:21:36', 'receiver,donor', NULL, 0),
(45, 'Shyam', 'KTM', '9876543210', 'B+', 45, 'shyam@gmail.com', 'Shyam@10', '2025-02-25 07:17:13', 'donor,receiver', NULL, 0),
(46, 'Himal', 'Ilam', '1234567890', 'B+', 34, 'himal@gmail.com', 'Himal@10', '2025-02-26 06:33:23', 'receiver', NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blood_requests_users` (`user_id`);

--
-- Indexes for table `donors`
--
ALTER TABLE `donors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_donors_users` (`user_id`);

--
-- Indexes for table `donor_notifications`
--
ALTER TABLE `donor_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_users` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `donors`
--
ALTER TABLE `donors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `donor_notifications`
--
ALTER TABLE `donor_notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD CONSTRAINT `fk_blood_requests_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `donors`
--
ALTER TABLE `donors`
  ADD CONSTRAINT `fk_donors_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `donor_notifications`
--
ALTER TABLE `donor_notifications`
  ADD CONSTRAINT `donor_notifications_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `donors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
