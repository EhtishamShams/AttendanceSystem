-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2018 at 12:08 PM
-- Server version: 5.7.18
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `AttendanceSystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `uid` int(11) NOT NULL,
  `date` date NOT NULL,
  `timeIn` time DEFAULT NULL,
  `timeOut` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`uid`, `date`, `timeIn`, `timeOut`) VALUES
(1, '2018-07-13', '09:22:50', '17:22:58'),
(1, '2018-07-17', '11:31:59', '14:46:29'),
(2, '2018-06-21', '09:00:23', '18:12:31'),
(2, '2018-07-17', '10:59:18', '11:00:33'),
(3, '2018-07-09', '10:59:43', '17:15:34'),
(3, '2018-07-11', '11:30:21', '18:10:29'),
(3, '2018-07-17', '10:55:43', '10:59:30'),
(4, '2018-07-17', '10:56:09', '10:59:42'),
(5, '2018-07-17', '10:58:07', '10:59:57'),
(6, '2018-07-13', '11:16:13', '18:31:46'),
(8, '2018-07-17', '10:58:40', '10:59:00'),
(9, '2018-07-13', '10:34:21', '16:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `email` varchar(1024) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `dept` varchar(1024) NOT NULL,
  `salary` int(11) NOT NULL,
  `picUrl` varchar(1024) DEFAULT NULL,
  `boss` int(11) DEFAULT NULL,
  `designation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `dept`, `salary`, `picUrl`, `boss`, `designation`) VALUES
(1, 'Test', 'test@test.com', '$2y$10$oPd7V4wKcEImNRkPrBadPO7wTuzqaT/3Hw/j/LK3q.W2fClKwnAyW', 'HR', 500000, 'uploads/test@test.com.png', NULL, 'CEO'),
(2, 'Test2', 'test2@test.com', '$2y$10$VzCBU9df.C9bMxTSVestsOE0wJGvbXSW/ASfCwagdw83Y907RB0vy', 'HR', 100000, 'uploads/test2@test.com.png', NULL, 'HR Manager'),
(3, 'test3', 'test3@test.com', '$2y$10$ZQbBDbaZpBS5tb/ul6OrFeSzNyWayYav74WH3OUmcb4z7K5YKEIV2', 'IT', 100000, NULL, NULL, 'Manager'),
(4, 'Test4', 'test4@test.com', '$2y$10$fuyfSezBtSYa.7gOIPLqUu0KMlprHzBuoWl2HFQBhS7hy5j7bVC/q', 'IT', 200000, 'uploads/test4@test.com.png', NULL, 'Manager'),
(5, 'Test5', 'test5@test.com', '$2y$10$gJPtzCzL.mflsz4pW31zUOE4q/CTBnfZnmmSvfTyrtbLNW5brCuIS', 'IT', 50000, 'uploads/test5@test.com.png', 3, 'Developer'),
(6, 'Test6', 'test6@test.com', '$2y$10$c1YLBWlT8HXq2SEwDM8Hy.1OSDd/.ygjhztCbr4mjX8.3FpdTNj2O', 'IT', 12341234, 'uploads/test6@test.com.jpg', NULL, 'HR Manager'),
(8, 'Test7', 'test7@test.com', '$2y$10$qGp1NcPI.sDOc8Kp9cBNDOhszQtMkS/97wE7XlcQ32FdU0FfqwjXq', 'HR', 1231231, 'uploads/test7@test.com.png', NULL, 'HR Manager'),
(9, 'Test8', 'test8@test.com', '$2y$10$rwnqw5DcJcrwDWZ80g.i/u45Wi3hMXVfDoR9udONeQvxnC8S/4bHi', 'HR', 100000, 'uploads/test8@test.com.png', 4, 'Developer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`uid`,`date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
