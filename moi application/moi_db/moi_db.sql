-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2024 at 02:56 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addmoi`
--

CREATE TABLE `addmoi` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `the_groom` varchar(225) NOT NULL,
  `the_bride` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `marriage_type` enum('the groom side','the bride side','','') DEFAULT NULL,
  `name` varchar(225) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addmoi`
--

INSERT INTO `addmoi` (`id`, `swaminame`, `date`, `the_groom`, `the_bride`, `mahal`, `marriage_type`, `name`, `address`, `mobile`, `amount`) VALUES
(77, 'muruga', '2024-09-30', 'rajesh', 'samantha', ' vms', 'the bride side', 'ghngtn', 'yukuy', '9787455425', 74278.00),
(81, 'rfrhfd', '2024-09-30', 'rajesh', 'samantha', ' vms', '', '1', 'wrwer', '6666666666', 4124.00);

-- --------------------------------------------------------

--
-- Table structure for table `ceremony`
--

CREATE TABLE `ceremony` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `ceremony` varchar(225) NOT NULL,
  `ceremonyowner` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `place` varchar(225) NOT NULL,
  `timing` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ceremony`
--

INSERT INTO `ceremony` (`id`, `swaminame`, `date`, `ceremony`, `ceremonyowner`, `mahal`, `place`, `timing`) VALUES
(6, 'muruga', '2024-09-30', 'earring ceremony', 'MR.milton samantha', 'vms', 'theni', '00:00:00'),
(16, 'sri kallapanpatti aathi sivan thunai', '2024-09-30', 'spring ceremony', 'muruga', 'vms', 'v', '04:28:00'),
(17, 'muruga', '2024-09-30', 'spring ceremony', 'MR.milton ms.samantha', 'kms', 'theni', '03:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `ceremony_moi`
--

CREATE TABLE `ceremony_moi` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `ceremony` varchar(225) NOT NULL,
  `ceremonyowner` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ceremony_moi`
--

INSERT INTO `ceremony_moi` (`id`, `swaminame`, `date`, `ceremony`, `ceremonyowner`, `mahal`, `name`, `address`, `mobile`, `amount`) VALUES
(13, 'sri kallapanpatti aathi sivan thunai', '2024-09-09', 'spring ceremony', 'muruga', '', 'muruga', 'wrwer', '1234567890', 4257.00),
(18, 'rfrhfd', '2024-09-23', 'spring ceremony', 'MR.milton ms.samantha', 'vms', 'muruga', 'wrwer', '6666666666', 401.00);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`) VALUES
(1, 'admin@gmail.com', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `uncle`
--

CREATE TABLE `uncle` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `the_groom` varchar(225) NOT NULL,
  `the_bride` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `marriage_type` enum('boy','girl','','') NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `sequence` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `extra_input` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uncle`
--

INSERT INTO `uncle` (`id`, `swaminame`, `date`, `the_groom`, `the_bride`, `mahal`, `marriage_type`, `name`, `address`, `mobile`, `sequence`, `amount`, `extra_input`) VALUES
(16, 'muruga', '2024-09-30', 'rajesh', 'samantha', 'vms', 'boy', 'saravana', 'allinagaram', '9855555555', 'biro', 4522.00, 'all mvs a'),
(17, 'rfrhfd', '2024-09-30', 'rajesh', 'samantha', 'vms', 'boy', '1', 'wrwer', '9855555555', 'biro', 4424.00, '42424');

-- --------------------------------------------------------

--
-- Table structure for table `uncle_ceremony`
--

CREATE TABLE `uncle_ceremony` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `ceremony` varchar(225) NOT NULL,
  `ceremonyowner` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `name` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `sequence` varchar(50) NOT NULL,
  `extra_input` text NOT NULL,
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uncle_ceremony`
--

INSERT INTO `uncle_ceremony` (`id`, `swaminame`, `date`, `ceremony`, `ceremonyowner`, `mahal`, `name`, `address`, `mobile`, `sequence`, `extra_input`, `amount`) VALUES
(6, 'muruga', '2024-09-30', 'spring ceremony', 'MR.milton ms.samantha', 'vms', 'muruga', 'wrwer', '1234567890', 'gold', '`12`121`2', 101.00);

-- --------------------------------------------------------

--
-- Table structure for table `wedding`
--

CREATE TABLE `wedding` (
  `id` int(11) NOT NULL,
  `swaminame` varchar(225) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `the_groom` varchar(225) NOT NULL,
  `the_bride` varchar(225) NOT NULL,
  `mahal` varchar(225) NOT NULL,
  `place` varchar(225) NOT NULL,
  `timing` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wedding`
--

INSERT INTO `wedding` (`id`, `swaminame`, `date`, `the_groom`, `the_bride`, `mahal`, `place`, `timing`) VALUES
(92, 'rfrhfd', '2024-09-30', 'rajesh', 'samantha', 'vms', 'w', '05:08:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addmoi`
--
ALTER TABLE `addmoi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ceremony`
--
ALTER TABLE `ceremony`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ceremony_moi`
--
ALTER TABLE `ceremony_moi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uncle`
--
ALTER TABLE `uncle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uncle_ceremony`
--
ALTER TABLE `uncle_ceremony`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wedding`
--
ALTER TABLE `wedding`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addmoi`
--
ALTER TABLE `addmoi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `ceremony`
--
ALTER TABLE `ceremony`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ceremony_moi`
--
ALTER TABLE `ceremony_moi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `uncle`
--
ALTER TABLE `uncle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `uncle_ceremony`
--
ALTER TABLE `uncle_ceremony`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wedding`
--
ALTER TABLE `wedding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
