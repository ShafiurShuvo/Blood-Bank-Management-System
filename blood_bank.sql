-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2025 at 09:45 PM
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
-- Database: `blood_bank_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@bloodbank.com', '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `blood_banks`
--

CREATE TABLE `blood_banks` (
  `blood_bank_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_banks`
--

INSERT INTO `blood_banks` (`blood_bank_id`, `name`, `address`, `city`, `state`, `phone`, `email`, `created_at`) VALUES
(1, 'Dhaka Central Blood Bank', 'Sher-e-Bangla Nagar', 'Dhaka', 'Dhaka Division', '02-9122789', 'central@bloodbank.bd', '2025-10-09 16:24:13'),
(2, 'Chittagong Blood Transfusion Center', 'Agrabad Access Road', 'Chittagong', 'Chittagong Division', '031-2511234', 'chittagong@bloodbank.bd', '2025-10-09 16:24:13'),
(3, 'Sylhet Regional Blood Bank', 'Shahjalal Upashahar', 'Sylhet', 'Sylhet Division', '0821-725456', 'sylhet@bloodbank.bd', '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `blood_donations`
--

CREATE TABLE `blood_donations` (
  `donation_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `blood_bank_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `units` int(11) DEFAULT 1,
  `donation_date` date NOT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_donations`
--

