-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 03, 2016 at 06:51 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meralco`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `description`, `user_id`, `dateadded`, `deleted`) VALUES
(16, 'Schedule of Brownout', 'February 29,2016 (LayLay, Boac, Marinduque', 24, '2016-02-24 01:36:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(11) NOT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `municipality`, `name`, `deleted`) VALUES
(6, 'boac', 'Boac Branch', NULL),
(7, 'mogpog', 'Mogpog Branch', NULL),
(8, 'gasan', 'Gasan Branch', NULL),
(9, 'stacrus', 'Sta Cruz Branch', NULL),
(10, 'buenavista', 'Buenavista Branch', NULL),
(11, 'torrijos', 'Torrijos  Branch', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `brgy`
--

CREATE TABLE `brgy` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `municipality` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brgy`
--

INSERT INTO `brgy` (`id`, `name`, `branch_id`, `municipality`) VALUES
(7, 'Agot', 6, 'boac'),
(8, 'Agumaymayan', 6, 'boac'),
(9, 'Amoingon', 6, 'boac'),
(10, 'Apitong', 6, 'boac'),
(11, 'Balagasan', 6, 'boac'),
(12, 'Balaring', 6, 'boac'),
(13, 'Balogo', 6, 'boac'),
(14, 'Bamban', 6, 'boac'),
(15, 'Bangbangalon', 6, 'boac'),
(16, 'Bantad', 6, 'boac'),
(17, 'Bantay', 6, 'boac'),
(18, 'Bayuti', 6, 'boac'),
(19, 'Binunga', 6, 'boac'),
(20, 'Boi', 6, 'boac'),
(21, 'Boton', 6, 'boac'),
(22, 'Buliasnin', 6, 'boac'),
(23, 'Bunganay', 6, 'boac'),
(24, 'Caganhao', 6, 'boac'),
(25, 'Canat', 6, 'boac'),
(26, 'Catubugan', 6, 'boac'),
(27, 'Cawit', 6, 'boac'),
(28, 'Daig', 6, 'boac'),
(29, 'Daypay', 6, 'boac'),
(30, 'Duyay', 6, 'boac'),
(31, 'Hinapulan', 6, 'boac'),
(32, 'ihatub', 6, 'boac'),
(33, 'Isok 2 (poblacion)', 6, 'boac'),
(34, 'Laylay', 6, 'boac'),
(35, 'Lupac', 6, 'boac'),
(36, 'Mahinhin', 6, 'boac'),
(37, 'Mainit', 6, 'boac'),
(38, 'Malbog', 6, 'boac'),
(39, 'Maligaya', 6, 'boac'),
(40, 'Malusak()', 6, 'boac'),
(41, 'Mansiwat', 6, 'boac'),
(42, 'Mataas na bayan', 6, 'boac'),
(43, 'Maybo', 6, 'boac'),
(44, 'Mercado', 6, 'boac'),
(45, '(Poblacion)', 6, 'boac'),
(46, 'Murallon (Poblacion)', 6, 'boac'),
(47, 'Ogbac', 6, 'boac'),
(48, 'Pawa', 6, 'boac'),
(49, 'Pili', 6, 'boac'),
(50, 'Poctoy', 6, 'boac'),
(51, 'Poras', 6, 'boac'),
(52, 'Puting BuHangin', 6, 'boac'),
(53, 'Puyog', 6, 'boac'),
(54, 'Sambong', 6, 'boac'),
(55, 'San Miguel (Poblacion)', 6, 'boac'),
(56, 'San Miguel (Poblacion)', 6, 'boac'),
(57, 'Santol', 6, 'boac'),
(58, 'Sawi', 6, 'boac'),
(59, 'Tabi', 6, 'boac'),
(60, 'Tabigue', 6, 'boac'),
(61, 'Tagwak', 6, 'boac'),
(62, 'Tambunan', 6, 'boac'),
(63, 'Tampus (poblacion)', 6, 'boac'),
(64, 'Tanza', 6, 'boac'),
(65, 'Tugos', 6, 'boac'),
(66, 'Tumagabok', 6, 'boac'),
(67, 'Tumapon', 6, 'boac'),
(68, 'Anapog-Sibucao', 7, 'mogpog'),
(69, 'Argao', 7, 'mogpog'),
(70, 'Balanacan', 7, 'mogpog'),
(71, 'Banto', 7, 'mogpog'),
(72, 'Bintakay', 7, 'mogpog'),
(73, 'Bocboc', 7, 'mogpog'),
(74, 'Butansapa', 7, 'mogpog'),
(75, 'Candahon', 7, 'mogpog'),
(76, 'Capayang', 7, 'mogpog'),
(77, ' Danao', 7, 'mogpog'),
(78, 'Dulong Bayan (Pob.)', 7, 'mogpog'),
(79, ' Gitnang Bayan (Pob)', 7, 'mogpog'),
(80, 'Guisian', 7, 'mogpog'),
(81, 'Hinadharan', 7, 'mogpog'),
(82, '  Hinanggayon', 7, 'mogpog'),
(83, 'Ino', 7, 'mogpog'),
(84, 'Janagdong', 7, 'mogpog'),
(85, 'Lamesa', 7, 'mogpog'),
(86, 'Laon', 7, 'mogpog'),
(87, 'Magapua', 7, 'mogpog'),
(88, 'Malayak', 7, 'mogpog'),
(89, 'Malusak ', 7, 'mogpog'),
(90, 'Mampaitan', 7, 'mogpog'),
(91, 'Mangyan-Mababad', 7, 'mogpog'),
(92, 'Market Site (PoB.)', 7, 'mogpog'),
(93, 'Mataas na Byan', 7, 'mogpog'),
(94, 'Mendez', 7, 'mogpog'),
(95, 'Nangka I (Pob.)', 7, 'mogpog'),
(96, 'Nangka 2', 7, 'mogpog'),
(97, ' Paye', 7, 'mogpog'),
(98, 'Pili', 7, 'mogpog'),
(99, 'Putung Buhangin', 7, 'mogpog'),
(100, 'Sayao', 7, 'mogpog'),
(101, 'Silangan', 7, 'mogpog'),
(102, 'Sumanggga', 7, 'mogpog'),
(103, 'Tarug', 7, 'mogpog'),
(104, 'Villa Mendez (Pob.)', 7, 'mogpog'),
(105, 'Antipolo', 8, 'gasan'),
(106, 'Bachao Ilaya', 8, 'gasan'),
(107, 'Bachao Ibaba', 8, 'gasan'),
(108, 'Bacong-Bacong', 8, 'gasan'),
(109, 'Bahi', 8, 'gasan'),
(110, 'Bangbang', 8, 'gasan'),
(111, 'Banot', 8, 'gasan'),
(112, 'Banuyo', 8, 'gasan'),
(113, 'Bognuyan', 8, 'gasan'),
(114, 'Cabugao', 8, 'gasan'),
(115, 'Dawis', 8, 'gasan'),
(116, 'Dili', 8, 'gasan'),
(117, 'Libtangin', 8, 'gasan'),
(118, 'Mahunig', 8, 'gasan'),
(119, 'Mangiliol', 8, 'gasan'),
(120, 'Masiga', 8, 'gasan'),
(121, 'Matangdang Gasan', 8, 'gasan'),
(122, 'Pangi', 8, 'gasan'),
(123, 'Pinggan', 8, 'gasan'),
(124, 'Tabionan', 8, 'gasan'),
(125, 'Tapuyan', 8, 'gasan'),
(126, 'TIGUION', 8, 'gasan'),
(127, 'Barangay I (Pob.)', 8, 'gasan'),
(128, 'Barangay II (Pob.)', 8, 'gasan'),
(129, 'Barangay III (pob)', 8, 'gasan'),
(130, 'Bagacay', 9, 'buenavista'),
(131, 'Bagtingon', 9, 'buenavista'),
(132, 'Bicas-bicas', 9, 'buenavista'),
(133, 'Caigangan', 9, 'buenavista'),
(134, 'Daykitin', 9, 'buenavista'),
(135, 'Libas', 9, 'buenavista'),
(136, 'Malbog', 9, 'buenavista'),
(137, 'Sihi', 9, 'buenavista'),
(138, ' Timbo', 9, 'buenavista'),
(139, 'Tungib-Lipata', 9, 'buenavista'),
(140, 'Yook', 9, 'buenavista'),
(141, 'Barangay 1 Pob.', 9, 'buenavista'),
(142, 'Barangay II Pob.', 9, 'buenavista'),
(143, 'Barangay III Pob.', 9, 'buenavista'),
(144, 'Barangay IV Pob.', 9, 'buenavista'),
(145, 'Alobo', 10, 'stacrus'),
(146, 'Angas', 10, 'stacrus'),
(147, ' Aturan', 10, 'stacrus'),
(148, 'Bagong Silangan Pob', 10, 'stacrus'),
(149, 'Baguidbirin', 10, 'stacrus'),
(150, 'Baliis', 10, 'stacrus'),
(151, 'Balogo', 10, 'stacrus'),
(152, 'Banahaw Pob. Bangcuangan', 10, 'stacrus'),
(153, 'Banogbog', 10, 'stacrus'),
(154, 'Biga', 10, 'stacrus'),
(155, 'Botilao', 10, 'stacrus'),
(156, ' Buyabod', 10, 'stacrus'),
(157, 'Dating Byan', 10, 'stacrus'),
(158, 'Devilla', 10, 'stacrus'),
(159, 'Dolores', 10, 'stacrus'),
(160, 'Haguimit Hupi', 10, 'stacrus'),
(161, 'Ipil', 10, 'stacrus'),
(162, 'Jolo', 10, 'stacrus'),
(163, 'Kaganhao', 10, 'stacrus'),
(164, 'Kalangkang', 10, 'stacrus'),
(165, 'Kamandugan', 10, 'stacrus'),
(166, 'Kasily', 10, 'stacrus'),
(167, 'Kilo-kilo', 10, 'stacrus'),
(168, 'Kinyaman', 10, 'stacrus'),
(169, 'Labo', 10, 'stacrus'),
(170, 'Lamesa', 10, 'stacrus'),
(171, 'Landy', 10, 'stacrus'),
(172, ' Lapu-lapu Pob.', 10, 'stacrus'),
(173, 'Libjo', 10, 'stacrus'),
(174, 'Lipa', 10, 'stacrus'),
(175, 'Lusok', 10, 'stacrus'),
(176, 'Maharlika Pob.', 10, 'stacrus'),
(177, 'Makulapnit', 10, 'stacrus'),
(178, 'Maniwaya', 10, 'stacrus'),
(179, 'Manlibunan', 10, 'stacrus'),
(180, 'Masaguisi', 10, 'stacrus'),
(181, 'Masalukot', 10, 'stacrus'),
(182, 'Matalaba', 10, 'stacrus'),
(183, 'Mongpong', 10, 'stacrus'),
(184, 'Morales', 10, 'stacrus'),
(185, ' Napo', 10, 'stacrus'),
(186, 'Pag-asa Pob.', 10, 'stacrus'),
(187, 'Pantayin', 10, 'stacrus'),
(188, 'Polo', 10, 'stacrus'),
(189, 'Pulong-parang', 10, 'stacrus'),
(190, 'San Isidro', 10, 'stacrus'),
(191, 'Punong', 10, 'stacrus'),
(192, 'San Antonio', 10, 'stacrus'),
(193, 'San Isidro', 10, 'stacrus'),
(194, 'Tagum', 10, 'stacrus'),
(195, 'Tamayo', 10, 'stacrus'),
(196, ' Tambangan', 10, 'stacrus'),
(197, 'Tawiran', 10, 'stacrus'),
(198, 'Taytay', 10, 'stacrus'),
(199, 'Bayakbakin', 11, 'torrijos'),
(200, 'Bolo', 11, 'torrijos'),
(201, 'Bonliw', 11, 'torrijos'),
(202, 'Buangan', 11, 'torrijos'),
(203, ' Cabuyo', 11, 'torrijos'),
(204, 'Cagpo', 11, 'torrijos'),
(205, 'Dampulan', 11, 'torrijos'),
(206, 'Bangwayin', 11, 'torrijos'),
(207, 'KayDuke', 11, 'torrijos'),
(208, 'Mabuhay', 11, 'torrijos'),
(209, 'Makawayan', 11, 'torrijos'),
(210, 'Malibago', 11, 'torrijos'),
(211, 'Malinao', 11, 'torrijos'),
(212, 'Maranlig', 11, 'torrijos'),
(213, 'Marlangga', 11, 'torrijos'),
(214, 'Matuyatuya', 11, 'torrijos'),
(215, 'Nangka', 11, 'torrijos'),
(216, 'Pakaskasan', 11, 'torrijos'),
(217, 'Payanas', 11, 'torrijos'),
(218, 'Poblacion', 11, 'torrijos'),
(219, 'Poctoy', 11, 'torrijos'),
(220, 'Sibuyao', 11, 'torrijos'),
(221, 'Suha', 11, 'torrijos'),
(222, 'Talawan', 11, 'torrijos'),
(223, 'Tigwi', 11, 'torrijos'),
(224, 'tEST', 7, 'mogpog'),
(225, 'Isok 1 (poblacion)', 6, 'boac'),
(226, 'Cabuyo', 11, 'torrijos');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `name`, `dob`, `userid`) VALUES
(5, 'child1', 'dob1', 43),
(6, 'child2', 'dob2', 43),
(7, 'c1', '2/21/1991', 129),
(8, 'c2', '2/11213', 129),
(9, 'c2 3', 'asdsfa', 130),
(10, 'Jomira', 'June 25, 2005', 168);

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` int(11) NOT NULL,
  `consumer_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `complaint_nature` text NOT NULL,
  `complaint_datetime` date NOT NULL,
  `action_desired` varchar(255) DEFAULT NULL,
  `action_taken` varchar(255) DEFAULT NULL,
  `action_datetime` date NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `completed` int(11) DEFAULT NULL,
  `walkin` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `consumer_name`, `address`, `contact_number`, `complaint_nature`, `complaint_datetime`, `action_desired`, `action_taken`, `action_datetime`, `dateadded`, `user_id`, `type`, `firstname`, `lastname`, `middlename`, `brgy`, `municipality`, `province`, `or_number`, `reason`, `completed`, `walkin`) VALUES
