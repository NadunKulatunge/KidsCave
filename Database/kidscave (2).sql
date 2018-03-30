-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2018 at 07:45 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kidscave`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deletePayment` (IN `payment_id` INT(11))  BEGIN   
           DELETE FROM student_payment_detail WHERE studentPaymentDetailID = payment_id;  
           END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertPayment` (IN `description` VARCHAR(250), `totalAmount` VARCHAR(250))  BEGIN  
                INSERT INTO student_payment_detail(description, totalAmount) VALUES (description, totalAmount);   
                END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selectPayment` ()  BEGIN  
      SELECT * FROM student_payment_detail ORDER BY studentPaymentDetailID DESC;  
      END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updatePayment` (IN `payment_id` INT(11), `description` VARCHAR(250), `totalAmount` VARCHAR(250))  BEGIN   
                UPDATE student_payment_detail SET description = description, totalAmount = totalAmount  
                WHERE studentPaymentDetailID = payment_id;  
                END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `wherePayment` (IN `payment_id` INT(11))  BEGIN   
      SELECT * FROM student_payment_detail WHERE studentPaymentDetailID = payment_id;  
      END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `classID` int(1) NOT NULL,
  `className` varchar(50) NOT NULL,
  `maxCapacity` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='To store the class names in the nursery ';

-- --------------------------------------------------------

--
-- Table structure for table `class_announcement`
--

CREATE TABLE `class_announcement` (
  `classAnnouncementID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teacherID` int(11) NOT NULL,
  `classID` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_period`
--

