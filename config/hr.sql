-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2021 at 06:56 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
CREATE TABLE IF NOT EXISTS `attendance` (
  `Att_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Att_Date` date NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `Emp_ID` int(11) NOT NULL,
  PRIMARY KEY (`Att_ID`),
  KEY `date_com` (`Emp_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Att_ID`, `Att_Date`, `status`, `Emp_ID`) VALUES
(7, '2021-11-11', 1, 3),
(15, '2021-11-10', 0, 3),
(16, '2021-11-09', 0, 3),
(19, '2021-11-02', 0, 3),
(20, '2021-11-03', 0, 3),
(21, '2021-11-12', 1, 3),
(22, '2021-11-12', 0, 4),
(23, '2021-11-12', 1, 5),
(24, '2021-11-12', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

DROP TABLE IF EXISTS `emp`;
CREATE TABLE IF NOT EXISTS `emp` (
  `Emp_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) CHARACTER SET utf32 NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` tinyint(4) NOT NULL DEFAULT 0,
  `Date_Register` date NOT NULL,
  `Phone` text DEFAULT NULL,
  `Att_Date` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Emp_ID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`Emp_ID`, `UserName`, `Password`, `Email`, `FullName`, `GroupID`, `Date_Register`, `Phone`, `Att_Date`, `status`) VALUES
(1, 'Anas', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'anas@anas.com', 'Anas Naser', 1, '2021-11-10', '777777777', NULL, 0),
(3, 'khalid', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'khalid@khalid.com', 'khalid khalid khalid', 0, '2021-11-11', '77777777', '', 1),
(4, 'Mohammed', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Mohammed@Mohammed.com', 'mohammed fadel', 0, '2021-11-10', '77777777', NULL, 0),
(5, 'ahmed', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ahmed@g.com', 'ahmed ahmed mohammed', 0, '2021-11-11', '77777777', NULL, 0),
(6, 'waheeb', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'waheeb@g.com', 'waheeb mohammed', 0, '2021-11-11', '77777777', NULL, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `date_com` FOREIGN KEY (`Emp_ID`) REFERENCES `emp` (`Emp_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
