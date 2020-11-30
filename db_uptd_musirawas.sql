-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2019 at 11:32 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 5.6.39

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_uptd_musirawas`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp  NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `role_id`, `name`, `email`, `contact`, `created_at`, `updated_at`) VALUES
(1, 'azhry', 'e10adc3949ba59abbe56e057f20f883e', 2, 'Azhary Arliansyah', '', 'test', '2019-09-16 15:02:39', '2019-09-16 16:07:39'),
(5, 'azhary', '985fabf8f96dc1c4c306341031569937', 1, 'Azhary Arliansyah', 'arliansyah_azhary@yahoo.com', '11223344', '2019-09-17 04:16:46', '2019-09-17 04:16:46');

-- --------------------------------------------------------

--
-- Table structure for table `financial_histories`
--

CREATE TABLE `financial_histories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `history_date` date NOT NULL,
  `realization` bigint(20) NOT NULL,
  `target` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `financial_histories`
--

INSERT INTO `financial_histories` (`id`, `item_id`, `history_date`, `realization`, `target`, `created_at`, `updated_at`) VALUES
(6, 13, '2019-09-04', 100000, 100, '2019-09-17 20:10:47', '2019-09-17 20:10:47'),
(7, 14, '2019-09-04', 260000000, 100, '2019-09-17 20:10:47', '2019-09-17 20:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `physical_histories`
--

CREATE TABLE `physical_histories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `history_date` date NOT NULL,
  `planning` float NOT NULL,
  `realization` float NOT NULL,
  `target` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `physical_histories`
--

INSERT INTO `physical_histories` (`id`, `item_id`, `history_date`, `planning`, `realization`, `target`, `created_at`, `updated_at`) VALUES
(10, 14, '2019-09-04', 100, 32, 100, '2019-09-17 20:10:47', '2019-09-17 20:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `provider_id` int(11) DEFAULT NULL,
  `project_name` text NOT NULL,
  `contract_number` varchar(100) NOT NULL,
  `contract_date` date NOT NULL,
  `contract_value` bigint(20) NOT NULL,
  `supervisor` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `type_id`, `provider_id`, `project_name`, `contract_number`, `contract_date`, `contract_value`, `supervisor`, `created_at`, `updated_at`) VALUES
(6, 4, 1, 'Peningkatan Jalan Simpang Periuk - Tugu Mulyo - Terawas', '622/732/PNK BID-JLN/DIS.PUBMTR/IV/2019', '2019-04-12', 20000000, '', '2019-09-17 20:08:35', '2019-09-17 20:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `project_item`
--

CREATE TABLE `project_item` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `budget_ceiling` bigint(20) NOT NULL,
  `item_type` enum('Physical','Financial') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_item`
--

INSERT INTO `project_item` (`id`, `project_id`, `name`, `budget_ceiling`, `item_type`, `created_at`, `updated_at`) VALUES
(13, 6, 'Administrasi Keuangan', 130000, 'Financial', '2019-09-17 20:08:35', '2019-09-17 20:08:35'),
(14, 6, 'Peningkatan Jalan Simpang Periuk - Tugu Mulyo - Terawas', 28000000, 'Physical', '2019-09-17 20:08:35', '2019-09-17 20:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `project_type`
--

CREATE TABLE `project_type` (
  `id` int(11) NOT NULL,
  `type` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_type`
--

INSERT INTO `project_type` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Pembangunan Jembatan', 'Lorem', '2019-09-16 20:54:47', '2019-09-16 20:54:47'),
(3, 'Pembangunan Bandara', 'Bandara', '2019-09-16 20:56:50', '2019-09-16 20:56:50'),
(4, 'Pembangunan dan Peningkatan Jalan', '', '2019-09-17 16:44:27', '2019-09-17 16:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '', '2019-09-16 14:34:24', '2019-09-16 14:34:24'),
(2, 'Service Provider', '', '2019-09-16 14:34:24', '2019-09-16 14:34:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `financial_histories`
--
ALTER TABLE `financial_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `physical_histories`
--
ALTER TABLE `physical_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `provider_id` (`provider_id`);

--
-- Indexes for table `project_item`
--
ALTER TABLE `project_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `project_type`
--
ALTER TABLE `project_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `financial_histories`
--
ALTER TABLE `financial_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `physical_histories`
--
ALTER TABLE `physical_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `project_item`
--
ALTER TABLE `project_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `project_type`
--
ALTER TABLE `project_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `financial_histories`
--
ALTER TABLE `financial_histories`
  ADD CONSTRAINT `financial_histories_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `project_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `physical_histories`
--
ALTER TABLE `physical_histories`
  ADD CONSTRAINT `physical_histories_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `project_item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `project_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`provider_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `project_item`
--
ALTER TABLE `project_item`
  ADD CONSTRAINT `project_item_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
