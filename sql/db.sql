-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 02, 2025 at 02:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `avo_laptops_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE `laptops` (
  `lap_id` int(11) NOT NULL,
  `lap_model` int(11) DEFAULT NULL,
  `lap_locker` int(11) DEFAULT NULL,
  `lap_name` varchar(40) DEFAULT NULL,
  `lap_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`lap_id`, `lap_model`, `lap_locker`, `lap_name`, `lap_status`) VALUES
(1, 1, 1, 'PC-01', 1),
(2, 1, 1, 'PC-02', 0),
(3, 1, 1, 'PC-03', 0),
(4, 1, 1, 'PC-04', 2),
(5, 1, 1, 'PC-05', 2),
(6, 1, 1, 'PC-06', 1),
(7, 1, 1, 'PC-07', 0),
(8, 1, 1, 'PC-08', 0),
(9, 1, 1, 'PC-09', 1),
(10, 1, 1, 'PC-10', 1),
(11, 1, 1, 'PC-11', 1),
(12, 1, 1, 'PC-12', -1),
(13, 1, 1, 'PC-13', 1),
(14, 1, 1, 'PC-14', 1),
(15, 1, 1, 'PC-15', 0),
(16, 1, 1, 'PC-16', 1),
(17, 1, 1, 'PC-17', 1),
(18, 1, 1, 'PC-18', 1),
(19, 1, 1, 'PC-19', -1),
(20, 1, 1, 'PC-20', 1),
(21, 1, 1, 'PC-21', 1),
(22, 1, 1, 'PC-22', 0),
(23, 1, 1, 'PC-23', 1),
(24, 1, 1, 'PC-24', 1),
(25, 1, 1, 'PC-25', 1),
(26, 1, 1, 'PC-26', 1),
(27, 1, 1, 'PC-27', -1),
(28, 1, 1, 'PC-28', 1),
(29, 1, 1, 'PC-29', 1),
(30, 1, 1, 'PC-30', 0),
(31, 2, 2, 'PC-1', 1),
(32, 2, 2, 'PC-2', -1),
(33, 2, 2, 'PC-3', 1),
(34, 2, 2, 'PC-4', 0),
(35, 2, 2, 'PC-5', 1);

--
-- Triggers `laptops`
--
DELIMITER $$
CREATE TRIGGER `log_laptops_maintenance` AFTER UPDATE ON `laptops` FOR EACH ROW BEGIN
	INSERT INTO log_maintenance (log_lap_id, log_date, log_time, log_status)
    	VALUES (NEW.lap_id, CURRENT_DATE(), CURRENT_TIME(), NEW.lap_status);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `laptops_reservations`
--

