-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 29, 2021 at 02:18 PM
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
(5, 'Vivian', 'Ruhlmann', 'Aucun Brevet', 'vivian.fr@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 0, 0),
(6, 'Vivian', 'Ruhlmann', 'Brevet de Base', 'vivian.ru@free.fr', 'b43f1d28a3dbf30070bf1ae7c88ee2784047fc86d7be8620c8510debbd8555b3ef0b96376a4dd494ae0561580274bcf7a3069f5c0beceff63d1237a13d4d72b7', 0, 0);

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
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`,`mail`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
