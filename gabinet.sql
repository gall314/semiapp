-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2017 at 01:21 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gabinet`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `app_id` int(255) NOT NULL,
  `date_id` int(255) NOT NULL,
  `patient_id` int(12) NOT NULL,
  `registrar` int(12) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`app_id`, `date_id`, `patient_id`, `registrar`, `comment`) VALUES
(74, 71, 55, 15, ''),
(75, 69, 15, 15, ''),
(76, 4, 47, 15, ''),
(80, 9, 100, 1, ''),
(81, 27, 47, 1, ''),
(83, 67, 1, 1, ''),
(84, 101, 55, 15, ''),
(85, 84, 39, 1, ''),
(86, 85, 15, 15, ''),
(88, 104, 15, 15, ''),
(97, 7, 15, 15, ''),
(98, 5, 15, 15, ''),
(99, 86, 35, 1, ''),
(101, 202, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `date_id` int(12) NOT NULL,
  `date` datetime NOT NULL,
  `doc_id` int(10) NOT NULL,
  `open` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`date_id`, `date`, `doc_id`, `open`) VALUES
(3, '2017-07-01 14:10:30', 37, 1),
(14, '2017-06-24 00:00:00', 7, 1),
(15, '2017-06-24 09:00:00', 7, 1),
(16, '2017-06-24 09:00:00', 7, 1),
(17, '2017-06-24 09:00:00', 7, 1),
(19, '2017-06-23 09:00:00', 57, 1),
(23, '2017-07-24 09:00:00', 7, 1),
(25, '2017-07-04 09:00:00', 7, 1),
(26, '2017-07-18 09:00:00', 7, 0),
(27, '2017-07-12 09:00:00', 7, 0),
(28, '2017-07-12 09:00:00', 7, 1),
(30, '2017-07-11 09:00:00', 7, 1),
(31, '2017-07-11 09:00:00', 7, 1),
(68, '2017-07-03 09:00:00', 7, 1),
(69, '2017-07-03 09:30:00', 7, 0),
(70, '2017-07-03 10:00:00', 7, 1),
(71, '2017-07-03 10:30:00', 7, 0),
(72, '2017-07-03 11:00:00', 7, 1),
(73, '2017-07-03 11:30:00', 7, 1),
(74, '2017-07-03 12:00:00', 7, 1),
(75, '2017-07-03 12:30:00', 7, 1),
(76, '2017-07-03 13:00:00', 7, 1),
(77, '2017-07-03 13:30:00', 7, 1),
(78, '2017-07-03 14:00:00', 7, 1),
(79, '2017-07-03 14:30:00', 7, 1),
(80, '2017-07-03 15:00:00', 7, 1),
(81, '2017-07-03 15:30:00', 7, 1),
(82, '2017-07-03 16:00:00', 7, 1),
(83, '2017-07-03 16:30:00', 7, 1),
(84, '2017-07-06 09:00:00', 7, 0),
(85, '2017-07-06 09:30:00', 7, 0),
(86, '2017-07-06 10:00:00', 7, 0),
(87, '2017-07-06 10:30:00', 7, 1),
(88, '2017-07-06 11:00:00', 7, 1),
(89, '2017-07-06 11:30:00', 7, 1),
(90, '2017-07-06 12:00:00', 7, 1),
(91, '2017-07-06 12:30:00', 7, 1),
(92, '2017-07-06 13:00:00', 7, 1),
(93, '2017-07-06 13:30:00', 7, 1),
(94, '2017-07-06 14:00:00', 7, 1),
(95, '2017-07-06 14:30:00', 7, 1),
(96, '2017-07-06 15:00:00', 7, 1),
(97, '2017-07-06 15:30:00', 7, 1),
(98, '2017-07-06 16:00:00', 7, 1),
(99, '2017-07-06 16:30:00', 7, 1),
(100, '2017-07-06 09:00:00', 36, 1),
(101, '2017-07-06 09:30:00', 36, 0),
(102, '2017-07-06 10:00:00', 36, 1),
(103, '2017-07-06 10:30:00', 36, 1),
(104, '2017-07-06 11:00:00', 36, 0),
(105, '2017-07-06 11:30:00', 36, 1),
(106, '2017-07-06 12:00:00', 36, 1),
(107, '2017-07-06 12:30:00', 36, 1),
(108, '2017-07-06 13:00:00', 36, 1),
(109, '2017-07-06 13:30:00', 36, 1),
(110, '2017-07-06 14:00:00', 36, 1),
(111, '2017-07-06 14:30:00', 36, 1),
(112, '2017-07-06 15:00:00', 36, 1),
(113, '2017-07-06 15:30:00', 36, 1),
(114, '2017-07-06 16:00:00', 36, 1),
(115, '2017-07-06 16:30:00', 36, 1),
(116, '2017-07-02 09:00:00', 37, 1),
(117, '2017-07-02 09:30:00', 37, 1),
(118, '2017-07-02 10:00:00', 37, 1),
(119, '2017-07-02 10:30:00', 37, 1),
(120, '2017-07-02 11:00:00', 37, 1),
(121, '2017-07-02 11:30:00', 37, 1),
(122, '2017-07-02 12:00:00', 37, 1),
(123, '2017-07-02 12:30:00', 37, 1),
(124, '2017-07-02 13:00:00', 37, 1),
(125, '2017-07-02 13:30:00', 37, 1),
(126, '2017-07-02 14:30:00', 37, 1),
(127, '2017-07-02 15:00:00', 37, 1),
(128, '2017-07-18 09:00:00', 37, 1),
(129, '2017-07-18 09:30:00', 37, 1),
(130, '2017-07-18 10:00:00', 37, 1),
(131, '2017-07-18 10:30:00', 37, 1),
(132, '2017-07-18 11:00:00', 37, 1),
(133, '2017-07-18 11:30:00', 37, 1),
(134, '2017-07-18 12:00:00', 37, 1),
(135, '2017-07-18 12:30:00', 37, 1),
(136, '2017-07-18 13:00:00', 37, 1),
(137, '2017-07-18 13:30:00', 37, 1),
(138, '2017-07-18 14:00:00', 37, 1),
(139, '2017-07-18 14:30:00', 37, 1),
(140, '2017-07-18 15:00:00', 37, 1),
(141, '2017-07-18 15:30:00', 37, 1),
(142, '2017-07-18 16:00:00', 37, 1),
(143, '2017-07-18 16:30:00', 37, 1),
(144, '2017-07-17 09:00:00', 37, 1),
(145, '2017-07-17 09:30:00', 37, 1),
(146, '2017-07-17 10:00:00', 37, 1),
(147, '2017-07-17 10:30:00', 37, 1),
(148, '2017-07-17 11:00:00', 37, 1),
(149, '2017-07-17 11:30:00', 37, 1),
(150, '2017-07-17 12:00:00', 37, 1),
(151, '2017-07-17 12:30:00', 37, 1),
(152, '2017-07-17 13:00:00', 37, 1),
(153, '2017-07-17 13:30:00', 37, 1),
(154, '2017-07-17 14:00:00', 37, 1),
(155, '2017-07-17 14:30:00', 37, 1),
(156, '2017-07-10 09:00:00', 37, 1),
(157, '2017-07-10 09:30:00', 37, 1),
(158, '2017-07-10 10:00:00', 37, 1),
(159, '2017-07-10 10:30:00', 37, 1),
(160, '2017-07-10 11:00:00', 37, 1),
(161, '2017-07-10 11:30:00', 37, 1),
(162, '2017-07-10 12:00:00', 37, 1),
(163, '2017-07-10 12:30:00', 37, 1),
(164, '2017-07-10 13:00:00', 37, 1),
(165, '2017-07-10 13:30:00', 37, 1),
(166, '2017-07-10 14:00:00', 37, 1),
(167, '2017-07-10 14:30:00', 37, 1),
(168, '2017-07-10 15:00:00', 37, 1),
(169, '2017-07-10 15:30:00', 37, 1),
(170, '2017-07-10 16:00:00', 37, 1),
(171, '2017-07-10 16:30:00', 37, 1),
(172, '2017-07-11 09:00:00', 37, 1),
(173, '2017-07-11 09:30:00', 37, 1),
(174, '2017-07-11 10:00:00', 37, 1),
(175, '2017-07-11 10:30:00', 37, 1),
(176, '2017-07-11 11:00:00', 37, 1),
(177, '2017-07-11 11:30:00', 37, 1),
(178, '2017-07-11 12:00:00', 37, 1),
(179, '2017-07-11 12:30:00', 37, 1),
(180, '2017-07-11 13:00:00', 37, 1),
(181, '2017-07-11 13:30:00', 37, 1),
(182, '2017-07-08 09:00:00', 37, 1),
(183, '2017-07-08 09:30:00', 37, 1),
(184, '2017-07-08 10:00:00', 37, 1),
(185, '2017-07-08 10:30:00', 37, 1),
(186, '2017-07-08 11:00:00', 37, 1),
(187, '2017-07-08 11:30:00', 37, 1),
(188, '2017-07-08 12:00:00', 37, 1),
(189, '2017-07-08 12:30:00', 37, 1),
(190, '2017-07-23 09:00:00', 37, 1),
(191, '2017-07-23 09:30:00', 37, 1),
(192, '2017-07-23 10:00:00', 37, 1),
(193, '2017-07-23 10:30:00', 37, 1),
(194, '2017-07-23 11:00:00', 37, 1),
(195, '2017-07-23 11:30:00', 37, 1),
(196, '2017-07-23 12:00:00', 37, 1),
(197, '2017-07-23 12:30:00', 37, 1),
(199, '2017-07-26 09:30:00', 7, 1),
(200, '2017-07-26 10:00:00', 7, 1),
(201, '2017-07-26 10:30:00', 7, 1),
(202, '2017-07-26 11:00:00', 7, 0),
(203, '2017-07-26 11:30:00', 7, 1),
(204, '2017-07-26 13:00:00', 36, 1),
(205, '2017-07-26 13:30:00', 36, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(6) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `join_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` enum('patient','doctor','admin') DEFAULT 'patient',
  `secmail` varchar(255) NOT NULL,
  `spam` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `join_date`, `role`, `secmail`, `spam`) VALUES
(1, 'pat@beat.com', 'wert1234', 'John', 'Lennon', '2017-07-07 22:28:45', 'admin', 'testest@mailinator.com', 0),
(7, 'drd@ss.com', '123456a', 'Aribert', 'Heim', '2017-06-24 22:52:10', 'doctor', 'another@email.com', 1),
(10, 'titty@buns.com', 'wert5666', 'Titty', 'Buns', '2017-07-04 22:16:36', 'patient', 'patient213@mailinator.com', 1),
(15, 'dup@dup.dd', '12345', 'Clair', 'Unfair', '2017-07-07 23:23:03', 'patient', 'dup@dup.dd', 0),
(18, 'djuj@dsd.cvb', 'wert1235', 'Darias', 'Awaria', '2017-07-04 22:16:43', 'patient', 'patient213@mailinator.com', 1),
(27, 'jan@wp.pl', 'wert', 'Janek', 'Muzykant', '2017-07-02 22:25:11', 'patient', 'nowy@email.com', 1),
(33, 'kkwss@dd.dd', 'wert1234', 'Hans', 'Kloss', '2017-07-04 20:14:47', 'patient', 'kkwss@dd.dd', 1),
(34, 'swsw@sws.sw', 'wert1234', 'StanisÅ‚aw', 'WodzisÅ‚aw', '2017-07-05 15:22:37', 'patient', 'swsw@sws.sw', 1),
(35, 'wsws@wsb.pl', '1234', 'LudiÅ‚a', 'KiÅ‚a', '2017-07-04 20:15:06', 'patient', 'wsws@wsb.pl', 1),
(36, 'qw@ww.pl', '12345a', 'Daniela', 'Poggiali', '2017-07-03 21:52:39', 'doctor', 'pull@theplug.com', 1),
(37, 'harold@needle.co.uk', 'wert1234', 'Harold', 'Shipman', '2017-07-04 22:15:32', 'doctor', 'harold@needle.co.uk', 1),
(38, 'admin@dent.io', '1234', 'John', 'Bull', '2017-07-04 22:14:06', 'admin', 'admin@dent.io', 1),
(39, 'chory01@wp.pl', 'wert1234', 'Janina', 'Pianina', '2017-07-04 22:14:15', 'patient', 'chory01@wp.pl', 1),
(42, 'd@d.d', 'asd', 'MaÅ‚gorzta', 'MaÅ‚olata', '2017-06-24 23:24:47', 'patient', 'fotka@wup.pl', 1),
(45, 'swssss@w.w', '123456', 'sfsdfs', 'sdsfdfs', '2017-07-04 22:14:48', 'patient', 'patient213@mailinator.com', 1),
(47, 'nowy@email.go', 'wert1234', 'Fatima', 'Zima', '2017-07-04 22:14:55', 'patient', 'patient213@mailinator.com', 1),
(49, 'test@pat.ient', '123456a', 'Jan', 'Chorobowy', '2017-07-04 22:15:01', 'patient', 'patient213@mailinator.com', 1),
(50, 'nowy@bezzem.ba', '123456a', 'Ewka', 'Szczerbata', '2017-07-07 20:22:15', 'patient', 'patient213@mailinator.com', 0),
(53, 'nowy12@w.sw', 'qwer1234', 'Zbychu', 'Spychu', '2017-06-25 00:10:54', 'patient', 'nowy12@w.swi', 1),
(54, 'qwert@qwq.wer', 'qwert12345', 'Aldona', 'Opalona', '2017-07-04 22:15:14', 'patient', 'patient213@mailinator.com', 1),
(55, 'nowy@moj.pl', 'wert1234', 'Adam', 'SÅ‚odowy', '2017-07-04 20:14:28', 'patient', 'nowy@moj.pl', 1),
(56, 'jeszcze@jeden.com', 'wert1234', 'Alina', 'Pralina', '2017-06-25 16:43:38', 'patient', 'jeszcze@dwa.com', 1),
(57, 'pain@dmx.de', 'wert1234', 'Hans', 'Schmerz', '2017-07-02 13:12:54', 'doctor', 'pain@dmx.de', 1),
(58, 'jeremy@hunt.co.uk', 'wert1234', 'Jeremy', 'Hunt', '2017-07-03 21:26:43', 'patient', 'jeremy@hunt.co.uk', 1),
(59, 'patient213@mailinator.com', 'wert1234', 'Imogen', 'Smith', '2017-07-04 22:18:22', 'patient', 'patient213@mailinator.com', 1),
(60, 'biuro@biuro.com', '', 'wybierz', 'pacjenta', '2017-07-06 20:52:53', 'patient', '', 0),
(61, 'calkiem@nowy.com', '12345', 'Dzielny', 'Pacjent', '2017-07-07 23:42:55', 'patient', 'calkiem@nowy.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`date_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `uniqueusername` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `app_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;
--
-- AUTO_INCREMENT for table `dates`
--
ALTER TABLE `dates`
  MODIFY `date_id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=206;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