INSERT INTO `blood_donations` (`donation_id`, `donor_id`, `blood_bank_id`, `blood_group`, `units`, `donation_date`, `status`, `created_at`) VALUES
(1, 1, 1, 'O+', 1, '2024-12-15', 'Approved', '2025-10-09 16:24:13'),
(2, 2, 2, 'A+', 1, '2024-11-20', 'Approved', '2025-10-09 16:24:13'),
(3, 3, 3, 'B+', 1, '2025-01-05', 'Approved', '2025-10-09 16:24:13'),
(4, 4, 1, 'AB+', 1, '2024-10-12', 'Approved', '2025-10-09 16:24:13'),
(5, 5, 2, 'O-', 1, '2024-12-01', 'Approved', '2025-10-09 16:24:13'),
(6, 6, 1, 'A-', 1, '2025-01-10', 'Pending', '2025-10-09 16:24:13'),
(7, 7, 3, 'B-', 1, '2024-11-15', 'Approved', '2025-10-09 16:24:13'),
(8, 8, 2, 'AB-', 1, '2025-01-08', 'Approved', '2025-10-09 16:24:13'),
(9, 11, 1, 'B+', 1, '2024-09-25', 'Approved', '2025-10-09 16:24:13'),
(10, 13, 3, 'O-', 1, '2024-12-20', 'Approved', '2025-10-09 16:24:13'),
(11, 14, 2, 'A-', 1, '2025-01-12', 'Pending', '2025-10-09 16:24:13'),
(12, 1, 2, 'O+', 1, '2024-08-10', 'Approved', '2025-10-09 16:24:13'),
(13, 2, 1, 'A+', 1, '2024-07-05', 'Approved', '2025-10-09 16:24:13'),
(14, 3, 3, 'B+', 1, '2024-09-18', 'Approved', '2025-10-09 16:24:13'),
(15, 4, 2, 'AB+', 1, '2024-06-22', 'Approved', '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `blood_inventory`
--

CREATE TABLE `blood_inventory` (
  `inventory_id` int(11) NOT NULL,
  `blood_bank_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `units_available` int(11) DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_inventory`
--

INSERT INTO `blood_inventory` (`inventory_id`, `blood_bank_id`, `blood_group`, `units_available`, `last_updated`) VALUES
(1, 1, 'A+', 25, '2025-10-09 16:24:13'),
(2, 1, 'A-', 10, '2025-10-09 16:24:13'),
(3, 1, 'B+', 20, '2025-10-09 16:24:13'),
(4, 1, 'B-', 8, '2025-10-09 16:24:13'),
(5, 1, 'AB+', 15, '2025-10-09 16:24:13'),
(6, 1, 'AB-', 5, '2025-10-09 16:24:13'),
(7, 1, 'O+', 30, '2025-10-09 16:24:13'),
(8, 1, 'O-', 12, '2025-10-09 16:24:13'),
(9, 2, 'A+', 18, '2025-10-09 16:24:13'),
(10, 2, 'A-', 7, '2025-10-09 16:24:13'),
(11, 2, 'B+', 22, '2025-10-09 16:24:13'),
(12, 2, 'B-', 6, '2025-10-09 16:24:13'),
(13, 2, 'AB+', 12, '2025-10-09 16:24:13'),
(14, 2, 'AB-', 5, '2025-10-09 17:00:48'),
(15, 2, 'O+', 28, '2025-10-09 16:24:13'),
(16, 2, 'O-', 10, '2025-10-09 16:24:13'),
(17, 3, 'A+', 20, '2025-10-09 16:24:13'),
(18, 3, 'A-', 9, '2025-10-09 16:24:13'),
(19, 3, 'B+', 16, '2025-10-09 16:24:13'),
(20, 3, 'B-', 7, '2025-10-09 16:24:13'),
(21, 3, 'AB+', 11, '2025-10-09 16:24:13'),
(22, 3, 'AB-', 3, '2025-10-09 16:24:13'),
(23, 3, 'O+', 25, '2025-10-09 16:24:13'),
(24, 3, 'O-', 8, '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `blood_orders`
--

CREATE TABLE `blood_orders` (
  `order_id` int(11) NOT NULL,
  `requester_type` enum('User','Hospital') NOT NULL,
  `requester_id` int(11) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `units` int(11) NOT NULL,
  `urgency` enum('Low','Medium','High','Critical') DEFAULT 'Medium',
  `source_type` enum('BloodBank','Donor') NOT NULL,
  `source_id` int(11) NOT NULL,
  `status` enum('Pending','Approved','Rejected','Completed') DEFAULT 'Pending',
  `order_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_orders`
--

INSERT INTO `blood_orders` (`order_id`, `requester_type`, `requester_id`, `blood_group`, `units`, `urgency`, `source_type`, `source_id`, `status`, `order_date`, `notes`, `created_at`) VALUES
(1, 'User', 9, 'O+', 2, 'High', 'BloodBank', 1, 'Approved', '2025-01-15', 'Need for emergency surgery', '2025-10-09 16:24:13'),
(2, 'User', 10, 'A+', 1, 'Medium', 'BloodBank', 2, 'Pending', '2025-01-14', 'Regular transfusion required', '2025-10-09 16:24:13'),
(3, 'User', 12, 'AB+', 1, 'Critical', 'BloodBank', 1, 'Approved', '2025-01-16', 'Urgent! Accident case', '2025-10-09 16:24:13'),
(4, 'User', 15, 'B-', 2, 'High', 'BloodBank', 3, 'Completed', '2025-01-13', 'Surgery scheduled tomorrow', '2025-10-09 16:24:13'),
(5, 'User', 9, 'O+', 1, 'Low', 'Donor', 1, 'Rejected', '2025-01-12', 'For planned treatment', '2025-10-09 16:24:13'),
(6, 'User', 10, 'A+', 2, 'Medium', 'Donor', 2, 'Pending', '2025-01-11', 'Requesting from compatible donor', '2025-10-09 16:24:13'),
(7, 'Hospital', 1, 'O-', 5, 'Critical', 'BloodBank', 1, 'Approved', '2025-01-16', 'Multiple trauma patients admitted', '2025-10-09 16:24:13'),
(8, 'Hospital', 2, 'A+', 3, 'High', 'BloodBank', 2, 'Approved', '2025-01-15', 'Thalassemia patients transfusion', '2025-10-09 16:24:13'),
(9, 'Hospital', 3, 'B+', 4, 'Medium', 'BloodBank', 3, 'Pending', '2025-01-14', 'Scheduled surgeries this week', '2025-10-09 16:24:13'),
(10, 'Hospital', 4, 'AB+', 2, 'High', 'BloodBank', 1, 'Completed', '2025-01-13', 'Cancer patients chemotherapy', '2025-10-09 16:24:13'),
(11, 'Hospital', 5, 'O+', 6, 'Critical', 'BloodBank', 2, 'Approved', '2025-01-16', 'Emergency department stock', '2025-10-09 16:24:13'),
(12, 'Hospital', 1, 'A-', 2, 'Medium', 'BloodBank', 1, 'Completed', '2025-01-12', 'ICU patients requirement', '2025-10-09 16:24:13'),
(13, 'Hospital', 2, 'B-', 1, 'Low', 'BloodBank', 3, 'Approved', '2025-01-11', 'Routine stock replenishment', '2025-10-09 16:24:13'),
(14, 'Hospital', 3, 'AB-', 1, 'High', 'BloodBank', 2, 'Completed', '2025-01-10', 'Rare blood type needed', '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `sender_type` enum('User','Hospital') NOT NULL,
  `sender_id` int(11) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Reviewed','Resolved') DEFAULT 'Pending',
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `sender_type`, `sender_id`, `subject`, `message`, `status`, `admin_response`, `created_at`) VALUES
(1, 'User', 1, 'Great Service!', 'I had a wonderful experience donating blood. The staff was very professional and caring. Thank you for making it easy to save lives!', 'Resolved', 'Thank you for your positive feedback! We are glad you had a great experience. Your contribution helps save lives.', '2025-10-09 16:24:13'),
(2, 'User', 9, 'Website Navigation Issue', 'I found it difficult to locate the blood inventory page. Could you make it more prominent on the dashboard?', 'Reviewed', 'Thank you for your suggestion. We will consider improving the navigation in our next update.', '2025-10-09 16:24:13'),
(3, 'User', 10, 'Suggestion for Notification System', 'It would be great if we could receive email notifications when our blood order is approved or when someone needs our blood type urgently.', 'Pending', NULL, '2025-10-09 16:24:13'),
(4, 'User', 12, 'Quick Response Appreciated', 'My blood order was processed very quickly during an emergency. I am grateful for the efficient system. Keep up the good work!', 'Resolved', 'We are happy we could help during your emergency. Thank you for your feedback!', '2025-10-09 16:24:13'),
(5, 'User', 15, 'Donor Certificate Request', 'Is it possible to get a digital donor certificate after each donation? It would be nice to have for our records.', 'Reviewed', 'Great suggestion! We are working on implementing digital certificates for donors.', '2025-10-09 16:24:13'),
(6, 'Hospital', 1, 'Excellent Blood Supply', 'The blood bank system has been very reliable. We receive timely responses to our requests and the quality is always maintained.', 'Resolved', 'Thank you for your continued partnership. We strive to maintain the highest standards.', '2025-10-09 16:24:13'),
(7, 'Hospital', 2, 'Request for Bulk Order Feature', 'We often need to order multiple blood types at once. A bulk order feature would save us time.', 'Reviewed', 'Thank you for the suggestion. We are evaluating the implementation of bulk ordering.', '2025-10-09 16:24:13'),
(8, 'Hospital', 3, 'Urgent Blood Request Process', 'During critical emergencies, the approval process could be faster. Perhaps a direct hotline for critical cases?', 'Pending', NULL, '2025-10-09 16:24:13'),
(9, 'Hospital', 5, 'Inventory Update Frequency', 'Sometimes the inventory shown online is not updated in real-time. Could you improve the update frequency?', 'Reviewed', 'We are working on real-time inventory synchronization. Thank you for bringing this to our attention.', '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `hospitals`
--

CREATE TABLE `hospitals` (
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `license_number` varchar(50) NOT NULL,
  `is_blocked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospitals`
--

INSERT INTO `hospitals` (`hospital_id`, `hospital_name`, `email`, `password`, `phone`, `address`, `city`, `state`, `license_number`, `is_blocked`, `created_at`) VALUES
(1, 'Dhaka Medical College Hospital', 'admin@dmch.gov.bd', '18f747ae2ad1e7fdf0533bd2dea4e3d1', '02-8626812', 'Secretariat Road, Ramna', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2020-001', 0, '2025-10-09 16:24:13'),
(2, 'Chittagong Medical College Hospital', 'contact@cmch.gov.bd', '18f747ae2ad1e7fdf0533bd2dea4e3d1', '031-2620231', 'Medical College Road, Panchlaish', 'Chittagong', 'Chittagong Division', 'DGHS-CH-2019-045', 0, '2025-10-09 16:24:13'),
(3, 'Square Hospital Dhaka', 'info@squarehospital.com', '18f747ae2ad1e7fdf0533bd2dea4e3d1', '02-8159457', '18/F, Bir Uttam Qazi Nuruzzaman Sarak, Panthapath', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2021-089', 0, '2025-10-09 16:24:13'),
(4, 'Evercare Hospital Dhaka', 'emergency@evercarehospital.com', '18f747ae2ad1e7fdf0533bd2dea4e3d1', '10678', 'Plot 81, Block E, Bashundhara R/A', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2018-123', 0, '2025-10-09 16:24:13'),
(5, 'Popular Diagnostic Centre', 'admin@populardiagnostic.com', '18f747ae2ad1e7fdf0533bd2dea4e3d1', '09666710678', '2 English Road, Gandaria, Dhaka', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2020-067', 0, '2025-10-09 16:24:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `blood_group` varchar(5) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `is_donor` tinyint(1) DEFAULT 0,
  `last_donation_date` date DEFAULT NULL,
  `is_blocked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `blood_group`, `gender`, `date_of_birth`, `address`, `city`, `state`, `is_donor`, `last_donation_date`, `is_blocked`, `created_at`) VALUES
(1, 'Shafiur Shuvo', 'shafiur.shuvo@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01712345678', 'O+', 'Male', '2001-01-01', 'Banasree', 'Dhaka', 'Dhaka Division', 1, '2024-12-15', 0, '2025-10-09 16:24:13'),
(2, 'Nazia Mumtahina', 'nazia.mumtahina@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01823456789', 'A+', 'Female', '1988-08-22', 'Motijheel', 'Dhaka', 'Dhaka Division', 1, '2024-11-20', 0, '2025-10-09 16:24:13'),
(3, 'Atik Shahriar', 'atik.shahriar@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01934567890', 'B+', 'Male', '1992-03-10', 'Agrabad', 'Chittagong', 'Chittagong Division', 1, '2025-01-05', 0, '2025-10-09 16:24:13'),
(4, 'Neha Islam', 'neha.islam@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01645678901', 'AB+', 'Female', '1995-11-30', 'Plot 8, Sector 7, Uttara', 'Dhaka', 'Dhaka Division', 1, '2024-10-12', 0, '2025-10-09 16:24:13'),
(5, 'Faisal Ahmed', 'faisal.ahmed@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01756789012', 'O-', 'Male', '1987-07-18', 'Mirpur - 6', 'Dhaka', 'Dhaka Division', 1, '2024-12-01', 0, '2025-10-09 16:24:13'),
(6, 'Ayesha Siddika', 'ayesha.siddika@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01867890123', 'A-', 'Female', '1993-02-25', 'Flat 2A, Lalmatia Housing', 'Dhaka', 'Dhaka Division', 1, NULL, 0, '2025-10-09 16:24:13'),
(7, 'Arnab Ghosh', 'arnab.ghosh@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01978901234', 'B-', 'Male', '1991-09-14', 'House 18, Boalia', 'Rajshahi', 'Rajshahi Division', 1, '2024-11-15', 0, '2025-10-09 16:24:13'),
(8, 'Tabassum Kabir', 'tabassum.kabir@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01589012345', 'AB-', 'Female', '1989-12-05', 'Flat 5C, Banani DOHS', 'Dhaka', 'Dhaka Division', 1, NULL, 0, '2025-10-09 16:24:13'),
(9, 'Abrar Faiyaz', 'abrar.faiyaz@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01690123456', 'O+', 'Male', '1994-04-20', 'House 7, Khan Jahan Ali Road', 'Khulna', 'Khulna Division', 0, NULL, 0, '2025-10-09 16:24:13'),
(10, 'Isha Agerwal', 'isha.agerwal@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01701234567', 'A+', 'Female', '1996-06-08', 'Flat 4D, Gulshan Avenue', 'Dhaka', 'Dhaka Division', 0, NULL, 0, '2025-10-09 16:24:13'),
(11, 'Ahmed khan', 'ahmed.khan@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01812345678', 'B+', 'Male', '1985-01-30', 'House 33, Oxygen Mor', 'Chittagong', 'Chittagong Division', 1, '2024-09-25', 0, '2025-10-09 16:24:13'),
(12, 'Samiha Haque', 'samiha.haque@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01923456789', 'AB+', 'Female', '1992-10-12', 'Plot 15, Mirpur DOHS', 'Dhaka', 'Dhaka Division', 0, NULL, 0, '2025-10-09 16:24:13'),
(13, 'Farhan Kabir', 'farhan.kabir@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01534567890', 'O-', 'Male', '1990-08-17', 'House 22, Zindabazar', 'Sylhet', 'Sylhet Division', 1, '2024-12-20', 0, '2025-10-09 16:24:13'),
(14, 'Nowrin Islam', 'nowrin.islam@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01645678902', 'A-', 'Female', '1993-03-28', 'Flat 6A, Bashundhara R/A', 'Dhaka', 'Dhaka Division', 1, NULL, 0, '2025-10-09 16:24:13'),
(15, 'Imran Khan', 'imran.khan@email.com', '482c811da5d5b4bc6d497ffa98491e38', '01756789013', 'B-', 'Male', '1988-11-09', 'House 11, Natun Bazar', 'Barisal', 'Barisal Division', 0, NULL, 0, '2025-10-09 16:24:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `blood_banks`
--
ALTER TABLE `blood_banks`
  ADD PRIMARY KEY (`blood_bank_id`);

--
-- Indexes for table `blood_donations`
--
ALTER TABLE `blood_donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `blood_orders`
--
ALTER TABLE `blood_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`hospital_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `license_number` (`license_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blood_banks`
--
ALTER TABLE `blood_banks`
  MODIFY `blood_bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blood_donations`
--
ALTER TABLE `blood_donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `blood_orders`
--
ALTER TABLE `blood_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blood_donations`
--
ALTER TABLE `blood_donations`
  ADD CONSTRAINT `blood_donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blood_donations_ibfk_2` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_banks` (`blood_bank_id`) ON DELETE CASCADE;

--
-- Constraints for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD CONSTRAINT `blood_inventory_ibfk_1` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_banks` (`blood_bank_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
