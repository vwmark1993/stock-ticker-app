-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 14, 2020 at 12:23 AM
-- Server version: 5.1.73
-- PHP Version: 5.5.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `000803494`
--

-- --------------------------------------------------------

--
-- Table structure for table `StockUpdates`
--

CREATE TABLE IF NOT EXISTS `StockUpdates` (
  `StockId` varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `StockName` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CurrentPrice` decimal(10,2) NOT NULL,
  `UpdateDateTime` datetime NOT NULL,
  PRIMARY KEY (`StockId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `StockUpdates`
--

INSERT INTO `StockUpdates` (`StockId`, `StockName`, `CurrentPrice`, `UpdateDateTime`) VALUES
('AAPL', 'Apple Inc.', '425.04', '2020-08-04 07:15:30'),
('AMZN', 'Amazon.com, Inc.', '3164.68', '2020-08-05 03:23:14'),
('DIS', 'Walt Disney Co', '117.48', '2020-08-05 15:04:09'),
('MSFT', 'Microsoft Corporation', '205.01', '2020-08-05 04:43:54'),
('NFLX', 'Netflix Inc', '488.88', '2020-08-06 07:20:12'),
('AAA', 'A Corp.', '5.00', '2020-08-14 00:09:02'),
('BBB', 'B Corp.', '54.12', '2020-08-14 00:20:18'),
('CCC', 'C Corp.', '70.01', '2020-08-14 00:20:18'),
('DDD', 'D Corp.', '51.98', '2020-08-14 00:20:18'),
('EEE', 'E Corp.', '0.96', '2020-08-14 00:20:18'),
('FFF', 'F Corp.', '713.41', '2020-08-14 00:21:34'),
('GGG', 'G Corp.', '6.02', '2020-08-14 00:21:34'),
('HHH', 'H Corp.', '10056.14', '2020-08-14 00:21:34'),
('III', 'I Corp.', '6121.61', '2020-08-14 00:21:34'),
('JJJ', 'J Corp.', '71.52', '2020-08-14 00:21:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
