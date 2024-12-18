-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 08:28 AM
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
-- Database: `manage_apartment`
--

-- --------------------------------------------------------

--
-- Table structure for table `check_bill`
--

CREATE TABLE `check_bill` (
  `bill_id` int(11) NOT NULL,
  `room_number` int(3) DEFAULT NULL,
  `billing_cycle` varchar(255) DEFAULT NULL,
  `room_price` decimal(10,2) DEFAULT NULL,
  `water_price` decimal(10,2) DEFAULT NULL,
  `electricity_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('ชำระแล้ว','ยังไม่ชำระ') NOT NULL DEFAULT 'ยังไม่ชำระ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_bill`
--

INSERT INTO `check_bill` (`bill_id`, `room_number`, `billing_cycle`, `room_price`, `water_price`, `electricity_price`, `total_price`, `date`, `payment_status`) VALUES
(110, 101, 'มกราคม', 3000.00, 240.00, 150.00, 3390.00, '2024-11-03 05:22:41', 'ชำระแล้ว'),
(111, 102, 'กุมภาพันธ์', 3000.00, 40.00, 300.00, 3340.00, '2024-11-03 05:27:11', 'ชำระแล้ว');

-- --------------------------------------------------------

--
-- Table structure for table `rentor`
--

CREATE TABLE `rentor` (
  `room_number` int(3) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `iden_id` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentor`
--

INSERT INTO `rentor` (`room_number`, `name`, `iden_id`, `phone`, `address`, `email`) VALUES
(101, 'นางสาวณัฐวรา  นาคงาม', '1329901182639', '0634563458', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@gmail.com'),
(102, 'นายวานิด ยาม่า', '1329901188265', '0982134566', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '1329901182639', '0634563458', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@gmail.com'),
(102, 'นางวานิด ยาม่า', '1329901188265', '0982134566', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '1329901182639', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@gmail.com'),
(102, 'นางวานิด ยาม่า', '1329901188265', '0222222222', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '1329901182639', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '1329901182639', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(102, 'นางวานิด ยาม่า', '1329901188265', '0222222222', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(102, 'นางวานิด ยาม่า', '132990118826215', '0222222222', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(102, 'นางวานิด ยาม่า', '132990118826215', '0222222222', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(103, 'ธนภัทร สุขกรี', '132990118263912', '0994185781', 'ฟหกฟหกหฟกหฟกหฟกหฟกหฟฟหกหฟกฟหก', '65200156@kmitl.ac.th'),
(103, 'ธนภัทร สุขกรี', '132990118263912', '0994185781', 'ฟหกฟหกหฟกหฟกหฟกหฟกหฟฟหกหฟกฟหก', '65200156@kmitl.ac.th'),
(104, 'กินข้าว', '123456789456', '0222222222', 'ฟหกฟหกหฟกหฟกหฟกหฟกหฟฟหกหฟกฟหกasd', '65200156@kmitl.ac.ths'),
(101, 'นางสาวณัฐวรา  นาคงาม', '132990118263912', '0634563450', 'บ้านนา 56 หมู่ 5 ต.หนองเต็ง อ.กระสัง จังหวัดบุรีรัมย์', 'natwara@kkgg.com'),
(105, 'gudie', '123456789456', '0994185781', 'asdasdsadasdsad', 'asdasd@asdasd.casd'),
(102, 'นางวานิด ยาม่า', '132990118826215', '0222222222', '45 ต.สนธนา อ.เมือง จ.เลย', 'vanit@gmail.com'),
(205, 'Time', '132990118826357', '0222222222', 'asdasdsadasdsadascascas', 'Time@kmitl.com'),
(202, 'asdwaasdwaasd', '132990118826215', '0994185781', 'ฟหกฟหกหฟกหฟกหฟกหฟกหฟฟหกหฟกฟหกasd', 'asdasd@asdasd.asdasasd'),
(101, 'Thanapat Sukkree', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'guide@gmail.com'),
(101, 'Thanapat Sukkree', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'guide@gmail.com'),
(101, 'ฟหกหฟก', '123123122124', 'ฟหกฟหกห', 'ฟหกหฟก', 'pop@gmail.com'),
(101, 'Thanapat Sukkree', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(103, 'asdwaasdwa', '132990118826357', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(102, 'asdwas2131', '123456789456', '0994185784', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200156@kmitl.ac.th123'),
(101, 'Thanapat Sukkree', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(102, 'Thana', '132990118826215', '0994185782', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200156@kmitl.ac.th'),
(102, 'asdwaasdwa', '123123122124', '0994185788', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(103, 'นางสาวณัฐวรา  นาคงาม', '132990118826357', '0222222222', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200122@kmitl.ac.th'),
(104, 'นายธนภัทร วงศ์เศรษฐโชติ', '132990118263912', '0994125782', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200154@kmitl.ac.th'),
(203, '    อ.จุ๋ม', '1234567894565', '0222222222', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '652156@kmitl.ac.th'),
(101, '  Thanapat Sukkree  ', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(101, '    Thanapat Sukkree    ', '132990118826215', '0994185755', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(101, 'อ.จุ๋ม', '132990118826215', '0994185755', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', 'pop@gmail.com'),
(101, '  อ.จุ๋ม  ', '132990118826215', '0994185755', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี', 'pop@gmail.com'),
(101, '    อ.จุ๋ม    ', '132990118826215', '0994185755', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี', 'pop@gmail.com'),
(102, '    อ.จุ๋ม', '132990118826215', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200156@kmitl.ac.th'),
(102, '    อ.จุ๋ม', '123456789456', '0994185781', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '65200156@kmitl.ac.th');

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `iden_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `name`, `email`, `room_number`, `start_date`, `end_date`, `address`, `phone`, `iden_id`) VALUES
(42, '    อ.จุ๋ม    ', 'pop@gmail.com', '101', '2575-04-12', '4575-07-05', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี', '0994185755', '132990118826215'),
(51, '    อ.จุ๋ม', '65200156@kmitl.ac.th', '102', '4545-05-04', '4546-05-04', 'ที่อยู่. 41. 12110. ธัญบุรี. 137 หมู่ 2 ถ.รังสิต-นครนายก อ.ธัญบุรี จ.ปทุมธานี ... 103/1 หมู่ 1 ต.ลุ่มสุ่ม อ.ไทรโยค จ.กาญจนบุรี 71150. 717. 71160. ', '0994185781', '123456789456');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'Cororo', 'rete@gmail.com', '$2y$10$28XmfJ4NpZV5hxMkBMGH9Oul77SexvALZZEH4GUnPNbYeAqYmk/aO'),
(2, 'Nana', 'nana@gmail.com', '$2y$10$94fZAX8gPAXgJ/vXK1tZtuM9T36oJEboP7dwaJ9CuSJekcbGhHEbC'),
(3, 'byname', 'myname@gmail.com', '$2y$10$3mO96y6JfZ4VOC8yJl6Q1eNSY1ekY.jSjbXAWaNungXnUYPwtEWhq'),
(4, 'pop987000za', 'pop@gmail.com', '$2y$10$GbirUuq.LrMBGFGsjg7fhO6rohVHpl2jNgKIJubLmMhYR/cxc73U6'),
(5, 'pnrd10asd', '65200156@kmitl.ac.thasd', '$2y$10$FZCWB0EEQheL3K2rXNRRG.dp1YvY1rSlqOCuoNxYZkmt57xhEJiL.'),
(6, 'pnrd11asdasdas', '65200156@kmitl.ac.thasdd', '$2y$10$.Q.1CfRuInEDqaDf2tSA2OhSc8.IW3KR.V97ZqazFl2vFSudhwBPG'),
(7, 'guide', 'popcat@gmail.com', '$2y$10$RVYFVTyqs79.e/RCdhGOcOWVowVbpJNXYJ12iCB002XLYTgCl6uHO'),
(8, 'time', 'Time@kmitl.com', '$2y$10$QMWccdAq4vnRo9OzuXzs0.CU7hkRk8i3Sl/k7Cx9HEbM85aEuAW2y'),
(9, 'kai', '65200156@kmitl.ac.thz', '$2y$10$4USyAA5t/WDkXutkwFH/sO7lohGKGwhG8xxGFQE4eLNvt0vZ4Mu1.'),
(10, 'kaisud032zaza', 'popza@gmail.com', '$2y$10$gQj2FHkj9oVpDnNVDzp8OuM6XWzb4GWTK3koHqaHO3j/8NvS0RnFa');

-- --------------------------------------------------------

--
-- Table structure for table `utilities_rates`
--

CREATE TABLE `utilities_rates` (
  `id` int(11) NOT NULL,
  `water_rate` decimal(10,2) NOT NULL,
  `electricity_rate` decimal(10,2) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilities_rates`
--

INSERT INTO `utilities_rates` (`id`, `water_rate`, `electricity_rate`, `updated_at`) VALUES
(1, 20.00, 7.00, '2024-11-03 05:29:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `check_bill`
--
ALTER TABLE `check_bill`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilities_rates`
--
ALTER TABLE `utilities_rates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `check_bill`
--
ALTER TABLE `check_bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `utilities_rates`
--
ALTER TABLE `utilities_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
