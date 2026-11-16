-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2026 at 03:07 PM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `technova`
--

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` char(10) NOT NULL,
  `course` varchar(60) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('new','contacted') NOT NULL DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enquiries`
--

INSERT INTO `enquiries` (`id`, `name`, `email`, `phone`, `course`, `message`, `status`, `created_at`) VALUES
(2, 'Yash Bhandari', 'golgatam@gmail.com', '6398711356', 'B.Tech Computer Science', 'testing for backend', 'contacted', '2026-11-11 12:25:59'),
(4, 'piyush', '123@gmail.com', '7834298742', 'B.Tech Computer Science', 'backend', 'contacted', '2026-11-11 12:32:03'),
(6, 'trfyt', 'ugiyugfjug@gmail.com', '9638374576', 'B.Tech Computer Science', 'tgiuyiuh ?', 'contacted', '2026-11-15 17:09:39'),
(7, 'yfjf\'', 'fhyrhyhgj@gmsil.com', '9999999999', 'B.Tech ECE', '', 'new', '2026-11-15 17:13:02'),
(8, 'Yash Bhandari', 'golgatam@gmail.com', '7834298742', 'B.Tech Computer Science', 'we cooked', 'new', '2026-11-15 17:30:04'),
(9, 'Yash Bhandari', 'golgatam@gmail.com', '7834298742', 'B.Tech Computer Science', '', 'new', '2026-11-16 13:44:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
