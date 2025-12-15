-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 15, 2025 at 02:10 PM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

DROP TABLE IF EXISTS `alerts`;
CREATE TABLE IF NOT EXISTS `alerts` (
  `id_alerts` int NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `disease_detected` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_date` date NOT NULL,
  `agent_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_alerts`),
  KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id_alerts`, `donor_name`, `disease_detected`, `appointment_date`, `agent_id`, `created_at`) VALUES
(1, 'Donor A', 'Hepatitis B', '2025-11-28', 3, '2025-11-26 05:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `associations`
--

DROP TABLE IF EXISTS `associations`;
CREATE TABLE IF NOT EXISTS `associations` (
  `id_associations` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_associations`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cts_centers`
--

DROP TABLE IF EXISTS `cts_centers`;
CREATE TABLE IF NOT EXISTS `cts_centers` (
  `id_cts_centers` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cts_centers`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

DROP TABLE IF EXISTS `diseases`;
CREATE TABLE IF NOT EXISTS `diseases` (
  `id_diseases` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_users` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_diseases`),
  KEY `id_users` (`id_users`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

DROP TABLE IF EXISTS `donations`;
CREATE TABLE IF NOT EXISTS `donations` (
  `id_donations` int NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `donation_type` enum('targeted','universal') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recipient_dob` date DEFAULT NULL,
  `recipient_chu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agent_id` int NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_donations`),
  KEY `agent_id` (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id_donations`, `donor_name`, `donation_type`, `recipient_name`, `recipient_dob`, `recipient_chu`, `agent_id`, `created_at`) VALUES
(1, 'Donor A', 'targeted', 'Recipient X', '1990-05-12', 'CHU Mostaganem', 3, '2025-11-26 05:16:23'),
(2, 'Donor B', 'universal', NULL, NULL, NULL, 3, '2025-11-26 05:16:23'),
(3, 'Donor C', 'universal', NULL, NULL, NULL, 4, '2025-11-26 05:16:23');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE IF NOT EXISTS `donors` (
  `id_donors` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `blood_type` enum('A','B','AB','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rhesus_factor` enum('+','-') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `donation_type` enum('blood','platelet') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_donors`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`id_donors`, `full_name`, `date_of_birth`, `blood_type`, `rhesus_factor`, `address`, `phone`, `donation_type`, `created_at`) VALUES
(1, 'Layachi Oualid', '2025-11-26', 'O', '+', 'A houriya,Mostaganem,Algeria', '0712345678', 'blood', '2025-11-26 23:46:43');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

DROP TABLE IF EXISTS `partners`;
CREATE TABLE IF NOT EXISTS `partners` (
  `id_partners` int NOT NULL AUTO_INCREMENT,
  `name_partners` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email_partners` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_partners` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manager_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_partners`),
  KEY `manager_id` (`manager_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipients`
--

DROP TABLE IF EXISTS `recipients`;
CREATE TABLE IF NOT EXISTS `recipients` (
  `id_recipients` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `chu_department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_donations` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_recipients`),
  KEY `id_donations` (`id_donations`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_users` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','manager','agent') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','disabled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `email_verified` tinyint(1) DEFAULT '0',
  `reset_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_users`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `email_2` (`email`),
  KEY `status` (`status`),
  KEY `role` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_users`, `username`, `password`, `email`, `phone`, `full_name`, `profile_picture`, `role`, `status`, `email_verified`, `reset_token`, `reset_token_expires`, `last_login`, `created_by`, `updated_by`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'admin', '$2y$10$ol0.Ai8K0Ju0EpQkV2hwO.3aNX/Lmz6u7lH71EUDixraAx1uDMRqu', 'haidra.mohamed04@gmail.com', '0555323456', 'Haidra Mohamed', 'Image/user1.png', 'admin', 'active', 1, 'f464d4f897efd16f7f2433cddfa4e62c5469f0f77ce412a6fb3f32eba89c38b9', '2025-12-11 17:38:29', '2025-12-15 12:50:37', NULL, NULL, '2025-11-26 05:05:12', '2025-12-15 12:50:37', 0),
(2, 'manager', '$2y$10$zcO0FEb54rT/TSRqMpOEyu7UeDkBdpsYarXdSm4Cb/7ZlKM3iS1Qm', 'manager@gmail.com', '07777777777', 'manager manager', NULL, 'manager', 'active', 1, NULL, NULL, '2025-12-15 14:57:41', NULL, NULL, '2025-11-26 05:05:12', '2025-12-15 14:57:41', 0),
(3, 'agent', '$2y$10$QE0/mT4w5Q8MU3W27n29eefhLjMR2tTNwHH59McajqrM0kEL3Pp/C', 'agent@gmail.com', '0666666666', 'agent 47', NULL, 'agent', 'active', 1, NULL, NULL, '2025-12-15 12:51:43', NULL, NULL, '2025-11-26 05:05:12', '2025-12-15 12:51:43', 0),
(4, 'agent2', '$2y$10$LHnP3wUYcUvX3jwwDX2wAOopQCjBnrdwGA2IIabIhH2XrrzKoUA3q', 'oualid.walid16@gmail.com', '0666666666', 'agent 47', NULL, 'agent', 'active', 1, 'f968f9e637454e706a97b8acdadfe882e7dba71f4899a4d46ec73f591552a221', '2025-12-15 11:28:45', '2025-12-10 23:29:38', 1, NULL, '2025-11-26 05:05:12', '2025-12-15 10:28:45', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `associations`
--
ALTER TABLE `associations`
  ADD CONSTRAINT `associations_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `cts_centers`
--
ALTER TABLE `cts_centers`
  ADD CONSTRAINT `cts_centers_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `diseases`
--
ALTER TABLE `diseases`
  ADD CONSTRAINT `diseases_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id_users`);

--
-- Constraints for table `recipients`
--
ALTER TABLE `recipients`
  ADD CONSTRAINT `recipients_ibfk_1` FOREIGN KEY (`id_donations`) REFERENCES `donations` (`id_donations`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
