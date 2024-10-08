-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2024 at 01:31 PM
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
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `FullName`, `email`, `updationDate`) VALUES
(1, 'admin', '$2y$10$Fnv2vggQTtJlSRnnMcyy5uBMrx8ba2oJmxuKxEt6DTWDajuLioss.', 'Admin', 'admin@gmail.com', '2024-07-10 09:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `Name` varchar(150) DEFAULT NULL,
  `ShortName` varchar(100) NOT NULL,
  `Code` varchar(50) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `Name`, `ShortName`, `Code`, `CreationDate`) VALUES
(1, 'Human Resource', 'HR', 'HR001', '2024-07-12 09:37:00'),
(2, 'Information Technology', 'IT', 'IT002', '2024-07-12 09:37:00'),
(3, 'Operations', 'OP', 'OP003', '2024-07-12 09:37:00'),
(4, 'Marketing', 'MK', 'MK004', '2024-07-12 09:37:00'),
(5, 'Finance', 'FI', 'FI005', '2024-07-12 09:37:00'),
(6, 'Sales', 'SS', 'SS006', '2024-07-12 09:37:00'),
(15, 'Research', 'RS', 'RS007', '2024-07-12 09:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(180) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `City` varchar(200) NOT NULL,
  `Phone` char(11) NOT NULL,
  `Status` int(1) NOT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `salary` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `EmpId`, `FirstName`, `LastName`, `Email`, `Password`, `Gender`, `Dob`, `Department`, `Address`, `City`, `Phone`, `Status`, `RegDate`, `salary`) VALUES