(2345, NULL, NULL, '09486329299', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:50:16', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '64', 'boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2346, NULL, NULL, '09152852575', 'Grounded Connection', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:52:53', NULL, 'complaint', 'Juan', 'dela cruz', 'lopez', '49', 'boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2347, NULL, NULL, '09486329299', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 05:14:35', NULL, 'complaint', 'Rachel', 'Hernando', 'Rocacurva', '34', 'Boac', 'Marinduque', NULL, 'No Assigned Inspector/Lineman for this type of request.', 1, 0),
(2348, NULL, NULL, '09485150005', 'Change Name', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 04:57:22', NULL, 'request', 'Nikko', 'Laguio', 'Hernando', '34', 'Boac', 'Marinduque', NULL, 'No Assigned Inspector/Lineman for this type of request.', 1, 0),
(2349, NULL, NULL, '09486329299', 'Spark Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:52:50', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '64', 'Boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2350, NULL, NULL, '09485150005', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 05:14:35', NULL, 'complaint', 'Rachel', 'Hernando', 'Rocacurva', '34', 'Boac', 'Marinduque', NULL, 'No Assigned Inspector/Lineman for this type of request.', 1, 0),
(2351, NULL, NULL, '09485150005', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:50:02', NULL, 'complaint', 'Rachel', 'Hernando', 'Rocacurva', '34', 'Boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2352, NULL, NULL, '09152852575', 'Low Clearance of KWH m', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:50:12', NULL, 'complaint', 'ady', 'sadiwa', 'eng', '49', 'boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2353, NULL, NULL, '09152852575', 'On and Off Power', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-03 08:50:07', NULL, 'complaint', 'Nikko', 'Laguio', 'Hernando', '34', 'Boac', 'Marinduque', NULL, 'Alloted Time for this request doesn''t fit any lineman''s schedule', 1, 0),
(2354, NULL, NULL, '09152852575', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 00:43:17', NULL, 'complaint', 'Juan', 'lacruz', 'de', '202', 'torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2355, NULL, NULL, '09309819567', 'Change Name', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 05:47:47', NULL, 'request', 'Jasmin', 'Cruzado', 'Lozano', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2356, NULL, NULL, '09956233053', 'Spark Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 05:59:51', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '199', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2357, NULL, NULL, '09309819567', 'Change Name', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:10:11', NULL, 'request', 'Rena', 'Baculinao', 'Hernando', '226', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2358, NULL, NULL, '09956233053', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:20:58', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2359, NULL, NULL, '09309819567', 'High Billing', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:29:37', NULL, 'complaint', 'Rachel', 'Hernando', 'Rocacurva', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2360, NULL, NULL, '09099540752', 'Damaged Service Drop Wire', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:35:45', NULL, 'complaint', 'Jasmin', 'Cruzado', 'Lozano', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2361, NULL, NULL, '09169037181', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:47:24', NULL, 'complaint', 'Maryjoy', 'Mansia', 'Matining', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2362, NULL, NULL, '09169037181', 'Under Voltage', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-25 07:52:38', NULL, 'complaint', 'Maryjoy', 'Mansia', 'Matining', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2363, NULL, NULL, '09486329299', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-27 04:16:32', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '208', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2364, NULL, NULL, '09486329299', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-29 01:07:27', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '86', 'Mogpog', 'Marinduque', NULL, NULL, 0, 0),
(2365, NULL, NULL, '09485150005', 'Change Name', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-29 03:18:10', NULL, 'request', 'Rachel', 'Hernando', 'Rocacurva', '226', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2366, NULL, NULL, '09485150005', 'Change Name', '0000-00-00', NULL, NULL, '0000-00-00', '2016-02-29 04:19:12', NULL, 'request', 'Rachel', 'Hernando', 'Rocacurva', '226', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2367, NULL, NULL, '09486329299', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 06:18:52', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '226', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2368, NULL, NULL, '09485150005', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 06:18:53', NULL, 'complaint', 'Rachel', 'Hernando', 'Rocacurva', '202', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2369, NULL, NULL, '09485150005', 'Loose Connection', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 06:19:41', NULL, 'complaint', 'Ryan', 'Hernando', 'Rocacurva', '223', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2370, NULL, NULL, '09485150005', 'Loose Connection', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 06:34:43', NULL, 'complaint', 'Ryan', 'Hernando', 'Rocacurva', '223', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2371, NULL, NULL, '09486329299', 'Loose Connection', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 06:36:02', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '208', 'Torrijos', 'Marinduque', NULL, NULL, 0, 0),
(2372, NULL, NULL, '09486329299', 'Busted Transformer', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 18:58:32', NULL, 'complaint', 'Reynalyn', 'Rondina', 'Maritana', '109', 'Gasan', 'Marinduque', NULL, NULL, 0, 0),
(2373, NULL, NULL, '09126120038', 'Loose Connection', '0000-00-00', NULL, NULL, '0000-00-00', '2016-03-02 19:56:35', NULL, 'complaint', 'Rose', 'Fermo', 'Sarile', '124', 'Gasan', 'Marinduque', NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `id` int(11) UNSIGNED NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `dateadded` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `filename`, `type`, `size`, `dateadded`, `userid`) VALUES
(16, '1435597629_data.png', 'image/png', '81411', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT '0',
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `from` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `religion` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `civil_status` varchar(255) DEFAULT NULL,
  `pob` varchar(255) DEFAULT NULL,
  `membership_type` varchar(255) DEFAULT NULL,
  `consumer_type` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `municipality` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`id`, `firstname`, `lastname`, `middlename`, `age`, `sex`, `dob`, `religion`, `address`, `nationality`, `weight`, `height`, `userid`, `civil_status`, `pob`, `membership_type`, `consumer_type`, `photo`, `contact_number`, `brgy`, `municipality`) VALUES
(45, 'Reynalyn', 'Rondina', 'Maritana', '20', 'female', '1995-08-12', 'Roman Catholic', 'Pili, Boac, Marinduque', 'afghan', '', '', 24, 'Single', 'Mercado,Boac,Marinduque', 'Single', 'Residential', '24.jpg', '09486329299', 'Mercado', 'boac'),
(50, 'Jhon', 'Doe', 'Smith', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 54, 'Single', '', 'Single', 'Residential', '', '09182959171', 'Balogo', 'boac'),
(51, 'Jhon2', 'Doe2', 'Smith2', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 55, 'Single', '', 'Single', 'Residential', '', '09182959171', 'Balogo', 'gasan'),
(52, 'ISD Manager Firstname', 'Sadiwa', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 58, 'Single', '', 'Single', 'Residential', NULL, '0918294', 'Balogo', 'boac'),
(53, 'CSC User', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 59, 'Single', '', 'Single', 'Residential', NULL, '09152852575', 'Balogo', 'boac'),
(54, 'Jhon', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 60, 'Single', '', 'Single', 'Residential', NULL, '09152852575', 'Bagacay', 'stacrus'),
(59, 'lineman', 'saitama', '', '0', 'male', '2015-11-19', '', '', 'afghan', '', '', 63, 'Single', '', 'Single', 'Residential', NULL, '09152852575', 'Balogo', 'boac'),
(93, 'dan', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 93, 'Single', '', 'Single', 'Residential', '', '09152852575', 'Balogo', 'boac'),
(94, 'inspector firstname', 'inspector lastname', 'inspector middlename', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 94, 'Single', '', 'Single', 'Residential', NULL, '09152852575', '  Hinanggayon', 'boac'),
(95, 'inspector firstname', 'inspector lastname', 'inspector middlename', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 81, 'Single', '', 'Single', 'Residential', NULL, '09152852575', '  Hinanggayon', 'boac'),
(96, 'outside', 'outsidel', 'outsidem', '0', 'male', '2015-12-16', '', '', 'afghan', '', '', 95, 'Single', '', 'Single', 'Residential', '', '09182959171', '  Hinanggayon', 'boac'),
(97, 'Inspector 2 Firstname', 'Lastname', 'mname', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 96, 'Single', '', 'Single', 'Residential', NULL, '09152852575', '  Hinanggayon', 'boac'),
(98, 'Inspector 2 Firstname', 'Lastname', 'mname', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 1, 'Single', '', 'Single', 'Residential', '1.jpg', '09152852575', '  Hinanggayon', 'boac'),
(99, 'lineman', 'saitama', 'mname super', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 97, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(100, 'asdlk', 'kj', 'kjh', '', '', '1970-01-01', '', '', 'afghan', '', '', 0, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(101, 'asdlk', 'kj', 'kjh', '', '', '1970-01-01', '', '', 'afghan', '', '', 0, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(102, '', '', '', '', '', '0000-00-00', '', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, 'jasdkj', 'kjh', 'jh', '', '', '1970-01-01', '', '', 'afghan', '', '', 98, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(104, 'jasdkjds', 'kjh', 'jh', '0', 'male', '2016-01-04', '', '', 'afghan', '', '', 99, 'Single', 'Pili', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(105, 'asdasd', 'kjh', 'jh', '0', 'male', '2016-01-04', '', '', 'afghan', '', '', 100, 'Single', 'Pili', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(106, 'ads', 'sdf', 'sdf', '', '', '1970-01-01', '', '', 'afghan', '', '', 101, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(107, 'Rex', 'Alisan', 'Sad', '27', 'male', '1988-05-13', 'Roman Catholic', '', 'afghan', '', '', 102, 'Single', 'Bunganay,Boac,Marinduque', 'Single', 'Residential', '', '09099540752', 'Bunganay', 'boac'),
(108, 'lksfhkj', 'kjj', 'kjhkl', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 103, 'Single', '', 'Single', 'Residential', '', '09152852575', ' Paye', 'mogpog'),
(109, 'John', 'Doe', 'Sadiwa', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 104, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(110, 'inc applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 105, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(111, 'inc2 applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 106, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(112, 'for orient applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 107, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(113, 'for orient2 applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 108, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(114, 'for orient3 applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 109, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(115, 'verified applicant', 'as.j', 'kjfkj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 110, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(116, 'ito', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 111, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(117, 'as', 'sf', 'sdf', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 112, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(118, 'sdf', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 113, 'Single', '', 'Single', 'Residential', '', '09152852575', 'Pangi', 'gasan'),
(119, 'sdf', 'ssdf', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 114, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(120, '', '', 'asd', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 115, 'Single', '', 'Single', 'Residential', '1223', '09152852575', '7', 'boac'),
(121, 'kjshdfkjs', 'kjhsdfkjh', 'kjh', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 116, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(122, 'fname', 'lname', 'mname', '-1', 'male', '2016-02-09', '', '', 'afghan', '', '', 117, 'Single', '', 'Single', 'Residential', '', '09152852575', ' Aturan', 'boac'),
(123, 'Jay', 'Sades', 'Rondera', '-1', 'male', '2016-02-09', '', '', 'afghan', '', '', 118, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(124, 'walkin1', 'lasnt', 'mname', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 119, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(125, 'walkin1', 'lasnts', 'mname', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 120, 'Single', '', 'Single', 'Commercial', '', '09152852575', '7', 'boac'),
(126, 'akjsdh', 'jkh', 'khj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 121, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(127, 'James', 'Rio', 'dlr', '0', 'male', '2016-02-03', '', '', 'afghan', '', '', 122, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(128, 'jasdkj', 'kj', 'hj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 123, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(129, 'jasdkj4', 'kj', 'hj', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 124, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(130, 'System', 'Admin', 'Sudo', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 125, 'Single', '', 'Single', 'Residential', '125.jpg', '09152852575', ' Buyabod', 'boac'),
(131, 'asd', 'sdf', 'sfd', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 126, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(132, 'Rico', 'Dela Pena', 'Villa', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 127, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(133, '', '', '', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 128, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(134, 'spouse', 'test', '124', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 129, 'Married', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(135, 'a', 'f', 'sf', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 130, 'Married', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(136, 'Mary Joy', 'Mansia', 'Malacas', '26', 'female', '1989-06-13', 'Roman Catholic', '', 'afghan', '', '', 131, 'Single', 'Bantad, Boac, Marinduque', 'Single', 'Residential', '', '09099540752', 'Amoingon', 'boac'),
(137, 'Juan', 'De La', 'Cruz', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 132, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'mogpog'),
(138, 'Jose', 'Laurel', 'Plaridel', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 133, 'Single', '', 'Single', 'Residential', '', '09152852575', '75', 'mogpog'),
(139, 'Mavis', 'Vermillion', 'Fa', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 134, 'Single', '', 'Single', 'Residential', '', '09152852575', '68', 'mogpog'),
(140, 'Rex', 'Olympia', 'S.', '26', 'male', '1989-05-23', 'Roman Catholic', '', 'afghan', '', '', 135, 'Single', 'Ihatub, Boac, MArinduque', 'Single', 'Residential', '135.jpg', '09485150005', 'ihatub', 'boac'),
(141, 'Rosalie', 'Rondina', 'Maritana', '27', 'female', '1988-06-12', 'Roman Catholic', '', 'afghan', '', '', 136, 'Single', '', 'Single', 'Residential', '', '09126632578', 'ihatub', 'boac'),
(142, 'Maryjoy', 'Mansia', 'Malacas', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 137, 'Single', '', 'Single', 'Residential', '', '09485150005', '  Hinanggayon', 'boac'),
(143, 'Reynalyn', 'Rondina', 'Maritana', '27', 'female', '1988-08-12', 'Roman Catholic', '', 'afghan', '', '', 138, 'Single', 'Bantad, Boac, Marinduque', 'Single', 'Residential', '', '09485150005', 'Amoingon', 'boac'),
(144, 'Jasmin', 'Cruzado', 'Malacas', '26', 'female', '1989-05-12', 'Roman Catholic', '', 'afghan', '', '', 139, 'Single', 'Caganhao, Boac, Marinduque', 'Single', 'Residential', '', '09099540752', 'Balogo', 'boac'),
(145, 'Mark', 'Maritana', 'Frias', '20', 'male', '1995-08-12', 'Roman Catholic', '', 'afghan', '', '', 140, 'Single', 'Mercado,Boac,Marinduque', 'Single', 'Residential', '', '09126632578', 'Mercado', 'boac'),
(146, 'Genabel', 'Mawac', 'Sace', '20', 'female', '1995-08-12', 'Roman Catholic', '', 'afghan', '', '', 141, 'Single', 'Bantad, Boac, Marinduque', 'Single', 'Residential', '', '09486329299', '16', 'boac'),
(147, 'Bryan', 'Maritana', 'Frias', '18', 'male', '1997-03-24', 'Roman Catholic', '', 'afghan', '', '', 142, 'Single', 'Bantad, Boac, Marinduque', 'Single', 'Commercial', '', '09486329299', '16', 'boac'),
(148, 'Arjie', 'Dela Pena', 'Hernando', '20', 'male', '1995-07-22', 'Roman Catholic', '', 'afghan', '', '', 143, 'Single', 'Butansapa,Mogpog, Marinduque', 'Single', 'Residential', '', '09485150005', '74', 'mogpog'),
(149, 'Rogelio', 'Rondina', 'Dela Austria', '27', 'male', '1988-06-23', 'Roman Catholic', '', 'afghan', '', '', 144, 'Single', 'Magapua', 'Single', 'Residential', '', '09126632578', '87', 'mogpog'),
(150, 'Mary', 'Jhon', 'Man', '30', 'male', '1985-03-12', 'Roman Catholic', '', 'afghan', '', '', 145, 'Single', 'Poblacion, Torrijos, Marinduque', 'Single', 'Residential', '145.jpg', '09486329299', 'Poblacion', 'torrijos'),
(151, 'Mark', 'Herrera', 'Maritana', '27', 'male', '1988-06-12', 'Roman Catholic', '', 'afghan', '', '', 146, 'Single', 'Poblacion, Torrijos, Marinduque', 'Single', 'Residential', '', '09126632578', 'Poblacion', 'torrijos'),
(152, 'Louie', 'Mazon', 'Madla', '27', 'male', '1988-06-23', 'Roman Catholic', '', 'afghan', '', '', 147, 'Single', 'Poblacion, Torrijos, Marinduque', 'Single', 'Residential', '', '09099277838', 'Mabuhay', 'torrijos'),
(153, 'May', 'Rose', 'Man', '20', 'female', '1995-08-12', 'Roman Catholic', '', 'afghan', '', '', 148, 'Single', 'Bonliw, Torrijos, Marinduque', 'Single', 'Residential', '', '09486329299', '201', 'torrijos'),
(154, 'Reymark', 'Rondina', 'Maritana', '20', 'male', '1995-08-12', 'Roman Catholic', '', 'afghan', '', '', 149, 'Single', 'Caganhao, Boac, Marinduque', 'Single', 'Residential', '', '09126632578', '24', 'boac'),
(155, 'Mark Bryan', 'Maritana', 'Frias', '18', 'male', '1997-08-20', 'Roman Catholic', '', 'afghan', '', '', 150, 'Single', 'Buangan, Torrijos, Marinduque', 'Single', 'Residential', '', '09309819567', '208', 'torrijos'),
(156, 'Jasmin', 'Cruzado', 'Frias', '20', 'female', '1995-05-23', 'Roman Catholic', '', 'filipino', '', '', 151, 'Single', 'Bayakbakin,Torrijos,Marinduque', 'Single', 'Residential', '', '09099540752', '199', 'torrijos'),
(157, 'Rico', 'Maling', 'Maritana', '27', 'male', '1988-07-12', 'Roman Catholic', '', 'filipino', '', '', 152, 'Single', 'Poblacion, Torrijos, Marinduque', 'Single', 'Residential', '', '09485150005', '218', 'torrijos'),
(158, 'Rena Sandy', 'Rondina', 'Maritana', '22', 'female', '1993-09-04', 'Roman Catholic', '', 'afghan', '', '', 153, 'Single', 'Sibuyao,Torrijos, Marinduque', 'Single', 'Residential', '', '09126632578', '220', 'torrijos'),
(159, 'Bryan', 'Madla', 'Yao', '27', 'male', '1988-10-12', 'Roman Catholic', '', 'filipino', '', '', 154, 'Single', 'Pinggan, Gasan, Marinduque', 'Single', 'Residential', '154.jpg', '09486329299', 'Pinggan', 'gasan'),
(160, 'Roncemer', 'Sosa', 'Rondina', '27', 'male', '1988-03-24', 'Iglesia Ni Cristo', '', 'filipino', '', '', 155, 'Single', 'Bahi,Gasan, Marinduque', 'Single', 'Residential', '', '09309819567', '109', 'gasan'),
(161, 'John', 'Madla', 'Sace', '23', 'male', '1992-07-23', 'Roman Catholic', '', 'afghan', '', '', 156, 'Single', 'Mahunig, Gasan, Marinduque', 'Single', 'Residential', '', '09126632578', 'Bacong-Bacong', 'gasan'),
(162, 'Benjie', 'Rondina', 'Malacas', '27', 'male', '1988-07-12', 'Roman Catholic', '', 'filipino', '', '', 157, 'Single', 'Tabioan, Gasan, Marinduque', 'Single', 'Residential', '', '09099540752', '124', 'gasan'),
(163, 'ana', 'may', 'riego', '22', 'male', '1993-09-04', 'Roman Catholic', '', 'filipino', '', '', 158, 'Single', 'Tabioan, Gasan, Marinduque', 'Single', 'Residential', '', '09126632578', '105', 'gasan'),
(164, 'Lea', 'Limbo', 'Malacas', '27', 'female', '1988-09-24', 'Roman Catholic', '', 'filipino', '', '', 159, 'Single', 'Tabionan, Gasan, Marinduque', 'Single', 'Residential', '', '09486329299', '124', 'gasan'),
(165, 'John', 'Doe', 'Dlr', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 160, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(166, 'Doe', 'Inspector', 'Dlr', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 161, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(167, 'CSC', 'Ng', 'Boac', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 162, 'Single', '', 'Single', 'Residential', '', '09152852575', '  Hinanggayon', 'boac'),
(168, 'Rena Sandy', 'Maritana', 'Baculinao', '22', 'female', '1993-07-24', 'Roman Catholic', '', 'afghan', '', '', 163, 'Single', 'Caganhao, Boac, Marinduque', 'Single', 'Residential', '', '09485150005', '24', 'boac'),
(169, 'Manilyn', 'Revidizo', 'Sace', '27', 'female', '1988-06-22', 'Roman Catholic', '', 'afghan', '', '', 164, 'Single', 'Dolores, Sta.Cruz, Marinduque', 'Single', 'Residential', '', '09126632578', 'Dolores', 'stacrus'),
(170, 'Rosalie', 'Maritana', 'Frias', '40', 'female', '1975-08-06', 'Roman Catholic', '', 'afghan', '', '', 165, 'Single', 'Poblacion, Torrijos, Marinduque', 'Single', 'Residential', '165.jpg', '09099277838', 'Poblacion', 'torrijos'),
(171, 'Rachel Ann', 'Hernando', 'Rocacurva', '38', 'male', '1977-06-23', 'Roman Catholic', '', 'afghan', '', '', 166, 'Single', 'Timbo, Buenavista, Marinduque', 'Single', 'Residential', '', '09485150005', ' Timbo', 'buenavista'),
(172, 'Donnabeth', 'Mawac', 'Sace', '20', 'female', '1995-11-28', 'Roman Catholic', '', 'afghan', '', '', 167, 'Single', 'Tabioan, Gasan, Marinduque', 'Single', 'Residential', '167.jpg', '09123462646', 'Mahunig', 'gasan'),
(173, 'Miriam', 'Malapad', 'Semilla', '40', 'female', '1975-12-04', 'Roman Catholic', '', 'filipino', '', '', 168, 'Married', 'Bahi,Gasan, Marinduque', 'Single', 'Residential', '', '09083448195', '109', 'gasan'),
(174, 'Reymark', 'Maritana', 'Maritana', '20', 'male', '1995-08-12', 'Roman Catholic', '', 'afghan', '', '', 169, 'Single', 'Masiga, Gasan, Marinduque', 'Single', 'Residential', '', '09485150005', '120', 'gasan'),
(175, 'Benjie', 'Rico', 'Rondina', '22', 'male', '1993-09-23', 'Roman Catholic', '', 'afghan', '', '', 170, 'Single', 'Dawis, Gasan, Marinduque', 'Single', 'Residential', '', '09126632578', 'Mahunig', 'gasan'),
(176, 'John Paul', 'Rabe', 'Magturo', '25', 'male', '1990-07-12', 'Roman Catholic', '', 'afghan', '', '', 171, 'Single', 'Pinggan, Gasan, Marinduque', 'Single', 'Residential', '', '09485150005', 'Bognuyan', 'gasan'),
(177, 'Merry Mel', 'Maritana', 'Ramos', '27', 'female', '1988-05-22', 'Roman Catholic', '', 'afghan', '', '', 172, 'Single', 'Mahunig, Gasan, Marinduque', 'Single', 'Residential', '', '09486329299', 'Mahunig', 'gasan'),
(178, 'Mikey', 'Gamboa', 'Limbo', '36', 'male', '1979-08-12', 'Roman Catholic', '', 'afghan', '', '', 173, 'Single', 'Bayakbakin,Torrijos,Marinduque', 'Single', 'Residential', '', '09126632578', 'Alobo', 'stacrus'),
(179, 'James', 'Yap', 'Ow', '35', 'male', '1980-06-18', 'Roman Catholic', '', 'afghan', '', '', 174, 'Single', 'Pakaskasan, Torrijos, Marinduque', 'Single', 'Residential', '', '09486329299', 'Anapog-Sibucao', 'mogpog'),
(180, 'Mickey', 'Mouse', 'Yello', '38', 'female', '1977-09-22', 'Roman Catholic', '', 'afghan', '', '', 175, 'Single', 'Nangka, Torrijos, Marinduque', 'Single', 'Commercial', '', '09126632578', 'Nangka', 'torrijos'),
(181, 'Camille', 'Maling', 'Osicos', '29', 'female', '1986-06-14', 'Roman Catholic', '', 'afghan', '', '', 176, 'Single', 'Janagdong, Mogpog, Marinduque', 'Single', 'Residential', '', '09099277838', 'Janagdong', 'mogpog'),
(182, 'Roncemer', 'Sosa', 'Rondina', '22', 'male', '1993-12-15', 'Roman Catholic', '', 'afghan', '', '', 177, 'Single', 'Butansapa,Mogpog, Marinduque', 'Single', 'Residential', '', '09075481064', 'Janagdong', 'mogpog'),
(183, 'Ysagani', 'Lanot', 'Dantes', '25', 'male', '1990-04-22', 'Roman Catholic', '', 'afghan', '', '', 178, 'Single', 'Capayang, Mogpog, Marinduque', 'Single', 'Residential', '', '09152852575', 'Capayang', 'mogpog'),
(184, 'ss', 'bb', 'vv', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 179, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac'),
(185, 'dsf', 'qdfs', 'fg', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 180, 'Single', '', 'Single', 'Residential', '', '09152852575', '199', 'torrijos'),
(186, 'dsda', 'sdf', 'sdf', '', 'male', '1970-01-01', '', '', 'afghan', '', '', 181, 'Single', '', 'Single', 'Residential', '', '09152852575', '7', 'boac');

-- --------------------------------------------------------

--
-- Table structure for table `inspection_result`
--

CREATE TABLE `inspection_result` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `date_attended` varchar(255) DEFAULT NULL,
  `old_brand` varchar(255) DEFAULT NULL,
  `old_reading` varchar(255) DEFAULT NULL,
  `old_serial` varchar(255) DEFAULT NULL,
  `new_brand` varchar(255) DEFAULT NULL,
  `new_reading` varchar(255) DEFAULT NULL,
  `new_serial` varchar(255) DEFAULT NULL,
  `or_number` varchar(255) DEFAULT NULL,
  `kwh_meter_type` varchar(255) DEFAULT NULL,
  `sdw_length` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inspection_result`
--

INSERT INTO `inspection_result` (`id`, `complaint_id`, `date_attended`, `old_brand`, `old_reading`, `old_serial`, `new_brand`, `new_reading`, `new_serial`, `or_number`, `kwh_meter_type`, `sdw_length`) VALUES
(1, 2312, '', '', '', '', 'asdasd', '', '', '', '', ''),
(4, 2342, '', '', '', '', '', '', '', NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) UNSIGNED NOT NULL,
  `supply_id` int(11) DEFAULT NULL,
  `class_code` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `is_default` tinyint(4) DEFAULT '0',
  `branch_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id`, `supply_id`, `class_code`, `description`, `quantity`, `unit`, `remarks`, `is_default`, `branch_id`, `parent_id`) VALUES
(193, NULL, '06361612', 'Bolt, Oval Eye, 3/4'' x 12''', '45', 'pc', '', 0, NULL, NULL),
(194, NULL, '05361510', 'Bolt, Oval Eye, 5/8 x 10''', '14', 'pc', '', 0, NULL, NULL),
(195, NULL, '', 'Bolt, Oval Eye, 5/8'' x 12''', '45', 'pc', '', 0, NULL, NULL),
(196, NULL, '06361514', 'Bolt, Oval Eye, 5/8'' x 14''', '-98', 'pc', '', 0, NULL, NULL),
(197, NULL, '06361518', 'Bolt, Oval Eye, 5/8'' x 18''', '-25', 'pc', '', 0, NULL, NULL),
(198, NULL, '06361506', 'Bolt, Oval Eye, 5/8'' x 18''', '98', 'pc', '', 0, NULL, NULL),
(199, NULL, '06361509', 'Bolt, Oval Eye, 5/8'' x 9''', '46', 'pc', '', 0, NULL, NULL),
(200, NULL, '06390510', 'Bolt, Single Upset, 5/8'' x 10''', '86', 'pc', '', 0, NULL, NULL),
(201, NULL, '06390612', 'Bolt, Single Upset, 5/8'' x 12''', '56', 'pc', '', 0, NULL, NULL),
(202, NULL, '06390514', 'Bolt, Single Upset, 5/8'' x 14''', '45', 'pc', '', 0, NULL, NULL),
(203, NULL, '06390508', 'Bolt, Single Upset, 5/8'' x 8''', '50', 'pc', '', 0, NULL, NULL),
(204, NULL, 'BPSPP75', 'BP Solarex Power Panel 75wp', '120', 'pc', '', 0, NULL, NULL),
(205, NULL, '07853484', 'Brace, Alley Arm, Steel, 7ft.', '105', 'pc', '', 0, NULL, NULL),
(206, NULL, '07533126', 'Brace, Crossarm, 28'' Flat, Steel', '123', 'pc', '', 0, NULL, NULL),
(207, NULL, '07535168', 'Brace, Double Span Angle, 60''', '56', 'pc', '', 0, NULL, NULL),
(208, NULL, '07513446', 'Brace, One Piece Angle, Steel, 48 inch.', '86', 'pc', '', 0, NULL, NULL),
(209, NULL, '07553250', 'Brace, Vertical Sidearm', '46', 'pc', '', 0, NULL, NULL),
(210, NULL, '07804500', 'Bracket, Clevis deadend w/o Spool (Sec. Bracket)', '78', 'pc', '', 0, NULL, NULL),
(211, NULL, '11732211', 'Clamp, 1 Bolt 6'' 1/2 max', '56', 'pc', '', 0, NULL, NULL),
(212, NULL, '11711110', 'Clamp, Anchor Rod Bonding, Single Eye', '89', 'pc', '', 0, NULL, NULL),
(213, NULL, '11723227-4/0', 'Clamp, Deadend Strain #4 - 4/0 ACSR', '56', 'pc', '', 0, NULL, NULL),
(214, NULL, '11723227', 'Clamp, Deadend Strain #2 - 2/0 ACSR', '36', 'pc', '', 0, NULL, NULL),
(215, NULL, '11732291', 'Clamp, Guy Staright, 3 Bolt Heavy Duty Steel', '68', 'pc', '', 0, NULL, NULL),
(216, NULL, '17417605', 'Clamp, Hotline #2 - #4/0 ACSR', '59', 'pc', '', 0, NULL, NULL),
(217, NULL, '11411910', 'Clamp, Hotline #4 - #4/0 ACSR', '231', 'pc', '', 0, NULL, NULL),
(218, NULL, '11721025', 'Clamp, Loop Deadend #6 to #2/0 ACSR', '135', 'pc', '', 0, NULL, NULL),
(219, NULL, '11742335', 'Clamp, Suspension 15,000lbs', '564', 'pc', '', 0, NULL, NULL),
(220, NULL, '12301201', 'Clevis, Secondary Swinging', '159', 'pc', '', 0, NULL, NULL),
(221, NULL, '12301401', 'Clevis, Services, Swinging', '145', 'pc', '', 0, NULL, NULL),
(222, NULL, '12601000', 'Clip, Ground Wire', '123', 'pc', '', 0, NULL, NULL),
(223, NULL, '12601538', 'Clip, Guy Wire', '458', 'pc', '', 0, NULL, NULL),
(224, NULL, '15110261', 'Conductor, Bare, ACSR, #2, AWG. 6/1 (MTS)', '23', 'mtr', '', 0, NULL, NULL),
(225, NULL, '15112061', 'Conductor, Bare, ACSR, #2/0, AWG. 6/1 (MTS)', '32', 'mtr', '', 0, NULL, NULL),
(226, NULL, '15113061', 'Conductor, Bare, ACSR, #3/0, AWG. 6/1 (MTS)', '87', 'mtr', '', 0, NULL, NULL),
(227, NULL, '15114061', 'Conductor, Bare, ACSR, #4/0, AWG. 6/1 (MTS)', '46', 'mtr', '', 0, NULL, NULL),
(228, NULL, '16120606', 'Conductor, Duplex, #6 AWG (MTS)', '87', 'mtr', '', 0, NULL, NULL),
(229, NULL, '16300101', 'Conductor, Duplex, ACSR #1/0 AWG (MTS', '65', 'mtr', '', 0, NULL, NULL),
(230, NULL, '15120202', 'Conductor, Duplex, ACSR #2 AWG (MTS', '78', 'mtr', '', 0, NULL, NULL),
(231, NULL, '16120404', 'Conductor, Duplex, ACSR #4 AWG (MTS', '45', 'mtr', '', 0, NULL, NULL),
(232, NULL, '15110361', 'Conductor, Insulated, ACSR #2 AWG (MTS', '89', 'mtr', '', 0, NULL, NULL),
(233, NULL, '7700001-1/2', 'Condulet, TYPE LB, 1/2', '64', 'pc', '', 0, NULL, NULL),
(234, NULL, '7700001', 'Condulet, TYPE LB, 3/4', '36', 'pc', '', 0, NULL, NULL),
(235, NULL, '7700003-1/2', 'Condulet, TYPE LL, 1/2', '59', 'pc', '', 0, NULL, NULL),
(236, NULL, '35120025', 'Link, Fuse, Buttom Head, Type K, 26Amp.', '231', 'pc', '', 0, NULL, NULL),
(237, NULL, '36120002', 'Link, Fuse, Buttom Head, Type K, 2Amp.', '456', 'pc', '', 0, NULL, NULL),
(238, NULL, '36120003', 'Link, Fuse, Buttom Head, Type K, Amp.', '78', 'pc', '', 0, NULL, NULL),
(239, NULL, '36120040', 'Link, Fuse, Buttom Head, Type K, 40Amp.', '475', 'pc', '', 0, NULL, NULL),
(240, NULL, '36120004', 'Link, Fuse, Buttom Head, Type K, 4Amp.', '78', 'pc', '', 0, NULL, NULL),
(241, NULL, '36120050', 'Link, Fuse, Buttom Head, Type K, 50Amp.', '456', 'pc', '', 0, NULL, NULL),
(242, NULL, '36120005', 'Link, Fuse, Buttom Head, Type K, 5Amp.', '36', 'pc', '', 0, NULL, NULL),
(243, NULL, '35120065', 'Link, Fuse, Buttom Head, Type K, 65Amp.', '125', 'pc', '', 0, NULL, NULL),
(244, NULL, '35120006', 'Link, Fuse, Buttom Head, Type K, 6Amp.', '254', 'pc', '', 0, NULL, NULL),
(245, NULL, '36120080', 'Link, Fuse, Buttom Head, Type K, 80Amp.', '362', 'pc', '', 0, NULL, NULL),
(246, NULL, '36120006', 'Link, Fuse, Buttom Head, Type K, 8Amp.', '745', 'pc', '', 0, NULL, NULL),
(247, NULL, '35120030', 'Link, Fuse, Buttom Head, Type K, 30Amp.', '103', 'pc', '', 0, NULL, NULL),
(248, NULL, 'LBT', 'Load Buster Tool', '200', 'unit', '', 0, NULL, NULL),
(249, NULL, '42905037', 'Locknut, MF Type, 3/8', '152', 'pc', '', 0, NULL, NULL),
(250, NULL, '42903055', 'Locknut, MF Type, 5/0', '452', 'pc', '', 0, NULL, NULL),
(251, NULL, '78000220', 'Meter Base Socket foe Meter Cl. 20. 3W, 3PH', '124', 'pc', '', 0, NULL, NULL),
(252, NULL, '26000110', 'Meter Cover, Plastic Bag, Black', '130', 'pc', '', 0, NULL, NULL),
(253, NULL, '60000001', 'Mounting Bracket Luminaire', '123', 'pc', '', 0, NULL, NULL),
(254, NULL, '42906063', 'Nut Thimble Eye, 5/8'' Single Eye', '145', 'pc', '', 0, NULL, NULL),
(255, NULL, '42901063', 'Nut, Eye, 5/8 Conventional', '145', 'pc', '', 0, NULL, NULL),
(256, NULL, '42903050', 'Nut, Lock, MF type, 1/2''', '52', 'pc', '', 0, NULL, NULL),
(257, NULL, 'PSA', 'Panel Support Aluminum', '125', 'PC', '', 0, NULL, NULL),
(258, NULL, '15C174100010', 'Parallel, Connector, Bronze', '102', 'pc', '', 0, NULL, NULL),
(259, NULL, '456121200', 'Pin, Pole Top, Ch. 1'' threaded Dia 20'' Long', '124', 'pc', '', 0, NULL, NULL),
(260, NULL, '45612120', 'Pin, Pole Top, Ch. 1'' threaded Dia 20'' Long(C)', '125', 'pc', '', 0, NULL, NULL),
(261, NULL, '75219800', 'Plastic Seal', '123', 'pc', '', 0, NULL, NULL),
(262, NULL, '46800821', 'Plate Reinforcing', '103', 'pc', '', 0, NULL, NULL),
(263, NULL, '46800427', 'Plate, Ground for Poles', '215', 'pc', '', 0, NULL, NULL),
(264, NULL, '46800619', 'Plate, Guy Strain type 4x6''', '69', 'pc', '', 0, NULL, NULL),
(265, NULL, '48230830', 'Pole, Steel, 30', '231', 'pc', '', 0, NULL, NULL),
(266, NULL, '46230840', 'Pole, Steel, 40ft.', '126', 'pc', '', 0, NULL, NULL),
(267, NULL, '48230570', 'Pole, Steel, 70ft. 2 section, Octagonal', '145', 'pint', '', 0, NULL, NULL),
(268, NULL, '48030575', 'Pole, Steel, 75ft. 2 section, Octagonal', '56', 'pc', '', 0, NULL, NULL),
(269, NULL, '48225351', 'Pole, Wood, 2573, Hardwood, Aust. Fine', '145', 'pc', '', 0, NULL, NULL),
(270, NULL, '48813003', 'Pole, Wood, 3073, Hardwood, Aust. Fine', '78', 'pc', '', 0, NULL, NULL),
(271, NULL, '48233503', 'Pole, Wood, 3573, Hardwood, Aust. Fine', '98', 'pc', '', 0, NULL, NULL),
(272, NULL, '48244003', 'Pole, Wood, 4073, Hardwood, Aust. Fine', '125', 'pc', '', 0, NULL, NULL),
(273, NULL, '60555001', 'Performed, Guy, Grip 3/0', '98', 'pc', '', 0, NULL, NULL),
(274, NULL, '53614310', 'Rod, Anchor, Threaded, Single Eye, 3/4''x10''', '241', 'pc', '', 0, NULL, NULL),
(275, NULL, '53816507', 'Rod, Anchor, Threaded, Single Eye, 5/8''x10''', '145', 'pc', '', 0, NULL, NULL),
(276, NULL, '53717022', 'Rod, Armor, Preformed, For #2ACSR, Double Set', '152', 'pc', '', 0, NULL, NULL),
(277, NULL, '53717021', 'Rod, Armor, Preformed, For #2ACSR, Single Set', '45', 'pc', '', 0, NULL, NULL),
(278, NULL, '53868510', 'Rod, Ground Steel, Galvanized, 5/8''x10''', '48', 'pc', '', 0, NULL, NULL),
(279, NULL, '53865085', 'Rod, Ground Steel, Galvanized, 5/8''x5''', '48', 'pc', '', 0, NULL, NULL),
(280, NULL, '53865086', 'Rod, Ground Steel, Galvanized, 5/8''x8''', '56', 'pc', '', 0, NULL, NULL),
(281, NULL, '53717023', 'Rod, Tapping, Preformed, For #2 ACSR', '89', 'pc', '', 0, NULL, NULL),
(282, NULL, '77000010', 'RSC Pipe, 1/2x10''', '95', 'pc', '', 0, NULL, NULL),
(283, NULL, '77000011', 'RSC Pipe, 3/4x10''', '78', 'pc', '', 0, NULL, NULL),
(284, NULL, '07805500', 'Secondary Rack, 3 Spool', '45', 'pc', '', 0, NULL, NULL),
(285, NULL, '07805000', 'Secondary Rack, Single Spool', '125', 'pc', '', 0, NULL, NULL),
(286, NULL, '12302800', 'Shackle, Anchor', '45', 'pc', '', 0, NULL, NULL),
(287, NULL, '59102173', 'Socket, Ringless, for CL200, 4 Jaws, Rectangular', '125', 'pc', '', 0, NULL, NULL),
(288, NULL, '60007501', 'Spacer, Pipe, 3/4'' x 1-1/2''', '89', 'pc', '', 0, NULL, NULL),
(289, NULL, '60007501x', 'Spacer, Pipe, 3/4'' x 1-1/2''', '75', 'pc', '', 0, NULL, NULL),
(290, NULL, '61802810', 'Staple, Groundwire, 1/2'' x 2''', '75', 'pc', '', 0, NULL, NULL),
(291, NULL, '45412151', 'Steel Pin Crossarm, 5/8'' Dia., 1''thread, Long Shank', '45', 'pc', '', 0, NULL, NULL),
(292, NULL, '64000800', 'Support, Groundwire', '56', 'pc', '', 0, NULL, NULL),
(293, NULL, 'TS', 'Thumbler Switch', '48', 'pc', '', 0, NULL, NULL),
(294, NULL, '71026012', 'Washer, Lock 1/2', '74', 'pc', '', 0, NULL, NULL),
(295, NULL, '71025038', 'Washer, Lock 3/8', '75', 'pc', '', 0, NULL, NULL),
(296, NULL, '71020438', 'Washer, Lock, 3/8', '89', 'pc', '', 0, NULL, NULL),
(297, NULL, '71024012', 'Washer, Round 1/2', '42', 'pc', '', 0, NULL, NULL),
(298, NULL, '72030512', 'Washer, Round, 1/2', '43', 'pc', '', 0, NULL, NULL),
(299, NULL, '71023071', 'Washer, Square, Curve, 3'' x 3'' x 3/16''Dia.Hole', '89', 'pc', '', 0, NULL, NULL),
(300, NULL, '71020451', 'Washer, Square, Flat 2-1/4'' x 2-14'' x 3/16''', '58', 'pc', '', 0, NULL, NULL),
(301, NULL, '71022851', 'Washer, Square, Flat 4'' x 4'' x 1/2'' w/ 7/8'' Dia. Ho', '124', 'pc', '', 0, NULL, NULL),
(302, NULL, '71022851', 'Washer, Square, Flat 4'' x 4'' x 3/16''', '48', 'pc', '', 0, NULL, NULL),
(303, NULL, '74500038', 'Wire, Copper, Bare, 38mm2', '-146', 'mtr', '', 0, NULL, NULL),
(304, NULL, '74000138', 'Wire, Copper, Insulated, 38mm2', '45', 'mtr', '', 0, NULL, NULL),
(305, NULL, '72232040', 'Wire, Copper, Insulated, 50mm2', '32', 'mtr', '', 0, NULL, NULL),
(306, NULL, '72232040', 'Wire, Ground, Alum. EC. Grade #4 AWG (Ft.)', '87', 'ft', '', 0, NULL, NULL),
(307, NULL, '72700003', 'Wire, Grounding, Galvanized, 5/16'', 3Strand (Ft.)', '456', 'ft', '', 0, NULL, NULL),
(308, NULL, '73638307', 'Wire, Guy, Steel, 3/8'', 7 Strand (Ft.)', '236', 'ft', '', 0, NULL, NULL),
(309, NULL, '75101022', 'Wire, Holder, Service', '124', 'pc', '', 0, NULL, NULL),
(310, NULL, '72320020', 'Wire, Tape, Armor, Al. Alloy, 0.5'' x 0.3'' (Ft.)', '95', 'ft', '', 0, NULL, NULL),
(311, NULL, '72320401', 'Wire, Tie, Aluminum, Alloy, Soft, #4 AWG (Ft.)', '85', 'ft', '', 0, NULL, NULL),
(312, NULL, '48224003', 'Wood Pole 40 ft.', '46', 'pc', '', 0, NULL, NULL),
(313, NULL, '48224503', 'Wood Pole 45 ft.', '74', 'pc', '', 0, NULL, NULL),
(314, NULL, '48222503', 'Wood Pole 25 ft.', '42', 'pc', '', 0, NULL, NULL),
(315, NULL, '75219500OSC', 'Wood Screw', '89', 'pc', '', 0, NULL, NULL),
(316, NULL, 'BPS AVR 14.4', 'BY Pass Switch 14.4', '45', 'pc', '', 0, NULL, NULL),
(317, NULL, '10555236', 'Capacitor Power, 100kvar, V7620, BIL95-110KV, PCB F', '50', 'pc', '', 0, NULL, NULL),
(318, NULL, '10556236', 'Capacitor Power, 150kvar, V7620, BIL95-110KV, PCB F', '87', 'pc', '', 0, NULL, NULL),
(319, NULL, '18341321', 'Cutout and Arrester Comb. 15KV, 100A', '45', 'pc', '', 0, NULL, NULL),
(320, NULL, '18341321w/o', 'Cutout with out Arrester, 15KV, 100A', '25', 'pc', '', 0, NULL, NULL),
(321, NULL, '183413FH', 'Fuse Holder, 15KV, 100A', '45', 'pc', '', 0, NULL, NULL),
(322, NULL, '18501310', 'Lightning Arrester, 10KV, Polimer, ABB Brand', '45', 'pc', '', 0, NULL, NULL),
(323, NULL, '18301315', 'Lightning Arrester, 15KV, Cooper', '90', 'pc', '', 0, NULL, NULL),
(324, NULL, '39911305', 'Meter, KWH Cl.1, ENERTEK, EEM28, 1Ph, 240V, 10-30', '100', 'pc', '', 0, NULL, NULL),
(325, NULL, '39911393F72', 'Meter, KWH Cl.100, F-72, 1Phase, 2Wire, 240V', '45', 'pc', '', 0, NULL, NULL),
(326, NULL, '39911307', 'Meter, KWH Cl.2.0, 1Ph, 2Wire, 240V', '65', 'pc', '', 0, NULL, NULL),
(327, NULL, '39911395', 'Meter, KWH CL100, ENERTEK, 1P, 2W, 240V, 60Hz', '123', 'pc', '', 0, NULL, NULL),
(328, NULL, '39911493', 'Meter, KWH, 1Ph, Cl 200, 3Wire, 240V', '123', 'pc', '', 0, NULL, NULL),
(329, NULL, '39911393', 'Meter, KWH, 1Ph.Cl 100, 2Wire, 240V, G.E', '145', 'pc', '', 0, NULL, NULL),
(330, NULL, '390303100', 'Meter, KWH, Cl. 100, 3P, 3Wire, 240V, G.E', '65', 'pc', '', 0, NULL, NULL),
(331, NULL, '39030420', 'Meter, KWH, Cl 20, 3P, 4Wire, 120V, G.E', '45', 'pc', '', 0, NULL, NULL),
(332, NULL, '39911394', 'Meter, KWH, Cl.2.0, CX23, 2Wire, 240V, 1P, CXIMC', '34', 'pc', '', 0, NULL, NULL),
(333, NULL, '39911305', 'Meter, KWH, Cl.2.0, TCC, TCW01, 1P, 2Wire, 60Hz, 5', '124', 'pc', '', 0, NULL, NULL),
(334, NULL, '39973KV2C', 'Meter, KWH, Cl.2.0, KV2C, 1P, 2W, FM3S, 120-480V', '123', 'pc', '', 0, NULL, NULL),
(335, NULL, '39911210', 'Meter, KWH, Cl.2.0, G.E.,i210, Form 2S, 2Wire, 60H', '120', 'pc', '', 0, NULL, NULL),
(336, NULL, '50421333', 'Recloser, 15KV, 3Phase', '123', 'pc', '', 0, NULL, NULL),
(337, NULL, '59101212', 'Socket, Ring Type, for CL100, 4 Jaws, Two 1'' Hubs', '32', 'pc', '', 0, NULL, NULL),
(338, NULL, '59102525', 'Socket, Ringless, for CL20 KV2C, 5 Jaws, w/ interc', '123', 'pc', '', 0, NULL, NULL),
(339, NULL, '6936333', 'Transformer Distribution 333kvs', '350', 'unit', '', 0, NULL, NULL),
(340, NULL, '69123921', 'Transformer, Current, Outdoor, 15KV, 100:5 Ratio', '120', 'pc', '', 0, NULL, NULL),
(341, NULL, '69113965', 'Transformer, Current, Outdoor, 15KV, 150:5 Ratio', '45', 'pc', '', 0, NULL, NULL),
(342, NULL, '69123920', 'Transformer, Current, Outdoor, 15KV, 200:5 Ratio', '56', 'pc', '', 0, NULL, NULL),
(343, NULL, '69123920', 'Transformer, Current, Outdoor, 15KV, 25:5 Ratio', '120', 'pc', '', 0, NULL, NULL),
(344, NULL, '69123959', 'Transformer, Current, Outdoor, 15KV, 50:5 Ratio', '452', 'pc', '', 0, NULL, NULL),
(345, NULL, '69362510', 'Transformer, Pole Type, Conv., 10KVA', '56', 'unit', '', 0, NULL, NULL),
(346, NULL, '69324215', 'Transformer, Pole Type, Conv., 15KVA', '123', 'unit', '', 0, NULL, NULL),
(347, NULL, '69362525', 'Transformer, Pole Type, Conv., 25KVA', '145', 'unit', '', 0, NULL, NULL),
(348, NULL, '69362617', 'Transformer, Pole Type, Conv., 37.5KVA', '452', 'unit', '', 0, NULL, NULL),
(349, NULL, '69362550', 'Transformer, Pole Type, Conv., 50KVA', '120', 'unit', '', 0, NULL, NULL),
(350, NULL, '69324211', 'Transformer, Pole Type, CSP, 10KVA', '150', 'unit', '', 0, NULL, NULL),
(351, NULL, '69324250', 'Transformer, Pole Type, CSP, 50KVA', '126', 'unit', '', 0, NULL, NULL),
(352, NULL, 'Bolt, Oval Eye, 5/8 x 10''', 'Bolt, Oval Eye, 5/8 x 10''', '50', 'pc', '', 0, 6, 194),
(353, NULL, 'Bolt, Oval Eye, 5/8'' x 18''', 'Bolt, Oval Eye, 5/8'' x 18''', '55', 'pc', '', 0, 6, 197),
(354, NULL, 'Clamp, Hotline #2 - #4/0 ACSR', 'Clamp, Hotline #2 - #4/0 ACSR', '40', 'pc', '', 0, 6, 197),
(355, NULL, 'Wire, Copper, Bare, 38mm2', 'Wire, Copper, Bare, 38mm2', '87', 'mtr', '', 0, 6, 303),
(356, NULL, 'Meter, KWH CL100, ENERTEK, 1P, 2W, 240V, 60Hz', 'Meter, KWH CL100, ENERTEK, 1P, 2W, 240V, 60Hz', '90', 'pc', '', 0, 6, 303),
(357, NULL, 'Conductor, Insulated, ACSR #2 AWG (MTS', 'Conductor, Insulated, ACSR #2 AWG (MTS', '67', 'mtr', '', 0, 6, 303),
(358, NULL, 'Conductor, Duplex, ACSR #1/0 AWG (MTS', 'Conductor, Duplex, ACSR #1/0 AWG (MTS', '25', 'mtr', '', 0, 6, 303),
(359, NULL, 'Plate, Guy Strain type 4x6''', 'Plate, Guy Strain type 4x6''', '55', 'pc', '', 0, 6, 264),
(360, NULL, 'Bolt, Oval Eye, 3/4'' x 12''', 'Bolt, Oval Eye, 3/4'' x 12''', '30', 'pc', '', 0, 11, 193),
(361, NULL, 'Bolt, Single Upset, 5/8'' x 8''', 'Bolt, Single Upset, 5/8'' x 8''', '50', 'pc', '', 0, 6, 203),
(362, NULL, 'Load Buster Tool', 'Load Buster Tool', '36', 'unit', '', 0, 6, 248),
(363, NULL, 'Bolt, Oval Eye, 5/8'' x 14''', 'Bolt, Oval Eye, 5/8'' x 14''', '34', 'pc', '', 0, 8, 196),
(364, NULL, 'Bolt, Single Upset, 5/8'' x 8''', 'Bolt, Single Upset, 5/8'' x 8''', '50', 'pc', '', 0, 8, 196),
(365, NULL, 'Clamp, Hotline #2 - #4/0 ACSR', 'Clamp, Hotline #2 - #4/0 ACSR', '59', 'pc', '', 0, 8, 196),
(366, NULL, 'Clevis, Secondary Swinging', 'Clevis, Secondary Swinging', '5', 'pc', '', 0, 8, 220);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `message_type` varchar(255) NOT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `shortcode` varchar(255) NOT NULL,
  `request_id` longtext NOT NULL,
  `message` varchar(255) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `to` varchar(255) DEFAULT NULL,
  `viewed` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `message_type`, `mobile_number`, `shortcode`, `request_id`, `message`, `timestamp`, `to`, `viewed`) VALUES
(11, 'incoming', '639181234567', '29290123456', '5048303030534D41525430303030303239323030303', 'test+message', '1383609498.44', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `nature`
--

CREATE TABLE `nature` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `emergency_level` varchar(255) DEFAULT NULL,
  `requirements` text,
  `alloted_time` varchar(255) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nature`
--

INSERT INTO `nature` (`id`, `type`, `name`, `emergency_level`, `requirements`, `alloted_time`, `description`) VALUES
(15, 'request', 'Disconnection', 'Low', 'reason', '50', ''),
(16, 'request', 'Reconnection', 'Low', 'Service Fee(Php 150.00)(OR #)', '50', ''),
(17, 'request', 'Calibration', 'Low', 'Reason,Three highest bills,Service Memo,Meter Test report form,Meter Test fee(Php 2,2000.00)(OR #),Service Fee (Php 50.00)(OR #)', '50', 'Ito yong pagkakalibrate o pagsukat ng Metro.'),
(18, 'request', 'Change Meter', 'Low', 'Reason,Service Fee(Php 50.00)(OR #),Additional Fee if there is defect of the meter', '50', 'Ito yong pagpapalit ng Metro.'),
(19, 'request', 'Change Name', 'Low', ',Letter for Request,Service Fee (Php 50.00) (OR#)', '50', 'Ito yong pagpapapalit ng pangalan.'),
(20, 'request', 'Transfer Of Meter', 'Low', ',Reason,Service Fee (Php 50.00) (OR#)', '50', 'Ito yong pagpapalipat ng Metro.'),
(21, 'request', 'Relocate Meter', 'Low', ',Reason,Service Fee (Php 50.00) (OR#)', '50', 'Ito yong pagpapalipat ng tamang lokasyon ng Metro.'),
(22, 'request', 'Separate Meter', 'Low', ',Reason,Service Fee (Php 50.00) (OR#)', '50', 'Ito yong paghihiwalay ng Metro.'),
(23, 'request', 'Change Type of Membership (Commercial-Residential)', 'Low', ',Certification from barangay (Proof no Business),Certification from Municipal,Letter for Request,Service Fee (Php 50.00) (OR #),Cedula,Birth Certificate', '50', ''),
(24, 'complaint', 'Turn Off Temporary Light', 'Low', '', '66', 'Ito yong panandaliang pagpatay ng ilaw.'),
(25, 'complaint', 'Relocate Service Drop Wire', 'Medium', '', '30', 'Ito ay ang paglilipat ng Service Pole na mas malapit sa bahay.'),
(26, 'complaint', 'Disconnected Ground', 'Medium', NULL, NULL, NULL),
(27, 'complaint', 'Low Clearance of KWH/m', 'Medium', NULL, NULL, NULL),
(28, 'complaint', 'Grounded Connection', 'Medium', '', '30', 'Ito yong mga Equipment na may sira ang Conductor. Isa sa mga sanhi nito kapag walang grounding rod ang bawat appliances.'),
(29, 'complaint', 'Pull-out Service Drop Wire', 'Medium', '', '30', 'Ito yong pinatanggal ng may-ari ng bahay ang SDW kapag ayaw ng magkakuryente o di kaya may damaged yong wire.'),
(30, 'complaint', 'Low Voltage', 'Medium', NULL, NULL, NULL),
(31, 'complaint', 'Check Meter Connection', 'Medium', '', '30', 'Ito yong pagsiyasat ng connection ng metro. Isa sa mga sanhi nito ay ang maluwag ang pagkakalagay ng Metro o kaya ay yong turnilyo.'),
(32, 'complaint', 'Grounded Wire', 'Medium', NULL, NULL, NULL),
(33, 'complaint', 'High Consumption', 'Medium', NULL, NULL, NULL),
(34, 'complaint', 'Low Sag Service', 'Medium', NULL, NULL, NULL),
(35, 'complaint', 'Low Sag Service Drop Wire', 'Medium', '', '30', 'Ito yong mababa ang pagkalagay ng Service Drop Wire ayon sa Standard Height.'),
(36, 'complaint', 'Damaged Service Drop Wire', 'High', '', '30', 'Ito yong putol ang neutral line/damaged installation. Isa sa mga sanhi ay ang matalas ang yero kaya nasisira ang wire.'),
(37, 'complaint', 'No Light', 'Medium', '', '30', 'Ito ay karaniwang nangyayari sa bahay at Electric Service Interruption. Isa sa mga sanhi nito ang ang pagputok ng Fuse at Short Circuit.'),
(38, 'complaint', 'Loose Connection', 'High', '', '30', 'Ito yong napapansin sa Tapping/Joints kaya nawawala yong Connection. Isa sa mga sanhi nito ay ang maluwag na pagkalagay ng Wire.'),
(39, 'complaint', 'On and Off Power', 'High', '', '30', 'Ito ay biglang pagtaas at pagbaba ng boltahe at biglang pagpatay buhay ng ilaw.'),
(40, 'complaint', 'Spark Service Drop Wire', 'High', '', '30', 'Ito yong wire na natalupan, any material na connected dito ay sanhi ng pagspark.'),
(41, 'complaint', 'Busted Transformer', 'High', 'test1,test2', '120', 'Overload transformer/luma na ang transformer o kailangan ng palitan. Isa sa mga sanhi nito ay pumutok na Fuse Link.'),
(42, 'complaint', 'New Calibration', 'High', '', NULL, NULL),
(44, 'complaint', 'Low Clearance of KWH m', 'High', '', '30', 'Ito yong mababang paglagay ng metro ayon sa recommended height.'),
(45, 'complaint', 'Under Voltage', 'High', '', '30', 'Ito yong kailangan ng additional transformer/rehabilitation of transformer.'),
(46, 'complaint', 'High Billing', 'Medium', '', '30', 'Ito yong pagtaas ng kuryente. Ang isa sa mga sanhi nito ay may depekto ang metro.'),
(47, 'request', 'Change Type of Membership (Residential-Commercial)', 'Low', 'History of Billing,Other''s Consumer Service Form with Note (MARELCO),Service Fee (Php 50.00 ) (OR#),Cedula,Birth Certificate', '40', ''),
(48, 'complaint', 'Damage Meter', 'High', '', '30', ''),
(49, 'request', 'Membership', 'Low', '', '40', '');

-- --------------------------------------------------------

--
-- Table structure for table `nature_supply`
--

CREATE TABLE `nature_supply` (
  `id` int(11) NOT NULL,
  `nature_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nature_supply`
--

INSERT INTO `nature_supply` (`id`, `nature_id`, `material_id`, `quantity`) VALUES
(13, 43, 124, 2),
(14, 43, 121, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pending_reason`
--

CREATE TABLE `pending_reason` (
  `id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE `requirements` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  `membership_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`id`, `name`, `checked`, `membership_type`) VALUES
(78, 'Picture 1x1 &amp; 2x2', 0, 'residential'),
(79, 'Community Tax', 0, 'residential'),
(80, 'Barangay Clearance', 0, 'residential'),
(81, 'Certification from the Barangay where the dwelling is located', 0, 'residential'),
(82, 'Marriage Contract', 0, 'residential'),
(83, 'Electrical Plan', 0, 'residential'),
(84, 'Electrical Permit', 0, 'residential'),
(85, 'Valid 2 ID''s', 0, 'residential'),
(86, 'Fire Safety Clearance', 0, 'residential'),
(87, 'Picture 1x1 &amp; 2x2', 0, 'commercial'),
(88, 'Community Tax', 0, 'commercial'),
(89, 'Barangay Clearance', 0, 'commercial'),
(90, 'Certification from the Barangay where the dwelling is located', 0, 'commercial'),
(91, 'Marriage Contract', 0, 'commercial'),
(92, 'Electrical Plan', 0, 'commercial'),
(93, 'Electrical Permit', 0, 'commercial'),
(94, 'Valid 2 ID''s', 0, 'commercial'),
(95, 'Fire Safety Clearance', 0, 'commercial');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_checklist`
--

CREATE TABLE `requirement_checklist` (
  `id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `nature` varchar(25) NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  `requirement` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirement_checklist`
--

INSERT INTO `requirement_checklist` (`id`, `consumer_id`, `nature`, `checked`, `requirement`) VALUES
(20, 16, 'Membership', 1, 'Valid ID ( any of the ff.) <ul><li>SSS</li><li>PRC</li><li>TIN</li><li>Driver''s Licence</li> <li>Company ID</li> <li>Passport</li> <li>Postal ID</li> <li>Senior Citizen''s ID</li></ul>'),
(21, 16, 'Membership', 1, '\r\n\r\nCommunity Tax'),
(22, 16, 'Membership', 1, 'Barangay Clearance'),
(23, 16, 'Membership', 1, 'Certification from the barangay where the dwelling is located'),
(24, 16, 'Membership', 1, 'Marriage Contract (For Marrie applicants)'),
(25, 15, 'Membership', 1, 'Pre-Membership Orientation Certificate of Attendance'),
(26, 14, 'Membership', 1, 'Certification from the barangay where the dwelling is located'),
(27, 14, 'Membership', 1, 'Electrical Plan'),
(28, 69, 'Reconnection', 1, 'Service Fee(Php 150.00)(OR #)'),
(29, 68, 'Reconnection', 1, 'Service Fee(Php 150.00)(OR #)'),
(30, 77, 'Reconnection', 1, 'Service Fee(Php 150.00)(OR #)'),
(31, 80, 'Calibration', 1, 'Reason'),
(32, 80, 'Calibration', 1, 'Three highest bills'),
(33, 80, 'Calibration', 1, 'Service Memo'),
(34, 80, 'Calibration', 1, 'Meter Test report form'),
(35, 80, 'Calibration', 1, 'Meter Test fee(Php 2'),
(36, 80, 'Calibration', 1, '2000.00)(OR #)'),
(37, 80, 'Calibration', 1, 'Service Fee (Php 50.00)(OR #)'),
(38, 84, 'Calibration', 1, 'Reason'),
(39, 84, 'Calibration', 1, 'Three highest bills'),
(40, 84, 'Calibration', 1, 'Service Memo'),
(41, 84, 'Calibration', 1, 'Meter Test report form'),
(42, 84, 'Calibration', 1, 'Meter Test fee(Php 2'),
(43, 84, 'Calibration', 1, '2000.00)(OR #)'),
(44, 84, 'Calibration', 1, 'Service Fee (Php 50.00)(OR #)'),
(45, 87, 'Change Name', 1, ''),
(46, 87, 'Change Name', 1, 'Letter for Request'),
(47, 87, 'Change Name', 1, 'Service Fee (Php 50.00) (OR#)'),
(48, 88, 'Reconnection', 1, 'Service Fee(Php 150.00)(OR #)'),
(49, 91, 'Transfer Of Meter', 1, ''),
(50, 91, 'Transfer Of Meter', 1, 'Reason'),
(51, 91, 'Transfer Of Meter', 1, 'Service Fee (Php 50.00) (OR#)'),
(52, 2198, 'Busted Transformer', 1, 'test1'),
(53, 2198, 'Busted Transformer', 1, 'test2');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `overview` text NOT NULL,
  `complaint_id` int(11) NOT NULL,
  `dateadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `startdate` text NOT NULL,
  `enddate` text NOT NULL,
  `lineman_id` int(11) NOT NULL,
  `inspector_id` int(11) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `final` int(11) NOT NULL DEFAULT '0',
  `s_date` datetime DEFAULT NULL,
  `e_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `overview`, `complaint_id`, `dateadded`, `user_id`, `startdate`, `enddate`, `lineman_id`, `inspector_id`, `branch`, `final`, `s_date`, `e_date`) VALUES
(11666, 'Damaged Service Drop Wire', 2347, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 06:30:00', 'Fri Mar 04 2016 07:00:00', 160, 0, 'boac', 0, '2016-03-04 06:30:00', '2016-03-04 07:00:00'),
(11667, 'Damaged Service Drop Wire', 2350, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 07:00:00', 'Fri Mar 04 2016 07:30:00', 160, 0, 'boac', 0, '2016-03-04 07:00:00', '2016-03-04 07:30:00'),
(11668, 'Damaged Service Drop Wire', 2351, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 07:30:00', 'Fri Mar 04 2016 08:00:00', 160, 0, 'boac', 0, '2016-03-04 07:30:00', '2016-03-04 08:00:00'),
(11669, 'On and Off Power', 2353, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 08:00:00', 'Fri Mar 04 2016 08:30:00', 160, 0, 'boac', 0, '2016-03-04 08:00:00', '2016-03-04 08:30:00'),
(11670, 'Low Clearance of KWH m', 2352, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 08:30:00', 'Fri Mar 04 2016 09:00:00', 160, 0, 'boac', 0, '2016-03-04 08:30:00', '2016-03-04 09:00:00'),
(11671, 'Damaged Service Drop Wire', 2345, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 13:00:00', 'Fri Mar 04 2016 13:30:00', 160, 0, 'boac', 0, '2016-03-04 13:00:00', '2016-03-04 13:30:00'),
(11672, 'Spark Service Drop Wire', 2349, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 13:30:00', 'Fri Mar 04 2016 14:00:00', 160, 0, 'boac', 0, '2016-03-04 13:30:00', '2016-03-04 14:00:00'),
(11673, 'Grounded Connection', 2346, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 14:00:00', 'Fri Mar 04 2016 14:30:00', 160, 0, 'boac', 0, '2016-03-04 14:00:00', '2016-03-04 14:30:00'),
(11674, 'Change Name', 2348, '2016-03-03 09:03:11', 24, 'Fri Mar 04 2016 02:00:00', 'Fri Mar 04 2016 02:50:00', 0, 161, 'boac', 0, '2016-03-04 02:00:00', '2016-03-04 02:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_notif`
--

CREATE TABLE `schedule_notif` (
  `id` int(11) NOT NULL,
  `complaint_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule_notif`
--

INSERT INTO `schedule_notif` (`id`, `complaint_id`) VALUES
(1, 2250),
(2, 2252),
(3, 2251),
(4, 2254),
(5, 2253),
(6, 2255),
(7, 2256),
(8, 2257),
(9, 2260),
(10, 2259),
(11, 2262),
(12, 2263),
(13, 2261),
(14, 2312),
(15, 2341);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) UNSIGNED NOT NULL,
  `about` text,
  `mobile` text,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `slogan` text,
  `mission` text,
  `vission` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `about`, `mobile`, `phone`, `fax`, `email`, `slogan`, `mission`, `vission`) VALUES
(3, 'MARELCO is an electric distribution utility based on the island-province of Marinduque, Philippines', '09182959171', '+032 962 53', '', 'marelco@yahoo.com', '', '<p>Building MARELCO an institution which provides total quality service in the Socio-Economic Development of Marinduque</p>\n\n<h3>Objectives:</h3>\n<ol>\n <li>We shall strive to adopt a reasonable rate structure that would really reflect the real cost of providing the desired level of electric service.</li>\n<li>We shall maintain adequate financial surflus to ensure our viability and standing as a cooperative.</li>\n<li>We shall provide a quality o service pursuant to acceptable standards.</li>\n<li>We shall work to provide information to all sectors to make them understand, accept and support the co-op''s thrust, programs and activities.</li>\n<li>We shall continue to enhance the productivity of our resources.</li>\n<li>We shall provide our employees with opportunities for professional growth and advancement on the basis of performance, integrity and loyalty to the co-op.</li>\n<li>We shall attend to the personal well-being of the employees and provide them with just and reasonable compensation.</li>\n<li>We shall maintain and uphold the highest standards of business ethics.</li>\n<li>We shall fulfull with dedication our social responsibilities.</li>\n<li>We shall undertake activities which contribute to the economic and social development of the province and enhance the utilization of our resources.</li>\n<li>We shall support programs for environment preservation.</li>\n<li>We shall strive to bring the benefits of electrification to the greatest number of people within our coverage area.</li>\n</ol>', '<p>MARELCO as a dynamic service institution and catalyst in the Socio-Economic Development of Marinduque</p>');

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `desc` text,
  `date_added` timestamp NULL DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `desc`, `date_added`, `cover`) VALUES
(29, 'MARELCO', 'Supply Monitoring and Repair Management System', '2016-02-23 18:32:25', 'uploads/m1.jpg'),
(30, 'MARELCO', 'Supply Monitoring and Repair Management System', '2016-02-23 18:32:46', 'uploads/m2.jpg'),
(31, 'MARELCO', 'Supply Monitoring and Repair Management System', '2016-02-23 18:33:02', 'uploads/m3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` int(11) NOT NULL,
  `inbox_id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `request_id` int(11) NOT NULL,
  `timestamp` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `seen` int(11) DEFAULT '0',
  `complaint_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `inbox_id`, `sender`, `receiver`, `message`, `request_id`, `timestamp`, `date_created`, `seen`, `complaint_id`) VALUES
(626, 33, '639486329299', '2929078229', 'C-36 Reynalyn,Maritana,Rondina/Tanza,boac', 504830, '2016-02-22 19:51:51', '1456141911.86', 1, 2345),
(627, 37, '639152852575', '2929078229', 'C-28 Juan,lopez,dela cruz/pili,boac', 504830, '2016-02-23 17:39:20', '1456220356.53', 1, 2346),
(628, 39, '639486329299', '2929078229', 'C-36 Rachel,Rocacurva,Hernando/Laylay,Boac', 504830, '2016-02-23 20:46:39', '1456231721.31', 1, 2347),
(629, 40, '639485150005', '2929078229', 'C-19 Nikko,Hernando,Laguio/Laylay,Boac', 504830, '2016-02-24 02:05:09', '1456250832.89', 1, 2348),
(630, 41, '639486329299', '2929078229', 'C-40 Reynalyn,Maritana,Rondina/Tanza,Boac', 504830, '2016-02-24 02:17:00', '1456251544.1', 1, 2349),
(631, 43, '639485150005', '2929078229', 'C-36 Rachel,Rocacurva,Hernando/Laylay,Boac', 504830, '2016-02-24 10:27:18', '1456280837.24', 1, 2350),
(632, 44, '639485150005', '2929078229', 'C-36 Rachel,Rocacurva,Hernando/Laylay,Boac', 504830, '2016-02-24 10:29:51', '1456280991.48', 1, 2351),
(633, 45, '639152852575', '2929078229', 'C-44 ady,eng,sadiwa/pili,boac', 504830, '2016-02-25 03:55:16', '1456343716.61', 1, 2352),
(634, 46, '639152852575', '2929078229', 'C-39 Nikko,Hernando,Laguio/Laylay,Boac', 504830, '2016-02-25 04:01:35', '1456344095.58', 1, 2353),
(635, 47, '639152852575', '2929078229', 'C-36 Juan,de,lacruz/buangan,torrijos', 504830, '2016-02-25 08:43:17', '1456360997.56', 0, 2354),
(636, 48, '639309819567', '2929078229', 'C-19 Jasmin,Lozano,Cruzado/Buangan,Torrijos', 504830, '2016-02-25 13:47:47', '1456379266.8', 0, 2355),
(637, 49, '639956233053', '2929078229', 'C-40 Reynalyn,Maritana,Rondina/Bayakbakin,Torrijos', 504830, '2016-02-25 13:59:51', '1456379991.05', 0, 2356),
(638, 50, '639309819567', '2929078229', 'C-19 Rena,Hernando,Baculinao/Cabuyo,Torrijos', 504830, '2016-02-25 15:10:11', '1456384211.44', 0, 2357),
(639, 51, '639956233053', '2929078229', 'C-36 Reynalyn,Maritana,Rondina/Buangan,Torrijos', 504830, '2016-02-25 15:20:58', '1456384858.38', 0, 2358),
(640, 52, '639309819567', '2929078229', 'C-46 Rachel,Rocacurva,Hernando/Buangan,Torrijos', 504830, '2016-02-25 15:29:37', '1456385377.28', 0, 2359),
(641, 53, '639099540752', '2929078229', 'C-36 Jasmin,Lozano,Cruzado/Buangan,Torrijos', 504830, '2016-02-25 15:35:45', '1456385745.65', 0, 2360),
(642, 54, '639169037181', '2929078229', 'C-41 Maryjoy,Matining,Mansia/Buangan,Torrijos', 504830, '2016-02-25 15:47:24', '1456386444.16', 0, 2361),
(643, 55, '639169037181', '2929078229', 'C-45 Maryjoy,Matining,Mansia/Buangan,Torrijos', 504830, '2016-02-25 15:52:38', '1456386758.44', 0, 2362),
(644, 58, '639486329299', '2929078229', 'C-41 Reynalyn,Maritana,Rondina/Mabuhay,Torrijos', 504830, '2016-02-27 12:16:32', '1456546592.89', 0, 2363),
(645, 59, '639486329299', '2929078229', 'C-41 Reynalyn,Maritana,Rondina/Laon,Mogpog', 504830, '2016-02-29 09:07:27', '1456708047.14', 0, 2364),
(646, 60, '639485150005', '2929078229', 'C-19 Rachel,Rocacurva,Hernando/Cabuyo,Torrijos', 504830, '2016-02-29 11:18:10', '1456715889.9', 0, 2365),
(647, 61, '639485150005', '2929078229', 'C-19 Rachel,Rocacurva,Hernando/Cabuyo,Torrijos', 504830, '2016-02-29 12:19:12', '1456719551.88', 0, 2366),
(648, 63, '639486329299', '2929078229', 'C-41 Reynalyn,Maritana,Rondina/Cabuyo,Torrijos', 504830, '2016-03-02 14:18:52', '1456899531.19', 0, 2367),
(649, 64, '639485150005', '2929078229', 'C-41 Rachel,Rocacurva,Hernando/Buangan,Torrijos', 504830, '2016-03-02 14:18:53', '1456899532.62', 0, 2368),
(650, 65, '639485150005', '2929078229', 'C-38 Ryan,Rocacurva,Hernando/Tigwi,Torrijos', 504830, '2016-03-02 14:19:41', '1456899581.02', 0, 2369),
(651, 66, '639485150005', '2929078229', 'C-38 Ryan,Rocacurva,Hernando/Tigwi,Torrijos', 504830, '2016-03-02 14:34:43', '1456900482.57', 0, 2370),
(652, 67, '639486329299', '2929078229', 'C-38 Reynalyn,Maritana,Rondina/Mabuhay,Torrijos', 504830, '2016-03-02 14:36:02', '1456900561.93', 0, 2371),
(653, 68, '639486329299', '2929078229', 'C-41 Reynalyn,Maritana,Rondina/Bahi,Gasan', 504830, '2016-03-03 02:58:32', '1456945110.94', 0, 2372),
(654, 69, '639126120038', '2929078229', 'C-38 Rose,Sarile,Fermo/Tabionan,Gasan', 504830, '2016-03-03 03:56:35', '1456948593.5', 0, 2373);

-- --------------------------------------------------------

--
-- Table structure for table `spouse`
--

CREATE TABLE `spouse` (
  `id` int(11) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `dob` varchar(255) NOT NULL,
  `pob` varchar(255) NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL,
  `age` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spouse`
--

INSERT INTO `spouse` (`id`, `lastname`, `firstname`, `middlename`, `dob`, `pob`, `occupation`, `userid`, `age`) VALUES
(68, 's last', 's first', 's middle', '02/09/2016', 'pili,boac,marinduque', 'programmer', 129, '0'),
(69, 's2l', 's2f', 's2m', '02/16/2016', 's', 'sdf', 130, '0'),
(70, '', '', '', '', '', '', 137, ''),
(71, '', '', '', '', '', '', 140, ''),
(72, '', '', '', '', '', '', 141, ''),
(73, '', '', '', '', '', '', 142, ''),
(74, '', '', '', '', '', '', 148, ''),
(75, '', '', '', '', '', '', 149, ''),
(76, '', '', '', '', '', '', 150, ''),
(77, '', '', '', '', '', '', 151, ''),
(78, '', '', '', '', '', '', 155, ''),
(79, '', '', '', '', '', '', 158, ''),
(80, '', '', '', '', '', '', 159, ''),
(81, 'Malapad', 'Joseph', 'Lazo', '04/22/1976', 'Pawa, Boac, Marinduque', 'Businessman', 168, '39');

-- --------------------------------------------------------

--
-- Table structure for table `supply`
--

CREATE TABLE `supply` (
  `id` int(11) UNSIGNED NOT NULL,
  `requesting_dept` int(11) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `work_order_ref_no` varchar(255) DEFAULT NULL,
  `requested_by` varchar(255) DEFAULT NULL,
  `approved_by` varchar(255) DEFAULT NULL,
  `muv_no` varchar(255) DEFAULT NULL,
  `approved` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supply`
--

INSERT INTO `supply` (`id`, `requesting_dept`, `purpose`, `date`, `work_order_ref_no`, `requested_by`, `approved_by`, `muv_no`, `approved`) VALUES
(1, 6, 'asd', '02/10/2016', '2342', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL,
  `status` int(11) DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `requirement` text,
  `branch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `date_registered`, `deleted`, `type`, `status`, `note`, `requirement`, `branch_id`) VALUES
(24, 'sudoadmin', '3c54e129eff2d3796423c11fb46a3264', 'admin@gmail.com', '2016-01-09 05:15:21', 0, 'admin', 3, NULL, NULL, 6),
(160, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 00:43:55', 0, 'line_man', 0, NULL, NULL, 6),
(161, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 00:45:09', 0, 'inspector', 0, NULL, NULL, 6),
(162, 'csc_boac', '3c54e129eff2d3796423c11fb46a3264', 'csc@gmail.com', '2016-02-29 00:47:26', 0, 'consumer_service_coordinator', 1, NULL, NULL, 6),
(163, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 01:59:10', 0, 'applicant', 3, '1', 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL),
(164, 'csc_stacruz', '3c54e129eff2d3796423c11fb46a3264', 'cscsantacruz@yahoo.com', '2016-02-29 03:08:46', 0, 'consumer_service_coordinator', 1, NULL, NULL, 9),
(165, 'csc_torrijos', '3c54e129eff2d3796423c11fb46a3264', 'csctorrijos@yahoo.com', '2016-02-29 03:10:20', 0, 'consumer_service_coordinator', 1, NULL, NULL, 11),
(166, 'csc_buenavista', '3c54e129eff2d3796423c11fb46a3264', 'cscbuenavista@yahoo.com', '2016-02-29 03:12:12', 0, 'consumer_service_coordinator', 1, NULL, NULL, 10),
(167, 'csc_gasan', '3c54e129eff2d3796423c11fb46a3264', 'cscgasan@yahoo.com', '2016-02-29 03:13:31', 0, 'consumer_service_coordinator', 1, NULL, NULL, 8),
(168, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 09:17:01', 0, 'applicant', 3, '1', 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL),
(169, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 09:27:41', 1, 'line_man', 0, NULL, NULL, 8),
(170, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 12:21:48', 0, 'line_man', 0, NULL, NULL, 8),
(171, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 12:24:26', 0, 'inspector', 0, NULL, NULL, 8),
(172, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 13:09:14', 0, 'applicant', 3, '1', 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL),
(173, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 17:17:43', 0, 'line_man', 0, NULL, NULL, 9),
(174, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 17:19:47', 0, 'inspector', 0, NULL, NULL, 7),
(175, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 22:37:32', 0, 'applicant', 3, '1', 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL),
(176, 'csc_mogpog', '3c54e129eff2d3796423c11fb46a3264', 'cscmogpog@yahoo.com', '2016-02-29 22:50:19', 0, 'consumer_service_coordinator', 1, NULL, NULL, 7),
(177, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 23:22:46', 0, 'line_man', 0, NULL, NULL, 7),
(178, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-02-29 23:25:48', 0, 'inspector', 0, NULL, NULL, 7),
(179, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-03-01 00:49:37', 0, 'applicant', 3, '1', 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL),
(180, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-03-02 03:19:59', 0, 'line_man', 0, NULL, NULL, 11),
(181, 'walkinUser', '3c54e129eff2d3796423c11fb46a3264', 'walkinemail@gmail.com', '2016-03-02 21:54:20', 0, 'applicant', 3, NULL, 'Picture 1x1 &amp; 2x2|Community Tax|Barangay Clearance|Certification from the Barangay where the dwelling is located|Marriage Contract|Electrical Plan|Electrical Permit|Valid 2 ID''s|Fire Safety Clearance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_schedule`
--

CREATE TABLE `user_schedule` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `start` text NOT NULL,
  `end` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_schedule`
--

INSERT INTO `user_schedule` (`id`, `userid`, `start`, `end`) VALUES
(189, 160, '02/29/2016 01:30:00', '02/29/2016 04:00:00'),
(190, 160, '02/29/2016 04:30:00', '02/29/2016 07:00:00'),
(196, 170, '03/02/2016 03:00:00', '03/02/2016 07:00:00'),
(197, 171, '03/02/2016 03:00:00', '03/02/2016 07:00:00'),
(200, 173, '03/02/2016 10:00:00', '03/02/2016 10:30:00'),
(201, 174, '03/02/2016 10:00:00', '03/02/2016 12:00:00'),
(202, 160, '03/02/2016 01:30:00', '03/02/2016 02:30:00'),
(204, 180, '03/02/2016 11:00:00', '03/02/2016 11:30:00'),
(205, 180, '03/03/2016 09:30:00', '03/03/2016 11:30:00'),
(206, 180, '03/03/2016 12:30:00', '03/03/2016 14:00:00'),
(207, 180, '03/02/2016 13:30:00', '03/02/2016 17:00:00'),
(208, 180, '03/03/2016 15:00:00', '03/03/2016 19:30:00'),
(209, 180, '03/04/2016 11:00:00', '03/04/2016 16:30:00'),
(213, 160, '03/02/2016 04:30:00', '03/02/2016 05:00:00'),
(215, 160, '03/01/2016 02:30:00', '03/01/2016 09:00:00'),
(231, 160, '03/04/2016 13:00:00', '03/04/2016 15:00:00'),
(232, 161, '03/04/2016 02:00:00', '03/04/2016 10:00:00'),
(235, 160, '03/04/2016 06:30:00', '03/04/2016 09:00:00'),
(236, 160, '03/03/2016 06:30:00', '03/03/2016 08:00:00'),
(237, 160, '03/03/2016 10:00:00', '03/03/2016 11:00:00'),
(240, 160, '03/03/2016 16:00:00', '03/03/2016 18:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `description` (`description`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brgy`
--
ALTER TABLE `brgy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);
ALTER TABLE `info` ADD FULLTEXT KEY `FullText` (`firstname`,`lastname`,`middlename`);

--
-- Indexes for table `inspection_result`
--
ALTER TABLE `inspection_result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nature`
--
ALTER TABLE `nature`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nature_supply`
--
ALTER TABLE `nature_supply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_reason`
--
ALTER TABLE `pending_reason`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirements`
--
ALTER TABLE `requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requirement_checklist`
--
ALTER TABLE `requirement_checklist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_notif`
--
ALTER TABLE `schedule_notif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spouse`
--
ALTER TABLE `spouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supply`
--
ALTER TABLE `supply`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user_schedule`
--
ALTER TABLE `user_schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `brgy`
--
ALTER TABLE `brgy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;
--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2374;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
--
-- AUTO_INCREMENT for table `inspection_result`
--
ALTER TABLE `inspection_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=367;
--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `nature`
--
ALTER TABLE `nature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `nature_supply`
--
ALTER TABLE `nature_supply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `pending_reason`
--
ALTER TABLE `pending_reason`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `requirements`
--
ALTER TABLE `requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `requirement_checklist`
--
ALTER TABLE `requirement_checklist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11675;
--
-- AUTO_INCREMENT for table `schedule_notif`
--
ALTER TABLE `schedule_notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=655;
--
-- AUTO_INCREMENT for table `spouse`
--
ALTER TABLE `spouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `supply`
--
ALTER TABLE `supply`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;
--
-- AUTO_INCREMENT for table `user_schedule`
--
ALTER TABLE `user_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
