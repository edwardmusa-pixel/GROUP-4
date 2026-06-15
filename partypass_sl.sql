-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2026 at 10:56 AM
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
-- Database: `partypass_sl`
--

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` enum('SOUND','LIGHTING','SEATING','POWER','STAGE','DECOR') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `location` text DEFAULT NULL,
  `poster_url` varchar(255) DEFAULT 'default.jpg',
  `poster` varchar(255) DEFAULT NULL,
  `status` enum('DRAFT','PUBLISHED','CANCELLED') DEFAULT 'DRAFT',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `capacity` int(11) DEFAULT 100,
  `price` decimal(10,2) DEFAULT 0.00,
  `event_time` time DEFAULT '20:00:00',
  `event_image` varchar(255) DEFAULT 'default_event.jpg',
  `price_vip` decimal(10,2) DEFAULT 0.00,
  `price_vvip` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `organizer_id`, `title`, `description`, `event_date`, `start_time`, `end_time`, `location`, `poster_url`, `poster`, `status`, `created_at`, `capacity`, `price`, `event_time`, `event_image`, `price_vip`, `price_vvip`) VALUES
(1, 18, 'Gbamgbaode', 'enjoy the Oblee sesaon with us this February 🎉 ', '2026-02-14', NULL, NULL, 'sugar land beach', 'default.jpg', NULL, 'DRAFT', '2026-02-02 13:13:06', 100, 0.00, '20:00:00', '1770037986_images (6).jpeg', 0.00, 0.00),
(2, 17, 'Ma-Dengn', 'its the Halloween 🦇 season', '2026-03-31', NULL, NULL, 'Radisson blu garden', 'default.jpg', NULL, 'DRAFT', '2026-02-02 13:17:21', 100, 0.00, '20:00:00', '1770038241_85f694e3.jpeg', 0.00, 0.00),
(3, 19, 'Kissy Pikin Outing', 'Korondo kissy', '2026-04-18', NULL, NULL, 'Beach cafe', 'default.jpg', NULL, 'DRAFT', '2026-02-02 14:56:35', 100, 0.00, '20:00:00', '1770044195_8bee580f.webp', 0.00, 0.00),
(4, 23, 'Kojuma-koju', 'see me are see u', '2026-11-21', NULL, NULL, 'sugar land beach', 'default.jpg', NULL, 'DRAFT', '2026-02-02 14:58:29', 100, 0.00, '20:00:00', '1770044309_4bd8b414.jpeg', 0.00, 0.00),
(5, 21, 'Eco-Fest', 'celebrating culture ', '2026-12-26', NULL, NULL, 'Beach cafe', 'default.jpg', NULL, 'DRAFT', '2026-02-02 15:00:42', 100, 0.00, '20:00:00', '1770044442_9ada7455.jpeg', 0.00, 0.00),
(10, 27, 'One Nation Reggae festival', 'in collaboration with the ministry of tourism to celebrate the sweetness of sierra leone culture', '2026-04-27', NULL, NULL, 'Radisson blu garden', 'default.jpg', NULL, 'DRAFT', '2026-02-02 15:18:36', 100, 0.00, '20:00:00', '1770045516_f0bba05a.jpeg', 0.00, 0.00),
(11, 30, 'Food Fest 6.0', 'celebrating the flavor of Sierra leone food 🍲 ', '2026-12-13', NULL, NULL, 'Radisson blu garden', 'default.jpg', NULL, 'DRAFT', '2026-02-04 12:36:29', 100, 0.00, '20:00:00', '1770208589_ac158842.jpeg', 0.00, 0.00),
(12, 18, 'Bottomless  Brunch ', 'Bring and Grill', '2026-02-13', NULL, NULL, 'Beach cafe', 'default.jpg', NULL, 'DRAFT', '2026-02-04 12:38:48', 100, 0.00, '20:00:00', '1770208728_a9141dd8.jpeg', 0.00, 0.00),
(13, 18, 'Adop Fest', 'nar for Adop man them', '2026-02-26', NULL, NULL, 'Beach cafe', 'default.jpg', NULL, 'DRAFT', '2026-02-04 21:04:42', 100, 0.00, '20:00:00', '1770239082_8bf6f0b5.jpeg', 0.00, 0.00),
(14, 19, 'Street carnival', 'epic', '2026-02-28', NULL, NULL, 'Bus station junction', 'default.jpg', NULL, 'DRAFT', '2026-02-05 02:29:57', 100, 0.00, '20:00:00', '1770258597_38b99458.png', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `event_performers`
--

CREATE TABLE `event_performers` (
  `performer_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `performer_name` varchar(255) DEFAULT NULL,
  `performer_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_prices`
