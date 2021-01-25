-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2021 at 11:52 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `counter`
--

-- --------------------------------------------------------

--
-- Table structure for table `main_table`
--

CREATE TABLE `main_table` (
  `counter_id` int(11) NOT NULL,
  `counter_value` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_table`
--

INSERT INTO `main_table` (`counter_id`, `counter_value`) VALUES
(1, '00:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `time_set`
--

CREATE TABLE `time_set` (
  `id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `time_set`
--

INSERT INTO `time_set` (`id`, `start_time`, `end_time`) VALUES
(1, '16:16:00', '16:17:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `main_table`
--
ALTER TABLE `main_table`
  ADD PRIMARY KEY (`counter_id`);

--
-- Indexes for table `time_set`
--
ALTER TABLE `time_set`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `main_table`
--
ALTER TABLE `main_table`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `time_set`
--
ALTER TABLE `time_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
