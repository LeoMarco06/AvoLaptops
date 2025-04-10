-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 10, 2025 alle 09:57
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
  `lap_locker` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `laptops_reservations`
--

CREATE TABLE `laptops_reservations` (
  `lap_id` int(11) NOT NULL,
  `res_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `u_password` varchar(61) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `lock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `models`
--
ALTER TABLE `models`
  MODIFY `mod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `reservations`
--
ALTER TABLE `reservations`
  MODIFY `res_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT;

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
-- Limiti per la tabella `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`res_user`) REFERENCES `users` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
