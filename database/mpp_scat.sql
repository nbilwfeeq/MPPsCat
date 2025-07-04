-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2024 at 07:53 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mpp_scat`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id_payment` int(12) NOT NULL,
  `id_reservation` int(12) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nama_penuh` varchar(200) NOT NULL,
  `nokp` varchar(200) NOT NULL,
  `notel` varchar(200) NOT NULL,
  `total_prices` decimal(10,2) NOT NULL,
  `payment_proof` varchar(200) DEFAULT NULL,
  `payment_type` varchar(20) NOT NULL,
  `status_payment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id_payment`, `id_reservation`, `email`, `nama_penuh`, `nokp`, `notel`, `total_prices`, `payment_proof`, `payment_type`, `status_payment`) VALUES
(38, 73, 'izzathazri@gmail.com', 'IZZAT HAZRI BIN HADFI', '051121011663', '0131234567', '0.30', NULL, 'CASH', '1'),
(39, 74, 'izzathazri@gmail.com', 'IZZAT HAZRI BIN HADFI', '051121011663', '0131234567', '2.10', NULL, 'CASH', '1'),
(40, 75, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', '0.10', 'proof_1731334413.jpg', 'TNG', '1'),
(41, 76, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', '0.20', NULL, 'CASH', '1'),
(42, 77, 'amirhanbola@gmail.com', 'MOHAMAD AMIR HANAFIAH BIN AFNIZANIZAM', '051011120797', '0133286664', '0.40', NULL, 'CASH', '1'),
(43, 78, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', '0.30', NULL, 'CASH', '1');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(12) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nama_penuh` varchar(200) NOT NULL,
  `nokp` varchar(200) NOT NULL,
  `notel` varchar(200) NOT NULL,
  `reserve_date` date NOT NULL DEFAULT current_timestamp(),
  `reserve_time` time NOT NULL DEFAULT current_timestamp(),
  `file` varchar(200) NOT NULL,
  `colored_pages` varchar(200) NOT NULL,
  `bw_pages` varchar(200) NOT NULL,
  `total_pages` varchar(200) NOT NULL,
  `total_prices` decimal(10,2) NOT NULL,
  `status_tempahan` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `email`, `nama_penuh`, `nokp`, `notel`, `reserve_date`, `reserve_time`, `file`, `colored_pages`, `bw_pages`, `total_pages`, `total_prices`, `status_tempahan`) VALUES
(73, 'izzathazri@gmail.com', 'IZZAT HAZRI BIN HADFI', '051121011663', '0131234567', '2024-11-11', '22:11:39', '../uploads/6732109bc45a93.59113860.pdf', '1', '1', '2', '0.30', 1),
(74, 'izzathazri@gmail.com', 'IZZAT HAZRI BIN HADFI', '051121011663', '0131234567', '2024-11-11', '22:12:18', '../uploads/673210c240a266.61234331.pdf', '1', '19', '20', '2.10', 1),
(76, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', '2024-11-11', '22:14:02', '../uploads/6732112ae334a8.57267874.jpg', '1', '0', '1', '0.20', 2),
(77, 'amirhanbola@gmail.com', 'MOHAMAD AMIR HANAFIAH BIN AFNIZANIZAM', '051011120797', '0133286664', '2024-11-12', '08:55:16', '../uploads/6732a77478ab32.73145061.pdf', '0', '4', '4', '0.40', 1),
(78, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', '2024-11-12', '09:40:11', '../uploads/6732b1fb5cdd01.22791708.pdf', '1', '1', '2', '0.30', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(12) NOT NULL,
  `email` varchar(200) NOT NULL,
  `nama_penuh` varchar(200) NOT NULL,
  `nokp` varchar(200) NOT NULL,
  `notel` varchar(200) NOT NULL,
  `kategori` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `nama_penuh`, `nokp`, `notel`, `kategori`, `password`) VALUES
(1, 'ahmadnabilwafiq@gmail.com', 'AHMAD NABIL WAFIQ BIN AHMAD ZAKI', '050627030189', '0137558636', 'PELAJAR', '$2y$10$LBycIyrv7k8mNgP2.ljlLODzOYNPtrr3qYLdxeK7NZ1GjqpWFGpem'),
(8, 'amirhanbola@gmail.com', 'MOHAMAD AMIR HANAFIAH BIN AFNIZANIZAM', '051011120797', '0133286664', 'PENSYARAH', '$2y$10$Pz3qSxr27K98pf23cm00FuOcVwlpFclDVF5h5vHSdXghCpJzTZCYS');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `id_admin` int(12) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`id_admin`, `username`, `password`) VALUES
(1, 'admin', 'Mpp@2024');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `id_reservation` (`id_reservation`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id_payment` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id_admin` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