(1, 'ASTR001245', 'Johnny', 'Scott', 'johnny@mail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 'Male', '1996-06-12', 'Information Technology', '49 Arron Smith Drive', 'Honolulu', '7854785477', 1, '2020-11-10 05:29:59', 0),
(2, 'Cum maxime quidem to', 'Shad', 'Samantha', 'samumofuse@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Male', '1983-04-24', 'Information Technology', 'Cumque quam qui volu', 'Cum ex voluptatem of', '+1 (982) 97', 1, '2024-07-12 02:12:20', 0),
(3, 'Eaque molestiae earu', 'Yoko', 'Arden', 'xekunaza@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Male', '2023-05-08', 'Operations', 'In sed veniam est ', 'Labore vitae laudant', '+1 (932) 62', 1, '2024-07-12 02:13:01', 0),
(4, 'Neque qui ut sapient', 'Carolyn', 'Dolan', 'cezagulosu@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Female', '1970-01-21', 'Marketing', 'Ut consequatur nemo', 'Est earum sed irure', '+1 (918) 18', 1, '2024-07-12 02:13:22', 0),
(5, 'Praesentium magna ip', 'Kyle', 'Ivana', 'dumuq@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Female', '1977-07-05', 'Quinn', 'Tiger', 'Odysseus', '01234567890', 1, '2024-07-12 02:30:44', 0),
(6, 'Veniam est beatae ', 'Gil', 'Wayne', 'xybuletopo@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Female', '2008-12-13', 'Kirby', 'Mufutau', 'Chloe', '03214569877', 1, '2024-07-12 02:30:54', 0),
(8, 'Cupiditate sint eli', 'Lesley', 'Aileen', 'nokybeqine@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Other', '2009-11-06', 'Patience', 'Vanna', 'Cameron', '03214569877', 1, '2024-07-12 02:32:40', 0),
(9, 'Sed ut eaque corpori', 'Joelle', 'Cassidy', 'qytape@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Female', '1988-07-07', 'Olivia', 'Madeson', 'Quyn', '01235469871', 1, '2024-07-12 02:35:37', 0),
(10, 'Tempora aspernatur s', 'Wesley', 'Kiara', 'sysyji@mailinator.com', 'f3ed11bbdb94fd9ebdefbaf646ab94d3', 'Female', '2009-09-27', 'Heidi', 'Bruce', 'Kane', '01234567893', 1, '2024-07-12 02:35:54', 0),
(11, 'EX9', 'Farhan ', 'Chowdhury', 'fx@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '2000-11-10', 'Information Technology', 'cv c', 'nkjnk', '545646542', 1, '2024-07-12 06:49:33', 50000),
(12, 'ER45', 'Shahrior', 'Rahman', 'sh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '2000-06-29', 'Marketing', 'sfssssssss', 'dff', '', 1, '2024-07-12 08:08:58', 50000),
(13, 'ZH12', 'Zahid', 'Hasan', 'zh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '2000-06-16', 'Finance', 'Dhaka', 'Dhaka', '01234567891', 1, '2024-07-15 12:19:54', 45000);

-- --------------------------------------------------------

--
-- Table structure for table `employee_salary`
--

CREATE TABLE `employee_salary` (
  `id` int(11) NOT NULL,
  `empId` int(11) NOT NULL,
  `salary_in` double DEFAULT NULL,
  `salary_out` double DEFAULT NULL,
  `balance` double NOT NULL,
  `month` varchar(25) NOT NULL,
  `payout_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_salary`
--

INSERT INTO `employee_salary` (`id`, `empId`, `salary_in`, `salary_out`, `balance`, `month`, `payout_date`) VALUES
(1, 11, 50000, 0, 50000, 'January', '2024-07-15 16:37:11'),
(2, 11, 50000, 0, 100000, 'February', '2024-07-15 16:38:37'),
(3, 13, 45000, 0, 45000, 'January', '2024-07-15 16:42:28'),
(4, 12, 50000, 0, 50000, 'February', '2024-07-17 04:28:27'),
(5, 11, 0, 15000, 85000, 'July', '2024-07-17 12:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `AdminRemark` mediumtext DEFAULT NULL,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int(1) NOT NULL,
  `IsRead` int(1) NOT NULL,
  `empid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `LeaveType`, `ToDate`, `FromDate`, `Description`, `PostingDate`, `AdminRemark`, `AdminRemarkDate`, `Status`, `IsRead`, `empid`) VALUES
(1, 'Annual Leave', '2024-07-15', '2024-07-10', 'Et aliquam neque sit', '2024-07-12 12:02:24', 'Enjoy', '2024-07-12 18:57:39 ', 1, 1, 11),
(2, 'Sick Leave', '2024-07-16', '2024-07-15', 'Ratione at est iure ', '2024-07-12 12:09:57', 'Happy vacation', '2024-07-12 23:50:28 ', 1, 1, 12),
(3, 'Sick Leave', '2024-07-14', '2024-07-09', 'jbjhvfty yfytf', '2024-07-12 17:53:18', 'snekfjbsgjhdg rf', '2024-07-12 23:54:35 ', 2, 1, 11),
(4, 'Sick Leave', '2024-07-15', '2024-07-13', 'need', '2024-07-13 09:15:58', NULL, NULL, 0, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `leavetype`
--

CREATE TABLE `leavetype` (
  `id` int(11) NOT NULL,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leavetype`
--

INSERT INTO `leavetype` (`id`, `LeaveType`, `Description`, `CreationDate`) VALUES
(1, 'Annual Leave', 'Leave taken for personal vacation or rest', '2024-07-12 11:42:59'),
(2, 'Sick Leave', 'Leave taken due to illness or medical appointments', '2024-07-12 11:42:59'),
(3, 'Maternity Leave', 'Leave taken for childbirth and care of a newborn', '2024-07-12 11:42:59'),
(4, 'Paternity Leave', 'Leave taken by a father for the birth and care of a newborn', '2024-07-12 11:42:59'),
(5, 'Bereavement Leave', 'Leave taken due to the death of a family member', '2024-07-12 11:42:59'),
(6, 'Study Leave', 'Leave taken for educational purposes or exams', '2024-07-12 11:42:59'),
(7, 'Unpaid Leave', 'Leave taken without pay for personal reasons', '2024-07-12 11:42:59');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `starting_date` date NOT NULL,
  `closing_date` date NOT NULL,
  `submission_date` date DEFAULT NULL,
  `documents` varchar(255) NOT NULL,
  `submitted_documents` varchar(255) DEFAULT NULL,
  `empId` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `admin_remarks` varchar(255) DEFAULT NULL,
  `admin_feedback` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `starting_date`, `closing_date`, `submission_date`, `documents`, `submitted_documents`, `empId`, `status`, `admin_remarks`, `admin_feedback`) VALUES
(1, 'Illo hic porro repud', 'Aliqua Impedit max', '2024-04-12', '2024-04-15', NULL, '../assets/project_file/xyz.pdf', NULL, 1, 0, NULL, NULL),
(2, 'Cupiditate quas amet', 'Occaecat ex anim fac', '2024-05-15', '2024-05-15', '2024-07-13', '../assets/project_file/zyx.pdf', '../assets/project_file/NSIC_PROJECT_PROFILE - NSIC_PROJECT_PROFILE.csv.pdf', 11, 1, '9', 'Well Done, You did it well'),
(3, 'Login page', 'adeafef', '2024-07-12', '2024-07-15', NULL, '../assets/project_file/Pragoitihashik By Manik Bandopadhyay (BDeBooks.Com).pdf', NULL, 12, 0, NULL, NULL),
(4, 'Quis accusantium nih', 'Quas quas dolor sit', '1974-08-27', '2003-08-31', NULL, '../assets/project_file/niir_org - niir_org.csv.pdf', NULL, 5, 0, NULL, NULL),
(5, 'Registration Page', 'Design and develop full responsive registration page', '2024-07-13', '2024-07-14', '2024-07-13', '../assets/project_file/niir_org - niir_org.csv.pdf', '../assets/project_file/NSIC_PROJECT_PROFILE - NSIC_PROJECT_PROFILE.csv.pdf', 12, 1, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_salary`
--
ALTER TABLE `employee_salary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leavetype`
--
ALTER TABLE `leavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_salary`
--
ALTER TABLE `employee_salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `leavetype`
--
ALTER TABLE `leavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
