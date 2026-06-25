-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 06, 2025 at 08:09 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminlogin`
--

DROP TABLE IF EXISTS `adminlogin`;
CREATE TABLE IF NOT EXISTS `adminlogin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `adminlogin`
--

INSERT INTO `adminlogin` (`id`, `email`, `password`) VALUES
(1, 'a@a.com', 'a1'),
(2, 'b@v.com', 'b1');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `age` int NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `aadhaar` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `aadhaar` (`aadhaar`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `name`, `phone`, `email`, `password`, `address`, `age`, `gender`, `aadhaar`) VALUES
(1, 'Sri Mathi', '90259', 'sri@gmail.com', '123', 'Ashok Nagar', 23, 'Female', '6660'),
(2, 'Venkatesh R', '9025955566', 'qwe@gmail.com', '1234', 'Lal Bahadur Shastri Street', 22, 'Male', '121212121212');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int NOT NULL,
  `question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`) VALUES
(1, 'What are the check-in and check-out times?', 'Check-in is from 2:00 PM, and check-out is until 12:00 PM.'),
(2, 'Do you offer free Wi-Fi?', 'Yes, complimentary high-speed Wi-Fi is available throughout the hotel.'),
(3, 'Is breakfast included in the booking?', 'It depends on the package you choose. Some rates include breakfast, while others do not.'),
(5, 'Is parking available?\r\n', 'Yes, we offer free parking for all guests.\r\n'),
(6, 'What is your cancellation policy?', 'Cancellation policies vary. Please check your booking confirmation for details.'),
(8, 'Are pets allowed in the hotel?', 'Yes, we allow pets in designated rooms.\r\n'),
(9, 'Do you provide airport shuttle service?', 'Yes, we offer airport shuttle service for free. Please contact the front desk to arrange transportation.'),
(10, 'Is there a swimming pool available?', 'Yes, we have an outdoor swimming pool that is open from 7:00 AM to 10:00 PM.'),
(11, 'Do you have a fitness center or gym?', 'Yes, we have a fully equipped fitness center available for guests, open 24/7.'),
(12, 'What payment methods do you accept?', 'We accept cash, credit/debit cards, and digital wallets.'),
(14, 'Do you offer room service?', 'Yes, room service is available 24/7 with a variety of dining options.'),
(15, 'Are there conference or meeting rooms available?', 'Yes, we have conference and meeting rooms available. Please contact our reservations team for booking details.'),
(16, 'Do you offer laundry services?', 'Yes, we provide laundry and dry-cleaning services for guests. Additional charges apply.'),
(17, 'Is there a restaurant in the hotel?', 'Yes, we have an on-site restaurant that serves breakfast, lunch, and dinner.'),
(18, 'Is there a spa or wellness center?', 'Yes, we have a spa offering massages and wellness treatments.'),
(19, 'Can I modify my booking after confirmation?', 'Yes, you can modify your booking depending on availability. Please contact our support team for changes.\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `checkin_date` date NOT NULL,
  `checkout_date` date NOT NULL,
  `adults` int NOT NULL,
  `children` int NOT NULL,
  `room_type_description` varchar(50) NOT NULL,
  `room_type_cost` int NOT NULL,
  `bedding_type_description` varchar(50) NOT NULL,
  `bedding_type_cost` int NOT NULL,
  `total_cost` decimal(10,2) NOT NULL,
  `initial_payment` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`reservation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_id`, `checkin_date`, `checkout_date`, `adults`, `children`, `room_type_description`, `room_type_cost`, `bedding_type_description`, `bedding_type_cost`, `total_cost`, `initial_payment`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, '2025-03-24', '2025-03-31', 2, 1, 'Executive Suite', 7500, 'Double Bed', 1500, 9000.00, 4050.00, 'Credit Card', 'Checked-out', '2025-03-23 14:23:16', '2025-03-23 14:24:14'),
(3, 2, '2025-04-10', '2025-05-30', 2, 1, 'Grand Luxury', 8500, 'King Size', 2500, 11000.00, 4950.00, 'Credit Card', 'Checked-in', '2025-04-05 16:29:43', '2025-04-05 16:55:00'),
(4, 2, '2025-04-17', '2025-04-30', 1, 1, 'Executive Suite', 7500, 'Double Bed', 1500, 9000.00, 4050.00, 'Credit Card', 'Pending', '2025-04-05 16:36:47', '2025-04-05 16:36:47'),
(5, 2, '2025-04-19', '2025-05-01', 1, 1, 'Grand Luxury', 8500, 'Single Bed', 500, 9000.00, 4050.00, 'Credit Card', 'Pending', '2025-04-05 16:39:08', '2025-04-05 16:39:08'),
(6, 2, '2025-04-19', '2025-05-29', 1, 1, 'Deluxe Room', 3500, 'King Size', 2500, 6000.00, 2700.00, 'Credit Card', 'Pending', '2025-04-05 16:39:52', '2025-04-05 16:39:52'),
(7, 2, '2025-04-19', '2025-05-02', 1, 1, 'Superior Room', 5000, 'Single Bed', 500, 5500.00, 2475.00, 'UPI', 'Checked-out', '2025-04-05 16:42:47', '2025-04-05 17:03:20'),
(8, 2, '2025-04-12', '2025-04-29', 2, 0, 'Superior Room', 5000, 'Single Bed', 500, 5500.00, 2475.00, 'UPI', 'Pending', '2025-04-05 16:50:47', '2025-04-05 16:50:47'),
(9, 2, '2025-04-12', '2025-05-01', 1, 0, 'Executive Suite', 7500, 'Single Bed', 500, 152000.00, 68400.00, 'Credit Card', 'Pending', '2025-04-05 16:53:18', '2025-04-05 16:53:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