CREATE TABLE `class_period` (
  `classPeriodID` int(2) NOT NULL,
  `fromTime` time NOT NULL,
  `toTime` time NOT NULL,
  `periodName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_timetable`
--

CREATE TABLE `class_timetable` (
  `classTimetableID` int(11) NOT NULL,
  `classID` int(1) NOT NULL,
  `dayName` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `periodID` int(2) NOT NULL,
  `activeStatus` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `studentAttendanceID` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('0','1') NOT NULL,
  `informed` enum('0','1') NOT NULL,
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_guardian`
--

CREATE TABLE `student_guardian` (
  `student_guardianID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Phone` varchar(10) NOT NULL,
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_leave`
--

CREATE TABLE `student_leave` (
  `studentLeaveID` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `reason` varchar(500) NOT NULL,
  `teacherApprove` enum('0','1') NOT NULL,
  `principalApprove` enum('0','1') NOT NULL,
  `studentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_payment`
--

CREATE TABLE `student_payment` (
  `studentPaymentID` int(11) NOT NULL,
  `paymentYear` year(4) NOT NULL,
  `userID` int(11) NOT NULL,
  `totalAmount` decimal(10,0) NOT NULL,
  `discount` int(2) NOT NULL,
  `amountPaid` decimal(10,0) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `paymentMethod` enum('Cash','Card') NOT NULL,
  `cashNote` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_payment`
--

INSERT INTO `student_payment` (`studentPaymentID`, `paymentYear`, `userID`, `totalAmount`, `discount`, `amountPaid`, `timestamp`, `startDate`, `endDate`, `paymentMethod`, `cashNote`) VALUES
(26, 2018, 9, '5608', 0, '5608', '2018-03-18 19:49:45', '2018-01-01', '2018-05-01', 'Cash', '0'),
(27, 2018, 9, '5608', 0, '5608', '2018-03-18 19:53:42', '2018-05-01', '2018-09-01', 'Cash', '0'),
(28, 2018, 9, '5608', 0, '5608', '2018-03-18 19:53:45', '2018-09-01', '2019-01-01', 'Cash', '0');

-- --------------------------------------------------------

--
-- Table structure for table `student_payment_detail`
--

CREATE TABLE `student_payment_detail` (
  `studentPaymentDetailID` int(11) NOT NULL,
  `description` text NOT NULL,
  `totalAmount` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_payment_detail`
--

INSERT INTO `student_payment_detail` (`studentPaymentDetailID`, `description`, `totalAmount`) VALUES
(3, 'Phone Bills', '2000'),
(4, 'Payment2', '2400'),
(5, 'Payment 3', '12424'),
(7, 'izus iusnui', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `userPass` varchar(100) NOT NULL,
  `userStatus` enum('Y','N') NOT NULL DEFAULT 'N',
  `userRole` enum('Parent','Teacher','Admin','Principal') NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birthday` date NOT NULL,
  `tokenCode` varchar(100) NOT NULL,
  `activeStatus` enum('active','retired') NOT NULL,
  `adminApprove` enum('0','1') NOT NULL,
  `principalApprove` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `userName`, `userEmail`, `userPass`, `userStatus`, `userRole`, `gender`, `birthday`, `tokenCode`, `activeStatus`, `adminApprove`, `principalApprove`) VALUES
(5, 'parent', 'parent@email.com', 'd0e45878043844ffc41aac437e86b602', 'Y', 'Parent', 'Male', '0000-00-00', '3e1c4712a2e3ce34dbf37ed5e55a2d91', 'active', '0', '0'),
(6, 'teacher', 'teacher@email.com', '8d788385431273d11e8b43bb78f3aa41', 'Y', 'Teacher', 'Male', '0000-00-00', '9a6a8dea5468547bcf0be39ce28759a7', 'active', '0', '0'),
(7, 'admin', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', 'Y', 'Admin', 'Male', '0000-00-00', '868adaf6b19de92c879587c1262d7c2c', 'active', '0', '0'),
(8, 'principal', 'principal@email.com', 'e7d715a9b79d263ae527955341bbe9b1', 'Y', 'Principal', 'Male', '0000-00-00', '14bd8a2fa2f9961c69c411058a1d504f', 'active', '0', '0'),
(9, 'parent1', 'parent1@email.com', '34f83b4b453db075f374fa73365b8283', 'Y', 'Parent', 'Male', '0000-00-00', '91589cf2467fb0759062c27e9c24a090', 'active', '0', '0'),
(10, 'teacher1', 'teacher1@email.com', '41c8949aa55b8cb5dbec662f34b62df3', 'N', 'Parent', 'Male', '0000-00-00', 'd248a908125bca33e16b3984f238da56', 'active', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacherID` int(11) NOT NULL,
  `classID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_appointment`
--

CREATE TABLE `teacher_appointment` (
  `teacherAppointmentID` int(11) NOT NULL,
  `guardianID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `appoinmentDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `venue` varchar(300) NOT NULL,
  `approvalTeacher` enum('0','1') NOT NULL,
  `approvalGuardian` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_leave`
--

CREATE TABLE `teacher_leave` (
  `teacherLeaveID` int(11) NOT NULL,
  `fromDate` date NOT NULL,
  `toDate` date NOT NULL,
  `principalApprove` enum('0','1') NOT NULL,
  `teacherID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classID`);

--
-- Indexes for table `class_announcement`
--
ALTER TABLE `class_announcement`
  ADD PRIMARY KEY (`classAnnouncementID`);

--
-- Indexes for table `class_period`
--
ALTER TABLE `class_period`
  ADD PRIMARY KEY (`classPeriodID`);

--
-- Indexes for table `class_timetable`
--
ALTER TABLE `class_timetable`
  ADD PRIMARY KEY (`classTimetableID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`studentAttendanceID`);

--
-- Indexes for table `student_guardian`
--
ALTER TABLE `student_guardian`
  ADD PRIMARY KEY (`student_guardianID`);

--
-- Indexes for table `student_leave`
--
ALTER TABLE `student_leave`
  ADD PRIMARY KEY (`studentLeaveID`);

--
-- Indexes for table `student_payment`
--
ALTER TABLE `student_payment`
  ADD PRIMARY KEY (`studentPaymentID`);

--
-- Indexes for table `student_payment_detail`
--
ALTER TABLE `student_payment_detail`
  ADD PRIMARY KEY (`studentPaymentDetailID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherID`);

--
-- Indexes for table `teacher_appointment`
--
ALTER TABLE `teacher_appointment`
  ADD PRIMARY KEY (`teacherAppointmentID`);

--
-- Indexes for table `teacher_leave`
--
ALTER TABLE `teacher_leave`
  ADD PRIMARY KEY (`teacherLeaveID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `classID` int(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_announcement`
--
ALTER TABLE `class_announcement`
  MODIFY `classAnnouncementID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_period`
--
ALTER TABLE `class_period`
  MODIFY `classPeriodID` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `class_timetable`
--
ALTER TABLE `class_timetable`
  MODIFY `classTimetableID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `studentAttendanceID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_guardian`
--
ALTER TABLE `student_guardian`
  MODIFY `student_guardianID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_leave`
--
ALTER TABLE `student_leave`
  MODIFY `studentLeaveID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_payment`
--
ALTER TABLE `student_payment`
  MODIFY `studentPaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `student_payment_detail`
--
ALTER TABLE `student_payment_detail`
  MODIFY `studentPaymentDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_appointment`
--
ALTER TABLE `teacher_appointment`
  MODIFY `teacherAppointmentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_leave`
--
ALTER TABLE `teacher_leave`
  MODIFY `teacherLeaveID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
