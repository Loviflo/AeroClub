-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 27, 2021 at 08:48 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aeroclub`
--

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `id_trainer` int(11) DEFAULT NULL,
  `id_plane` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `mode` enum('solo','trainer') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_activity` (`id_activity`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_trainer` (`id_trainer`),
  ADD KEY `id_plane` (`id_plane`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `id_activity` FOREIGN KEY (`id_activity`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_member` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_plane` FOREIGN KEY (`id_plane`) REFERENCES `planes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_trainer` FOREIGN KEY (`id_trainer`) REFERENCES `trainers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
