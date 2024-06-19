-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2019 at 09:33 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `einvoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `detail` text,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`, `detail`, `status`) VALUES
(2, 'เครื่องเขียนสำนักงาน', '2019-04-21 05:58:42', '2019-04-21 05:58:42', 'มีท่อนต่างๆ ของ Lorem Ipsum ให้หยิบมาใช้งานได้มากมาย แต่ส่วนใหญ่แล้วจะถูกนำไปปรับให้เป็นรูปแบบอื่นๆ', 1),
(3, 'เครื่องใช้ไฟฟ้า', '2019-04-21 06:00:54', '2019-04-21 06:00:54', 'ด้วยคำที่มั่วขึ้นมาซึ่งถึงอย่างไรก็ไม่มีทางเป็นเรื่องจริงได้เลยแม้แต่น้อย ถ้าคุณกำลังคิดจะใช้ Lorem Ipsum สักท่อนหนึ่ง', 1),
(4, 'อุปกรณ์คอมพิวเตอร์', '2019-04-21 06:01:24', '2019-04-21 06:47:53', 'ตรงกันข้ามกับความเชื่อที่นิยมกัน Lorem Ipsum', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) UNSIGNED NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `tax_no` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `contact_name` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `address` text,
  `credit_day` int(11) NOT NULL COMMENT 'เครดิต(วัน)',
  `type` int(11) NOT NULL COMMENT '1=ลูกค้า, 2=ผู้จัดจำหน่าย',
  `branch_no` varchar(50) DEFAULT NULL COMMENT 'รหัสสาขา',
  `branch_name` varchar(100) DEFAULT NULL COMMENT 'ชื่อรหัส',
  `note` text,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `code`, `tax_no`, `profile_picture`, `name`, `contact_name`, `email`, `tel`, `fax`, `website`, `created_at`, `updated_at`, `address`, `credit_day`, `type`, `branch_no`, `branch_name`, `note`, `status`) VALUES
