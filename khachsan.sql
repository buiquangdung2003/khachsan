-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2025 at 05:04 PM
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
-- Database: `khachsan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_cred`
--

CREATE TABLE `admin_cred` (
  `sr_no` int(11) NOT NULL,
  `admin_name` varchar(150) NOT NULL,
  `admin_pass` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_cred`
--

INSERT INTO `admin_cred` (`sr_no`, `admin_name`, `admin_pass`) VALUES
(3, 'duongminhcuong', '123');

-- --------------------------------------------------------

--
-- Table structure for table `booking_details`
--

CREATE TABLE `booking_details` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `total_pay` int(11) NOT NULL,
  `room_no` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `address` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_details`
--

INSERT INTO `booking_details` (`sr_no`, `booking_id`, `room_name`, `price`, `total_pay`, `room_no`, `user_name`, `phonenum`, `address`) VALUES
(114, 115, 'Phòng VIP 1', 1000000, 1000000, NULL, 'Dương Minh Cường', '0372202056', 'Hà Đông - Hà Nội'),
(115, 116, 'Phòng Đơn', 500000, 2500000, NULL, 'Bùi Quang Dũng', '0984652501', 'Ba Vì - Hà Nội'),
(116, 117, 'Phòng Bình Dân', 800000, 1600000, NULL, 'Nguyễn Thế Anh', '0982267810', 'Quảng Ninh');

-- --------------------------------------------------------

--
-- Table structure for table `booking_order`
--

CREATE TABLE `booking_order` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `arrival` int(11) NOT NULL DEFAULT 0,
  `refund` int(11) DEFAULT NULL,
  `booking_status` varchar(100) NOT NULL DEFAULT 'Đã Đặt',
  `order_id` varchar(150) NOT NULL,
  `trans_id` varchar(200) DEFAULT NULL,
  `trans_amt` int(11) NOT NULL,
  `trans_status` varchar(100) NOT NULL DEFAULT 'Đã Đặt',
  `trans_resp_msg` varchar(200) DEFAULT NULL,
  `rate_review` int(11) DEFAULT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_order`
--

INSERT INTO `booking_order` (`booking_id`, `user_id`, `room_id`, `check_in`, `check_out`, `arrival`, `refund`, `booking_status`, `order_id`, `trans_id`, `trans_amt`, `trans_status`, `trans_resp_msg`, `rate_review`, `datentime`) VALUES
(109, 10, 6, '2023-09-27', '2023-09-29', 1, NULL, 'Đã Thanh Toán', 'ORD_109543167', NULL, 3000000, 'TXN_SUCCESS', NULL, 1, '2023-09-27 07:48:44'),
(110, 10, 8, '2023-09-28', '2023-09-29', 1, NULL, 'Đã Thanh Toán', 'ORD_107126095', NULL, 500000, 'TXN_SUCCESS', NULL, NULL, '2023-09-27 08:10:32'),
(115, 10, 4, '2025-06-05', '2025-06-06', 1, NULL, 'Đã Thanh Toán', 'ORD_109951122', NULL, 1000000, 'TXN_SUCCESS', NULL, NULL, '2025-06-05 12:34:09'),
(116, 10, 8, '2025-06-05', '2025-06-10', 1, NULL, 'Đã Thanh Toán', 'ORD_109825362', NULL, 2500000, 'TXN_SUCCESS', NULL, NULL, '2025-06-05 12:39:44'),
(117, 10, 3, '2025-06-05', '2025-06-07', 0, 0, 'Đã Huỷ', 'ORD_102783166', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-06-05 12:41:42'),
(118, 10, 3, '2025-06-06', '2025-06-07', 0, 0, 'Đã Huỷ', 'ORD_108009737', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-06-06 11:46:46'),
(119, 10, 3, '2025-07-03', '2025-07-04', 0, 0, 'Đã Huỷ', 'ORD_105446191', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-07-03 19:00:02'),
(120, 10, 3, '2025-07-03', '2025-07-04', 0, 0, 'Đã Huỷ', 'ORD_103411514', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-07-03 19:00:23'),
(121, 10, 3, '2025-07-03', '2025-07-04', 0, 0, 'Đã Huỷ', 'ORD_104253898', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-07-03 19:19:22'),
(122, 10, 3, '2025-07-03', '2025-07-05', 0, 0, 'Đã Huỷ', 'ORD_105631647', NULL, 0, 'Đã Đặt', NULL, NULL, '2025-07-03 19:19:31');

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `sr_no` int(11) NOT NULL,
  `image` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`sr_no`, `image`) VALUES
(11, 'IMG_13334.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

CREATE TABLE `contact_details` (
  `sr_no` int(11) NOT NULL,
  `address` varchar(500) NOT NULL,
  `gmap` varchar(1000) NOT NULL,
  `pn1` bigint(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fb` varchar(100) NOT NULL,
  `insta` varchar(100) NOT NULL,
  `tw` varchar(100) NOT NULL,
  `iframe` varchar(1000) NOT NULL,
  `pn2` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_details`
--

INSERT INTO `contact_details` (`sr_no`, `address`, `gmap`, `pn1`, `email`, `fb`, `insta`, `tw`, `iframe`, `pn2`) VALUES
(1, 'Số 142 đường Hoàng Văn Thụ, phường Hoàng Văn Thụ, thành phố Thái Nguyên, tỉnh Thái Nguyên', 'https://www.google.com/maps/place/142+%C4%90%C6%B0%E1%BB%9Dng+Ho%C3%A0ng+V%C4%83n+Th%E1%BB%A5,+Th%C3%A0nh+ph%E1%BB%91+Th%C3%A1i+Nguy%C3%AAn,+Th%C3%A1i+Nguy%C3%AAn,+Vi%E1%BB%87t+Nam/@21.5897549,105.8277686,17z/data=!3m1!4b1!4m6!3m5!1s0x313526e00d5dbd33:0x35022798ae96c804!8m2!3d21.5897549!4d105.8303435!16s%2Fg%2F11j9dbqswn?hl=vi&entry=ttu&g_ep=EgoyMDI1MDUyOC4wIKXMDSoASAFQAw%3D%3D', 2083758288, 'khachsandonga1@gmail.com', 'https://www.facebook.com/CafeDongA1/?locale=vi_VN', 'https://www.facebook.com/', '', 'https://www.google.com/maps/place/142+%C4%90%C6%B0%E1%BB%9Dng+Ho%C3%A0ng+V%C4%83n+Th%E1%BB%A5,+Th%C3%A0nh+ph%E1%BB%91+Th%C3%A1i+Nguy%C3%AAn,+Th%C3%A1i+Nguy%C3%AAn,+Vi%E1%BB%87t+Nam/@21.5897549,105.8277686,17z/data=!3m1!4b1!4m6!3m5!1s0x313526e00d5dbd33:0x35022798ae96c804!8m2!3d21.5897549!4d105.8303435!16s%2Fg%2F11j9dbqswn?hl=vi&entry=ttu&g_ep=EgoyMDI1MDUyOC4wIKXMDSoASAFQAw%3D%3D', 981146288);

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `description`) VALUES
(13, 'Wifi', 'Wifi trong khách sạn cho phép khách hàng kết nối internet không dây tốc độ cao, có thể truy cập vào các trang web yêu thích của họ, xem phim, nghe nhạc, tải xuống các tài liệu, và liên lạc với người thân và bạn bè. '),
(14, 'Điều Hoà', ' Khách hàng có thể dễ dàng điều chỉnh nhiệt độ và các tính năng khác trên điều hòa để đáp ứng các nhu cầu của họ và tạo ra một không gian nghỉ ngơi lý tưởng.'),
(15, 'Tivi', 'TV cung cấp cho khách hàng nhiều kênh truyền hình đa dạng và phong phú, bao gồm cả các kênh quốc tế và địa phương, các kênh phim, chương trình giải trí, tin tức, thể thao và giáo dục'),
(17, 'Spa', 'Tại spa, khách hàng có thể trải nghiệm các liệu pháp chăm sóc da, tắm thủy lực, massage và nhiều dịch vụ khác.'),
(18, 'Máy sưởi', 'Máy sưởi phòng được thiết kế để giữ cho phòng ấm áp và thoải mái trong suốt mùa đông.'),
(19, 'Nóng Lạnh', 'Được trang bị các tính năng và thiết bị hiện đại như màn hình LCD hiển thị nhiệt độ, điều khiển từ xa, cảm biến nhiệt độ và chức năng tự động điều chỉnh nhiệt độ nước.');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(18, 'Phòng Ngủ'),
(19, 'Ban Công'),
(20, 'Phòng Bếp'),
(21, 'Ghế sofa'),
(23, 'Bàn Ăn');

-- --------------------------------------------------------

--
-- Table structure for table `rating_review`
--

CREATE TABLE `rating_review` (
  `sr_no` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(200) NOT NULL,
  `seen` int(11) NOT NULL DEFAULT 0,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating_review`
--

INSERT INTO `rating_review` (`sr_no`, `booking_id`, `room_id`, `user_id`, `rating`, `review`, `seen`, `datentime`) VALUES
(12, 110, 3, 5, 5, 'Khách sạn rất đẹp, nhân viên tư vấn nhiệt tình', 0, '2025-06-03 14:00:22'),
(15, 109, 6, 10, 5, 'Dịch vụ khách sạn rất tốt ', 0, '2025-06-05 17:11:18');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `area` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `adult` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `description` varchar(350) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `removed` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `area`, `price`, `quantity`, `adult`, `children`, `description`, `status`, `removed`) VALUES
(3, 'Phòng Bình Dân', 30, 800000, 4, 5, 3, 'Các tiện nghi trong phòng khách sạn bao gồm các ghế sofa và bàn, tivi màn hình phẳng, minibar, két sắt, điều hòa, máy sưởi, hệ thống chiếu sáng, tủ quần áo và giường ngủ thoải mái.', 1, 0),
(4, 'Phòng VIP 1', 40, 1000000, 3, 5, 5, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero sed tempore illo atque beatae asperiores, adipisci dicta quia nisi voluptates impedit perspiciatis, nobis libero culpa error officiis totam?Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos voluptate vero sed tempore illo atque beatae asperiores, adipisci dic', 1, 0),
(5, 'Phòng Vip 2', 40, 1200000, 3, 8, 6, 'Các tiện nghi trong phòng khách sạn bao gồm các ghế sofa và bàn, tivi màn hình phẳng, minibar, két sắt, điều hòa, máy sưởi, hệ thống chiếu sáng, tủ quần áo và giường ngủ thoải mái.', 1, 0),
(6, 'Phòng Vip 3', 50, 1500000, 7, 9, 10, 'Các tiện nghi trong phòng khách sạn bao gồm các ghế sofa và bàn, tivi màn hình phẳng, minibar, két sắt, điều hòa, máy sưởi, hệ thống chiếu sáng, tủ quần áo và giường ngủ thoải mái.', 1, 0),
(7, 'Phòng Đơn', 20, 800000, 2, 2, 2, 'phòng rộng rãi', 1, 1),
(8, 'Phòng Đơn', 20, 500000, 2, 2, 2, 'rộng rãi thoáng mát', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_facilities`
--

CREATE TABLE `room_facilities` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `facilities_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_facilities`
--

INSERT INTO `room_facilities` (`sr_no`, `room_id`, `facilities_id`) VALUES
(52, 4, 13),
(53, 4, 14),
(54, 4, 19),
(65, 3, 13),
(66, 3, 14),
(67, 3, 15),
(68, 5, 13),
(69, 5, 14),
(70, 5, 19),
(71, 6, 13),
(72, 6, 14),
(73, 6, 15),
(74, 6, 18),
(75, 6, 19),
(77, 8, 13);

-- --------------------------------------------------------

--
-- Table structure for table `room_features`
--

CREATE TABLE `room_features` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `features_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_features`
--

INSERT INTO `room_features` (`sr_no`, `room_id`, `features_id`) VALUES
(36, 4, 18),
(37, 4, 19),
(38, 4, 20),
(46, 3, 18),
(47, 3, 20),
(48, 5, 18),
(49, 5, 19),
(50, 5, 21),
(51, 6, 18),
(52, 6, 19),
(53, 6, 20),
(54, 6, 21),
(56, 8, 18);

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `sr_no` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `image` varchar(150) NOT NULL,
  `thumb` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_images`
--

INSERT INTO `room_images` (`sr_no`, `room_id`, `image`, `thumb`) VALUES
(26, 3, 'IMG_95263.png', 0),
(27, 3, 'IMG_67237.png', 1),
(28, 4, 'IMG_45742.png', 0),
(29, 4, 'IMG_25983.png', 1),
(30, 5, 'IMG_61875.png', 1),
(31, 5, 'IMG_48729.png', 0),
(32, 6, 'IMG_96889.png', 0),
(33, 6, 'IMG_82238.jpg', 1),
(34, 8, 'IMG_71497.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `sr_no` int(11) NOT NULL,
  `site_title` varchar(50) NOT NULL,
  `site_about` varchar(250) NOT NULL,
  `shutdown` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`sr_no`, `site_title`, `site_about`, `shutdown`) VALUES
(1, 'Đông Á 1 Hotel', 'Khách sạn Đông Á 1 Hotel là một trong những khách sạn hàng đầu tại Việt Nam, được thiết kế theo phong cách hiện đại và đầy đủ tiện nghi, với hệ thống phòng nghỉ sang trọng, nhà hàng, quầy bar, trung tâm thể dục và spa.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `team_details`
--

CREATE TABLE `team_details` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `picture` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cred`
--

CREATE TABLE `user_cred` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` varchar(120) NOT NULL,
  `phonenum` varchar(100) NOT NULL,
  `pincode` int(11) NOT NULL,
  `dob` date NOT NULL,
  `profile` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `token` varchar(200) DEFAULT NULL,
  `t_expire` date DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `datentime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_cred`
--

INSERT INTO `user_cred` (`id`, `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`, `password`, `is_verified`, `token`, `t_expire`, `status`, `datentime`) VALUES
(5, 'Nguyễn Văn Đức', 'vanduc01@gmail.com', 'Nghĩa Hưng - Nam Định ', '0982450162', 41700, '2001-04-23', '', '23042001', 0, NULL, NULL, 1, '2025-06-02 13:56:32'),
(10, 'Dương Minh Cường', 'ssscuong2003@gmail.com', 'Hà Đông - Hà Nội', '0372202056', 12100, '2003-12-26', '3.jpeg', '26122003', 1, NULL, NULL, 1, '2025-05-20 14:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` varchar(500) NOT NULL,
  `datentime` datetime NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `subject`, `message`, `datentime`, `seen`) VALUES
(16, 'Nguyễn Văn Nam', 'nguyenvannam21gmail.com', 'Phản hồi', 'Chất lượng phục vụ của khách sạn rất tốt', '2025-06-05 18:17:18', 1),
(18, 'Dương Minh Cường', 'ssscuong2003@gmail.com', 'Phản hồi', 'Khách sạn rất đẹp, phòng thoáng mát, nhân viên tư vấn hỗ trợ rất nhiệt tình', '2025-07-01 14:10:06', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_cred`
--
ALTER TABLE `admin_cred`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `contact_details`
--
ALTER TABLE `contact_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `facilities id` (`facilities_id`),
  ADD KEY `room id` (`room_id`);

--
-- Indexes for table `room_features`
--
ALTER TABLE `room_features`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `features id` (`features_id`),
  ADD KEY `rm id` (`room_id`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`sr_no`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `team_details`
--
ALTER TABLE `team_details`
  ADD PRIMARY KEY (`sr_no`);

--
-- Indexes for table `user_cred`
--
ALTER TABLE `user_cred`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_cred`
--
ALTER TABLE `admin_cred`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking_details`
--
ALTER TABLE `booking_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `booking_order`
--
ALTER TABLE `booking_order`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `contact_details`
--
ALTER TABLE `contact_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `rating_review`
--
ALTER TABLE `rating_review`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `room_facilities`
--
ALTER TABLE `room_facilities`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `room_features`
--
ALTER TABLE `room_features`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `team_details`
--
ALTER TABLE `team_details`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_cred`
--
ALTER TABLE `user_cred`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking_details`
--
ALTER TABLE `booking_details`
  ADD CONSTRAINT `booking_details_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`);

--
-- Constraints for table `booking_order`
--
ALTER TABLE `booking_order`
  ADD CONSTRAINT `booking_order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`),
  ADD CONSTRAINT `booking_order_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `rating_review`
--
ALTER TABLE `rating_review`
  ADD CONSTRAINT `rating_review_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking_order` (`booking_id`),
  ADD CONSTRAINT `rating_review_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `rating_review_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user_cred` (`id`);

--
-- Constraints for table `room_facilities`
--
ALTER TABLE `room_facilities`
  ADD CONSTRAINT `facilities id` FOREIGN KEY (`facilities_id`) REFERENCES `facilities` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `room id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_features`
--
ALTER TABLE `room_features`
  ADD CONSTRAINT `features id` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `rm id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `room_images`
--
ALTER TABLE `room_images`
  ADD CONSTRAINT `room_images_ibfk_1` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