CREATE TABLE `laptops_reservations` (
  `lap_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laptops_reservations`
--

INSERT INTO `laptops_reservations` (`lap_id`, `res_id`) VALUES
(1, 7),
(1, 8),
(1, 10),
(1, 12),
(1, 13),
(1, 14),
(2, 2),
(2, 7),
(2, 8),
(2, 10),
(2, 12),
(2, 13),
(2, 14),
(3, 3),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(4, 3),
(4, 4),
(4, 11),
(4, 12),
(4, 14),
(5, 5),
(5, 12),
(5, 14),
(6, 12),
(6, 14),
(7, 12),
(7, 14),
(8, 2),
(8, 12),
(8, 14),
(9, 3),
(9, 12),
(9, 14),
(10, 4),
(10, 12),
(10, 14),
(11, 5),
(11, 12),
(11, 14),
(13, 12),
(13, 14),
(14, 2),
(14, 12),
(14, 14),
(15, 3),
(15, 12),
(15, 14),
(16, 4),
(16, 12),
(16, 14),
(17, 5),
(17, 12),
(17, 14),
(18, 12),
(18, 14),
(20, 2),
(20, 12),
(20, 14),
(21, 12),
(21, 14),
(22, 12),
(22, 14),
(23, 12),
(23, 14),
(24, 12),
(24, 14),
(25, 9),
(25, 12),
(25, 14),
(26, 9),
(26, 12),
(26, 14),
(28, 12),
(28, 14),
(29, 12),
(29, 14),
(30, 12),
(30, 14);

-- --------------------------------------------------------

--
-- Table structure for table `lockers`
--

CREATE TABLE `lockers` (
  `lock_id` int(11) NOT NULL,
  `lock_floor` int(11) DEFAULT NULL,
  `lock_class` varchar(30) DEFAULT NULL,
  `lock_capacity` int(11) DEFAULT NULL,
  `lock_incharge` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lockers`
--

INSERT INTO `lockers` (`lock_id`, `lock_floor`, `lock_class`, `lock_capacity`, `lock_incharge`) VALUES
(1, 1, 'Aula Informatica', 30, 'Prof. Rossi'),
(2, 2, 'Biblioteca', 30, 'Prof.ssa Verdi'),
(3, 3, 'Laboratorio', 30, 'Prof. Bianchi');

-- --------------------------------------------------------

--
-- Table structure for table `log_maintenance`
--

CREATE TABLE `log_maintenance` (
  `log_id` int(11) NOT NULL,
  `log_lap_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `log_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `log_maintenance`
--

INSERT INTO `log_maintenance` (`log_id`, `log_lap_id`, `log_date`, `log_time`, `log_status`) VALUES
(1, 7, '2025-04-23', '11:36:44', 0),
(2, 2, '2025-04-24', '19:04:45', 0),
(3, 5, '2025-05-26', '20:09:17', 2),
(4, 4, '2025-05-26', '20:11:33', 2);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `mod_id` int(11) NOT NULL,
  `mod_name` varchar(50) DEFAULT NULL,
  `mod_RAM` int(11) DEFAULT NULL,
  `mod_memory` int(11) DEFAULT NULL,
  `mod_CPU` varchar(30) DEFAULT NULL,
  `mod_display` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`mod_id`, `mod_name`, `mod_RAM`, `mod_memory`, `mod_CPU`, `mod_display`) VALUES
(1, 'Dell Latitude 5400', 8, 256, 'Intel Core i5-8265U', 14.00),
(2, 'HP EliteBook 850', 16, 512, 'Intel Core i5-5300U', 15.60),
(3, 'Lenovo ThinkPad X1', 16, 1024, 'Intel Core i5-4200U', 14.00);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `res_id` int(11) NOT NULL,
  `res_start_time` time DEFAULT NULL,
  `res_end_time` time DEFAULT NULL,
  `res_day` date DEFAULT NULL,
  `res_flag` tinyint(1) DEFAULT NULL,
  `res_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`res_id`, `res_start_time`, `res_end_time`, `res_day`, `res_flag`, `res_user`) VALUES
(2, '10:00:00', '12:00:00', '2025-04-20', 1, 38),
(3, '13:00:00', '15:00:00', '2025-04-20', 1, 39),
(4, '11:00:00', '13:00:00', '2025-01-15', 0, 39),
(5, '11:00:00', '13:00:00', '2025-02-15', 0, 37),
(7, '14:00:00', '14:30:00', '2025-05-07', 1, 37),
(8, '15:00:00', '15:30:00', '2025-05-07', 1, 37),
(9, '16:00:00', '16:30:00', '2025-05-07', 1, 37),
(10, '13:30:00', '14:00:00', '2025-05-14', 1, 37),
(11, '13:30:00', '14:00:00', '2025-05-14', 1, 37),
(12, '08:00:00', '08:30:00', '2025-05-27', 1, 37),
(13, '10:00:00', '13:00:00', '2025-05-29', 0, 37),
(14, '10:00:00', '10:30:00', '2025-05-27', 1, 37);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(50) NOT NULL,
  `u_surname` varchar(50) NOT NULL,
  `u_date_birth` date NOT NULL,
  `u_email` varchar(64) NOT NULL,
  `u_password` varchar(61) NOT NULL,
  `u_role` int(11) NOT NULL,
  `u_authorized` tinyint(1) DEFAULT NULL,
  `u_token` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_surname`, `u_date_birth`, `u_email`, `u_password`, `u_role`, `u_authorized`, `u_token`) VALUES
(37, 'Mario', 'Rossi', '2025-06-10', 'mario.rossi@itisavogadro.it', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 1, 1, '86a94807a3dbbd516ca5b5df54ef4f4ae5d833535639b50b188bc126d5c335b6'),
(38, 'Anna', 'Verdi', '0000-00-00', 'anna.verdi@itisavogadro.it', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 1, 1, NULL),
(39, 'Luigi', 'Bianchi', '0000-00-00', 'luigi.bianchi@itisavogadro.it', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 1, 1, NULL),
(41, 'Nome', 'Cognome', '0000-00-00', 'ncognome@itisavogadro.it', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 10, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`lap_id`),
  ADD KEY `lap_model` (`lap_model`),
  ADD KEY `lap_locker` (`lap_locker`);

--
-- Indexes for table `laptops_reservations`
--
ALTER TABLE `laptops_reservations`
  ADD PRIMARY KEY (`lap_id`,`res_id`),
  ADD KEY `res_id` (`res_id`);

--
-- Indexes for table `lockers`
--
ALTER TABLE `lockers`
  ADD PRIMARY KEY (`lock_id`);

--
-- Indexes for table `log_maintenance`
--
ALTER TABLE `log_maintenance`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_lap_id` (`log_lap_id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `res_user` (`res_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `lap_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `lockers`
--
ALTER TABLE `lockers`
  MODIFY `lock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `log_maintenance`
--
ALTER TABLE `log_maintenance`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laptops`
--
ALTER TABLE `laptops`
  ADD CONSTRAINT `laptops_ibfk_1` FOREIGN KEY (`lap_model`) REFERENCES `models` (`mod_id`),
  ADD CONSTRAINT `laptops_ibfk_2` FOREIGN KEY (`lap_locker`) REFERENCES `lockers` (`lock_id`);

--
-- Constraints for table `laptops_reservations`
--
ALTER TABLE `laptops_reservations`
  ADD CONSTRAINT `laptops_reservations_ibfk_1` FOREIGN KEY (`lap_id`) REFERENCES `laptops` (`lap_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laptops_reservations_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `reservations` (`res_id`) ON DELETE CASCADE;

--
-- Constraints for table `log_maintenance`
--
ALTER TABLE `log_maintenance`
  ADD CONSTRAINT `log_maintenance_ibfk_1` FOREIGN KEY (`log_lap_id`) REFERENCES `laptops` (`lap_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`res_user`) REFERENCES `users` (`u_id`) ON DELETE CASCADE;
COMMIT;
