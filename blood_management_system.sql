-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 21, 2024 at 05:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(40) DEFAULT NULL,
  `Admin_Email` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `Admin_Email`, `password`) VALUES
(1, 'admin1', 'admin1@gmail.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `blood_bank`
--

CREATE TABLE `blood_bank` (
  `blood_bank_id` int(11) NOT NULL,
  `location` text DEFAULT NULL,
  `Blood_bank_name` varchar(30) DEFAULT NULL,
  `Blood_bank_contact` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blood_bank`
--

INSERT INTO `blood_bank` (`blood_bank_id`, `location`, `Blood_bank_name`, `Blood_bank_contact`) VALUES
(1, '7/5, Aurongzeb Road, Mohammadpur, Dhaka.', 'Red Crescent Blood Bank', '0155475136');

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE `control` (
  `admin_id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donates_in`
--

CREATE TABLE `donates_in` (
  `user_id` int(11) NOT NULL,
  `blood_bank_id` int(11) NOT NULL,
  `donation_date` date DEFAULT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donates_in`
--

INSERT INTO `donates_in` (`user_id`, `blood_bank_id`, `donation_date`, `unit`) VALUES
(59, 1, '2023-11-05', 1),
(60, 1, '2023-12-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `donor`
--

CREATE TABLE `donor` (
  `D_user_id` int(11) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `medical_condition` text DEFAULT NULL,
  `blood_group` varchar(10) NOT NULL,
  `blood_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donor`
--

INSERT INTO `donor` (`D_user_id`, `age`, `medical_condition`, `blood_group`, `blood_id`) VALUES
(58, 22, 'Null', 'O+', 0),
(59, 23, 'okay', 'B+', 3),
(60, 22, 'good', 'A+', 4);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `message`) VALUES
(1, 'very good'),
(4, 'very bad'),
(5, 'bad reiew'),
(6, 'very well');

-- --------------------------------------------------------

--
-- Table structure for table `gives`
--

CREATE TABLE `gives` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gives`
--

INSERT INTO `gives` (`feedback_id`, `user_id`) VALUES
(1, 59),
(4, 57),
(6, 63);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`hospital_id`, `hospital_name`, `password`, `email`) VALUES
(1, 'Labaid Hospital', '2580', 'labaid@gmail.com'),
(2, 'Evercare Hospital', '0000', 'evercare@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `blood_bank_id` int(11) NOT NULL,
  `hospital_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `P_user_id` int(11) NOT NULL,
  `medicine_list` text DEFAULT NULL,
  `doctor_advices` text DEFAULT NULL,
  `P_hospital_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`P_user_id`, `medicine_list`, `doctor_advices`, `P_hospital_id`) VALUES
(59, 'Kisu na', 'Need enough sleep', 1);

-- --------------------------------------------------------

--
-- Table structure for table `search_in`
--

CREATE TABLE `search_in` (
  `user_id` int(11) NOT NULL,
  `blood_bank_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `search_in`
--

INSERT INTO `search_in` (`user_id`, `blood_bank_id`) VALUES
(59, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `phone_number` char(11) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `blocked` varchar(50) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `phone_number`, `email`, `password`, `address`, `blocked`) VALUES
(57, 'Nazia', 'Mumtahina', '0155486746', 'nazia@gmail.com', '0147', 'Kamlapur', 'NO'),
(58, 'Shafiur', 'Shuvo', '01832255775', 'shuvo@gmail.com', '5678', 'Banasree', 'NO'),
(59, 'Faisal', 'Ahmed', '01245785412', 'gaysal@gmail.com', '6969', 'mirpur', 'NO'),
(60, 'Mamnun', 'Zihad', '01478523698', 'zihad@gmail.com', '2222', 'Rajshahi', 'NO'),
(61, 'Sakib', 'Rayhan', '0191478542', 'sakib@gmail.com', 'saba', 'banasree\r\n', 'yes'),
(62, 'Ariyan', 'Safwat', '01547896541', 'ariyan@gmail.com', '1111', 'Banasree', 'NO'),
(63, 'mahin', 'rahman', '01457895621', 'mahin@gmail.com', '5555', 'banasree', 'NO'),
(64, 'Sneha', 'ENH', '01945368745', 'enh@yahoo.com', 'faisal', 'Mirpur Gram', 'NO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`admin_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `blood_bank`
--
ALTER TABLE `blood_bank`
  ADD PRIMARY KEY (`blood_bank_id`);

--
-- Indexes for table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`admin_id`,`feedback_id`),
  ADD KEY `feedback_id` (`feedback_id`);

--
-- Indexes for table `donates_in`
--
ALTER TABLE `donates_in`
  ADD PRIMARY KEY (`user_id`,`blood_bank_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `donor`
--
ALTER TABLE `donor`
  ADD PRIMARY KEY (`D_user_id`),
  ADD UNIQUE KEY `Blood_id` (`blood_id`),
  ADD UNIQUE KEY `blood_id_2` (`blood_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `gives`
--
ALTER TABLE `gives`
  ADD PRIMARY KEY (`feedback_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`),
  ADD KEY `hospital_id` (`hospital_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`P_user_id`),
  ADD KEY `P_hospital_id` (`P_hospital_id`);

--
-- Indexes for table `search_in`
--
ALTER TABLE `search_in`
  ADD PRIMARY KEY (`user_id`,`blood_bank_id`),
  ADD KEY `blood_bank_id` (`blood_bank_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blood_bank`
--
ALTER TABLE `blood_bank`
  MODIFY `blood_bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `control_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`),
  ADD CONSTRAINT `control_ibfk_2` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`);

--
-- Constraints for table `donates_in`
--
ALTER TABLE `donates_in`
  ADD CONSTRAINT `donates_in_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `donor` (`D_user_id`),
  ADD CONSTRAINT `donates_in_ibfk_2` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_bank` (`blood_bank_id`);

--
-- Constraints for table `donor`
--
ALTER TABLE `donor`
  ADD CONSTRAINT `donor_ibfk_1` FOREIGN KEY (`D_user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `gives`
--
ALTER TABLE `gives`
  ADD CONSTRAINT `gives_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`),
  ADD CONSTRAINT `gives_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_bank` (`blood_bank_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`hospital_id`) REFERENCES `hospital` (`hospital_id`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`P_user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `patient_ibfk_2` FOREIGN KEY (`P_hospital_id`) REFERENCES `hospital` (`hospital_id`);

--
-- Constraints for table `search_in`
--
ALTER TABLE `search_in`
  ADD CONSTRAINT `search_in_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `search_in_ibfk_2` FOREIGN KEY (`blood_bank_id`) REFERENCES `blood_bank` (`blood_bank_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