--

CREATE TABLE `event_prices` (
  `price_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `ticket_type` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizers`
--

CREATE TABLE `organizers` (
  `organizer_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `business_address` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `verification_status` enum('PENDING','APPROVED','REJECTED') DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `organizers`
--

INSERT INTO `organizers` (`organizer_id`, `company_name`, `business_address`, `bio`, `user_id`, `brand_name`, `description`, `logo`, `verification_status`) VALUES
(13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING'),
(17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING'),
(18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING'),
(19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING'),
(21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING'),
(23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `price_paid` decimal(10,2) DEFAULT 0.00,
  `transaction_id` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'completed',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `amount`, `reference`, `price_paid`, `transaction_id`, `status`, `payment_date`, `event_id`) VALUES
(28, 17, 700.00, 'PP-70429', 0.00, 'TXN-177003845492DD', 'PENDING', '2026-02-02 13:20:54', 2),
(29, 17, 1000.00, 'PP-98103', 0.00, 'TXN-1770038802104F', 'PENDING', '2026-02-02 13:26:42', 2),
(30, 17, 1000.00, 'PP-48135', 0.00, 'TXN-177003906972CE', 'COMPLETED', '2026-02-02 13:31:09', 2),
(31, 1, 2300.00, 'PP-55099', 0.00, 'TXN-1770039362851D', 'COMPLETED', '2026-02-02 13:36:02', 1),
(32, 1, 700.00, 'PP-86694', 0.00, 'TXN-1770045611472E', 'COMPLETED', '2026-02-02 15:20:11', 10);

-- --------------------------------------------------------

--
-- Table structure for table `platform_settings`
--

CREATE TABLE `platform_settings` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `platform_settings`
--

INSERT INTO `platform_settings` (`setting_key`, `setting_value`) VALUES
('currency_code', 'SLE'),
('ticket_commission_percent', '5'),
('venue_commission_percent', '10');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(3, 'Attendee'),
(5, 'EquipmentVendor'),
(2, 'Organizer'),
(4, 'VenueOwner');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_code` varchar(100) NOT NULL,
  `status` enum('valid','used','cancelled') DEFAULT 'valid',
  `purchase_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `scanned_at` datetime DEFAULT NULL,
  `price_paid` decimal(10,2) DEFAULT 0.00,
  `customer_name` varchar(255) DEFAULT NULL,
  `ticket_type` varchar(50) DEFAULT 'regular'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `user_id`, `event_id`, `ticket_code`, `status`, `purchase_date`, `created_at`, `scanned_at`, `price_paid`, `customer_name`, `ticket_type`) VALUES
(26, 17, 2, 'TIX-9DE7BDC2', 'valid', '2026-02-02 13:20:54', '2026-02-02 13:20:54', NULL, 700.00, NULL, 'regular'),
(27, 17, 2, 'TIX-B64751A1', 'valid', '2026-02-02 13:26:42', '2026-02-02 13:26:42', NULL, 1000.00, NULL, 'regular'),
(28, 17, 2, 'TIX-8321CDBC', 'valid', '2026-02-02 13:31:09', '2026-02-02 13:31:09', NULL, 1000.00, NULL, 'VVIP Access'),
(29, 1, 1, 'TIX-10208B72', 'valid', '2026-02-02 13:36:02', '2026-02-02 13:36:02', NULL, 2300.00, NULL, 'VIP Access'),
(30, 1, 10, 'TIX-99512706', 'valid', '2026-02-02 15:20:11', '2026-02-02 15:20:11', NULL, 700.00, NULL, 'VIP Access'),
(31, 26, 14, 'TIX-A9F5FB17', '', '2026-06-15 06:12:44', '2026-06-15 06:12:44', NULL, 0.00, NULL, 'REGULAR ACCESS'),
(32, 26, 14, 'TIX-D5C594BD', '', '2026-06-15 06:14:31', '2026-06-15 06:14:31', NULL, 0.00, NULL, 'REGULAR ACCESS'),
(33, 26, 14, 'TIX-12D49E49', 'valid', '2026-06-15 06:17:33', '2026-06-15 06:17:33', NULL, 0.00, NULL, 'REGULAR ACCESS');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_categories`
--

CREATE TABLE `ticket_categories` (
  `category_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `category_name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_payments`
--

CREATE TABLE `ticket_payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reference_code` varchar(10) NOT NULL,
  `amount_expected` decimal(10,2) NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('PENDING','SUCCESS','FAILED') DEFAULT 'PENDING',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `ticket_type_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity_available` int(11) DEFAULT NULL,
  `total_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_types`
--

INSERT INTO `ticket_types` (`ticket_type_id`, `event_id`, `name`, `price`, `quantity_available`, `total_capacity`) VALUES
(1, 1, 'Regular Access', 1000.00, 500, 500),
(2, 1, 'VIP Access', 2300.00, 100, 100),
(3, 1, 'VVIP Access', 7000.00, 50, 50),
(4, 2, 'Regular Access', 300.00, 500, 500),
(5, 2, 'VIP Access', 700.00, 100, 100),
(6, 2, 'VVIP Access', 1000.00, 50, 50),
(7, 3, 'Regular Access', 150.00, 500, 500),
(8, 3, 'VIP Access', 300.00, 100, 100),
(9, 3, 'VVIP Access', 500.00, 50, 50),
(10, 4, 'Regular Access', 150.00, 500, 500),
(11, 4, 'VIP Access', 300.00, 100, 100),
(12, 4, 'VVIP Access', 500.00, 50, 50),
(13, 5, 'Regular Access', 300.00, 500, 500),
(14, 5, 'VIP Access', 700.00, 100, 100),
(15, 5, 'VVIP Access', 1500.00, 50, 50),
(16, 10, 'Regular Access', 300.00, 500, 500),
(17, 10, 'VIP Access', 700.00, 100, 100),
(18, 10, 'VVIP Access', 1000.00, 50, 50),
(19, 11, 'Regular Access', 150.00, 500, 500),
(20, 11, 'VIP Access', 300.00, 100, 100),
(21, 11, 'VVIP Access', 500.00, 50, 50),
(22, 12, 'Regular Access', 100.00, 500, 500),
(23, 12, 'VIP Access', 250.00, 100, 100),
(24, 12, 'VVIP Access', 500.00, 50, 50),
(25, 13, 'Regular Access', 5.00, 500, 500),
(26, 13, 'VIP Access', 10.00, 100, 100),
(27, 13, 'VVIP Access', 15.00, 50, 50),
(28, 14, 'Regular Access', 1.00, 500, 500),
(29, 14, 'VIP Access', 2.00, 100, 100),
(30, 14, 'VVIP Access', 3.00, 50, 50);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `available_balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `full_name`, `email`, `phone`, `password_hash`, `is_verified`, `created_at`, `available_balance`) VALUES
(1, 1, 'EDWARD SAHR MUSA', 'musaedwardsahr@gmail.com', '', '$2y$10$FCDXIQsdCf3LTCI7GtINo.9gAHmDaprcQ07iLJ06qQKM/rSk68pIG', 1, '2026-01-10 10:08:04', 0.00),
(11, 3, 'Tangase', 'tangase@gmail.com', '+23234867344', '$2y$10$/l.jKDFbeguJASbZTitIh..DTOJ8AoPGsgqZNUIdVpCqyyWPLKAtW', 1, '2026-01-10 12:16:05', 0.00),
(12, 3, 'Iphone fest', 'iphone@gmail.com', '+23211111111', '$2y$10$JWju3VeUuBQ0V3yfCXIRCubi/xZ/d8mxPGNr4xv6NvaszfzE1oNSa', 1, '2026-01-10 12:40:06', 0.00),
(13, 3, 'Party Pass', 'party@gmail.com', '+232121212', '$2y$10$q0KibzY6VxE7xI2YtkDc7ublilcEmyJWNbMXrbUk2GGMdageZWzOq', 1, '2026-01-10 14:04:44', 0.00),
(15, 2, 'EDWARD SAHR MUSA', 'edwardsahr@gmail.com', '+23234867345', '$2y$10$ZCmZliVobfV0R7nN1R9ese2/azS3igz.zcLhzeDoCDV.o/2vHrdKG', 1, '2026-01-10 17:51:57', 0.00),
(17, 3, 'Ma-Dengn', 'madengn@gmail.com', '+23234867343', '$2y$10$hQ5AU/W.0lHMsnMNRbYUtOIa5V1CJulLtg2aNPpt2p4FoqzVZz87O', 1, '2026-01-10 22:31:06', 0.00),
(18, 3, 'Gbam Gbaode', 'GbamGbaode@gmail.com', '+23234867342', '$2y$10$Ae8720SvqG54VzvwJ.S.YOrKhnVI1RKCMtTu9vYRP.8T28mxqQ0BK', 1, '2026-01-10 22:34:47', 0.00),
(19, 3, 'kissy pikin', 'kissy@gmail.com', '+23234867341', '$2y$10$HPZgIAPb3gAf.N4iUAww7eya/bmSzE1Lw9/GDJ88bL4r6j8U8nNZa', 1, '2026-01-10 22:36:13', 0.00),
(21, 3, 'Eco-fest', 'eco@gmail.com', '+23234867339', '$2y$10$ZMn6vM.ybr4JjlXRPleh1.TuDwzLyRyGy9hbF.CBDgE501yih1FgS', 1, '2026-01-10 22:38:08', 0.00),
(22, 3, 'chapter 1', 'chapter1@gmail.com', '+23234867338', '$2y$10$v6RjzOf2CpQtmR7O9YxY9.YcsHtuag.VJs58hWHHghZ5FwC2y./HO', 1, '2026-01-10 22:39:19', 0.00),
(23, 3, 'Kojuma-Koju', 'kojuma@gmail.com', '+23234867337', '$2y$10$Vwfi6OAgmiw/gRfFo7cEteFOsiB0K6QjNfgzzvme0T05Cl.GUPHuu', 1, '2026-01-10 22:40:30', 0.00),
(25, 2, 'Favour Bendu', 'favour@gmail.com', '+2329999999', '$2y$10$NvdqRt4R5bxmZnYCr8xnAuHNTqY5yqYw2UoxwAxG3EtNaEA3/cQ8m', 1, '2026-01-21 10:28:44', 0.00),
(26, 2, 'bai', 'bai@gmail.com', '+23289898989', '$2y$10$X4JmLFRJraBs8vNU8jvuRep2NgwzeyfHynrsHnSikV73LFtK3mynS', 1, '2026-01-21 13:07:44', 0.00),
(27, 3, 'One Nation Festival', 'one@gmail.com', '+23234000090', '$2y$10$ScvfTrspEjvO.KUCLh6DGeEFY4xcSQ8aMGVSXiHYl5SlKCMBAJaQW', 1, '2026-02-02 15:02:23', 0.00),
(28, 3, 'Jakes', 'jakes@gmail.com', '+23280203537', '$2y$10$f5Q9C40HnrA2xnkvw4/dnuUDv6U.J3rwwKFNo1daQM/PiSGgU4D1u', 1, '2026-02-03 11:01:50', 0.00),
(29, 3, 'Georgia', 'georg@gmail.com', '+23280658559', '$2y$10$1SHrIDn1r1N091ZjR1xmeOcmnIZffPFh41YztXAa/o4ReYy06KV6K', 1, '2026-02-03 11:09:13', 0.00),
(30, 3, 'Food fest', 'food@gmail.com', '+23273676576', '$2y$10$ujULi2QhZH/6m4dWy6RXGuZ5Lb/p9oeQPSxYAsRgnnBSziiFnwr9O', 1, '2026-02-04 12:33:04', 0.00),
(31, 2, 'mickey', 'mickey@gmail.com', '+23234190784', '$2y$10$ho2DAbgTRw5fsoJezqm9ZORqJPeW7JNgGgvvtovA1G9jgZzbCosUK', 1, '2026-02-04 20:57:21', 0.00),
(32, 2, 'test', 'test@gmail.com', '+23234867340', '$2y$10$B3kAqTWSezRdCqGYTXj5E.c3gIj42QLrTkrVSNf5ZIjLCphczCkZ2', 1, '2026-06-10 21:35:47', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `venues`
--

CREATE TABLE `venues` (
  `venue_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `price_per_day` decimal(10,2) DEFAULT NULL,
  `amenities` text DEFAULT NULL,
  `status` enum('AVAILABLE','UNAVAILABLE') DEFAULT 'AVAILABLE',
  `price_per_night` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venue_bookings`
--

CREATE TABLE `venue_bookings` (
  `booking_id` int(11) NOT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `organizer_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `status` enum('PENDING','APPROVED','CANCELLED') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `fk_organizer_to_users` (`organizer_id`);

--
-- Indexes for table `event_performers`
--
ALTER TABLE `event_performers`
  ADD PRIMARY KEY (`performer_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `event_prices`
--
ALTER TABLE `event_prices`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organizers`
--
ALTER TABLE `organizers`
  ADD PRIMARY KEY (`organizer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `platform_settings`
--
ALTER TABLE `platform_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD UNIQUE KEY `ticket_code` (`ticket_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ticket_payments`
--
ALTER TABLE `ticket_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD UNIQUE KEY `reference_code` (`reference_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`ticket_type_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `venues`
--
ALTER TABLE `venues`
  ADD PRIMARY KEY (`venue_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `venue_bookings`
--
ALTER TABLE `venue_bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `venue_id` (`venue_id`,`booking_date`,`status`),
  ADD KEY `organizer_id` (`organizer_id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `event_performers`
--
ALTER TABLE `event_performers`
  MODIFY `performer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_prices`
--
ALTER TABLE `event_prices`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizers`
--
ALTER TABLE `organizers`
  MODIFY `organizer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ticket_payments`
--
ALTER TABLE `ticket_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `ticket_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `venues`
--
ALTER TABLE `venues`
  MODIFY `venue_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `venue_bookings`
--
ALTER TABLE `venue_bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_user_fk` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_organizer_to_users` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_performers`
--
ALTER TABLE `event_performers`
  ADD CONSTRAINT `event_performers_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_prices`
--
ALTER TABLE `event_prices`
  ADD CONSTRAINT `event_prices_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `organizers`
--
ALTER TABLE `organizers`
  ADD CONSTRAINT `organizers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_categories`
--
ALTER TABLE `ticket_categories`
  ADD CONSTRAINT `ticket_categories_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `ticket_payments`
--
ALTER TABLE `ticket_payments`
  ADD CONSTRAINT `ticket_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD CONSTRAINT `ticket_types_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `venues`
--
ALTER TABLE `venues`
  ADD CONSTRAINT `venues_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `venue_bookings`
--
ALTER TABLE `venue_bookings`
  ADD CONSTRAINT `venue_bookings_ibfk_1` FOREIGN KEY (`venue_id`) REFERENCES `venues` (`venue_id`),
  ADD CONSTRAINT `venue_bookings_ibfk_2` FOREIGN KEY (`organizer_id`) REFERENCES `organizers` (`organizer_id`),
  ADD CONSTRAINT `venue_bookings_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
