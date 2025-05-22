-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 12:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `studentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` varchar(200) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `name`, `department`, `email`, `password`, `mobile`) VALUES
('A1', 'DR.K.M.ALAAUDEEN', 'CSE', 'alaaudeen.km@gmail.com', '$2y$10$5qL4uc.gupr/D8ZA21OKdeCmw47SosHpdCwh7uNUpEva3GCRZ5gmW', '9994446197'),
('A2', 'Mr.M.KRISHNA KUMAR', 'ECE', 'krishnakumar@grace.edu.in', '$2y$10$VmAg6sKUyPfA9W.f6XcRZel4ZcUSfI4pjcy1TJ7amhkUEiwdW0z9q', '9878989887'),
('A3', 'MRS.P.GAYATHRI', 'EEE', 'gayathri@grace.edu.in', '$2y$10$i5zI9gaBHBvF//3LSTyzle0VJz80PMAy8QtNULyiGwrrUDDO4Wuta', '9898878787'),
('A4', 'Dr.NALINI JEBASTINA', 'CIVIL', 'nalinijebastina@grace.edu.in', '$2y$10$oKWNcBJy/n.njB7nH4DX2uwVI0CQkFZaKLmiZEljSOt1U6oQka486', '8787878787'),
('A5', 'Dr.M.D.MOHAN GIFT', 'MECH', 'mohangift@gmail.com', '$2y$10$D9fEZgtfzRM4KWW1DvQsJOArvHhkl1VtoBS/.26StNlWRiytmauzy', '8787878787'),
('A6', 'MRS.N.NANCY CHITRA THILAGA', 'AI&DS', 'nancychitrathilaga@gracecoe.org', '$2y$10$DI7nxMa0CdeRsF.WUyVlSesLzawkr5vdqL3nnJdl/qpA4Of/88PSS', '8787878787'),
('A7', 'DR.SIVAKUMAR', 'MBA', 'sivakumar@gmail.com', '$2y$10$sabqg6.4dWuuCuzou07LIeaw.LehmSrMDoN4w5j1kMHtl24G9abfG', '8787878787'),
('P1', 'DR.S.RICHARD', '', 'iamrichi@gmail.com', '$2y$10$hroPhaUE5.fhZDFBGsMs.eoR1tx3pOFG3C8OWC9eNn2ejNV1CI4Su', '9443113113'),
('P2', 'MS.JEFFRIN', '', 'jeffrin@gmail.com', '$2y$10$hI/U4LCWb1h4Smi8Ikiml.23hy5eBrRUMxXhUgNZ4zPMrmOzIPWpW', '9898878776');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `sid` varchar(200) NOT NULL,
  `status` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`sid`, `status`, `date`, `id`) VALUES
('GHB004', '1', '2025-03-25', 4),
('GHG001', '1', '2025-03-25', 5),
('GHG002', '0', '2025-03-25', 6),
('GHG003', '1', '2025-03-25', 7),
('GHG004', '0', '2025-03-25', 8),
('GHG005', '1', '2025-03-25', 9),
('GHG006', '1', '2025-03-25', 10),
('GHG001', '0', '2025-04-15', 11),
('GHG002', '0', '2025-04-15', 12),
('GHG003', '1', '2025-04-15', 13),
('GHG001', '1', '2025-04-22', 14),
('GHG001', '1', '2025-04-22', 15),
('GHG003', '1', '2025-04-22', 18),
('GHG003', '1', '2025-04-22', 19),
('GHG005', '0', '2025-04-22', 20),
('GHG005', '0', '2025-04-22', 21),
('GHG006', '1', '2025-04-22', 22),
('GHG006', '1', '2025-04-22', 23),
('GHB001', '0', '2025-04-22', 24),
('GHB002', '0', '2025-04-22', 25),
('GHB003', '0', '2025-04-22', 26),
('GHB004', '1', '2025-04-22', 27),
('GHB005', '0', '2025-04-22', 28),
('GHG002', '0', '2025-04-22', 29),
('GHG003', '0', '2025-04-23', 32),
('GHG005', '0', '2025-04-23', 33),
('GHG006', '1', '2025-04-23', 34),
('GHG001', '1', '2025-04-24', 35),
('GHG002', '1', '2025-04-24', 36),
('GHG003', '0', '2025-04-24', 37),
('GHG006', '0', '2025-04-24', 39),
('GHG001', '0', '2025-04-26', 40),
('GHG003', '1', '2025-04-26', 41),
('GHG001', '0', '2025-05-08', 67),
('GHG002', '0', '2025-05-08', 68),
('GHG003', '1', '2025-05-08', 69),
('GHG004', '0', '2025-05-08', 70),
('GHG005', '1', '2025-05-08', 71),
('GHG006', '0', '2025-05-08', 72),
('GHG007', '1', '2025-05-08', 73),
('GHG008', '1', '2025-05-08', 74),
('GHG009', '0', '2025-05-08', 75),
('GHG021', '1', '2025-05-08', 76),
('GHG010', '1', '2025-05-08', 77),
('GHG011', '1', '2025-05-08', 78),
('GHG012', '1', '2025-05-08', 79),
('GHG013', '1', '2025-05-08', 80),
('GHG014', '1', '2025-05-08', 81),
('GHG015', '1', '2025-05-08', 82),
('GHG016', '1', '2025-05-08', 83),
('GHG018', '0', '2025-05-08', 84),
('GHG019', '0', '2025-05-08', 85),
('GHG020', '0', '2025-05-08', 86),
('GHG017', '0', '2025-05-08', 87),
('GHG022', '1', '2025-05-08', 88),
('GHG023', '1', '2025-05-08', 89),
('GHG024', '1', '2025-05-08', 90),
('GHB001', '0', '2025-05-08', 91),
('GHB002', '0', '2025-05-08', 92),
('GHB002', '0', '2025-05-08', 93),
('GHB002', '0', '2025-05-08', 94),
('GHB002', '1', '2025-05-08', 95),
('GHB003', '1', '2025-05-08', 96),
('GHB004', '1', '2025-05-08', 97),
('GHB004', '1', '2025-05-08', 98),
('GHB017', '1', '2025-05-08', 99),
('GHB005', '1', '2025-05-08', 100),
('GHB006', '0', '2025-05-08', 101),
('GHB007', '1', '2025-05-08', 102),
('GHB014', '1', '2025-05-08', 103),
('GHB016', '1', '2025-05-08', 104),
('GHB008', '1', '2025-05-08', 105),
('GHB011', '1', '2025-05-08', 106),
('GHB015', '1', '2025-05-08', 107),
('GHB009', '1', '2025-05-08', 108),
('GHB010', '1', '2025-05-08', 109),
('GHB012', '1', '2025-05-08', 110),
('GHB018', '1', '2025-05-08', 111),
('GHB013', '1', '2025-05-08', 112),
('GHB019', '1', '2025-05-08', 113),
('GHB020', '1', '2025-05-08', 114),
('GHB021', '0', '2025-05-08', 115),
('GHB022', '1', '2025-05-08', 116),
('GHB023', '1', '2025-05-08', 117),
('GHB024', '0', '2025-05-08', 118),
('GHB025', '1', '2025-05-08', 119),
('GHB034', '1', '2025-05-08', 120),
('GHB033', '0', '2025-05-08', 121),
('GHB032', '1', '2025-05-08', 122),
('GHB026', '0', '2025-05-08', 123),
('GHB027', '1', '2025-05-08', 124),
('GHB028', '0', '2025-05-08', 125),
('GHB029', '1', '2025-05-08', 126),
('GHB030', '0', '2025-05-08', 127),
('GHB031', '0', '2025-05-08', 128);

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `s.no` varchar(200) NOT NULL,
  `batch_year` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`s.no`, `batch_year`) VALUES
