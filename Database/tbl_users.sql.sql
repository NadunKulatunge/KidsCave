-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2018 at 02:13 PM
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
(2, 'Nadun Kulatunge', 'kulatunge.nadun070@gmail.com', '51274a400090fbf5f2c6e284a1032f67', 'Y', 'Parent', 'Male', '0000-00-00', '0bfd4b127c5e4788693985204bc6425a', 'active', '0', '0'),
(3, 'dd', 'dd@gmail.com', '1aabac6d068eef6a7bad3fdf50a05cc8', 'Y', 'Teacher', 'Male', '0000-00-00', '63a1ae42d7aa4d55eec452ef8559ee2e', 'active', '0', '0'),
(4, 'Katherine Pierce', 'kpm@gmail.com', '386c57017f4658ca5215569643f0189d', 'Y', 'Parent', 'Male', '0000-00-00', '4d6f70b914fb19fb1ca3da66f4590039', 'active', '0', '0'),
(5, 'parent', 'parent@email.com', 'd0e45878043844ffc41aac437e86b602', 'Y', 'Parent', 'Male', '0000-00-00', '3e1c4712a2e3ce34dbf37ed5e55a2d91', 'active', '0', '0'),
(6, 'teacher', 'teacher@email.com', '8d788385431273d11e8b43bb78f3aa41', 'Y', 'Teacher', 'Male', '0000-00-00', '9a6a8dea5468547bcf0be39ce28759a7', 'active', '0', '0'),
(7, 'admin', 'admin@email.com', '21232f297a57a5a743894a0e4a801fc3', 'Y', 'Admin', 'Male', '0000-00-00', '868adaf6b19de92c879587c1262d7c2c', 'active', '0', '0'),
(8, 'principal', 'principal@email.com', 'e7d715a9b79d263ae527955341bbe9b1', 'Y', 'Principal', 'Male', '0000-00-00', '14bd8a2fa2f9961c69c411058a1d504f', 'active', '0', '0'),
(9, 'parent1', 'parent1@email.com', '34f83b4b453db075f374fa73365b8283', 'Y', 'Parent', 'Male', '0000-00-00', '91589cf2467fb0759062c27e9c24a090', 'active', '0', '0'),
(10, 'teacher1', 'teacher1@email.com', '41c8949aa55b8cb5dbec662f34b62df3', 'N', 'Parent', 'Male', '0000-00-00', 'd248a908125bca33e16b3984f238da56', 'active', '0', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
