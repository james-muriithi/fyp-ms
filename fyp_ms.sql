-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2020 at 06:42 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`emp_id`, `full_name`, `email`, `phone_no`, `expertise`, `profile`, `created_at`) VALUES
('12345', 'peter arnold', 'muriithijames556@gmail.com', '0746792699', 'java', 'dbdadc0933.jpg', '2020-03-16 09:58:57'),
('m3456', 'john Msagha', 'muriithijames123@gmail.com', '+254746792699', 'databases', NULL, '2020-03-26 08:46:30'),
('PU-4567', 'John Smith', 'muriithijames123@gmail.com', '0704554585', 'database', NULL, '2020-11-09 08:08:46');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(45) NOT NULL,
  `receiver` varchar(45) NOT NULL,
  `message` varchar(500) NOT NULL,
  `read` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender`, `receiver`, `message`, `read`, `created_at`) VALUES
(1, '12345', 'sb30/pu/41760/16', 'hey', 1, '2020-05-18 00:15:51'),
(2, 'sb30/pu/41760/16', '12345', 'hello', 1, '2020-05-19 11:45:49'),
(3, 'm3456', 'sb30/pu/41769/16', 'hello', 1, '2020-05-19 15:28:48'),
(4, 'm3456', 'sb30/pu/41769/16', 'how are you doing?', 1, '2020-05-19 15:29:01'),
(11, 'm3456', 'sb30/pu/41769/16', 'I need your chapter 1', 1, '2020-05-19 22:28:01'),
(12, 'sb30/pu/41769/16', 'm3456', 'okay sir', 1, '2020-05-19 22:28:19'),
(13, 'm3456', 'sb30/pu/41769/16', 'Good night', 1, '2020-05-19 22:30:07'),
(14, 'sb30/pu/41769/16', 'm3456', 'Good night to you too sir', 1, '2020-05-19 22:36:09'),
(15, 'm3456', 'sb30/pu/41769/16', 'okay', 1, '2020-05-19 22:36:41'),
(16, 'sb30/pu/41769/16', 'm3456', 'hello', 1, '2020-05-19 22:44:47'),
(17, 'sb30/pu/41769/16', 'm3456', 'hey', 1, '2020-05-19 22:46:22'),
(18, 'm3456', 'sb30/pu/41769/16', 'talk to me', 1, '2020-05-19 22:46:40'),
(19, 'm3456', 'sb30/pu/41769/16', 'tomorrow', 0, '2020-05-20 12:28:32'),
(20, '12345', 'sb30/pu/41766/16', 'hello there', 1, '2020-05-20 13:30:54'),
(21, 'sb30/pu/41766/16', '12345', 'hello sir', 1, '2020-05-20 13:33:17'),
(22, '12345', 'sb30/pu/41766/16', 'i need your help', 1, '2020-05-20 13:41:53'),
(23, 'sb30/pu/41766/16', '12345', 'where can i help?', 1, '2020-05-20 13:42:45'),
(24, '12345', 'sb30/pu/41760/16', 'good day', 1, '2020-05-20 13:43:51'),
(25, '12345', 'sb30/pu/41766/16', 'talk to me', 1, '2020-05-22 12:33:10'),
(26, 'sb30/pu/41766/16', 'sb30/pu/41769/16', 'hello', 0, '2020-05-22 13:09:20'),
(27, 'sb30/pu/41766/16', '12345', 'okay', 1, '2020-05-22 13:28:58'),
(28, 'sb30/pu/41766/16', 'sb30/pu/41760/16', 'Niaje', 1, '2020-05-22 13:49:34'),
(29, 'sb30/pu/41760/16', 'sb30/pu/41766/16', 'poa sana', 1, '2020-05-22 13:50:24'),
(30, '12345', 'sb30/pu/41766/16', 'hello', 1, '2020-10-29 14:27:00'),
(31, 'PU-4567', '12345', 'hello', 1, '2020-11-09 09:37:20'),
(32, 'PU-4567', 'SB30/pu/41785/16', 'hey', 1, '2020-11-09 09:37:39'),
(33, 'SB30/pu/41760/16', 'sb30/pu/41766/16', 'hello', 0, '2020-11-09 18:42:31'),
(34, 'SB30/pu/41760/16', 'm3456', 'hey', 0, '2020-11-09 18:42:54'),
(35, 'SB30/pu/41760/16', '12345', 'you too', 1, '2020-11-09 18:43:24'),
(36, 'sb30/pu/41785/16', '12345', 'hello', 1, '2020-11-09 18:47:43'),
(37, 'sb30/pu/41785/16', 'm3456', 'hey', 0, '2020-11-09 19:12:47'),
(38, 'sb30/pu/41785/16', 'PU-4567', 'hello', 1, '2020-11-12 09:54:53');

--
-- Triggers `messages`
--
DELIMITER $$
CREATE TRIGGER `messages_AFTER_INSERT` AFTER INSERT ON `messages` FOR EACH ROW BEGIN
	INSERT INTO notifications SET recipient_id = NEW.receiver, sender_id= 'system', type= 'message.new', reference_id = NEW.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `on_message_read` AFTER UPDATE ON `messages` FOR EACH ROW BEGIN
	IF (New.read = 1) THEN
    	UPDATE notifications SET unread = 0 WHERE reference_id = NEW.id and type='message.new' ;
    END IF;	
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
  `unread` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(255) NOT NULL DEFAULT '',
  `level` tinyint(4) NOT NULL DEFAULT 2,
  `reference_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `recipient_id`, `sender_id`, `unread`, `type`, `level`, `reference_id`, `created_at`) VALUES