('1', '2021'),
('2', '2022'),
('3', '2023'),
('4', '2024');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `s.no` varchar(200) NOT NULL,
  `Dept_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`s.no`, `Dept_name`) VALUES
('6', 'AI&DS'),
('5', 'CIVIL'),
('1', 'CSE'),
('2', 'ECE'),
('3', 'EEE'),
('4', 'MECH');

-- --------------------------------------------------------

--
-- Table structure for table `food_schedule`
--

CREATE TABLE `food_schedule` (
  `id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `meal_type` enum('Breakfast','Lunch','Dinner') NOT NULL,
  `menu` text NOT NULL,
  `timing` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_schedule`
--

INSERT INTO `food_schedule` (`id`, `day`, `meal_type`, `menu`, `timing`) VALUES
(1, 'Monday', 'Breakfast', 'Rava Upma, Coconut Chutney', ''),
(2, 'Monday', 'Lunch', 'Rice, Rasam, Egg Curry, Butter Milk', ''),
(3, 'Monday', 'Dinner', 'Chapati, Veg Curry', ''),
(4, 'Tuesday', 'Breakfast', 'Dosa, Sambar, Kesari', ''),
(5, 'Tuesday', 'Lunch', 'Rice, Sambar, Rasam, Greens', ''),
(6, 'Tuesday', 'Dinner', 'Variety Rice, Coconut Chutney', ''),
(7, 'Wednesday', 'Breakfast', 'Idli, Sambar, Coconut Chutney', ''),
(8, 'Wednesday', 'Lunch', 'Rice, Rasam, Chicken Curry, Veg Meals', ''),
(9, 'Wednesday', 'Dinner', 'Parrota, Chicken Curry', ''),
(10, 'Sunday', 'Breakfast', 'Poori, Potato Curry', ''),
(11, 'Sunday', 'Dinner', 'Rice, Dal', ''),
(12, 'Sunday', 'Lunch', 'Veg & Non veg Biryani', ''),
(13, 'Saturday', 'Breakfast', 'Variety Rice, Sambar', ''),
(14, 'Thursday', 'Dinner', 'Dosa, Sambar', ''),
(15, 'Thursday', 'Breakfast', 'Pongal, Sambar, Coconut Chutney', ''),
(16, 'Friday', 'Breakfast', 'Idli, Tomato & Coconut Chutney', ''),
(17, 'Friday', 'Lunch', 'Rice, Sambar, Rasam, Spiced Potato, Payasam', ''),
(18, 'Friday', 'Dinner', 'Chapati, Veg Curry', ''),
(19, 'Thursday', 'Lunch', 'Rice, Rasam, Tamarind curry', ''),
(20, 'Saturday', 'Lunch', 'Rice, Rasam, Fish Curry, Dry Potato', ''),
(21, 'Saturday', 'Dinner', 'Idli, Chicken Curry', '');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `created_at`) VALUES
(1, 'New outpass request from SID: ', '2025-04-23 08:23:19'),
(2, 'New outpass request from SID: ', '2025-04-23 08:23:33'),
(3, 'New outpass request from SID: ', '2025-04-23 08:23:57'),
(4, 'New outpass request from SID: F6', '2025-04-23 08:27:33'),
(5, 'New outpass request from SID: F6', '2025-04-23 08:29:54'),
(6, 'New outpass request from SID: F6', '2025-04-23 08:39:11'),
(7, 'New outpass request from SID: F6', '2025-04-24 03:44:54'),
(8, 'New outpass request from SID: F6', '2025-04-24 06:21:05'),
(9, 'New outpass request from SID: F6', '2025-04-24 06:21:12'),
(10, 'New outpass request from SID: F6', '2025-04-24 08:30:51'),
(11, 'New outpass request from SID: F2', '2025-04-24 08:40:46'),
(12, 'New outpass request from SID: F2', '2025-04-24 08:43:11'),
(13, 'New outpass request from SID: F6', '2025-04-25 03:43:59'),
(14, 'New outpass request from SID: F2', '2025-04-25 03:44:16'),
(15, 'New outpass request from SID: F6', '2025-04-26 04:00:01'),
(16, 'New outpass request from SID: F6', '2025-04-26 04:04:07'),
(17, 'New outpass request from SID: F6', '2025-04-26 04:04:12'),
(18, 'New outpass request from SID: ', '2025-04-26 04:15:31'),
(19, 'New outpass request from SID: ', '2025-04-26 04:15:35'),
(20, 'New outpass request from SID: ', '2025-04-26 04:23:58'),
(21, 'New outpass request from SID: ', '2025-04-26 04:24:44'),
(22, 'New outpass request from SID: ', '2025-04-26 04:24:48'),
(23, 'New outpass request from SID: ', '2025-04-26 04:26:45'),
(24, 'New outpass request from SID: ', '2025-04-26 04:43:46'),
(25, 'New outpass request from SID: ', '2025-04-26 04:43:58'),
(26, 'New outpass request from SID: ', '2025-04-26 04:54:48'),
(27, 'New outpass request from SID: ', '2025-04-26 04:54:53'),
(28, 'New outpass request from SID: ', '2025-04-26 05:39:11'),
(29, 'New outpass request from SID: ', '2025-04-26 05:39:15'),
(30, 'New outpass request from SID: ', '2025-04-26 06:15:44'),
(31, 'New outpass request from SID: ', '2025-04-26 06:47:20'),
(32, 'New outpass request from SID: ', '2025-04-26 06:48:16'),
(33, 'New outpass request from SID: ', '2025-04-26 06:48:17'),
(34, 'New outpass request from SID: ', '2025-04-26 06:48:20'),
(35, 'New outpass request from SID: ', '2025-04-26 06:48:23'),
(36, 'New outpass request from SID: ', '2025-04-26 06:48:24'),
(37, 'New outpass request from SID: ', '2025-04-26 06:48:36'),
(38, 'New outpass request from SID: ', '2025-04-26 06:48:38'),
(39, 'New outpass request from SID: F6', '2025-04-26 06:50:37'),
(40, 'New outpass request from SID: F6', '2025-04-26 06:50:52'),
(41, 'New outpass request from SID: F6', '2025-04-26 08:55:50'),
(42, 'New outpass request from SID: F6', '2025-04-26 08:56:04'),
(43, 'New outpass request from SID: F6', '2025-04-26 08:57:10'),
(44, 'New outpass request from SID: F6', '2025-04-26 08:57:12'),
(45, 'New outpass request from SID: F6', '2025-04-26 10:12:27'),
(46, 'New outpass request from SID: F6', '2025-04-26 10:12:53'),
(47, 'New outpass request from SID: F6', '2025-04-26 10:13:07'),
(48, 'New outpass request from SID: F6', '2025-04-26 10:13:15'),
(49, 'New outpass request from SID: F6', '2025-04-26 10:13:23'),
(50, 'New outpass request from SID: F6', '2025-04-26 10:13:40'),
(51, 'New outpass request from SID: F6', '2025-04-26 10:14:37'),
(52, 'New outpass request from SID: F6', '2025-04-26 10:14:46'),
(53, 'New outpass request from SID: F6', '2025-04-26 10:14:57'),
(54, 'New outpass request from SID: F6', '2025-04-26 10:15:06'),
(55, 'New outpass request from SID: F6', '2025-04-26 10:15:08'),
(56, 'New outpass request from SID: F6', '2025-04-26 10:15:21'),
(57, 'New outpass request from SID: F6', '2025-04-26 10:16:20'),
(58, 'New outpass request from SID: F6', '2025-04-26 10:17:36'),
(59, 'New outpass request from SID: F6', '2025-04-26 10:18:55'),
(60, 'New outpass request from SID: F6', '2025-04-26 10:18:57'),
(61, 'New outpass request from SID: F6', '2025-04-26 10:20:30'),
(62, 'New outpass request from SID: F6', '2025-04-26 10:20:46'),
(63, 'New outpass request from SID: F6', '2025-04-26 10:20:58'),
(64, 'New outpass request from SID: F6', '2025-04-26 10:21:11'),
(65, 'New outpass request from SID: F6', '2025-04-26 10:21:18'),
(66, 'New outpass request from SID: F6', '2025-04-26 10:21:24'),
(67, 'New outpass request from SID: F6', '2025-04-26 10:21:31'),
(68, 'New outpass request from SID: F6', '2025-04-26 10:22:43'),
(69, 'New outpass request from SID: F6', '2025-04-26 10:23:04'),
(70, 'New outpass request from FID: F6', '2025-04-28 03:55:02'),
(71, 'New outpass request from SID: F6', '2025-04-28 04:15:24'),
(72, 'New outpass request from SID: F6', '2025-04-28 04:15:28'),
(73, 'New outpass request from SID: F6', '2025-04-28 04:36:30'),
(74, 'New outpass request from SID: F6', '2025-04-28 04:36:39'),
(75, 'New outpass request from SID: F6', '2025-04-28 04:36:43'),
(76, 'New outpass request from SID: F6', '2025-04-28 05:00:37'),
(77, 'New outpass request from SID: F6', '2025-04-28 05:00:39'),
(78, 'New outpass request from SID: F6', '2025-04-28 05:52:39'),
(79, 'New outpass request from SID: F2', '2025-04-28 05:53:14'),
(80, 'New outpass request from SID: F6', '2025-04-28 05:53:35'),
(81, 'New outpass request from SID: F6', '2025-04-28 05:53:38'),
(82, 'New outpass request from SID: F6', '2025-04-28 06:00:00'),
(83, 'New outpass request from SID: F6', '2025-04-28 06:00:04'),
(84, 'New outpass request from SID: F6', '2025-04-28 06:03:24'),
(85, 'New outpass request from SID: F6', '2025-04-28 06:03:26'),
(86, 'New outpass request from SID: F6', '2025-04-28 06:49:41'),
(87, 'New outpass request from SID: F2', '2025-04-28 06:50:16'),
(88, 'New outpass request from SID: F2', '2025-04-28 06:50:20'),
(89, 'New outpass request from SID: F2', '2025-04-28 10:02:59'),
(90, 'New outpass request from SID: F6', '2025-04-29 03:59:02'),
(91, 'New outpass request from SID: F6', '2025-04-29 04:17:12'),
(92, 'New outpass request from SID: F2', '2025-04-29 04:28:07'),
(93, 'New outpass request from SID: F2', '2025-04-29 04:28:12'),
(94, 'New outpass request from SID: F6', '2025-04-29 04:35:22'),
(95, 'New outpass request from SID: F6', '2025-04-29 06:31:28'),
(96, 'New outpass request from SID: F2', '2025-04-29 06:34:46'),
(97, 'New outpass request from SID: F2', '2025-04-29 06:34:51'),
(98, 'New outpass request from SID: F2', '2025-04-29 06:35:17'),
(99, 'New outpass request from SID: F6', '2025-04-30 08:23:54'),
(100, 'New outpass request from SID: F6', '2025-04-30 08:26:59'),
(101, 'New outpass request from SID: F2', '2025-05-06 05:14:29');

-- --------------------------------------------------------

--
-- Table structure for table `outpass_requests`
--

CREATE TABLE `outpass_requests` (
  `sid` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `room_no` varchar(20) NOT NULL,
  `reason` text NOT NULL,
  `leave_date` date NOT NULL,
  `return_date` date NOT NULL,
  `leave_time` time NOT NULL,
  `return_time` time NOT NULL,
  `destination` varchar(255) NOT NULL,
  `sstatus` varchar(20) DEFAULT 'Pending',
  `astatus` varchar(20) DEFAULT 'Pending',
  `pstatus` varchar(20) DEFAULT 'Pending',
  `tstatus` varchar(20) DEFAULT 'Pending',
  `fstatus` varchar(20) DEFAULT 'Pending',
  `id` int(11) NOT NULL,
  `final_status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outpass_requests`
--

INSERT INTO `outpass_requests` (`sid`, `name`, `room_no`, `reason`, `leave_date`, `return_date`, `leave_time`, `return_time`, `destination`, `sstatus`, `astatus`, `pstatus`, `tstatus`, `fstatus`, `id`, `final_status`) VALUES
('GHG006', 'Keerthana', 'S8', 'GATE Examination', '2025-04-30', '2025-05-01', '13:56:00', '13:56:00', 'chennai', 'Approved', 'Approved', 'Approved', 'Approved', 'Approved', 134, 'Pending'),
('GHB002', 'Joel', 'F05', 'GATE Examination', '2025-05-06', '2025-05-07', '06:00:00', '06:00:00', 'Kerala', 'Outdated Request', 'Approved', 'Approved', 'Approved', 'Approved', 136, 'Outdated Request');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_no` varchar(10) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_no`, `capacity`) VALUES
('F05', 4),
('F06', 4),
('F07', 4),
('F08', 4),
('F09', 4),
('F10', 4),
('F11', 4),
('F12', 4),
('F13', 4),
('F14', 4),
('F15', 4),
('F16', 4),
('F17', 4),
('F18', 4),
('F19', 4),
('G03', 4),
('G04', 4),
('G05', 4),
('G07', 4),
('G08', 4),
('G09', 4),
('G11', 4),
('G13', 4),
('G29', 4),
('G30', 4),
('G31', 4),
('G33', 4),
('G34', 4),
('G35', 4),
('G36', 4),
('G37', 4),
('S1', 4),
('S2', 4),
('S3', 4),
('S4', 4),
('S5', 4),
('S6', 4),
('S7', 4);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `sid` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `st_id` varchar(200) NOT NULL,
  `department` varchar(350) NOT NULL,
  `gender` varchar(350) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `joining_year` year(4) NOT NULL,
  `passout_year` year(4) NOT NULL,
  `current_year` varchar(10) NOT NULL,
  `address` varchar(200) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `room_no` varchar(200) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`sid`, `name`, `st_id`, `department`, `gender`, `email`, `password`, `joining_year`, `passout_year`, `current_year`, `address`, `mobile`, `room_no`, `phone`) VALUES
('GHB001', 'THANGA PANDI', '950321108011', 'MECH', 'Male', 'thangapandi@gmail.com', 'thangapandi', '2021', '2025', 'IV', '1/ttt,ppp', '8787878787', 'F05', '9898989898'),
('GHB002', 'GUNA', '950321108012', 'MECH', 'Male', 'guna@gmail.com', 'guna', '2021', '2025', 'IV', '2/ggg,aaa', '8787878787', 'F06', '9898989898'),
('GHB003', 'NICOLAS MARANDI', '950321106011', 'ECE', 'Male', 'nicolasmarandi@gmail.com', 'nicolasmarandi', '2021', '2025', 'IV', '3/nnn,mmm', '8787878787', 'F07', '9898989898'),
('GHB004', 'PRANAV', '950321106012', 'ECE', 'Male', 'pranav@gmail.com', 'pranav', '2021', '2025', 'IV', '4/ppp,vvv', '8787878787', 'F07', '9898989898'),
('GHB005', 'ABHISHEK A STEPHEN', '950321104002', 'CSE', 'Male', 'abhishekastephen@gmail.com', 'abhishekastephen', '2021', '2025', 'IV', '5/aaa,sss', '8787878787', 'F08', '9898989898'),
('GHB006', 'DENNI THOMAS', '950321104015', 'CSE', 'Male', 'dennithomas@gmail.com', 'dennithomas', '2021', '2025', 'IV', '6/ddd,ttt', '8787878787', 'F08', '9898989898'),
('GHB007', 'SUSHANT BAGHEL', '950321104052', 'CSE', 'Male', 'sushantbaghel@gmail.com', 'sushantbaghel', '2021', '2025', 'IV', '7/sss,bbb', '8787878787', 'F08', '9898989898'),
('GHB008', 'MARK S THOMAS', '950321104028', 'CSE', 'Male', 'marksthomas@gmail.com', 'marksthomas', '2021', '2025', 'IV', '8/mmm,ttt', '8787878787', 'F08', '9898989898'),
('GHB009', 'JOEL B MATHEW', '950321104023', 'CSE', 'Male', 'joelbmathew@gmail.com', 'joelbmathew', '2021', '2025', 'IV', '9/jjj,mmm', '8787878787', 'F09', '9898989898'),
('GHB010', 'JERIN P JOSE', '950321106013', 'ECE', 'Male', 'jerinpjose@gmail.com', 'jerinpjose', '2021', '2025', 'IV', '10/jjj,jjj', '8787878787', 'F09', '9898989898'),
('GHB011', 'PRADEEP', '950321104037', 'CSE', 'Male', 'pradeep@gmail.com', 'pradeep', '2021', '2025', 'IV', '11/ppp,ppp', '8787878787', 'F09', '9898989898'),
('GHB012', 'SRI MAHA VIGNESH', '950321106014', 'ECE', 'Male', 'srimahavignesh@gmail.com', 'srimahavignesh', '2021', '2025', 'IV', '12/sss,vvv', '8787878787', 'F09', '9898989898'),
('GHB013', 'THANGA MARIAPPAN', '950321106015', 'ECE', 'Male', 'thangamariappan@gmail.com', 'thangamariappan', '2021', '2025', 'IV', '13/ttt,mmm', '8787878787', 'F10', '9898989898'),
('GHB014', 'ANUSH', '950321104010', 'CSE', 'Male', 'anush@gmail.com', 'anush', '2021', '2025', 'IV', '14/aaa,hhh', '8787878787', 'F10', '9898989898'),
('GHB015', 'RONALD DAS', '950321104041', 'CSE', 'Male', 'ronalddas@gmail.com', 'ronalddas', '2021', '2025', 'IV', '15/rrr,ddd', '8787878787', 'F10', '9898989898'),
('GHB016', 'VISHAL KUMAR', '950321103011', 'CSE', 'Male', 'vishalkumar@gmail.com', 'vishalkumar', '2022', '2026', 'III', '16/vvv,kkk', '8787878787', 'F11', '9898989898'),
('GHB017', 'ARUL JAYARAJ A', '90321103012', 'CSE', 'Male', 'aruljeyaraja@gmail.com', 'aruljeyaraja', '2022', '2026', 'III', '17/aaa,jjj', '8787878787', 'F11', '9898989898'),
('GHB018', 'BALAMURUGAN', '950321105011', 'AI&DS', 'Male', 'balamurugan@gmail.com', 'balamurugan', '2022', '2026', 'III', '18/bbb,mmm', '8787878787', 'F11', '9898989898'),
('GHB019', 'HIRALAL BESRA', '950321104011', 'MECH', 'Male', 'hiralalbesra@gmail.com', 'hiralalbesra', '2022', '2026', 'III', '19/hhh,bbb', '8787878787', 'F12', '9898989898'),
('GHB020', 'SAMDAVI', '950321104011', 'AI&DS', 'Male', 'samdavi@gmail.com', 'samdavi', '2022', '2026', 'III', '20/sss,ddd', '8787878787', 'F12', '9898989898'),
('GHB021', 'ABRAHAM RAJASINGH P', '950321104011', 'CSE', 'Male', 'abrahamrajasinghp@gmail.com', 'abrahamrajasinghp', '2022', '2026', 'III', '21/aaa,rrr', '8787878787', 'F12', '9898989898'),
('GHB022', 'RANISH T', '950321104011', 'CSE', 'Male', 'ranisht@gmail.om', 'ranisht', '2022', '2026', 'III', '22/rrr,hhh', '8787878787', 'F12', '9898989898'),
('GHB023', 'ARUN SAINI', '950321104011', 'CSE', 'Male', 'arunsaini@gmail.com', 'arunsaini', '2022', '2026', 'III', '23/aaa,sss', '8787878787', 'F13', '9898989898'),
('GHB024', 'STANLEY GENO S', '950321104011', 'CSE', 'Male', 'stanleygenos@gmail.com', 'stanleygenos', '2022', '2026', 'III', '24/sss,ggg', '8787878787', 'F13', '9898989898'),
('GHB025', 'SUBASH CHANDRABOSE', '950321104011', 'CIVIL\r\n', 'Male', 'subashchandrabose@gmail.com', 'subashchandrabose', '2023', '2027', 'II', '25/sss,ccc', '8787878787', 'F13', '9898989898'),
('GHB026', 'AKASH KUMAR', '950321104011', 'CSE', 'Male', 'akashkumar@gmail.com', 'akashkumar', '2022', '2026', 'III', '26/aaa,kkk', '8787878787', 'F14', '9898989898'),
('GHB027', 'VIJAYAN S', '950321104011', 'ECE', 'Male', 'vijayans@gmail.com', 'vijayans', '2023', '2027', 'II', '27/vvv,sss', '8787878787', 'F14', '9898989898'),
('GHB028', 'JOHN ALLSON', '950321104011', 'AI&DS', 'Male', 'johnallson@gmail.com', 'johnallson', '2022', '2026', 'III', '28/jjj,aaa', '8787878787', 'F14', '9898989898'),
('GHB029', 'CHANDRESH KUMAR', '950321104011', 'CSE', 'Male', 'chandreshkumar@gmail.com', 'chandreshkumar', '2022', '2026', 'III', '29,ccc,kkk', '8787878787', 'F16', '9898989898'),
('GHB030', 'GIPSON XAVIER JEBAS', '950321104011', 'CSE', 'Male', 'gipsonxavierjebas@gmail.com', 'gipsonxavierjebas', '2022', '2026', 'III', '30/ggg,xxx', '8787878787', 'F16', '9898989898'),
('GHB031', 'ARAVINDH', '950321104011', 'CSE', 'Male', 'aravindh@gmail.com', 'aravindh', '2022', '2026', 'III', '31/aaa,hhh', '8787878787', 'F15', '9898989898'),
('GHB032', 'ANANDHA SARAVANAN', '950321104011', 'CSE', 'Male', 'anandhasaravanan@gmail.com', 'anandhasaravanan', '2022', '2026', 'III', '32/aaa,sss', '8787878787', 'F15', '9898989898'),
('GHB033', 'AKASH A', '950321104011', 'CSE', 'Male', 'akasha@gmail.com', 'akasha', '2022', '2026', 'III', '33/aaa,aaa', '8787878787', 'F15', '9898989898'),
('GHB034', 'ANBU', '950321104011', 'CSE', 'Male', 'anbu@gmail.com', 'anbu', '2022', '2026', 'III', '34/aaa,uuu', '8787878787', 'F15', '9898989898'),
('GHB035', 'OSHAN', '950321104011', 'AI&DS', 'Male', 'oshan@gmail.com', 'oshan', '2022', '2026', 'III', '35/ooo,hhh', '8787878787', 'F17', '9898989898'),
('GHB036', 'KERSOME', '950321104011', 'EEE', 'Male', 'kersome@gmail.com', 'kersome', '2023', '2027', 'II', '36/kkk,eee', '8787878787', 'F17', '9898989898'),
('GHB037', 'ABISHEK JEYARAJ.J', '950321104011', 'CSE', 'Male', 'abhishekjeyarajj@gmail.com', 'abhishekjeyarajj', '2023', '2027', 'II', '37/aaa,jjj', '8787878787', 'S1', '9898989898'),
('GHB038', 'ABISHEK JOY ', '950321104011', 'CSE', 'Male', 'abhishekjoy@gmail.com', 'abhishekjoy', '2023', '2027', 'II', '38/aaa,jjj', '8787878787', 'S1', '9898989898'),
('GHB039', 'HARI HARAN G', '950321104011', 'CSE', 'Male', 'hariharang@gmail.com', 'hariharang', '2023', '2027', 'II', '39/hhh,hhh', '8787878787', 'S1', '9898989898'),
('GHB040', 'HARIDEVAN P', '950321104011', 'CSE', 'Male', 'haridevanp@gmail.com', 'haridevanp', '2023', '2027', 'II', '40/hhh,ddd', '8787878787', 'S1', '9898989898'),
('GHB041', 'AJAY S', '950321104011', 'CSE', 'Male', 'ajays@gmail.com', 'ajays', '2023', '2027', 'II', '41/aaa,sss', '8787878787', 'S2', '9898989898'),
('GHB042', 'DEEPAK KUMAR', '950321104011', 'CSE', 'Male', 'deepakkumar@gmail.com', 'deepakkumar', '2023', '2027', 'II', '42/ddd,kkk', '8787878787', 'S2', '9898989898'),
('GHB043', 'RENNY DANIEL RAJ', '950321104011', 'CSE', 'Male', 'rennydanielraj@gmail.com', 'rennydanielraj', '2023', '2027', 'II', '43/rrr,ddd', '8787878787', 'S2', '9898989898'),
('GHB044', 'MAHARAJA M', '950321104011', 'CSE', 'Male', 'maharajam@gmail.com', 'maharajam', '2023', '2027', 'II', '44/mmm,rrr', '8787878787', 'S2', '9898989898'),
('GHB045', 'THIRUMALAI KARTHICK S', '950321104011', 'CSE', 'Male', 'thirumalaikarthicks@gmail.com', 'thirumalaikarthicks', '2023', '2027', 'II', '45/ttt,kkk', '8787878787', 'S3', '9898989898'),
('GHB046', 'LINGA MOORTHI S', '950321104011', 'CSE', 'Male', 'lingamoorthis@gmail.com', 'lingamoorthis', '2023', '2027', 'II', '46/lll,mmm', '8787878787', 'S3', '9898989898'),
('GHB047', 'MOHIT KUMAR', '950321104011', 'CSE', 'Male', 'mohitkumar@gmail.com', 'mohitkumar', '2023', '2027', 'II', '47/mmm,kkk', '8787878787', 'S3', '9898989898'),
('GHB048', 'DANIEL J', '950321104011', 'CSE', 'Male', 'danielj@gmail.com', 'danielj', '2023', '2027', 'II', '48/jjj,jjj', '8787878787', 'S3', '9898989898'),
('GHB049', 'MOHAMMED AFZAL KHAN  I', '950321104011', 'CSE', 'Male', 'mohammedafzalkhani@gmail.com', 'mohammedafzalkhani', '2023', '2027', 'II', '49/mmm,fff', '8787878787', 'S4', '9898989898'),
('GHB050', 'VIGNESH RAJA P', '950321104011', 'EEE', 'Male', 'vigneshrajap@gmail.com', 'vigneshrajap', '2023', '2027', 'II', '50/vvv,rrr', '8787878787', 'S4', '9898989898'),
('GHB051', 'ABISHEK C', '950321104011', 'EEE', 'Male', 'abishekc@gmail.com', 'abishekc', '2023', '2027', 'II', '51/aaa,ccc', '8787878787', 'S4', '9898989898'),
('GHB052', 'CHANDRU', '950321104011', 'EEE', 'Male', 'chandru@gmail.com', 'chandru', '2023', '2027', 'II', '52/ccc,uuu', '8787878787', 'S5', '9898989898'),
('GHB053', 'SRI RAM ', '950321104011', 'CIVIL', 'Male', 'sriram@gmail.com', 'sriram', '2023', '2027', 'II', '53/sss,rrr', '8787878787', 'S5', '9898989898'),
('GHB054', 'MUTHU VEL', '950321104011', 'CSE', 'Male', 'muthuvel@gmail.com', 'muthuvel', '2023', '2027', 'II', '54/mmm,vvv', '8787878787', 'S5', '9898989898'),
('GHB055', 'YESHWANTH KUMAR R', '950321104011', 'AI&DS', 'Male', 'yeshwanthkumarr@gmail.com', 'yeshwanthkumarr', '2023', '2027', 'II', '55/yyy,kkk', '8787878787', 'S5', '9898989898'),
('GHB056', 'KARTHIKEYAN', '950321104011', 'EEE', 'Male', 'karthikeyan@gmail.com', 'karthikeyan', '2023', '2027', 'II', '56/kkk,nnn', '8787878787', 'F18', '9898989898'),
('GHB057', 'MATHESH R', '950321104011', 'MECH', 'Male', 'matheshr@gmail.com', 'matheshr', '2023', '2027', 'II', '57/mmm,rrr', '8787878787', 'F18', '9898989898'),
('GHB058', 'PARTHIBAN P', '950321104011', 'EEE', 'Male', 'parthibanp@gmail.com', 'parthibanp', '2023', '2027', 'II', '58/PPP,PPP', '8787878787', 'F18', '9898989898'),
('GHB059', 'LAKSHMANAN', '950321104011', 'ECE', 'Male', 'lakshmanan@gmail.com', 'lakshmanan', '2023', '2027', 'II', '59/lll,nnn', '8787878787', 'F18', '9898989898'),
('GHB060', 'CHRISTAN MARK ', '950321104011', 'AI&DS', 'Male', 'christanmark@gmail.com', 'christanmark', '2023', '2027', 'II', '60/ccc,mmm', '8787878787', 'F19', '9898989898'),
('GHB061', 'SELVA G', '950321104011', 'ECE', 'Male', 'selvag@gmail.com', 'selvag', '2023', '2027', 'II', '61/sss,ggg', '8787878787', 'F19', '9898989898'),
('GHB062', 'PAULDURAI', '950321104011', 'AI&DS', 'Male', 'pauldurai@gmail.com', 'pauldurai', '2023', '2027', 'II', '62/ppp,ddd', '8787878787', 'F19', '9898989898'),
('GHB063', 'ABISHEK M', '950321104011', 'CIVIL', 'Male', 'abishekm@gmail.com', 'abishekm', '2023', '2027', 'II', '63/aaa,mmm', '8787878787', 'F19', '9898989898'),
('GHB064', 'KAVIRAJ', '950321000000', 'CSE', 'Male', 'kaviraj@gmail.com', 'kaviraj', '2023', '2027', 'II', '64/kkk,jjj', '8787878787', 'S4', '9898989898'),
('GHB065', 'MAYAPERUMAL', '950321000000', 'CSE', 'Male', 'mayaperumal@gmail.com', 'mayaperumal', '2023', '2027', 'II', '65/mmm,lll', '8787878787', 'S5', '9898989898'),
('GHB066', 'RAVIKUMAR', '950321000000', 'AI&DS', 'Male', 'ravikumar@gmail.com', 'ravikumar', '2023', '2027', 'II', '66/rrr,kkk', '8787878787', 'S4', '9898989898'),
('GHB067', 'PAULSON', '950321000000', 'AI&DS', 'Male', 'paulson@gmail.com', 'paulson', '2023', '2027', 'II', '67/ppp,nnn', '8787878787', 'F17', '9898989898'),
('GHB068', 'STEPHEN JEBADURAI', '950321000000', 'CSE', 'Male', 'stephenjebadurai@gmail.com', 'stephenjebadurai', '2023', '2027', 'II', '68/sss,jjj', '8787878787', 'F19', '9898989898'),
('GHB069', 'ADIKESAVAN M', '950321000000', 'CSE', 'Male', 'adikesavan@gmail.com', 'adikesavan', '2024', '2028', 'I', '69/aaa,nnn', '8787878787', 'S1', '9898989898'),
('GHB070', 'ARPUTHARAJ G', '950321000000', 'ECE', 'Male', 'arputharajg@gmail.com', 'arputharajg', '2024', '2028', 'I', '70/aaa,ggg', '8787878787', 'S1', '9898989898'),
('GHB071', 'ASHISHRAM S', '950321000000', 'ECE', 'Male', 'ashishrams@gmail.com', 'ashishrams', '2024', '2028', 'I', '71/aaa,mmm', '8787878787', 'S1', '9898989898'),
('GHB072', 'BALAKAMAL', '950321000000', 'EEE', 'Male', 'balakamal@gmail.com', 'balakamal', '2024', '2028', 'I', '72/bbb,kkk', '8787878787', 'S1', '9898989898'),
('GHB073', 'DANIEL S', '950321000000', 'CSE', 'Male', 'daniels@gmail.com', 'daniels', '2024', '2028', 'I', '73/ddd,sss', '8787878787', 'S2', '9898989898'),
('GHB074', 'ELAKKIYAN P', '950321000000', 'CSE', 'Male', 'elakkiyanp@gmail.com', 'elakkiyanp', '2024', '2028', 'I', '74/eee,ppp', '8787878787', 'S2', '9898989898'),
('GHB075', 'FRANKLIN GODSON B', '950321000000', 'MECH', 'Male', 'franklingodsonb@gmail.com', 'franklingodsonb', '2024', '2028', 'I', '75/ggg,bbb', '8787878787', 'S2', '9898989898'),
('GHB076', 'MUTHU SUBASH S', '950321000000', 'CSE', 'Male', 'muthusubashs@gmail.com', 'muthusubashs', '2024', '2028', 'I', '76/mmm,sss', '8787878787', 'S3', '9898989898'),
('GHB077', 'NAVANEETHAN S', '950321000000', 'ECE', 'Male', 'navaneethans@gmail.com', 'navaneethans', '2024', '2028', 'I', '77/nnn,sss', '8787878787', 'S3', '9898989898'),
('GHB078', 'PAVITHRAN R', '950321000000', 'CIVIL', 'Male', 'pavithranr@gmail.com', 'pavithranr', '2024', '2028', 'I', '78/PPP,PPP', '8787878787', 'S3', '9898989898'),
('GHB079', 'PRAVEEN', '950321000000', 'AI&DS', 'Male', 'praveen@gmail.com', 'praveen', '2024', '2028', 'I', '79/ppp,ppp', '8787878787', 'S4', '9898989898'),
('GHB080', 'RAJACHANDRU', '950321000000', 'MECH', 'Male', 'rajachandru@gmail.com', 'rajachandru', '2024', '2028', 'I', '80/rrr,ccc', '8787878787', 'S4', '9898989898'),
('GHB081', 'RAVISHANKAR M', '950321000000', 'CSE', 'Male', 'ravishankarm@gmail.com', 'ravishankarm', '2024', '2028', 'I', '81/rrr,rrr', '8787878787', 'S4', '9898989898'),
('GHB082', 'REJEESH R', '950321000000', 'ECE', 'Male', 'rajeeshr@gmail.com', 'rajeeshr', '2024', '2028', 'I', '82/rrr,rrr', '8787878787', 'S4', '9898989898'),
('GHB083', 'RITHEESWARAN T', '950321000000', 'AI&DS', 'Male', 'ritheeswarant@gmail.com', 'ritheeswarant', '2024', '2028', 'I', '83/nnn,nnn', '8787878787', 'S5', '9898989898'),
('GHB084', 'ROHITH P', '950321000000', 'ECE', 'Male', 'rohithp@gmail.com', 'rohithp', '2024', '2028', 'I', '84/rrr,ppp', '8787878787', 'S5', '9898989898'),
('GHB085', 'SAHIL KUMAR', '950321000000', 'AI&DS', 'Male', 'sahilkumar@gmail.com', 'sahilkumar', '2024', '2028', 'I', '85/sss,kkk', '8787878787', 'S5', '9898989898'),
('GHB086', 'SANTHOSH KUMAR', '950321000000', 'CSE', 'Male', 'santhoshkumar@gmail.com', 'santhoshkumar', '2024', '2028', 'I', '86/sss,kkk', '8787878787', 'S5', '9898989898'),
('GHB087', 'SARAVANAN M', '950321000000', 'CSE', 'Male', 'saravananm@gmail.com', 'saravananm', '2024', '2028', 'I', '87/kkk,kkk', '8787878787', 'S6', '9898989898'),
('GHB088', 'SRINATH D', '950321000000', 'MECH', 'Male', 'srinathd@gmail.com', 'srinathd', '2024', '2028', 'I', '88/kkk,kkk', '8787788787', 'S6', '9898989898'),
('GHB089', 'SUDHAKAR B', '950321000000', 'CSE', 'Male', 'sudhakarb@gmail.com', 'sudhakarb', '2024', '2028', 'I', '89/sss,bbb', '8787878787', 'S6', '9898989898'),
('GHB090', 'SURYA PRASATH S', '950321000000', 'CSE', 'Male', 'suryaprasaths@gmail.com', 'suryaprasaths', '2024', '2028', 'I', '90/sss,ppp', '8787878787', 'S6', '9898989898'),
('GHB091', 'AYYALU SAMY M', '950321000000', 'CSE', 'Male', 'ayyalusamym@gmail.com', 'ayyalusamym', '2024', '2028', 'I', '91/sss,sss', '8787878787', 'S7', '9898989898'),
('GHB092', 'DEVA SHARJIN D', '950321000000', 'CSE', 'Male', 'devasharjind@gmail.com', 'devasharjind', '2024', '2028', 'I', '92/ddd,sss', '8787878787', 'S7', '9898989898'),
('GHB093', 'KISHORE M', '950321000000', 'EEE', 'Male', 'kishorem@gmail.com', 'kishorem', '2024', '2028', 'I', '93/kkk,mmm', '8787878787', 'S7', '9898989898'),
('GHB094', 'THULASI', '950321000000', 'CSE', 'Male', 'thulasi@gmail.com', 'thulasi', '2024', '2028', 'I', '94/ttt,iii', '8787878787', 'S7', '9898989898'),
('GHG001', 'ABIRAMI', '950321000000', 'AI&DS', 'Female', 'abirami@gmail.com', 'abirami', '2024', '2028', 'I', '1/aaa,iii', '8787878787', 'G03', '9898989898'),
('GHG002', 'BAVANI', '950321000000', 'EEE', 'Female', 'bavani@gmail.com', 'bavani', '2022', '2026', 'III', '2/bbb,iii', '8787878787', 'G03', '9898989898'),
('GHG003', 'BRINTHA', '950321000000', 'ECE', 'Female', 'brintha@gmail.com', 'brintha', '2023', '2027', 'II', '3/bbb,ppp', '8787878787', 'G03', '9898989898'),
('GHG004', 'RUBISHA', '950321000000', 'AI&DS', 'Female', 'rubisha@gmail.com', 'rubisha', '2024', '2028', 'I', '4/rrr,rrr', '8787878787', 'G03', '9898989898'),
('GHG005', 'ANJU', '950321000000', 'ECE', 'Female', 'anju@gmail.com', 'anju', '2023', '2027', 'II', '5/rrr,rrr', '8787878787', 'G04', '9898989898'),
('GHG006', 'KANIGA', '950321000000', 'ECE', 'Female', 'kaniga@gmail.com', 'kaniga', '2023', '2027', 'II', '6/rrr,rrr', '8787878787', 'G04', '9898989898'),
('GHG007', 'MUTHU PRIYATHARSHNI', '950321000000', 'AI&DS', 'Female', 'muthupriyatharshini@gmail.com', 'muthupriyatharshini', '2023', '2027', 'II', '7/mmm,ppp', '8787878778', 'G04', '9898989889'),
('GHG008', 'SATHYA', '950321000000', 'AI&DS', 'Female', 'sathya@gmail.com', 'sathya', '2024', '2028', 'I', '8/ppp,ppp', '8787878787', 'G04', '9898989898'),
('GHG009', 'MUTHU SELVI', '950321000000', 'AI&DS', 'Female', 'muthuselvi@gmail.com', 'muthuselvi', '2022', '2026', 'III', '9/mmm,sss', '8787878787', 'G05', '9898989898'),
('GHG010', 'NARMATHA SRI', '950321000000', 'AI&DS', 'Female', 'narmathasri@gmail.com', 'narmathasri', '2022', '2026', 'III', '10/nnn,sss', '8787878787', 'G05', '9898989898'),
('GHG011', 'SATHYA BAMA', '950321000000', 'ECE', 'Female', 'sathyabama@gmail.com', 'sathyabama', '2023', '2027', 'III', '11/sss,bbb', '8787878787', 'G05', '9898989898'),
('GHG012', 'SIVA NANTHINI', '950321000000', 'ECE', 'Female', 'sivananthini@gmail.com', 'sivananthini', '2022', '2026', 'III', '12/nnn,nnn', '8787878787', 'G05', '9898989898'),
('GHG013', 'ATHISHA', '950321000000', 'ECE', 'Female', 'athisha@gmail.com', 'athisha', '2023', '2027', 'II', '13/nnn,nnn', '8787878787', 'G07', '9898989898'),
('GHG014', 'KESHIYA', '950321000000', 'ECE', 'Female', 'keshiya@gmail.com', 'keshiya', '2023', '2027', 'II', '14/nnn,nnn', '8787878787', 'G07', '9898989898'),
('GHG015', 'PANDI LAKSHMI', '950321000000', 'AI&DS', 'Female', 'pandilakshmi@gmail.com', 'pandilakshmi', '2023', '2027', 'II', '15/ppp,lll', '8787878787', 'G07', '9898989898'),
('GHG016', 'SELVA RAHAVI', '950321000000', 'ECE', 'Female', 'selvarahavi@gmail.com', 'selvarahavi', '2023', '2027', 'II', '16/sss,rrr', '8787878787', 'G07', '9898989898'),
('GHG017', 'PEVINA', '950321000000', 'CSE', 'Female', 'pevina@gmail.com', 'pevina', '2023', '2027', 'II', '17/ppp,sss', '8787878787', 'G08', '9898989898'),
('GHG018', 'MARY', '950321000000', 'CSE', 'Female', 'mary@gmail.com', 'mary', '2023', '2027', 'II', '18/mmm,yyy', '8787878787', 'G08', '9898989898'),
('GHG019', 'NISHA.T', '950321000000', 'CIVIL', 'Female', 'nisha@gmail.com', 'nisha', '2023', '2027', 'II', '19/nnn,nnn', '8787878787', 'G08', '9898989898'),
('GHG020', 'SHEELA', '950321000000', 'CSE', 'Female', 'sheela@gmail.com', 'sheela', '2023', '2027', 'II', '20/sss,lll', '8787878787', 'G08', '9898989898'),
('GHG021', 'DHANA LAKSHMI', '950321000000', 'CSE', 'Female', 'dhanalakshmi@gmail.com', 'dhanalakshmi', '2023', '2027', 'II', '21/ddd,lll', '8787878787', 'G09', '9898989898'),
('GHG022', 'HAMIMAH METHRN', '950321000000', 'CSE', 'Female', 'hamimahmethrn@gmail.com', 'hamimahmethrn', '2023', '2027', 'II', '22/hhh,mmm', '8787878787', 'G09', '9898989898'),
('GHG023', 'MUTHU SELVI', '950321000000', 'CSE', 'Female', 'muthuselvi@gmail.com', 'muthuselvi', '2023', '2027', 'II', '23/mmm,sss', '8787878787', 'G09', '9898989898'),
('GHG024', 'NISHA R', '950321000000', 'CSE', 'Female', 'nishar@gmail.com', 'nishar', '2023', '2027', 'II', '24/nnn,rrr', '8787878787', 'G09', '9898989898'),
('GHG025', 'DIVYA DHARSHINI', '950321000000', 'AI&DS', 'Female', 'divyadharshini@gmail.com', 'divyadharshini', '2024', '2028', 'I', '25/ddd,ddd', '8787878787', 'G11', '9898989898'),
('GHG026', 'JEMIMAH ROSELIN', '950321000000', 'AI&DS', 'Female', 'jemimahroselin@gmail.com', 'jemimahroselin', '2024', '2028', 'I', '26/jjj,rrr', '8787878787', 'G11', '9898989898'),
('GHG027', 'JESSICA CAROLINE', '950321000000', 'AI&DS', 'Female', 'jessicacaroline@gmail.com', 'jessicacaroline', '2024', '2028', 'I', '27/jjj,ccc', '8787878787', 'G11', '9898989898'),
('GHG028', 'SUBA LAKSHMI', '950321000000', 'CSE', 'Female', 'subalakshmi@gmail.com', 'subalakshmi', '2024', '2028', 'I', '28/sss,lll', '8787878787', 'G11', '9898989898'),
('GHG029', 'AARTHI', '950321000000', 'CSE', 'Female', 'aarthi@gmail.com', 'aarthi', '2022', '2026', 'III', '29/aaa,aaa', '8787878787', 'G13', '9898989898'),
('GHG030', 'ANITHA', '950321000000', 'CSE', 'Female', 'anitha@gmail.com', 'anitha', '2023', '2027', 'III', '30/aaa,aaa', '8787878787', 'G13', '9898989898'),
('GHG031', 'MUTHU GAYATHRI', '950321000000', 'CSE', 'Female', 'muthugayathri@gmail.com', 'muthugayathri', '2022', '2026', 'III', '31/mmm,mmm', '8787878787', 'G13', '9898989898'),
('GHG032', 'SANGEETHA PRAPHA', '950321000000', 'CSE', 'Female', 'sangeethaprapha@gmail.com', 'sangeethaprapha', '2022', '2026', 'III', '32/sss,ppp', '8787878787', 'G13', '9898989898'),
('GHG033', 'BEAULAH', '950321000000', 'ECE', 'Female', 'beaulah@gmail.com', 'beaulah', '2024', '2028', 'I', '33/bbb,bbb', '8787878787', 'G29', '9898989898'),
('GHG034', 'SIVA SAKTHI', '950321000000', 'ECE', 'Female', 'sivasakthi@gmail.com', 'sivasakthi', '2024', '2028', 'I', '34/sss,sss', '8787878787', 'G29', '9898989898'),
('GHG035', 'ABINAYA', '950321000000', 'ECE', 'Female', 'abinaya@gmail.com', 'abinaya', '2021', '2025', 'IV', '35/aaa,aaa', '8787878787', 'G30', '9898989898'),
('GHG036', 'GODJIN DAMY', '950321000000', 'ECE', 'Female', 'godjindamy@gmail.com', 'godjindamy', '2021', '2025', 'IV', '36/ggg,ddd', '8787878787', 'G30', '9898989898'),
('GHG037', 'TANNU', '950321000000', 'ECE', 'Female', 'tannu@gmail.com', 'tannu', '2021', '2025', 'IV', '37/ttt,ttt', '8787878787', 'G30', '9898989898'),
('GHG038', 'ANITHA', '950321000000', 'CSE', 'Female', 'anitha@gmail.com', 'anitha', '2021', '2025', 'IV', '38/aaa,aaa', '8787878787', 'G31', '9898989898 '),
('GHG039', 'ANANTHA JOTHI', '950321000000', 'CSE', 'Female', 'ananthajothi@gmail.com', 'ananthajothi', '2021', '2025', 'IV', '39/aaa,jjj', '8787878787', 'G31', '9898989898'),
('GHG040', 'KRANTI KUMARI', '950321000000', 'CSE', 'Female', 'krantikumari@gmail.com', 'krantikumari', '2021', '2025', 'IV', '40/kkk,kkk', '8787878787', 'G31', '9898989898'),
('GHG041', 'ASWINI', '950321000000', 'CSE', 'Female', 'aswini@gmail.com', 'aswini', '2024', '2028', 'I', '41/aaa,nnn', '8787878787', 'G33', '9898989898'),
('GHG042', 'MANJU KUMARI', '950321000000', 'CSE', 'Female', 'manjukumari@gmail.com', 'manjukumari', '2024', '2028', 'I', '42/mmm,kkk', '8787878787', 'G33', '9898989898'),
('GHG043', 'MAHARASI', '950321000000', 'CSE', 'Female', 'maharasi@gmail.com', 'maharasi', '2024', '2028', 'I', '43/mmm,rrr', '8787878787', 'G33', '9898989898'),
('GHG044', 'SELVI SREE', '950321000000', 'CSE', 'Female', 'selvisree@gmail.com', 'selvisree', '2024', '2028', 'I', '44/sss,sss', '8787878787', 'G33', '9898989898'),
('GHG045', 'KEERTHIKA', '950321000000', 'AI&DS', 'Female', 'keerthika@gmail.com', 'keerthika', '2024', '2028', 'I', '45/kkk,kkk', '8787878787', 'G34', '9898989898'),
('GHG046', 'SAMSU NIHANA', '950321000000', 'CSE', 'Female', 'samsunihana@gmail.com', 'samsunihana', '2024', '2028', 'I', '46/sss,nnn', '8787878787', 'G34', '9898989898'),
('GHG047', 'SRIYA', '950321000000', 'CSE', 'Female', 'sriya@gmail.com', 'sriya', '2024', '2028', 'I', '47/sss,sss', '8787878787', 'G34', '9898989898'),
('GHG048', 'VISHALINI', '950321000000', 'CIVIL', 'Female', 'vishalini@gmail.com', 'vishalini', '2024', '2028', 'I', '48/vvv,iii', '8787878787', 'G34', '9898989898'),
('GHG049', 'ARUL JOTHI', '950321000000', 'CSE', 'Female', 'aruljothi@gmail.com', 'aruljothi', '2023', '2027', 'II', '49/aaa,jjj', '8787878787', 'G35', '9898989898'),
('GHG050', 'FATHIMA EBISIBA', '950321000000', 'CSE', 'Female', 'fathimaebisiba@gmail.com', 'fathimaebisiba', '2023', '2027', 'II', '50/aaa,jjj', '8787878787', 'G35', '9898989898'),
('GHG051', 'MANJULA', '950321000000', 'CSE', 'Female', 'manjula@gmail.com', 'manjula', '2023', '2027', 'II', '51/mmm,mmm', '8787878787', 'G35', '9898989898'),
('GHG052', 'SELVI ESWARI', '950321000000', 'CSE', 'Female', 'selvieswari@gmail.com', 'selvieswari', '2023', '2027', 'II', '52/sss,eee', '8787878787', 'G35', '9898989898'),
('GHG053', 'PRITI RANI LIMMA', '950321000000', 'CSE', 'Female', 'pritiranilimma@gmail.com', 'pritiranilimma', '2022', '2026', 'III', '53/ppp,lll', '8787878787', 'G36', '9898989898'),
('GHG054', 'RAJA PRIYA', '950321000000', 'CSE', 'Female', 'rajapriya@gmail.com', 'rajapriya', '2022', '2026', 'III', '54/lll,lll', '8787878787', 'G36', '9898989898'),
('GHG055', 'SUSANNA KUMARI', '950321000000', 'CSE', 'Female', 'susannakumari@gmail.com', 'susannakumari', '2022', '2026', 'III', '55/sss,kkk', '8787878787', 'G36', '9898989898'),
('GHG056', 'ANUSHIYA', '950321000000', 'CSE', 'Female', 'anushiya@gmail.com', 'anushiya', '2022', '2026', 'III', '56/aaa,aaa', '8787878787', 'G37', '9898989898'),
('GHG057', 'MURUGAVALLI', '950321000000', 'EEE', 'Female', 'murugavalli@gmail.com', 'murugavalli', '2022', '2026', 'III', '57/mmm,lll', '8787878787', 'G37', '9898989898'),
('GHG058', 'RAMA DEVI', '950321000000', 'EEE', 'Female', 'ramadevi@gmail.com', 'ramadevi', '2023', '2027', 'II', '58/rrr,ddd', '8787878787', 'G37', '9898989898'),
('GHG059', 'TAMILMOZHI', '950321000000', 'CSE', 'Female', 'tamilmozhi@gmail.com', 'tamilmozhi', '2022', '2026', 'III', '59/ttt,mmm', '8787878787', 'G37', '9898989898');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `rid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `department` varchar(200) NOT NULL,
  `current_year` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`rid`, `name`, `email`, `password`, `gender`, `mobile`, `department`, `current_year`) VALUES
