-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 19, 2021 at 12:23 PM
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
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `type` enum('BREVET','ULM','OTHER') NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `cost` float NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_trainer` int(11) DEFAULT NULL,
  `id_plane` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `type`, `start`, `end`, `cost`, `id_member`, `id_trainer`, `id_plane`) VALUES
(2, 'BREVET', '2021-08-08 16:00:00', '2021-08-08 18:00:00', 323.2, 5, 1, 1),
(3, 'BREVET', '2021-08-09 16:00:00', '2021-08-09 18:00:00', 323.2, 5, 1, 1),
(4, 'BREVET', '2021-08-08 14:00:00', '2021-08-08 16:00:00', 323.2, 5, 1, 1),
(5, 'BREVET', '2021-07-29 16:00:00', '2021-07-29 18:00:00', 323.2, 5, 1, 1),
(6, 'BREVET', '2021-08-05 10:00:00', '2021-08-05 12:00:00', 323.2, 5, 1, 1),
(7, 'BREVET', '2021-08-04 18:00:00', '2021-08-04 20:00:00', 323.2, 5, 1, 1),
(8, 'ULM', '2021-08-09 16:00:00', '2021-08-09 18:00:00', 323, 5, 1, 3),
(9, 'OTHER', '2021-08-09 16:00:00', '2021-08-09 18:00:00', 323, 5, 1, 2),
(12, 'BREVET', '2021-08-02 10:00:00', '2021-08-02 12:00:00', 323.2, 5, 1, 1),
(14, 'BREVET', '2021-08-02 10:00:00', '2021-08-02 12:00:00', 323.2, 5, 1, 1),
(15, 'BREVET', '2021-08-02 10:00:00', '2021-08-02 12:00:00', 323.2, 5, 1, 1),
(16, 'BREVET', '2021-08-03 10:00:00', '2021-08-03 12:00:00', 323.2, 5, 1, 1),
(17, 'BREVET', '2021-08-13 12:00:00', '2021-08-13 14:00:00', 323.2, 5, 1, 1),
(18, 'BREVET', '2021-08-14 16:00:00', '2021-08-14 18:00:00', 323.2, 5, 1, 1),
(19, 'BREVET', '2021-08-10 16:00:00', '2021-08-10 18:00:00', 323.2, 5, 1, 1),
(20, 'ULM', '2021-08-17 16:00:00', '2021-08-17 18:00:00', 323, 5, 1, 3),
(21, 'BREVET', '2021-08-15 18:00:00', '2021-08-15 20:00:00', 323.2, 5, 1, 1),
(22, 'BREVET', '2021-08-11 14:00:00', '2021-08-11 16:00:00', 323.2, 5, 1, 1),
(23, 'BREVET', '2021-08-10 12:00:00', '2021-08-10 14:00:00', 323.2, 5, 1, 1),
(24, 'BREVET', '2021-08-09 12:00:00', '2021-08-09 14:00:00', 323.2, 5, 1, 1),
(25, 'BREVET', '2021-07-27 14:00:00', '2021-07-27 16:00:00', 323.2, 5, 1, 1),
(26, 'BREVET', '2021-07-31 12:00:00', '2021-07-31 14:00:00', 323.2, 5, 1, 1),
(27, 'BREVET', '2021-08-20 12:00:00', '2021-08-20 14:00:00', 323.2, 5, 1, 1),
(29, 'BREVET', '2021-08-19 16:00:00', '2021-08-19 18:00:00', 323.2, 5, 1, 1),
(30, 'BREVET', '2021-08-16 10:00:00', '2021-08-16 12:00:00', 323.2, 5, 1, 1),
(31, 'BREVET', '2021-08-21 16:00:00', '2021-08-21 18:00:00', 323.2, 5, 1, 1),
(32, 'BREVET', '2021-08-21 18:00:00', '2021-08-21 20:00:00', 323.2, 5, 1, 1),
(33, 'ULM', '2021-08-19 14:00:00', '2021-08-19 16:00:00', 390, 5, 1, 3),
(36, 'BREVET', '2021-08-12 14:00:00', '2021-08-12 16:00:00', 323.2, 6, 1, 1),
(37, 'BREVET', '2021-08-13 18:00:00', '2021-08-13 20:00:00', 323.2, 6, 1, 1),
(39, 'BREVET', '2021-08-16 12:00:00', '2021-08-16 14:00:00', 323.2, 6, 1, 1),
(40, 'BREVET', '2021-08-18 12:00:00', '2021-08-18 14:00:00', 323.2, 6, 1, 1),
(42, 'ULM', '2021-08-21 10:00:00', '2021-08-21 12:00:00', 390, 6, 1, 4),
(43, 'ULM', '2021-08-20 16:00:00', '2021-08-20 18:00:00', 390, 6, 1, 3),
(45, 'OTHER', '2021-08-19 16:00:00', '2021-08-19 18:00:00', 390, 6, 1, 2),
(46, 'ULM', '2021-08-20 16:00:00', '2021-08-20 18:00:00', 390, 5, 1, 4),
(47, 'ULM', '2021-08-19 14:00:00', '2021-08-19 16:00:00', 390, 6, 1, 3),
(48, 'ULM', '2021-08-17 16:00:00', '2021-08-17 18:00:00', 390, 8, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `level` enum('Aucun Brevet','Brevet de Base','Licence Pilote d''Avion Léger','Brevet de Pilote Privé') NOT NULL DEFAULT 'Aucun Brevet',
  `mail` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `soloHours` int(11) NOT NULL DEFAULT '0',
  `trainingHours` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `firstname`, `lastname`, `level`, `mail`, `password`, `soloHours`, `trainingHours`) VALUES
(5, 'Vivian', 'Ruhlmann', 'Aucun Brevet', 'vivian.fr@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 4, 22),
(6, 'Vivian', 'Ruhlmann', 'Brevet de Base', 'vivian.ru@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 8, 16),
(7, 'Kilian', 'Cassaigne', 'Aucun Brevet', 'kicass@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 0, 0),
(8, 'Patrick', 'Bertrand', 'Licence Pilote d\'Avion Léger', 'patrick@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `planes`
--

CREATE TABLE `planes` (
  `id` int(11) NOT NULL,
  `purpose` enum('TRAINING','RECREATIONAL','ULM') NOT NULL,
  `model` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `planes`
--

INSERT INTO `planes` (`id`, `purpose`, `model`) VALUES
(1, 'TRAINING', 'Robin DR 400 120cv FGDES'),
(2, 'RECREATIONAL', 'PIPER PA 28 180 cv FGIDI'),
(3, 'ULM', 'Model 1'),
(4, 'ULM', 'Model 2');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id_member` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `date` date NOT NULL,
  `hour` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `firstname`, `lastname`, `mail`, `password`) VALUES
(1, 'Pierre', 'Martin', 'pierre.martin@aeroclub.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_member` (`id_member`),
  ADD KEY `fk_trainer` (`id_trainer`) USING BTREE,
  ADD KEY `fk_plane` (`id_plane`) USING BTREE;

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`,`mail`) USING BTREE;

--
-- Indexes for table `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id_member`,`id_activity`),
  ADD KEY `id_activity` (`id_activity`),
  ADD KEY `id_member` (`id_member`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `planes`
--
ALTER TABLE `planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `fk_member` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_plane` FOREIGN KEY (`id_plane`) REFERENCES `planes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_trainer` FOREIGN KEY (`id_trainer`) REFERENCES `trainers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `id_activity` FOREIGN KEY (`id_activity`) REFERENCES `activities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_member` FOREIGN KEY (`id_member`) REFERENCES `members` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
