-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 23, 2025 alle 15:07
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avo_laptops_db`
--
CREATE DATABASE IF NOT EXISTS `avo_laptops_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `avo_laptops_db`;

-- --------------------------------------------------------

--
-- Struttura della tabella `laptops`
--

CREATE TABLE `laptops` (
  `lap_id` int(11) NOT NULL,
  `lap_model` int(11) DEFAULT NULL,
  `lap_locker` int(11) DEFAULT NULL,
  `lap_name` varchar(40) DEFAULT NULL,
  `lap_status` int(11) DEFAULT NULL
) ;

--
-- Dump dei dati per la tabella `laptops`
--

INSERT INTO `laptops` (`lap_id`, `lap_model`, `lap_locker`, `lap_name`, `lap_status`) VALUES
(1, 1, 1, 'PC-01', 1),
(2, 1, 1, 'PC-02', 1),
(3, 1, 1, 'PC-03', 0),
(4, 1, 1, 'PC-04', 1),
(5, 1, 1, 'PC-05', -1),
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
-- Trigger `laptops`
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
-- Struttura della tabella `laptops_reservations`
--

CREATE TABLE `laptops_reservations` (
  `lap_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `laptops_reservations`
--

INSERT INTO `laptops_reservations` (`lap_id`, `res_id`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1),
(5, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `lockers`
--

CREATE TABLE `lockers` (
  `lock_id` int(11) NOT NULL,
  `lock_floor` int(11) DEFAULT NULL,
  `lock_class` varchar(30) DEFAULT NULL,
  `lock_capacity` int(11) DEFAULT NULL,
  `lock_incharge` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `lockers`
--

INSERT INTO `lockers` (`lock_id`, `lock_floor`, `lock_class`, `lock_capacity`, `lock_incharge`) VALUES
(1, 1, 'Aula Informatica', 30, 'Prof. Rossi'),
(2, 2, 'Biblioteca', 30, 'Prof.ssa Verdi'),
(3, 3, 'Laboratorio', 30, 'Prof. Bianchi');

-- --------------------------------------------------------

--
-- Struttura della tabella `log_maintenance`
--

CREATE TABLE `log_maintenance` (
  `log_id` int(11) NOT NULL,
  `log_lap_id` int(11) NOT NULL,
  `log_date` date NOT NULL,
  `log_time` time NOT NULL,
  `log_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `log_maintenance`
--

INSERT INTO `log_maintenance` (`log_id`, `log_lap_id`, `log_date`, `log_time`, `log_status`) VALUES
(1, 7, '2025-04-23', '11:36:44', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `models`
--

CREATE TABLE `models` (
  `mod_id` int(11) NOT NULL,
  `mod_name` varchar(50) DEFAULT NULL,
  `mod_RAM` int(11) DEFAULT NULL,
  `mod_memory` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `models`
--

INSERT INTO `models` (`mod_id`, `mod_name`, `mod_RAM`, `mod_memory`) VALUES
(1, 'Dell Latitude 5400', 8, 256),
(2, 'HP EliteBook 850', 16, 512),
(3, 'Lenovo ThinkPad X1', 16, 1024);

-- --------------------------------------------------------

--
-- Struttura della tabella `reservations`
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
-- Dump dei dati per la tabella `reservations`
--

INSERT INTO `reservations` (`res_id`, `res_start_time`, `res_end_time`, `res_day`, `res_flag`, `res_user`) VALUES
(1, '08:00:00', '10:00:00', '2025-04-20', 1, 37),
(2, '10:00:00', '12:00:00', '2025-04-20', 1, 38),
(3, '13:00:00', '15:00:00', '2025-04-20', 1, 39);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(50) DEFAULT NULL,
  `u_surname` varchar(50) DEFAULT NULL,
  `u_email` varchar(64) DEFAULT NULL,
  `u_cf` varchar(16) DEFAULT NULL,
  `u_password` varchar(61) DEFAULT NULL,
  `u_role` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_surname`, `u_email`, `u_cf`, `u_password`, `u_role`) VALUES
(37, 'Mario', 'Rossi', 'mario.rossi@itisavogadro.it', 'MROSSI12345678', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 1),
(38, 'Anna', 'Verdi', 'anna.verdi@itisavogadro.it', 'AVERDI12345678', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 2),
(39, 'Luigi', 'Bianchi', 'luigi.bianchi@itisavogadro.it', 'LBIANCHI12345678', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 3),
(40, 'Anna', 'Verdi', 'anna.verdi@itisavogadro.it', 'AVERDI12345678', '$2y$10$bUTASuIFIeiq8/xSq7ppM.brt9.J/8dB1s.SjeAVJW4g4ulFqx7N6', 2);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`lap_id`),
  ADD KEY `lap_model` (`lap_model`),
  ADD KEY `lap_locker` (`lap_locker`);

--
-- Indici per le tabelle `laptops_reservations`
--
ALTER TABLE `laptops_reservations`
  ADD PRIMARY KEY (`lap_id`,`res_id`),
  ADD KEY `res_id` (`res_id`);

--
-- Indici per le tabelle `lockers`
--
ALTER TABLE `lockers`
  ADD PRIMARY KEY (`lock_id`);

--
-- Indici per le tabelle `log_maintenance`
--
ALTER TABLE `log_maintenance`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `log_lap_id` (`log_lap_id`);

--
-- Indici per le tabelle `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`mod_id`);

--
-- Indici per le tabelle `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `res_user` (`res_user`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `laptops`
--
ALTER TABLE `laptops`
  MODIFY `lap_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `lockers`
--
ALTER TABLE `lockers`
  MODIFY `lock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `log_maintenance`
--
ALTER TABLE `log_maintenance`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `models`
--
ALTER TABLE `models`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `laptops`
--
ALTER TABLE `laptops`
  ADD CONSTRAINT `laptops_ibfk_1` FOREIGN KEY (`lap_model`) REFERENCES `models` (`mod_id`),
  ADD CONSTRAINT `laptops_ibfk_2` FOREIGN KEY (`lap_locker`) REFERENCES `lockers` (`lock_id`);

--
-- Limiti per la tabella `laptops_reservations`
--
ALTER TABLE `laptops_reservations`
  ADD CONSTRAINT `laptops_reservations_ibfk_1` FOREIGN KEY (`lap_id`) REFERENCES `laptops` (`lap_id`),
  ADD CONSTRAINT `laptops_reservations_ibfk_2` FOREIGN KEY (`res_id`) REFERENCES `reservations` (`res_id`);

--
-- Limiti per la tabella `log_maintenance`
--
ALTER TABLE `log_maintenance`
  ADD CONSTRAINT `log_maintenance_ibfk_1` FOREIGN KEY (`log_lap_id`) REFERENCES `laptops` (`lap_id`);

--
-- Limiti per la tabella `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`res_user`) REFERENCES `users` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
