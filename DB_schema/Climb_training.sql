-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 06, 2020 alle 15:09
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Climb_training`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `exercise`
--

CREATE TABLE `exercise` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `importantNotes` text NOT NULL,
  `repsMin` int(11) NOT NULL,
  `repsMax` int(11) NOT NULL,
  `setMin` int(11) NOT NULL,
  `setMax` int(11) NOT NULL,
  `restMin` time NOT NULL,
  `restMax` time NOT NULL,
  `overweightMin` int(11) NOT NULL,
  `overweightMax` int(11) NOT NULL,
  `overweightUnit` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `exercise`
--

INSERT INTO `exercise` (`id`, `name`, `description`, `importantNotes`, `repsMin`, `repsMax`, `setMin`, `setMax`, `restMin`, `restMax`, `overweightMin`, `overweightMax`, `overweightUnit`) VALUES
(1, 'Dip', 'Dips description extende', 'h', 18, 39, 7, 9, '00:00:01', '00:00:50', 6, 9, '%'),
(2, 'Curls', 'Curls description extended', 'importamt notes', 4, 30, 2, 4, '00:00:00', '00:00:00', 20, 30, '%'),
(4, 'Loreipsum', 'Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '', 15, 30, 2, 4, '00:00:00', '00:00:00', 0, 0, 'Kg');

-- --------------------------------------------------------

--
-- Struttura della tabella `exercise_to_photo`
--

CREATE TABLE `exercise_to_photo` (
  `id` int(11) NOT NULL,
  `id_exercise` int(11) NOT NULL,
  `id_photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `exercise_to_photo`
--

INSERT INTO `exercise_to_photo` (`id`, `id_exercise`, `id_photo`) VALUES
(8, 2, 13);

-- --------------------------------------------------------

--
-- Struttura della tabella `exercise_to_tools`
--

