-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2020 at 11:05 PM
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
  `academic_year` varchar(9) NOT NULL DEFAULT '2019-2020'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coordinator`
--

INSERT INTO `coordinator` (`emp_id`, `academic_year`) VALUES
('12345', '2019-2020');

--
-- Triggers `coordinator`
--
DELIMITER $$
CREATE TRIGGER `coordinator_AFTER_INSERT` AFTER INSERT ON `coordinator` FOR EACH ROW BEGIN
	UPDATE user SET level = 1 WHERE username = NEW.emp_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_coordinator` BEFORE DELETE ON `coordinator` FOR EACH ROW BEGIN
	UPDATE fyp_ms.user SET level = 2 WHERE username=OLD.emp_id;
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`emp_id`, `full_name`, `email`, `phone_no`, `expertise`, `profile`, `created_at`) VALUES
('12345', 'peter arnold', 'muriithijames556@gmail.com', '0746792699', 'java', 'dbdadc0933.jpg', '2020-03-16 09:58:57'),
('m3456', 'john Msagha', 'muriithijames123@gmail.com', '+254746792699', 'databases', NULL, '2020-03-26 08:46:30');

--
-- Triggers `lecturer`
--
DELIMITER $$
CREATE TRIGGER `lecturer_AFTER_INSERT` AFTER INSERT ON `lecturer` FOR EACH ROW BEGIN
	INSERT INTO user set username = NEW.emp_id,level = 2,status =1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `lecturer_BEFORE_DELETE` BEFORE DELETE ON `lecturer` FOR EACH ROW BEGIN
	DELETE FROM fyp_ms.user WHERE username = OLD.emp_id;
    DELETE FROM fyp_ms.coordinator WHERE emp_id = OLD.emp_id;
    UPDATE fyp_ms.project SET supervisor = NULL WHERE supervisor = OLD.emp_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `recipient_id` varchar(20) NOT NULL,
  `sender_id` varchar(20) NOT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(255) NOT NULL DEFAULT '',
  `level` tinyint(4) NOT NULL DEFAULT '2',
  `reference_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient_id`, `sender_id`, `unread`, `type`, `level`, `reference_id`, `created_at`) VALUES
(3, 'm3456', 'sb30/pu/41769/16', 1, 'upload.new', 2, 11, '2020-05-06 12:38:27'),
(4, 'sb30/pu/41769/16', 'system', 1, 'upload.new', 1, 11, '2020-05-06 12:38:27'),
(5, 'm3456', 'sb30/pu/41769/16', 1, 'upload.new', 2, 12, '2020-05-07 17:57:00'),
(6, 'sb30/pu/41769/16', 'sb30/pu/41769/16', 1, 'upload.new', 1, 12, '2020-05-07 17:57:00');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` int(11) NOT NULL,
  `student` varchar(30) NOT NULL,
  `supervisor` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `category`, `student`, `supervisor`, `status`) VALUES
(1, 'FINAL YEAR MANAGEMENT SYSTEM', 'it helps manage all the final year projects amen.', 1, 'sb30/pu/41760/16', '12345', 0),
(8, 'Church Management System', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 'sb30/pu/41769/16', 'm3456', 0);

--
-- Triggers `project`
--
DELIMITER $$
CREATE TRIGGER `project_BEFORE_DELETE` BEFORE DELETE ON `project` FOR EACH ROW DELETE FROM fyp_ms.upload WHERE upload.project_id = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_categories`
--

INSERT INTO `project_categories` (`id`, `name`) VALUES
(1, 'Web App'),
(2, 'Android App'),
(3, 'Desktop App');

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
  `profile` varchar(15) DEFAULT 'avatar-st.png',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`reg_no`, `full_name`, `email`, `phone_no`, `course`, `school`, `department`, `profile`, `created_at`) VALUES
