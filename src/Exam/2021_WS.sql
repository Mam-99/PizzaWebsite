-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2022 at 09:09 AM
-- Server version: 5.7.34
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2021_WS`
--
CREATE DATABASE IF NOT EXISTS `2021_WS` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `2021_WS`;

-- --------------------------------------------------------

--
-- Table structure for table `Bewertung`
--

CREATE TABLE IF NOT EXISTS `Bewertung` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `matrikelnummer` int(11) NOT NULL,
  `regler_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Bewertung`
--

INSERT INTO `Bewertung` (`matrikelnummer`, `regler_id`, `value`) VALUES
(481516, 1, 2),
(481516, 0, 6),
(548547, 1, 3),
(548547, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Regler`
--

CREATE TABLE IF NOT EXISTS `Regler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `beschriftung` varchar(255) NOT NULL,
  `min_value` int(11) NOT NULL,
  `max_value` int(11) NOT NULL,
  `label_min` varchar(255) NOT NULL,
  `label_max` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Regler`
--

INSERT INTO `Regler` (`beschriftung`, `min_value`, `max_value`, `label_min`, `label_max`) VALUES
('Konzentration', 0, 7, 'sehr müde', 'hellwach'),
('Raumtemperatur', 0, 10, 'Zu kalt', 'Zu heiß'),
('Vortragslautstärke', 0, 5, 'Zu leise', 'Zu laut'),
('Arbeitsatmosphäre', 0, 10, 'sehr schlecht', 'sehr gut');

-- --------------------------------------------------------

--
-- Table structure for table `Student`
--

CREATE TABLE IF NOT EXISTS `Student` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nachname` varchar(255) NOT NULL,
  `vorname` varchar(255) NOT NULL,
  `matrikelnummer` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Student`
--

INSERT INTO `Student` (`nachname`, `vorname`, `matrikelnummer`) VALUES
('Reyes', 'Hugo', 481516),
('Shephard', 'Jack', 548547),
('Locke', 'Jonathan', 263740);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
