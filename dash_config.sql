-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2024 at 02:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems_mm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dash_config_a1`
--

CREATE TABLE `dash_config_a1` (
  `_id` int(11) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `caption` varchar(50) DEFAULT NULL,
  `page_num` int(1) DEFAULT NULL,
  `card_num` int(1) NOT NULL,
  `remark` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dash_config_a1`
--

INSERT INTO `dash_config_a1` (`_id`, `key`, `caption`, `page_num`, `card_num`, `remark`) VALUES
(6, 'LIFT', 'PM LIFT', 1, 1, NULL),
(7, 'Penerangan Dan Stop Kontak', 'PM PENERANGAN & STOP KONTAK', 1, 1, NULL),
(8, 'Elektronik', 'PM ELEKTRONIK', 1, 1, NULL),
(9, 'Tata Udara', 'PM TATA UDARA', 1, 1, NULL),
(10, 'Tata Air', 'PM TATA AIR', 1, 1, NULL),
(11, 'Komputer', 'PM KOMPUTER', 1, 1, NULL),
(12, 'LIFT', 'PM LIFT', 1, 2, NULL),
(13, 'Penerangan', 'PM PENERANGAN & STOP KONTAK', 1, 2, NULL),
(14, 'Elektronik', 'PM ELEKTRONIK', 1, 2, NULL),
(15, 'Tata Udara', 'PM TATA UDARA', 1, 2, NULL),
(16, 'Tata Air', 'PM TATA AIR', 1, 2, NULL),
(17, 'Komputer', 'PM KOMPUTER', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dash_config_a2`
--

CREATE TABLE `dash_config_a2` (
  `_id` int(11) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `caption` varchar(50) DEFAULT NULL,
  `page_num` int(1) DEFAULT NULL,
  `card_num` int(1) NOT NULL,
  `remark` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dash_config_a2`
--

INSERT INTO `dash_config_a2` (`_id`, `key`, `caption`, `page_num`, `card_num`, `remark`) VALUES
(6, 'LIFT', 'PM LIFT', 1, 1, NULL),
(7, 'Penerangan Dan Stop Kontak', 'PM PENERANGAN & STOP KONTAK', 1, 1, NULL),
(8, 'Elektronik', 'PM ELEKTRONIK', 1, 1, NULL),
(9, 'Tata Udara', 'PM TATA UDARA', 1, 1, NULL),
(10, 'Tata Air', 'PM TATA AIR', 1, 1, NULL),
(11, 'Komputer', 'PM KOMPUTER', 1, 1, NULL),
(12, 'LIFT', 'PM LIFT', 1, 2, NULL),
(13, 'Penerangan', 'PM PENERANGAN & STOP KONTAK', 1, 2, NULL),
(14, 'Elektronik', 'PM ELEKTRONIK', 1, 2, NULL),
(15, 'Tata Udara', 'PM TATA UDARA', 1, 2, NULL),
(16, 'Tata Air', 'PM TATA AIR', 1, 2, NULL),
(17, 'Komputer', 'PM KOMPUTER', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dash_config_mm`
--

CREATE TABLE `dash_config_mm` (
  `_id` int(11) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `caption` varchar(50) DEFAULT NULL,
  `page_num` int(1) DEFAULT NULL,
  `card_num` int(1) NOT NULL,
  `remark` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dash_config_mm`
--

INSERT INTO `dash_config_mm` (`_id`, `key`, `caption`, `page_num`, `card_num`, `remark`) VALUES
(6, 'LIFT', 'PM LIFT', 1, 1, NULL),
(7, 'Penerangan Dan Stop Kontak', 'PM PENERANGAN & STOP KONTAK', 1, 1, NULL),
(8, 'Elektronik', 'PM ELEKTRONIK', 1, 1, NULL),
(9, 'Tata Udara', 'PM TATA UDARA', 1, 1, NULL),
(10, 'Tata Air', 'PM TATA AIR', 1, 1, NULL),
(12, 'LIFT', 'PM LIFT', 1, 2, NULL),
(13, 'Penerangan', 'PM PENERANGAN & STOP KONTAK', 1, 2, NULL),
(14, 'Elektronik', 'PM ELEKTRONIK', 1, 2, NULL),
(15, 'Tata Udara', 'PM TATA UDARA', 1, 2, NULL),
(16, 'Tata Air', 'PM TATA AIR', 1, 2, NULL),
(17, 'Komputer', 'PM KOMPUTER', 1, 2, NULL),
(18, 'LVMDP C1', 'PANEL UTAMA 1 (LVMDP C1)', 2, 4, NULL),
(19, 'LVMDP C2', 'PANEL UTAMA 2 (LVMDP C2)', 2, 4, NULL),
(20, 'LVMDP 28', 'PANEL UTAMA 3 (LVMDP 28)', 2, 4, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dash_config_a1`
--
ALTER TABLE `dash_config_a1`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `key` (`key`);

--
-- Indexes for table `dash_config_a2`
--
ALTER TABLE `dash_config_a2`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `key` (`key`);

--
-- Indexes for table `dash_config_mm`
--
ALTER TABLE `dash_config_mm`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `key` (`key`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dash_config_a1`
--
ALTER TABLE `dash_config_a1`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dash_config_a2`
--
ALTER TABLE `dash_config_a2`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `dash_config_mm`
--
ALTER TABLE `dash_config_mm`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