('F1', 'DR.K.M.ALAAUDEEN', 'alaaudeen.km@gmail.com', 'alaaudeenkm', 'Male', '8787878787', 'CSE', 'IV'),
('F10', 'MRS.A.SAMSU NIGHAR', 'samsunighar@grace.edu.in', 'samsunighar', 'Female', '8787878787', 'ECE', 'III'),
('F11', 'MRS.M.SENTHAMIL SELVI', 'senthamilselvi@grace.edu.in', 'senthamilselvi', 'Female', '8787878787', 'ECE', 'II'),
('F12', 'MRS.E.M.UMA SELVI', 'umaselvi@grace.edu.in', 'umaselvi', 'Female', '8787878787', 'ECE', 'IV'),
('F13', 'MRS.P.TAMILSELVI', 'tamilashu22@gmail.com', 'tamilashu22', 'Female', '8787878787', 'ECE', 'III'),
('F14', 'MRS.P.GAYATHRI', 'gayathri@grace.edu.in', 'gayathri', 'Female', '8778878787', 'EEE', 'IV'),
('F15', 'MRS.L.PRAISY', 'praisy@grace.edu.in', 'praisy', 'Female', '8787878787', 'EEE', 'III'),
('F16', 'MS.R.KOWSHIKA', 'kowshika@grace.edu.in', 'kowshika', 'Female', '8787878787', 'EEE', 'II'),
('F17', 'DR.NALINI JEBASTINA', 'nalinijebastina@grace.edu.in', 'nalinijebastina', 'Female', '8787878787', 'CIVIL', 'IV'),
('F18', 'MR.R.NITHIN', 'rajannithin59@gmail.com', 'rajannithin59', 'Male', '8787878787', 'CIVIL', 'IV'),
('F19', 'MRS.S.PRABHA', 'prabha@grace.edu.in', 'prabha', 'Female', '8787878787', 'CIVIL', 'III'),
('F2', 'MS.S.ABARNA', 'abarna@grace.edu.in', 'abarna', 'Female', '8787878787', 'CSE', 'III'),
('F20', 'MRS.A.L.SWARNA', 'swarnavinoth39@gmail.com', 'swarnavinoth39', 'Female', '8787878787', 'CIVIL', 'III'),
('F21', 'MRS.S.DHANA LAKSHMI', 'dhanalakshmi@grace.edu.in', 'dhanalakshmi', 'Female', '8787878787', 'CIVIL', 'II'),
('F22', 'DR.L.DANIEL DEVARAJ', 'danieldevaraj@grace.edu.in', 'danieldevaraj', 'Male', '8787878787', 'MECH', 'IV'),
('F23', 'DR.M.D.MOHAN GIFT', 'gift@gmail.com', 'gift', 'Male', '9878787887', 'MECH', 'IV'),
('F24', 'DR.S.RICHARD', 'iamrichi@gmail.com', 'iamrichi', 'Male', '9443113113', 'MECH', 'III'),
('F25', 'MR.W.SURIYA PRABHU TYAGAR', 'suriyaprabhutyagar@grace.edu.in\r\n', 'suriyaprabhutyagar', 'Male', '9887878787', 'MECH', 'III'),
('F26', 'MR.M.MAHARAJA', 'maharaja@grace.edu.in', 'maharaja', 'Male', '8787878787', 'MECH', 'II'),
('F27', 'MR.P.THANGA KUMAR', 'thangakumar@gracecoe.org', 'thangakumar', 'Male', '8787878787', 'MECH', 'II'),
('F28', 'MRS.S.PORKODI', 'porkodi@gracecoe.org', 'porkodi', 'Female', '8787878787', 'AI&DS', 'IV'),
('F29', 'MRS.R.JANANI', 'janani@grace.edu.in', 'janani', 'Female', '8787878787', 'AI&DS', 'III'),
('F3', 'Dr.I.FELCIA JERLIN', 'felciajerlin@grace.edu.in', 'felciajerlin', 'Female', '8787878787', 'CSE', 'III'),
('F30', 'DR.J.ANTONY REX RODRIGO', 'rodrigoantonyrex@gmail.com', 'rodrigoantonyrex', 'Male', '8787878787', 'CSE', 'I'),
('F31', 'MR.R.RAMAN', 'raman@grace.edu.in', 'raman', 'Male', '8787878787', 'CSE', 'I'),
('F32', 'MRS.G.JEYANTHA', 'jeyantha96@gmail.com\r\n', 'jeyantha96', 'Female', '8787878787', 'CSE', 'I'),
('F34', 'MRS.G.SOMA SUNDARI ', 'somasundari@grace.edu.in', 'somasundari', 'Female', '8787878787', 'ECE', 'I'),
('F35', 'MRS.J.JINIKAMAL EASTRO', 'jinikamal1981@gmail.com\r\n', 'jinikamal1981', 'Female', '8787878787', 'CSE', 'I'),
('F36', 'Dr.G.VICTOR EMMANUEL', 'emmanuelvidhya@gmail.com\r\n', 'emmanuelvidhya', 'Male', '8787878787', 'ECE', 'I'),
('F37', 'MRS.G.AROCKIA SHINEY', 'arockiashiney@grace.edu.in', 'arockiashiney', 'Female', '8787878787', 'EEE', 'I'),
('F38', 'DR.R.JAQULIN ISABELLA', 'drjaqulinisabella@gmail.com', 'drjaqulinisabella', 'Female', '8787878787', 'EEE', 'I'),
('F39', 'MR.M.SIVA KUMAR', 'avis7062@gmail.com\r\n', 'avis7062', 'Male', '8787878787', 'MECH', 'I'),
('F4', 'MRS.P.JOY SUGANTHY BAI', 'joysuganthybai@gracecoe.org', 'joysuganthybai', 'Female', '8787878787', 'CSE', 'III'),
('F40', 'MR.S.SELVA PREMKUMAR', 'selvapremkumar@grace.edu.in', 'selvapremkumar', 'Male', '8787878787', 'MECH', 'I'),
('F41', 'MRS.R.SARANYA', 'saranya@gracecoe.org', 'saranya', 'Female', '8787878787', 'CIVIL', 'I'),
('F42', 'MS.S.DYANA FLORA', 'dyanaflora@grace.edu.in', 'dyanaflora', 'Female', '8787878787', 'AI&DS', 'I'),
('F5', 'MRS.P.SUBASHREE KASI THANGAM', 'subashreekasithangam@grace.edu.in', 'subashreekasithangam', 'Female', '8787878787', 'CSE', 'II'),
('F6', 'MRS.V.REVATHY', 'revathy@grace.edu.in', 'revathy', 'Female', '8787878787', 'CSE', 'II'),
('F7\r\n', 'Ms.I.M.S.B.REBECCA', 'rebecca@grace.edu.in', 'rebecca', 'Female', '8787878787', 'CSE', 'II'),
('F8', 'MR.M.KRISHNA KUMAR', 'krishnakumar@grace.edu.in', 'krishnakumar', 'Male', '8787878787', 'ECE', 'IV'),
('F9', 'MR.R.JAMES NEASARATNAM', 'jamesnesaratnam@grace.edu.in', 'jamesnesaratnam', 'Male', '8787878787', 'ECE', 'IV'),
('R1', 'G.SANTHIYA', 'santhiya@gmail.com', 'santhiya', 'Female', '9887898791', '', ''),
('R2', 'E.PUSHPARAGAM', 'pushparagam@gmail.com', 'pushparagam', 'Female', '9887988776', '', ''),
('R3', 'Dr.K.M.ALAAUDEEN', 'alaaudeen.km@gmail.com', 'alaaudeen', 'Male', '9994446197', '', ''),
('R4', 'VINITH', 'vinith@gmail.com', 'vinith', 'Male', '8999898799', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_year`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Dept_name`);

--
-- Indexes for table `food_schedule`
--
ALTER TABLE `food_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outpass_requests`
--
ALTER TABLE `outpass_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_no`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `sid` (`sid`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`rid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `food_schedule`
--
ALTER TABLE `food_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `outpass_requests`
--
ALTER TABLE `outpass_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
