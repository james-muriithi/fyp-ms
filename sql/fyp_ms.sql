-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2020 at 11:27 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fyp_ms`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coordinator`
--

CREATE TABLE `coordinator` (
  `emp_id` varchar(10) NOT NULL,
  `academic_year` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `coordinator`
--
DELIMITER $$
CREATE TRIGGER `coordinator_AFTER_INSERT` AFTER INSERT ON `coordinator` FOR EACH ROW BEGIN
	UPDATE user SET level = 1 WHERE username = NEW.emp_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `emp_id` varchar(10) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `expertise` varchar(105) NOT NULL,
  `profile` varchar(15) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `lecturer`
--
DELIMITER $$
CREATE TRIGGER `lecturer_AFTER_INSERT` AFTER INSERT ON `lecturer` FOR EACH ROW BEGIN
	INSERT INTO user set username = NEW.emp_id,level = 2,status =1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `user` varchar(30) NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` int(11) NOT NULL,
  `student` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `reg_no` varchar(30) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `course` varchar(50) NOT NULL DEFAULT 'Bsc. Computer Science',
  `school` varchar(50) NOT NULL DEFAULT 'School of Pure And Applied Sciences',
  `department` varchar(45) NOT NULL DEFAULT 'Mathematics and Computer Science',
  `profile` varchar(15) DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`reg_no`, `full_name`, `email`, `phone_no`, `course`, `school`, `department`, `profile`, `created_at`) VALUES
('SB30/PU/41760/16', 'JAMES MURIITHI', 'muriithijames556@gmail.com', '0746792699', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', NULL, '2020-02-28 10:10:42.270780');

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `student_AFTER_INSERT` AFTER INSERT ON `student` FOR EACH ROW BEGIN
	INSERT INTO user set username = NEW.reg_no,level = 3,status =1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assignment`
--

CREATE TABLE `tbl_assignment` (
  `student_regno` varchar(30) NOT NULL,
  `supervisor` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `project_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '0',
  `upload_time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload_category`
--

CREATE TABLE `upload_category` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `description` varchar(500) NOT NULL,
  `deadline` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(64) NOT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `token`, `otp`, `level`, `status`) VALUES
('SB30/PU/41760/16', '$2y$10$WSdHCVgJeDAFnKdatmKQzeV/IjgkBEE4OGPDiDQyP5LyAkx4HI4/C', '6bd564a49393317fcc7354f4399803cd68e8d518409ba44d64ffd9ac3a5a169c', '052535', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD KEY `emp_id_idx` (`emp_id`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `emp_id_UNIQUE` (`emp_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username_idx` (`user`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_UNIQUE` (`title`),
  ADD KEY `reg_no_idx` (`student`),
  ADD KEY `id_idx` (`category`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`reg_no`);

--
-- Indexes for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  ADD PRIMARY KEY (`student_regno`,`supervisor`),
  ADD KEY `empid_idx` (`supervisor`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`,`category`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id_idx` (`project_id`);

--
-- Indexes for table `upload_category`
--
ALTER TABLE `upload_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `token` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD CONSTRAINT `employee_id` FOREIGN KEY (`emp_id`) REFERENCES `lecturer` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `username` FOREIGN KEY (`user`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `id` FOREIGN KEY (`category`) REFERENCES `project_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reg_no` FOREIGN KEY (`student`) REFERENCES `student` (`reg_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_assignment`
--
ALTER TABLE `tbl_assignment`
  ADD CONSTRAINT `empid` FOREIGN KEY (`supervisor`) REFERENCES `lecturer` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sregno` FOREIGN KEY (`student_regno`) REFERENCES `student` (`reg_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `upload_cat` FOREIGN KEY (`id`) REFERENCES `upload_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
