-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2023 at 01:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_information`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_d`
--

CREATE TABLE `user_d` (
  `id` int(6) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `numb` int(11) NOT NULL,
  `cpass` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `departments` varchar(30) NOT NULL,
  `dob` date DEFAULT NULL,
  `filee` varchar(70) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_d`
--

INSERT INTO `user_d` (`id`, `email`, `fname`, `lname`, `pass`, `numb`, `cpass`, `city`, `gender`, `departments`, `dob`, `filee`, `created_at`) VALUES
(1, 'sati8097@gmail.com', 'Vaibhav', 'Mahobiya', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'female', 'hindi', '2023-11-16', '1698922154tt.jpeg', '2023-11-02 10:49:14'),
(2, 'neeraj@gmail.com', 'Neeraj', 'Surya', 'fa7fa1f85069389bbc94f1c69afe2461', 2147483647, 'Neeraj@12345', 'Bhopal', 'female', 'hindi,marathi', '2023-11-13', '1699019163pexels-pixabay-268533.jpg', '2023-11-03 13:46:03'),
(3, 'rajni@gmail.com', 'Rajni', 'Paswan', '077053ebfe4db0dcf16e84e32ae531a4', 2147483647, 'Rajni@12345', 'Delhi', 'female', 'hindi', '2023-11-15', '1699019245pexels-pixabay-268533.jpg', '2023-11-03 13:47:25'),
(4, 'kuldeep@gmail.com', 'Kuldeep', 'Gujraj', 'd81b1916b8d2638a794280b78510416b', 2147483647, 'Kuldeep@12345', 'Bhopal', 'male', 'hindi,english', '2023-11-07', '1699019335222.jpg', '2023-11-03 13:48:55'),
(5, 'bajrang@gmail.com', 'Bajrang', 'Bali', '341246f46795543d48e922e198ce6db2', 2147483647, 'Bajrang@12345', 'Delhi', 'male', 'marathi,english', '2023-11-06', '1699019415tt.jpeg', '2023-11-03 13:50:15'),
(6, 'monu@gmail.com', 'Monu', 'Thakur', '0d02b27110f5608f2d7f436d28535f63', 2147483647, 'Monu@12345', 'Bhopal', 'male', 'marathi,english', '2023-11-06', '1699019512download.jpg', '2023-11-03 13:51:52'),
(7, 'mkodnu@gmail.com', 'dsdonu', 'dsdakur', '0d02b27110f5608f2d7f436d28535f63', 2147483647, 'Monu@12345', 'Bhopal', 'male', 'marathi,english', '2023-11-06', '1699019668222.jpg', '2023-11-03 13:54:28'),
(8, 'mksdodnu@gmail.com', 'sdsdsdonu', 'akur', '0d02b27110f5608f2d7f436d28535f63', 2147483647, 'Monu@12345', 'Delhi', 'female', 'hindi,marathi,english', '2023-11-23', '1699019697download.jpg', '2023-11-03 13:54:57'),
(9, 'mkfgsdodnu@gmail.com', 'Msdsdsasdonu', 'Thsdsdasakur', '0d02b27110f5608f2d7f436d28535f63', 2147483647, 'Monu@12345', 'Goa', 'others', 'hindi,english', '2023-11-06', '1699019721tt.jpeg', '2023-11-03 13:55:21'),
(10, 'Jaydsa@gmail.com', 'Jay', 'Sharma', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Goa', 'male', 'marathi,english', '2023-11-06', '1699075446Screenshot (8).png', '2023-11-04 05:24:06'),
(11, 'Mayadsd@gmail.com', 'Maya', 'Dubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Goa', 'female', 'hindi,english', '2023-11-06', '1699075484Screenshot (11).png', '2023-11-04 05:24:44'),
(12, 'Msaayadsd@gmail.com', 'Masaya', 'ADubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Bhopal', 'male', 'hindi,marathi', '2023-11-08', '1699075529Screenshot (11).png', '2023-11-04 05:25:29'),
(13, 'dfsdfMsaayadsd@gmail.com', 'RdfMasaya', 'TADubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Bhopal', 'female', 'hindi', '2023-11-08', '1699075554Screenshot (2).png', '2023-11-04 05:25:54'),
(14, 'dfsdfMdsd@gmail.com', 'RdfMasaya', 'TADubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Bhopal', 'female', 'hindi', '2023-11-08', '1699075607Screenshot (2).png', '2023-11-04 05:26:47'),
(15, 'dasdfadsd@gmail.com', 'RdasfMasaya', 'TAasDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi,marathi', '2023-11-08', '1699076361Screenshot (1).png', '2023-11-04 05:39:21'),
(17, 'asdsd23@gmail.com', 'RdassdasfMasaya', 'TAwassDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi,marathi', '2023-11-08', '1699076438tt.jpeg', '2023-11-04 05:40:38'),
(18, 'saasdsadsd23@gmail.com', 'RdassdasfMsasaya', 'TAwassDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Bhopal', 'female', 'hindi,marathi', '2023-11-08', '1699076456tt.jpeg', '2023-11-04 05:40:56'),
(19, 'asdaayadsd23@gmail.com', 'RdasdasfMasaya', 'TAwasDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'female', 'hindi', '2023-11-08', '1699076406download.jpg', '2023-11-04 05:40:06'),
(20, 'ssad23@gmail.com', 'RdsassdasfMsasaya', 'DTAwassDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-14', '1699076481tt.jpeg', '2023-11-04 05:41:21'),
(21, 'sdsdasdaayadsd23@gmail.com', 'Cdfsaya', 'DTAwsaassDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi,english', '2023-11-11', '1699076515download.jpg', '2023-11-04 05:41:55'),
(22, 'asdaasyadsd23@gmail.com', 'Tsasaya', 'DTAxwsa', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-11', '1699076571222.jpg', '2023-11-04 05:42:51'),
(23, 'asdad23@gmail.com', 'Vzasf', 'TAxwss', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-11', '1699076589download (1).jpg', '2023-11-04 05:43:09'),
(24, 'asdsdsdd23@gmail.com', 'AsfMssssaya', 'DTAsxwssaassDubey', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-11', '1699076698download.jpg', '2023-11-04 05:44:58'),
(25, 'sadd23@gmail.com', 'Mssssaya', 'DsA', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'female', 'hindi,english', '2023-11-11', '1699076715download.jpg', '2023-11-04 05:45:15'),
(185, 'saaasti8097@gmail.com', 'Kdfsd', 'Kasdasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-07', '1699598537download (1).jpg', '2023-11-10 06:42:17'),
(186, 'saaassti8097@gmail.com', 'Kdasfsd', 'Kaassdasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-07', '1699598552download (1).jpg', '2023-11-10 06:42:32'),
(187, 'saaaassti8097@gmail.com', 'Kdasfsd', 'Kaasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-11-07', '1699598580download (1).jpg', '2023-11-10 06:43:00'),
(188, 'saassti8097@gmail.com', 'Ksfsd', 'Kaasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-06-16', '1699598606download (1).jpg', '2023-11-10 06:43:26'),
(189, 'saaasstai8097@gmail.com', 'Ksasfsd', 'Kaaasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-02-16', '1699598638download.jpg', '2023-11-10 06:43:58'),
(190, 'sstasi8097@gmail.com', 'Kxsasfsd', 'Kaaasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-04-15', '1699598791download.jpg', '2023-11-10 06:46:31'),
(191, 'sastasi8097@gmail.com', 'Vxsasfsd', 'Vtaaasd', 'adf0204c44224b68c6ef57160c17d6a9', 2147483647, 'Vm@12345', 'Indore', 'male', 'hindi', '2023-02-15', '1699599285download.jpg', '2023-11-10 06:54:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_d`
--
ALTER TABLE `user_d`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_d`
--
ALTER TABLE `user_d`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
