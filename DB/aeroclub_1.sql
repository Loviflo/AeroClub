-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 25, 2021 at 04:26 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.1

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
  `type` enum('BREVET','ULM','PARACHUTE','FIRSTFLIGHT') NOT NULL,
  `name` enum('Brevet de Base','License Pilote D''avion Léger','Brevet de Pilote Privé') DEFAULT NULL,
  `soloRequired` int(11) DEFAULT NULL,
  `trainingRequired` int(11) DEFAULT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `type`, `name`, `soloRequired`, `trainingRequired`, `cost`) VALUES
(2, 'BREVET', 'Brevet de Base', 4, 6, 323.2),
(3, 'ULM', NULL, NULL, NULL, 250),
(4, 'PARACHUTE', NULL, NULL, NULL, 390),
(7, 'BREVET', 'License Pilote D\'avion Léger', 6, 15, 323.2),
(8, 'BREVET', 'Brevet de Pilote Privé', 10, 25, 323.2),
(9, 'FIRSTFLIGHT', NULL, NULL, NULL, 150);

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
  `trainingHours` int(11) NOT NULL DEFAULT '0',
  `signInDate` date NOT NULL DEFAULT '2020-01-01',
  `birthDate` date NOT NULL DEFAULT '2020-01-01',
  `additionalCost` int(11) NOT NULL,
  `payed` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `firstname`, `lastname`, `level`, `mail`, `password`, `soloHours`, `trainingHours`, `signInDate`, `birthDate`, `additionalCost`, `payed`) VALUES
(5, 'Vivian', 'Ruhlmann', 'Aucun Brevet', 'vivian.fr@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 2, 0, '2020-01-01', '2020-01-01', 0, 0),
(6, 'Vivian', 'Ruhlmann', 'Brevet de Base', 'vivian.ru@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 0, 0, '2020-01-01', '2020-01-01', 0, 1),
(7, 'Kilian', 'Cassaigne', 'Aucun Brevet', 'kicass@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 4, 0, '2020-01-01', '2020-01-01', 0, 1);

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
  `id` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_activity` int(11) NOT NULL,
  `id_trainer` int(11) NOT NULL DEFAULT '99',
  `id_plane` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `id_member`, `id_activity`, `id_trainer`, `id_plane`, `start`, `end`) VALUES
(2, 6, 3, 1, 3, '2021-08-19 16:00:00', '2021-08-19 18:00:00'),
(3, 7, 4, 1, 2, '2021-08-19 12:00:00', '2021-08-19 14:00:00'),
(7, 5, 2, 1, 1, '2021-08-16 18:00:00', '2021-08-08 20:00:00');

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
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_activity` (`id_activity`),
  ADD KEY `id_member` (`id_member`),
  ADD KEY `id_trainer` (`id_trainer`),
  ADD KEY `id_plane` (`id_plane`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
