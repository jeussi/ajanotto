-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 28, 2025 at 01:41 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajanottojarjestelma`
--

-- --------------------------------------------------------

--
-- Table structure for table `arvotut_erat`
--

CREATE TABLE `arvotut_erat` (
  `id` int NOT NULL,
  `vaihe` enum('alkuera','valiera','kerailyera','finaali') NOT NULL,
  `era_numero` int NOT NULL,
  `joukkue_id` int NOT NULL,
  `tuomari_id` int DEFAULT NULL,
  `rataid` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `arvotut_erat`
--

INSERT INTO `arvotut_erat` (`id`, `vaihe`, `era_numero`, `joukkue_id`, `tuomari_id`, `rataid`) VALUES
(1, 'alkuera', 1, 3, 5, 1),
(2, 'alkuera', 1, 4, 6, 2),
(3, 'alkuera', 1, 6, 7, 3),
(4, 'alkuera', 1, 8, 4, 4),
(5, 'alkuera', 1, 2, 8, 5),
(6, 'alkuera', 1, 1, 2, 6),
(7, 'alkuera', 2, 5, 5, NULL),
(8, 'alkuera', 2, 7, 7, NULL),
(9, 'valiera', 1, 3, 6, NULL),
(10, 'valiera', 1, 2, 7, NULL),
(11, 'valiera', 1, 7, 5, NULL),
(12, 'valiera', 1, 4, 2, NULL),
(13, 'valiera', 1, 1, 8, NULL),
(14, 'valiera', 1, 8, 4, NULL),
(15, 'valiera', 2, 5, 6, NULL),
(16, 'valiera', 2, 6, 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `joukkueet`
--

CREATE TABLE `joukkueet` (
  `joukkueid` int NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `koulu` varchar(100) NOT NULL,
  `jasen1` varchar(100) NOT NULL,
  `jasen2` varchar(100) NOT NULL,
  `jasen3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `joukkueet`
--

INSERT INTO `joukkueet` (`joukkueid`, `nimi`, `koulu`, `jasen1`, `jasen2`, `jasen3`) VALUES
(1, 'Leijonat', 'Armfelt', 'Joonas', 'Jaakko', 'Jenina'),
(2, 'Testijoukkue', 'Hermanni', 'Joona', 'Teemu', 'Sari'),
(3, 'Testijoukkue 2', 'Moisio', 'Julia', 'Tuomas', 'Anni'),
(4, 'Testijoukkue 3', 'Armfelt', 'Pekka', 'Teppo', 'Jaakko'),
(5, 'Testijoukkue 4', 'Hermanni', 'Leena', 'Jere', 'Lauri'),
(6, 'Testijoukkue 5', 'Moisio', 'Tero', 'Milla', 'Hanna'),
(7, 'Testijoukkue 6', 'Hermanni', 'Laura', 'Jasmin', 'Oona'),
(8, 'asd', 'asd', 'dgdfgd', 'dfgdfg', 'dfgdfgdf');

-- --------------------------------------------------------

--
-- Table structure for table `kayttajat`
--

