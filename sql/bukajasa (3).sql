-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 09:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukajasa`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Accepted','Declined') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `job_id`, `user_id`, `application_date`, `status`) VALUES
(9, 3, 4, '2024-06-11 00:15:37', 'Accepted'),
(11, 3, 5, '2024-06-11 14:53:04', 'Declined'),
(12, 4, 5, '2024-06-12 18:04:35', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `deadline` date NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `company_id`, `title`, `description`, `requirements`, `salary`, `deadline`, `category`) VALUES
(3, 1, 'buat aplikasi', 'membuat aplikasi android dilaptop', 'otak,laptop,wifi', 99999999.99, '2024-06-29', 'Komputer/IT'),
(4, 1, 'Itung Uang', 'menghitung uang dalam jumlah besar', 'anggota tubuh', 99999999.99, '2024-06-14', 'Akuntansi/Keuangan'),
(5, 1, 'Ngajarin anak balita beckend programing', 'buat agar anak balita memahami beckend programing dalam 5 jam', 'mampu', 9999999.00, '2024-06-28', 'Pendidikan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Mahasiswa','Perusahaan','Admin') NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT 'default_profile_picture.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`, `name`, `profile_picture`) VALUES
(1, 'zidan', '$2y$10$i1umm5Y.o1xIWi2Sl41jvuEYXAMlBjFm3YqMDnuvejpmoPAF5B9KS', 'Perusahaan', 'zdn@gmail.com', 'zidan', 'IMG-20240514-WA0005.jpg'),
(4, 'divo', '$2y$10$Qg6aHFO8JVSDUr5uCxVsz.pEs0Cu7ZqgHR9A8vBZdLHRfMVoIaErm', 'Mahasiswa', 'demaheswara@linux.com', 'youra vince', 'IMG-20221025-WA0010.jpg'),
(5, 'sugeng', '$2y$10$bB0XLHQRcdzm3Ry33xl2heEsInBO6tcq.HOnER76h44Ar/R8lNEwS', 'Mahasiswa', 'sg@gmail.com', 'sugenk sunarta', 'rawr_pengurus-hmif-2024-35 (1).jpg'),
(6, 'dino', '$2y$10$j8/rqrSrlHnJ3jGChowEyOGdBLNMrKVZjrF74uCF2EKCW.Ayr/uMG', 'Admin', 'dn@gmail.com', 'Aldrin Aldino', 'default_profile_picture.png'),
(10, 'perusahaan 2', '$2y$10$pDZLq8r9Y58VBzFBoISeoOS8yf5iPAjhZbrj40a.DvPM3e5nPP5mG', 'Perusahaan', 'p2@gmail.com', 'perusahaan2', 'default_profile_picture.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`),
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