(3, 'm3456', 'sb30/pu/41769/16', 0, 'upload.new', 2, 11, '2020-05-06 12:38:27'),
(4, 'sb30/pu/41769/16', 'system', 0, 'upload.new', 1, 11, '2020-05-06 12:38:27'),
(5, 'm3456', 'sb30/pu/41769/16', 0, 'upload.new', 2, 12, '2020-05-07 17:57:00'),
(6, 'sb30/pu/41769/16', 'sb30/pu/41769/16', 0, 'upload.new', 1, 12, '2020-05-07 17:57:00'),
(7, 'sb30/pu/41760/16', 'system', 0, 'category.new', 2, 4, '2020-05-10 12:10:09'),
(8, 'sb30/pu/41769/16', 'system', 0, 'category.new', 2, 4, '2020-05-10 12:10:09'),
(18, 'sb30/pu/41760/16', 'system', 0, 'upload.status', 3, 3, '2020-05-10 14:45:00'),
(28, '12345', 'sb30/pu/41760/16', 0, 'upload.new', 2, 13, '2020-05-11 15:00:22'),
(29, 'sb30/pu/41760/16', 'system', 0, 'upload.new', 1, 13, '2020-05-11 15:00:22'),
(30, 'sb30/pu/41760/16', 'system', 0, 'message.new', 2, 1, '2020-05-18 23:22:29'),
(31, '12345', 'system', 0, 'message.new', 2, 2, '2020-05-19 11:45:49'),
(32, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 3, '2020-05-19 15:28:48'),
(33, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 4, '2020-05-19 15:29:01'),
(34, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 5, '2020-05-19 17:12:49'),
(35, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 6, '2020-05-19 17:16:25'),
(36, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 7, '2020-05-19 21:48:54'),
(37, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 8, '2020-05-19 21:54:50'),
(38, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 9, '2020-05-19 22:04:12'),
(39, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 10, '2020-05-19 22:08:12'),
(40, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 11, '2020-05-19 22:28:01'),
(41, 'm3456', 'system', 0, 'message.new', 2, 12, '2020-05-19 22:28:19'),
(42, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 13, '2020-05-19 22:30:07'),
(43, 'm3456', 'system', 0, 'message.new', 2, 14, '2020-05-19 22:36:09'),
(44, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 15, '2020-05-19 22:36:41'),
(45, 'm3456', 'system', 0, 'message.new', 2, 16, '2020-05-19 22:44:47'),
(46, 'm3456', 'system', 0, 'message.new', 2, 17, '2020-05-19 22:46:22'),
(47, 'sb30/pu/41769/16', 'system', 0, 'message.new', 2, 18, '2020-05-19 22:46:40'),
(48, 'sb30/pu/41769/16', 'system', 1, 'message.new', 2, 19, '2020-05-20 12:28:32'),
(49, 'sb30/pu/41766/16', 'system', 0, 'message.new', 2, 20, '2020-05-20 13:30:54'),
(50, '12345', 'system', 0, 'message.new', 2, 21, '2020-05-20 13:33:17'),
(51, 'sb30/pu/41766/16', 'system', 0, 'message.new', 2, 22, '2020-05-20 13:41:53'),
(52, '12345', 'system', 0, 'message.new', 2, 23, '2020-05-20 13:42:45'),
(53, 'sb30/pu/41760/16', 'system', 0, 'message.new', 2, 24, '2020-05-20 13:43:51'),
(54, 'sb30/pu/41766/16', 'system', 0, 'message.new', 2, 25, '2020-05-22 12:33:10'),
(55, 'sb30/pu/41769/16', 'system', 1, 'message.new', 2, 26, '2020-05-22 13:09:20'),
(56, '12345', 'system', 0, 'message.new', 2, 27, '2020-05-22 13:28:58'),
(57, 'sb30/pu/41760/16', 'system', 0, 'message.new', 2, 28, '2020-05-22 13:49:34'),
(58, 'sb30/pu/41766/16', 'system', 0, 'message.new', 2, 29, '2020-05-22 13:50:24'),
(60, 'sb30/pu/41760/16', 'system', 0, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(61, '12345', 'system', 0, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(62, 'sb30/pu/41769/16', 'system', 1, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(63, 'm3456', 'system', 1, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(64, 'sb30/pu/41766/16', 'system', 0, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(65, '12345', 'system', 0, 'category.new', 2, 5, '2020-10-09 20:16:35'),
(66, 'sb30/pu/41760/16', 'system', 0, 'project.status', 1, 1, '2020-10-09 20:55:35'),
(68, 'sb30/pu/41769/16', 'system', 1, 'project.status', 1, 8, '2020-10-23 06:57:38'),
(73, 'sb30/pu/41766/16', 'system', 0, 'project.status', 1, 9, '2020-10-23 07:24:43'),
(74, 'sb30/pu/41760/16', 'system', 0, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(75, '12345', 'system', 0, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(76, 'sb30/pu/41769/16', 'system', 1, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(77, 'm3456', 'system', 1, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(78, 'sb30/pu/41766/16', 'system', 0, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(79, '12345', 'system', 0, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(80, 'sb30/pu/41770/16', 'system', 1, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(81, '12345', 'system', 0, 'category.new', 2, 6, '2020-10-29 12:26:15'),
(83, 'sb30/pu/41769/16', 'system', 1, 'upload.status', 2, 8, '2020-10-29 12:29:45'),
(84, 'sb30/pu/41766/16', 'system', 0, 'message.new', 2, 30, '2020-10-29 14:27:00'),
(85, '12345', 'sb30/pu/41766/16', 0, 'upload.new', 2, 14, '2020-10-29 15:31:38'),
(86, 'sb30/pu/41766/16', 'system', 1, 'upload.new', 1, 14, '2020-10-29 15:31:38'),
(87, 'sb30/pu/41760/16', 'system', 0, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(88, '12345', 'system', 0, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(89, 'sb30/pu/41769/16', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(90, 'm3456', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(91, 'sb30/pu/41766/16', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(92, '12345', 'system', 0, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(93, 'sb30/pu/41770/16', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(94, '12345', 'system', 0, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(95, 'SB30/PU/41785/16', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(96, 'PU-4567', 'system', 1, 'category.new', 2, 7, '2020-11-09 08:34:12'),
(97, 'PU-4567', 'SB30/PU/41785/16', 0, 'upload.new', 2, 15, '2020-11-09 09:26:25'),
(98, 'SB30/PU/41785/16', 'system', 1, 'upload.new', 1, 15, '2020-11-09 09:26:25'),
(99, '12345', 'system', 0, 'message.new', 2, 31, '2020-11-09 09:37:20'),
(100, 'SB30/PU/41785/16', 'system', 0, 'message.new', 2, 32, '2020-11-09 09:37:39'),
(101, 'SB30/PU/41785/16', 'system', 1, 'upload.status', 1, 15, '2020-11-09 09:41:46'),
(102, 'SB30/PU/41785/16', 'system', 0, 'project.status', 1, 13, '2020-11-09 09:44:27'),
(103, 'sb30/pu/41766/16', 'system', 1, 'message.new', 2, 33, '2020-11-09 18:42:31'),
(104, 'm3456', 'system', 1, 'message.new', 2, 34, '2020-11-09 18:42:54'),
(105, '12345', 'system', 0, 'message.new', 2, 35, '2020-11-09 18:43:24'),
(106, '12345', 'system', 0, 'message.new', 2, 36, '2020-11-09 18:47:43'),
(107, 'm3456', 'system', 1, 'message.new', 2, 37, '2020-11-09 19:12:47'),
(108, 'PU-4567', 'system', 0, 'message.new', 2, 38, '2020-11-12 09:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `category` int(11) NOT NULL,
  `student` varchar(30) NOT NULL,
  `supervisor` varchar(10) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `complete_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `category`, `student`, `supervisor`, `status`, `complete_date`) VALUES
(1, 'FINAL YEAR MANAGEMENT SYSTEM', 'it helps manage all the final year projects amen.', 1, 'sb30/pu/41760/16', '12345', 1, NULL),
(8, 'Church Management System', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 'sb30/pu/41769/16', 'm3456', 1, '2020-10-09 23:41:57'),
(9, 'Abuse and harrasment reporting system', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 2, 'sb30/pu/41766/16', '12345', 1, '2020-10-23 10:24:43'),
(12, 'library management system', 'lorem ipsum dorem isit', 1, 'sb30/pu/41770/16', '12345', 0, NULL),
(13, 'Plant Disease Recognition and Mitigation', 'lorem ipsum', 6, 'sb30/pu/41785/16', 'PU-4567', 1, '2020-11-09 12:44:27');

--
-- Triggers `project`
--
DELIMITER $$
CREATE TRIGGER `project_BEFORE_DELETE` BEFORE DELETE ON `project` FOR EACH ROW DELETE FROM fyp_ms.upload WHERE upload.project_id = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `project_update_notification` AFTER UPDATE ON `project` FOR EACH ROW BEGIN
	DECLARE lvl INT;
    
    SET lvl = New.status + 1;
    
    IF (New.status = 1) THEN
    	SET lvl = 1;
    END IF;
    
    IF (New.status = 0) THEN
    	SET lvl = 2;
    END IF;
    

    IF (NEW.status != OLD.status) THEN
    	DELETE FROm notifications where recipient_id = NEW.student AND reference_id = NEW.id AND type = 'project.status';
      INSERT INTO notifications SET recipient_id = NEW.student, sender_id = 'system', type = 'project.status', level = lvl, reference_id = NEW.id;    
   END IF;
	
END
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
(3, 'Desktop App'),
(4, 'Artificial Intelligence'),
(6, 'Human Computer Interface');

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
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`reg_no`, `full_name`, `email`, `phone_no`, `course`, `school`, `department`, `profile`, `created_at`) VALUES
('sb30/pu/41760/16', 'james muriithi', 'muriithijames556@gmail.com', '0746792699', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', '16b9bfccb4.png', '2020-03-16 09:58:26'),
('sb30/pu/41766/16', 'Peter Ndemange', 'james@oyaa.co.ke', '+254746792699', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', 'avatar-st.png', '2020-05-20 12:19:48'),
('sb30/pu/41769/16', 'Angelo Karugo', 'muriithijames556@gmail.com', '0789152672', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', NULL, '2020-03-23 12:58:17'),
('sb30/pu/41770/16', 'THE SCHEMAQ', 'theschemaqhigh@gmail.com', '0704554585', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', 'avatar-st.png', '2020-10-14 14:42:56'),
('sb30/pu/41783/16', 'Webster avosa', 'wa@gmail.com', '+254746792698', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', 'avatar-st.png', '2020-10-29 12:25:02'),
('sb30/pu/41785/16', 'Jeremiah Polo', 'muriithijames556@gmail.com', '0789152672', 'Bsc. Computer Science', 'School of Pure And Applied Sciences', 'Mathematics and Computer Science', 'avatar-st.png', '2020-11-09 08:11:06');

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
  `approved` int(11) NOT NULL DEFAULT 0,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `upload`
--

INSERT INTO `upload` (`id`, `name`, `project_id`, `category`, `approved`, `upload_time`) VALUES
(3, '469fff0ad9.pdf', 1, 1, 2, '2020-04-25 17:02:56'),
(8, 'b99d316f92.zip', 8, 1, 0, '2020-04-26 15:02:35'),
(9, 'f85c6bfe27.zip', 1, 2, 1, '2020-04-26 15:06:24'),
(11, 'f85c6bfe27.zip', 8, 2, 0, '2020-05-06 12:38:27'),
(12, 'e01ed17da4.docx', 8, 3, 0, '2020-05-07 17:57:00'),
(13, '9df951b5ba.pdf', 1, 3, 0, '2020-05-11 15:00:22'),
(14, '1e20ac4187.docx', 9, 5, 0, '2020-10-29 15:31:38'),
(15, '77caef53f3.docx', 13, 7, 1, '2020-11-09 09:26:25');

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
DELIMITER $$
CREATE TRIGGER `delete_notification` BEFORE DELETE ON `upload` FOR EACH ROW BEGIN
	DELETE FROM notifications WHERE refence_id = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_notification` AFTER UPDATE ON `upload` FOR EACH ROW BEGIN
	DECLARE lvl INT;
	DECLARE done INT DEFAULT FALSE;
    DECLARE c1 VARCHAR(20);
    DECLARE cur CURSOR FOR SELECT student FROM project WHERE id=NEW.project_id;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;
    OPEN cur;
    ins_loop: LOOP
    FETCH cur INTO c1;
    IF done THEN
    LEAVE ins_loop;
    END IF;
    SET lvl = New.approved + 1;
    
    IF (New.approved = 1) THEN
    	SET lvl = 1;
    END IF;
    
    IF (New.approved = 0) THEN
    	SET lvl = 2;
    END IF;
    

    IF (NEW.approved != OLD.approved) THEN
    	DELETE FROm notifications where recipient_id = c1 AND reference_id = NEW.id AND type = 'upload.status';
      INSERT INTO notifications SET recipient_id = c1, sender_id = 'system', type = 'upload.status', level = lvl, reference_id = NEW.id;    
   END IF;
    
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
(3, 'chapter 3', 'lorem ipsum', '2020-05-07', '2020-05-21'),
(4, 'chapter 4', 'lorem ipsum', '2020-05-28', '2020-06-05'),
(5, 'Final Report', 'all the chapters combined', '2020-10-07', '2020-10-31'),
(6, 'chapter 5', 'lorem ipsum', '2020-10-29', '2020-11-06'),
(7, 'Concept Paper 2019-2020', 'give in the concept paper', '2020-11-09', '2020-11-13');

--
-- Triggers `upload_category`
--
DELIMITER $$
CREATE TRIGGER `category_add_notification` AFTER INSERT ON `upload_category` FOR EACH ROW BEGIN
	DECLARE done INT DEFAULT FALSE;
    DECLARE c1 VARCHAR(20);
    DECLARE c2 VARCHAR(20);
    DECLARE cur CURSOR FOR SELECT student, supervisor FROM project;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done=TRUE;
    OPEN cur;
    ins_loop: LOOP
    FETCH cur INTO c1, c2;
    IF done THEN
    LEAVE ins_loop;
    END IF;
    INSERT INTO notifications SET recipient_id = c1, sender_id = 'system', type = 'category.new', reference_id = NEW.id;
    INSERT INTO notifications SET recipient_id = c2, sender_id = 'system', type = 'category.new', reference_id = NEW.id;
    END LOOP;
    CLOSE cur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `category_before_delete` BEFORE DELETE ON `upload_category` FOR EACH ROW BEGIN
	DELETE FROM fyp_ms.upload WHERE category = OLD.id;
    DELETE FROM notifications WHERE reference_id = OLD.id AND type = 'category.new';
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
('PU-4567', '$2y$10$5piO72t5On8hYP/yuvMvte1GvNI8j9ZzLSHZCN8i1YQneZ8NFy9nW', '52d31a771bbcbbd40038290804db61cb', 498043, 2, 1),
('sb30/pu/41760/16', '$2y$10$6XIhTHZFxYCMiQgSIWMQDOqvG9yPWZ979w9Ia7U9FLs.rDqmBufSC', '1f837df59fd02777dd33916c6f9b8eee', 332997, 3, 1),
('sb30/pu/41766/16', '$2y$10$eYVTqHDII4ru1XVgZpb2XOFw/Uv83TZooISRk1sFfAUxxbYouSQ4m', 'be5be3dec82e52e4ad1ece318dc2c88b', 814091, 3, 1),
('sb30/pu/41769/16', '$2y$10$r86DNGUJWSb1aD6PBGpNyOxvJqzUwHivJ8zEb97TNzMZrTm98Bx5q', '174a48b5f2c694d3d85e9f6f47e8543e', 515969, 3, 1),
('sb30/pu/41770/16', NULL, NULL, NULL, 3, 1),
('sb30/pu/41783/16', NULL, NULL, NULL, 3, 1),
('SB30/pu/41785/16', '$2y$10$NvmQPJL4i9GjLHfAXqSrOuoIQMmZk3ztmg2RFqgj1Y8rMKXPB6ENi', 'dfc21a66e7501b42ab2a1c865e6ecd38', 562490, 3, 1);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `upload_category`
--
ALTER TABLE `upload_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