(1, 'C001', '12346790122', NULL, 'มายา จำกัด', 'นครไทย ใจสง', 'nakorn@hotmail.com', '0811448167', '', '', '2019-04-21 13:27:37', '2019-04-23 21:27:38', '123/56789 ต.หนองงูเห่า อ.ลาดลุมแก้ว จ.สระบุรี 12900', 30, 1, '0000', 'สำนักงานใหญ่', '', 1),
(3, 'C002', '999541123231', NULL, 'มิสเตอร์ทีม เอนเตอร์เทรนเม้นท์ จำกัด (มหาชน)', 'วิชัย', 'wichai@hotmail.com', '08114456998', '02112355987', 'www.wichai.com', '2019-04-21 13:45:09', '2019-04-21 13:45:34', '999/874 ต.หนองหอย\r\nอ.ห้างงู จ.หนึ่งสี่ห้า 12398', 60, 1, '0000', 'สำนักงานใหญ่', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) UNSIGNED NOT NULL,
  `doc_no` varchar(100) NOT NULL,
  `ref_doc` varchar(100) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `payment_type` int(11) NOT NULL COMMENT '1=เงินสด, 2=เช็ค',
  `credit_day` int(11) NOT NULL COMMENT 'เครดิต(วัน)',
  `contact_name` text,
  `contact_address` text,
  `contact_email` varchar(100) DEFAULT NULL,
  `contact_tel` varchar(50) DEFAULT NULL,
  `contact_fax` varchar(50) DEFAULT NULL,
  `contact_tax_no` varchar(50) DEFAULT NULL,
  `contact_branch_name` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `remark` text,
  `vat_type` int(11) NOT NULL COMMENT '1=exclude, 2=include, 3=novat',
  `vat` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `pay_total` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=ใบแจ้งหนี้(invoice)',
  `status` int(11) NOT NULL COMMENT '1=รอดำเนินการ, 2=รอเก็บเงิน, 3=เก็บเงินแล้ว, 4=void',
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `doc_no`, `ref_doc`, `doc_date`, `due_date`, `payment_type`, `credit_day`, `contact_name`, `contact_address`, `contact_email`, `contact_tel`, `contact_fax`, `contact_tax_no`, `contact_branch_name`, `created_at`, `updated_at`, `created_by`, `updated_by`, `remark`, `vat_type`, `vat`, `discount`, `total`, `grand_total`, `pay_total`, `balance`, `type`, `status`, `contact_id`) VALUES
(11, 'INV19040024', 'QO190040002', '2019-04-23', '2019-04-30', 1, 60, 'วิชัย', '999/874 ต.หนองหอย\r\nอ.ห้างงู จ.หนึ่งสี่ห้า 12398', 'wichai@hotmail.com', '08114456998', '02112355987', '999541123231', 'สำนักงานใหญ่', '2019-04-23 16:44:30', '2019-04-23 20:34:13', 1, 1, NULL, 2, '1318.55', '0.00', '20155.00', '20155.00', '100.00', '20055.00', 1, 3, 3),
(13, 'INV19040026', NULL, '2019-04-23', '2019-05-01', 1, 30, 'นครไทย ใจสง', '123/56789 ต.หนองงูเห่า อ.ลาดลุมแก้ว จ.สระบุรี 12900', 'nakron@hotmail.com', '0811433241', '', '12346790122', 'สำนักงานใหญ่', '2019-04-23 21:12:04', '2019-04-23 21:13:28', 1, 1, NULL, 1, '1410.85', '0.00', '20155.00', '21565.85', '0.00', '21565.85', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `document_details`
--

CREATE TABLE `document_details` (
  `id` int(11) NOT NULL,
  `line_no` int(11) NOT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `document_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `document_details`
--

INSERT INTO `document_details` (`id`, `line_no`, `product_name`, `quantity`, `price`, `cost_price`, `total`, `unit`, `product_id`, `document_id`) VALUES
(1, 1, 'ดินสอแท่ง', '10.00', '5.00', '4.00', '50.00', 'แท่ง', 1, 11),
(1, 1, 'ดินสอแท่ง', '10.00', '5.00', '4.00', '50.00', 'แท่ง', 1, 13),
(2, 2, 'ปากาเมจิก', '5.00', '10.00', '9.00', '50.00', 'แท่ง', 2, 11),
(2, 2, 'ปากาเมจิก', '5.00', '10.00', '9.00', '50.00', 'แท่ง', 2, 13),
(3, 3, 'กระทะไฟฟ้า', '7.00', '2500.00', '1999.00', '17500.00', 'ชิ้น', 4, 11),
(3, 3, 'กระทะไฟฟ้า', '7.00', '2500.00', '1999.00', '17500.00', 'ชิ้น', 4, 13),
(4, 4, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 11),
(4, 4, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 13),
(5, 5, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 11),
(5, 5, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 13),
(6, 6, 'กระทะไฟฟ้า', '1.00', '2500.00', '1999.00', '2500.00', 'ชิ้น', 4, 11),
(6, 6, 'กระทะไฟฟ้า', '1.00', '2500.00', '1999.00', '2500.00', 'ชิ้น', 4, 13),
(7, 7, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 11),
(7, 7, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 13),
(8, 8, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 11),
(8, 8, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 13),
(9, 9, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 11),
(9, 9, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 13),
(10, 10, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 11),
(10, 10, 'ปากาเมจิก', '1.00', '10.00', '9.00', '10.00', 'แท่ง', 2, 13),
(11, 11, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 11),
(11, 11, 'ดินสอแท่ง', '1.00', '5.00', '4.00', '5.00', 'แท่ง', 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(20190422231900);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `sku` varchar(100) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(100) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `unit` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `detail` text,
  `buy_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1=สินค้านับสต๊อก, 2=สินค้าไม่นับสต๊อก, 3=สินค้าบริการ',
  `quantity` decimal(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active',
  `categorie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `barcode`, `profile_picture`, `name`, `unit`, `created_at`, `updated_at`, `detail`, `buy_price`, `sell_price`, `type`, `quantity`, `status`, `categorie_id`) VALUES
(1, '11112346', '998721316479', 'pro_5cbbecd828a7e.JPG', 'ดินสอแท่ง', 'แท่ง', '2019-04-21 06:09:02', '2019-04-21 06:12:43', 'จากวิทยาลัยแฮมพ์เด็น-ซิดนีย์ ในรัฐเวอร์จิเนียร์ นำคำภาษาละตินคำว่า consectetur ซึ่งหาคำแปลไม่ได้จาก Lorem Ipsum ตอนหนึ่งมาค้นเพิ่มเติม', '4.00', '5.00', 1, '74.00', 1, 2),
(2, 'S123456', '456464664', 'pro_5cbbed4c75984.JPG', 'ปากาเมจิก', 'แท่ง', '2019-04-21 06:11:43', '2019-04-21 06:11:43', '', '9.00', '10.00', 1, '82.00', 1, 2),
(4, 'D030391', '3409427491799', 'pro_5cbc1cb62c083.JPG', 'กระทะไฟฟ้า', 'ชิ้น', '2019-04-21 09:33:46', '2019-04-21 10:38:50', '', '1999.00', '2500.00', 2, '100.00', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `runs`
--

CREATE TABLE `runs` (
  `id` varchar(20) NOT NULL,
  `val` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `runs`
--

INSERT INTO `runs` (`id`, `val`) VALUES
('INV1904', 27);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL COMMENT 'ชื่อ',
  `value` longtext NOT NULL COMMENT 'ค่าข้อมูล'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'company_name', 'Bahtsoft จำกัด'),
(2, 'address', '123/456 ต.ฟ้าคราม อ.เชียง จ.อภินิหารใจ'),
(3, 'tax_no', '123456790'),
(4, 'branch', 'สำนักงานใหญ่'),
(5, 'tel', '0811448167'),
(6, 'fax', '021123364'),
(7, 'website', 'https://www.bahtsoft.com'),
(8, 'logo', ''),
(9, 'vat', '7');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) DEFAULT NULL,
  `token_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL COMMENT '0=inactive, 1=active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `token`, `token_date`, `status`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'Kanoksak Norjai', 'kanoksak@hotmail.com', NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_details`
--
ALTER TABLE `document_details`
  ADD PRIMARY KEY (`id`,`document_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `runs`
--
ALTER TABLE `runs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