CREATE TABLE `kayttajat` (
  `id` int NOT NULL,
  `kayttajanimi` varchar(100) NOT NULL,
  `salasana` varchar(100) NOT NULL,
  `rooli` enum('admin','sihteeri','tuomari') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `kayttajat`
--

INSERT INTO `kayttajat` (`id`, `kayttajanimi`, `salasana`, `rooli`) VALUES
(1, 'test', '$2y$10$ccV5RGGc/5cXmc1un1/RteTc85FutdXEqI/Csd/oKrrQaj15iJR3.', 'admin'),
(2, 'tuomari1', '$2y$10$iBNvMZCoVGzha4v22I1raOJjdzkDzRXuOquAahLR8MrmW143DimUe', 'tuomari'),
(3, 'sihteeri1', '$2y$10$dLjf6hVtklYmTd8f884Ao..PuregFhPOQlBN1i9HjWobdK8ci2gb6', 'sihteeri'),
(4, 'tuomari2', '$2y$10$0tMgcI4EcruMpHXFr4a9..hYVk2SFn/Ix9FYxDW3yX5wa0njtRgQu', 'tuomari'),
(5, 'tuomari3', '$2y$10$JmAdFrANqAe/mRZMgnwQJuIXsj.VWiwcOw7mQD4BX84hwdM62tpG6', 'tuomari'),
(6, 'tuomari4', '$2y$10$o/.FfQ7cVSd4HF6EB/addOVOSM6MVjmfCXL6B6vk1ITuZ/8JaYZBm', 'tuomari'),
(7, 'tuomari5', '$2y$10$ACj..t277KXA3Qt/YGm7Z.rA2RzF540VQp9XE5Cx.rFCC4DyH5abS', 'tuomari'),
(8, 'tuomari6', '$2y$10$UU.0v7nozl0S8kTD90WXKu2Xzfw3W/FlZvQdrubfZyLZKpc8Xh2Bq', 'tuomari'),
(9, 'tuomari14', '$2y$10$jwh3ozXJzDGmRpBsh/C3CeN8RSR7t5oQ9Xn9LqBfPJKwZjlFf8FQe', 'tuomari');

-- --------------------------------------------------------

--
-- Table structure for table `rata`
--

CREATE TABLE `rata` (
  `rataid` int NOT NULL,
  `valmis` tinyint(1) DEFAULT '0',
  `aika_aloitettu` tinyint(1) NOT NULL DEFAULT '0',
  `viimeisin_paivitys` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rata`
--

INSERT INTO `rata` (`rataid`, `valmis`, `aika_aloitettu`, `viimeisin_paivitys`) VALUES
(1, 0, 0, '2025-03-10 14:52:06'),
(2, 0, 0, '2025-03-10 14:52:06'),
(3, 0, 0, '2025-03-10 14:52:06'),
(4, 0, 0, '2025-03-10 14:52:06'),
(5, 0, 0, '2025-03-10 14:52:06'),
(6, 0, 0, '2025-03-10 14:52:06');

-- --------------------------------------------------------

--
-- Table structure for table `tulostaulu`
--

CREATE TABLE `tulostaulu` (
  `aikaid` int NOT NULL,
  `joukkueid` int NOT NULL,
  `era` enum('Alkuera','Kerailyera','Valiera','Finaali') NOT NULL,
  `era_numero` int NOT NULL,
  `tehtava1aika` varchar(10) NOT NULL,
  `tehtava2aika` varchar(10) NOT NULL,
  `tehtava3aika` varchar(10) NOT NULL,
  `kokonaisaika` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tulostaulu`
--

INSERT INTO `tulostaulu` (`aikaid`, `joukkueid`, `era`, `era_numero`, `tehtava1aika`, `tehtava2aika`, `tehtava3aika`, `kokonaisaika`) VALUES
(1, 8, 'Alkuera', 1, '00:01.398', '00:00.478', '00:00.544', '00:02.420'),
(2, 6, 'Alkuera', 1, '00:01.243', '00:00.451', '00:00.521', '00:02.215'),
(3, 7, 'Alkuera', 2, '00:00.455', '00:00.229', '00:00.291', '00:00.975'),
(4, 2, 'Alkuera', 1, '00:00.525', '00:00.149', '00:00.169', '00:00.843'),
(5, 2, 'Valiera', 1, '00:00.830', '00:00.141', '00:00.149', '00:01.121'),
(6, 1, 'Alkuera', 1, '00:00.580', '00:00.210', '00:00.282', '00:01.072'),
(7, 4, 'Alkuera', 1, '00:00.780', '00:00.255', '00:00.324', '00:01.359'),
(8, 4, 'Alkuera', 1, '00:00.780', '00:00.255', '00:00.324', '00:01.359'),
(9, 4, 'Alkuera', 1, '00:00.780', '00:00.255', '00:00.324', '00:01.359'),
(10, 8, 'Alkuera', 1, '01:06.703', '00:08.090', '00:05.410', '01:20.203'),
(11, 1, 'Alkuera', 1, '00:08.779', '00:10.242', '00:05.576', '00:24.597'),
(12, 4, 'Alkuera', 1, '00:27.801', '00:07.859', '00:06.032', '00:41.692'),
(13, 3, 'Alkuera', 1, '01:59.575', '00:04.296', '00:06.006', '02:09.878'),
(14, 2, 'Alkuera', 1, '01:57.707', '00:08.016', '00:06.275', '02:11.998'),
(15, 6, 'Alkuera', 1, '01:58.231', '00:06.398', '00:06.303', '02:10.932');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joukkue_id` (`joukkue_id`),
  ADD KEY `rataid` (`rataid`);

--
-- Indexes for table `joukkueet`
--
ALTER TABLE `joukkueet`
  ADD PRIMARY KEY (`joukkueid`);

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rata`
--
ALTER TABLE `rata`
  ADD PRIMARY KEY (`rataid`);

--
-- Indexes for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  ADD PRIMARY KEY (`aikaid`),
  ADD KEY `joukkueid` (`joukkueid`),
  ADD KEY `eraid` (`era_numero`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `joukkueet`
--
ALTER TABLE `joukkueet`
  MODIFY `joukkueid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  MODIFY `aikaid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  ADD CONSTRAINT `arvotut_erat_ibfk_1` FOREIGN KEY (`joukkue_id`) REFERENCES `joukkueet` (`joukkueid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