CREATE TABLE `exercise_to_tools` (
  `id` int(11) NOT NULL,
  `id_exercise` int(11) NOT NULL,
  `id_tool` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `exercise_to_tools`
--

INSERT INTO `exercise_to_tools` (`id`, `id_exercise`, `id_tool`) VALUES
(36, 2, 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `photo`
--

INSERT INTO `photo` (`id`, `path`, `description`) VALUES
(13, 'upload/1.jpeg', 'Passo 1');

-- --------------------------------------------------------

--
-- Struttura della tabella `tecnical_tools`
--

CREATE TABLE `tecnical_tools` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `tecnical_tools`
--

INSERT INTO `tecnical_tools` (`id`, `name`) VALUES
(1, 'BeastMaker 2000'),
(2, 'BeastMaker 1000'),
(3, 'Monnboard'),
(4, 'Rings'),
(5, 'Rope');

-- --------------------------------------------------------

--
-- Struttura della tabella `trainingprogram`
--

CREATE TABLE `trainingprogram` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `timeMin` time NOT NULL,
  `timeMax` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `trainingprogram`
--

INSERT INTO `trainingprogram` (`id`, `title`, `description`, `timeMin`, `timeMax`) VALUES
(1, 'Stabilizer/Antagonist Workout mmm', 'Increase strength and endurance in the vital stabilizer & antagonist muscles of the arms, shoulders, and torsoaweawefasdfasdf', '12:22:00', '22:22:00'),
(3, 'Stabilizer/Antagonist Workout', 'Increase strength and endurance in the vital stabilizer & antagonist muscles of the arms, shoulders, and torso', '01:00:00', '02:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `trainingprogram_to_exercise`
--

CREATE TABLE `trainingprogram_to_exercise` (
  `id` int(11) NOT NULL,
  `id_exercise` int(11) NOT NULL,
  `id_trainingProgram` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `trainingprogram_to_exercise`
--

INSERT INTO `trainingprogram_to_exercise` (`id`, `id_exercise`, `id_trainingProgram`) VALUES
(47, 2, 3),
(48, 1, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `surname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `username`, `password`, `email`) VALUES
(1, 'test', 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 'test@test.it'),
(3, '', '', 't', 'e358efa489f58062f10dd7316b65649e', 'r'),
(4, 'mario', 'rosssi', 'Mario', 'de2f15d014d40b93578d255e6221fd60', 'mario@gmail.com'),
(5, 'Test', 'Test', 'Test1', 'e1b849f9631ffc1829b2e31402373e3c', 'qwer'),
(6, 'Lorenzo', 'Tomasetti', 'TOMAWOCK', '81dc9bdb52d04dc20036dbd8313ed055', 'l.tom@tim.it');

-- --------------------------------------------------------

--
-- Struttura della tabella `user_trainingprogram`
--

CREATE TABLE `user_trainingprogram` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trainingprogram_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user_trainingprogram`
--

INSERT INTO `user_trainingprogram` (`id`, `user_id`, `trainingprogram_id`) VALUES
(23, 5, 3);

-- --------------------------------------------------------

--
-- Struttura della tabella `user_trainingprogram_execution`
--

CREATE TABLE `user_trainingprogram_execution` (
  `id` int(11) NOT NULL,
  `id_exercise` int(11) NOT NULL,
  `id_trainingProgram` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `sets` int(11) NOT NULL,
  `date` date NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `user_trainingprogram_execution`
--

INSERT INTO `user_trainingprogram_execution` (`id`, `id_exercise`, `id_trainingProgram`, `id_user`, `reps`, `sets`, `date`, `note`) VALUES
(25, 2, 3, 5, 2, 3, '2020-06-06', 'fatti bene '),
(26, 1, 3, 5, 12, 14, '2020-06-06', 'fatti molto male');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `exercise_to_photo`
--
ALTER TABLE `exercise_to_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_to_p` (`id_exercise`),
  ADD KEY `p_to_e` (`id_photo`);

--
-- Indici per le tabelle `exercise_to_tools`
--
ALTER TABLE `exercise_to_tools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercise_to_tool` (`id_exercise`),
  ADD KEY `tool_to_exercise` (`id_tool`);

--
-- Indici per le tabelle `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `tecnical_tools`
--
ALTER TABLE `tecnical_tools`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `trainingprogram`
--
ALTER TABLE `trainingprogram`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `trainingprogram_to_exercise`
--
ALTER TABLE `trainingprogram_to_exercise`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_exercise` (`id_exercise`),
  ADD KEY `id_trainingProgram` (`id_trainingProgram`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `user_trainingprogram`
--
ALTER TABLE `user_trainingprogram`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainingprogram_id` (`trainingprogram_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indici per le tabelle `user_trainingprogram_execution`
--
ALTER TABLE `user_trainingprogram_execution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_exercise` (`id_exercise`),
  ADD KEY `id_scheda` (`id_trainingProgram`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `exercise`
--
ALTER TABLE `exercise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la tabella `exercise_to_photo`
--
ALTER TABLE `exercise_to_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT per la tabella `exercise_to_tools`
--
ALTER TABLE `exercise_to_tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT per la tabella `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT per la tabella `tecnical_tools`
--
ALTER TABLE `tecnical_tools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `trainingprogram`
--
ALTER TABLE `trainingprogram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT per la tabella `trainingprogram_to_exercise`
--
ALTER TABLE `trainingprogram_to_exercise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT per la tabella `user_trainingprogram`
--
ALTER TABLE `user_trainingprogram`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT per la tabella `user_trainingprogram_execution`
--
ALTER TABLE `user_trainingprogram_execution`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `exercise_to_photo`
--
ALTER TABLE `exercise_to_photo`
  ADD CONSTRAINT `e_to_p` FOREIGN KEY (`id_exercise`) REFERENCES `exercise` (`id`),
  ADD CONSTRAINT `p_to_e` FOREIGN KEY (`id_photo`) REFERENCES `photo` (`id`);

--
-- Limiti per la tabella `exercise_to_tools`
--
ALTER TABLE `exercise_to_tools`
  ADD CONSTRAINT `exercise_to_tool` FOREIGN KEY (`id_exercise`) REFERENCES `exercise` (`id`),
  ADD CONSTRAINT `tool_to_exercise` FOREIGN KEY (`id_tool`) REFERENCES `tecnical_tools` (`id`);

--
-- Limiti per la tabella `trainingprogram_to_exercise`
--
ALTER TABLE `trainingprogram_to_exercise`
  ADD CONSTRAINT `trainingprogram_to_exercise_ibfk_1` FOREIGN KEY (`id_exercise`) REFERENCES `exercise` (`id`),
  ADD CONSTRAINT `trainingprogram_to_exercise_ibfk_2` FOREIGN KEY (`id_trainingProgram`) REFERENCES `trainingprogram` (`id`);

--
-- Limiti per la tabella `user_trainingprogram`
--
ALTER TABLE `user_trainingprogram`
  ADD CONSTRAINT `user_trainingprogram_ibfk_1` FOREIGN KEY (`trainingprogram_id`) REFERENCES `trainingprogram` (`id`),
  ADD CONSTRAINT `user_trainingprogram_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Limiti per la tabella `user_trainingprogram_execution`
--
ALTER TABLE `user_trainingprogram_execution`
  ADD CONSTRAINT `user_trainingprogram_execution_ibfk_1` FOREIGN KEY (`id_exercise`) REFERENCES `exercise` (`id`),
  ADD CONSTRAINT `user_trainingprogram_execution_ibfk_2` FOREIGN KEY (`id_trainingProgram`) REFERENCES `trainingprogram` (`id`),
  ADD CONSTRAINT `user_trainingprogram_execution_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
