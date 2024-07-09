-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 05:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taskmanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--
CREATE DATABASE taskmanagement;

CREATE TABLE `task` (
  `taskID` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `due` date NOT NULL,
  `status` enum('Pending','In Progress','Completed','') NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`taskID`, `title`, `description`, `due`, `status`, `userID`) VALUES
(10, '2rfewd', '2fwrefd', '2024-07-11', 'Pending', 2),
(13, '33', '33', '2024-07-18', 'In Progress', 10),
(14, 'fe', 'sfefsf', '2024-07-24', 'In Progress', 2),
(15, 'fsd', 'fsdfwef2uygtydrsg', '2024-08-16', 'Pending', 2),
(16, 'sfdf', 'wfe1', '2024-07-21', 'Completed', 2),
(17, 'iyukjdhfg', ']-[oupyiotuydth', '2024-08-02', 'Completed', 9),
(18, 'wqe', '2343rergf youtbe: www.youtube.com', '2024-08-01', 'Completed', 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`taskID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `taskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
