-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2018 at 04:33 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techfest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `techfest_choices`
--

CREATE TABLE `techfest_choices` (
  `choice_id` int(11) NOT NULL,
  `choice_question_id` int(11) NOT NULL,
  `choice_content` varchar(300) NOT NULL,
  `choice_iscurrect` tinyint(4) NOT NULL,
  `choice_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `techfest_questions`
--

CREATE TABLE `techfest_questions` (
  `question_id` int(11) NOT NULL,
  `question_content` varchar(1000) NOT NULL,
  `question_image` varchar(1000) DEFAULT NULL,
  `question_type` tinyint(4) NOT NULL,
  `question_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `techfest_users`
--

CREATE TABLE `techfest_users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_fullname` varchar(100) NOT NULL,
  `user_college` varchar(200) NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '1',
  `user_status` tinyint(4) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `techfest_choices`
--
ALTER TABLE `techfest_choices`
  ADD PRIMARY KEY (`choice_id`);

--
-- Indexes for table `techfest_questions`
--
ALTER TABLE `techfest_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `techfest_users`
--
ALTER TABLE `techfest_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `techfest_choices`
--
ALTER TABLE `techfest_choices`
  MODIFY `choice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `techfest_questions`
--
ALTER TABLE `techfest_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `techfest_users`
--
ALTER TABLE `techfest_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