('sb30/pu/41760/16', 'james muriithi', 'muriithijames556@gmail.com', '0746792699', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', '16b9bfccb4.png', '2020-03-16 09:58:26'),
('sb30/pu/41769/16', 'Angelo Karugo', 'muriithijames556@gmail.com', '0789152672', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', NULL, '2020-03-23 12:58:17');

--
-- Triggers `student`
--
DELIMITER $$
CREATE TRIGGER `student_AFTER_INSERT` AFTER INSERT ON `student` FOR EACH ROW BEGIN
	INSERT INTO user set username = NEW.reg_no,level = 3,status =1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `student_BEFORE_DELETE` BEFORE DELETE ON `student` FOR EACH ROW BEGIN
	DELETE FROM fyp_ms.user WHERE username = OLD.reg_no;
    DELETE FROM fyp_ms.project WHERE student = OLD.reg_no;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `project_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `approved` int(11) NOT NULL DEFAULT '0',
  `upload_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id`, `name`, `project_id`, `category`, `approved`, `upload_time`) VALUES
(3, '469fff0ad9.pdf', 1, 1, 2, '2020-04-25 17:02:56'),
(8, 'b99d316f92.zip', 8, 1, 0, '2020-04-26 15:02:35'),
(9, 'f85c6bfe27.zip', 1, 2, 1, '2020-04-26 15:06:24'),
(11, 'f85c6bfe27.zip', 8, 2, 0, '2020-05-06 12:38:27'),
(12, 'e01ed17da4.docx', 8, 3, 0, '2020-05-07 17:57:00');

--
-- Triggers `upload`
--
DELIMITER $$
CREATE TRIGGER `add_notification` AFTER INSERT ON `upload` FOR EACH ROW BEGIN
	DECLARE done INT DEFAULT FALSE;
    DECLARE c1 VARCHAR(20);
    DECLARE c2 VARCHAR(20);
    DECLARE cur CURSOR FOR SELECT student,supervisor FROM project WHERE id=NEW.project_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;
    OPEN cur;
    ins_loop: LOOP
    FETCH cur INTO c1,c2;
    IF done THEN
    LEAVE ins_loop;
    END IF;
    INSERT INTO notifications SET recipient_id = c2, sender_id = c1, type = 'upload.new', reference_id = NEW.id;
    INSERT INTO notifications SET recipient_id = c1, sender_id = 'system', type = 'upload.new',level = 1, reference_id = NEW.id;
    END LOOP;
    CLOSE cur;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `upload_category`
--

CREATE TABLE `upload_category` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `description` varchar(500) NOT NULL,
  `start_date` date NOT NULL,
  `deadline` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload_category`
--

INSERT INTO `upload_category` (`id`, `name`, `description`, `start_date`, `deadline`) VALUES
(1, 'chapter 1', 'lorem ipsum dorem isit', '2020-04-01', '2020-04-24'),
(2, 'chapter 2', 'lorem ipsum dorem', '2020-04-25', '2020-05-01'),
(3, 'chapter 3', 'lorem ipsum', '2020-05-07', '2020-05-21');

--
-- Triggers `upload_category`
--
DELIMITER $$
CREATE TRIGGER `category_before_delete` BEFORE DELETE ON `upload_category` FOR EACH ROW BEGIN
	DELETE FROM fyp_ms.upload WHERE category = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `token` varchar(32) DEFAULT NULL,
  `otp` int(6) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `token`, `otp`, `level`, `status`) VALUES
('12345', '$2y$10$1dXhDkf7tZNJL5zft6jYlOt80RJe4kwowr61v3vemp.r9VTwu6Lhm', 'e7185655f1a327d87b6deccfba5efbfb', 918206, 1, 1),
('m3456', '$2y$10$/sekwZomjenmHGWHLrfVEOHUl/BHq94N7lQGPwOid5QtNTbbGFewW', '9ae759eb20990263ee1966803f117271', 298684, 2, 1),
('sb30/pu/41760/16', '$2y$10$6XIhTHZFxYCMiQgSIWMQDOqvG9yPWZ979w9Ia7U9FLs.rDqmBufSC', '1f837df59fd02777dd33916c6f9b8eee', 95727, 3, 1),
('sb30/pu/41769/16', '$2y$10$r86DNGUJWSb1aD6PBGpNyOxvJqzUwHivJ8zEb97TNzMZrTm98Bx5q', '174a48b5f2c694d3d85e9f6f47e8543e', 515969, 3, 1);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_UNIQUE` (`title`),
  ADD KEY `reg_no_idx` (`student`),
  ADD KEY `id_idx` (`category`),
  ADD KEY `empid_idx` (`supervisor`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`reg_no`),
  ADD UNIQUE KEY `reg_no` (`reg_no`);

--
-- Indexes for table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`,`category`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`),
  ADD KEY `id_idx` (`project_id`),
  ADD KEY `upload_cat_idx` (`category`);

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
  ADD UNIQUE KEY `token_UNIQUE` (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `upload_category`
--
ALTER TABLE `upload_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coordinator`
--
ALTER TABLE `coordinator`
  ADD CONSTRAINT `employee_id` FOREIGN KEY (`emp_id`) REFERENCES `lecturer` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `empid` FOREIGN KEY (`supervisor`) REFERENCES `lecturer` (`emp_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `id` FOREIGN KEY (`category`) REFERENCES `project_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reg_no` FOREIGN KEY (`student`) REFERENCES `student` (`reg_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `upload`
--
ALTER TABLE `upload`
  ADD CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `upload_cat` FOREIGN KEY (`category`) REFERENCES `upload_category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
