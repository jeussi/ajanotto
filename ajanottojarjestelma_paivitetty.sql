-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 13.02.2025 klo 13:33
-- Palvelimen versio: 5.7.39
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
-- Rakenne taululle `arvotut_erat`
--

CREATE TABLE `arvotut_erat` (
  `id` int(11) NOT NULL,
  `vaihe` enum('alkuera','valiera','kerailyera','finaali') NOT NULL,
  `era_numero` int(11) NOT NULL,
  `joukkue_id` int(11) NOT NULL,
  `tuomari_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vedos taulusta `arvotut_erat`
--

INSERT INTO `arvotut_erat` (`id`, `vaihe`, `era_numero`, `joukkue_id`, `tuomari_id`) VALUES
(1, 'alkuera', 1, 3, 5),
(2, 'alkuera', 1, 4, 6),
(3, 'alkuera', 1, 6, 7),
(4, 'alkuera', 1, 8, 4),
(5, 'alkuera', 1, 2, 8),
(6, 'alkuera', 1, 1, 2),
(7, 'alkuera', 2, 5, 5),
(8, 'alkuera', 2, 7, 7),
(9, 'valiera', 1, 3, 6),
(10, 'valiera', 1, 2, 7),
(11, 'valiera', 1, 7, 5),
(12, 'valiera', 1, 4, 2),
(13, 'valiera', 1, 1, 8),
(14, 'valiera', 1, 8, 4),
(15, 'valiera', 2, 5, 6),
(16, 'valiera', 2, 6, 8);

-- --------------------------------------------------------

--
-- Rakenne taululle `joukkueet`
--

CREATE TABLE `joukkueet` (
  `joukkueid` int(100) NOT NULL,
  `nimi` varchar(100) NOT NULL,
  `koulu` varchar(100) NOT NULL,
  `jasen1` varchar(100) NOT NULL,
  `jasen2` varchar(100) NOT NULL,
  `jasen3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vedos taulusta `joukkueet`
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
-- Rakenne taululle `kayttajat`
--

CREATE TABLE `kayttajat` (
  `id` int(100) NOT NULL,
  `kayttajanimi` varchar(100) NOT NULL,
  `salasana` varchar(100) NOT NULL,
  `rooli` enum('admin','sihteeri','tuomari') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vedos taulusta `kayttajat`
--

INSERT INTO `kayttajat` (`id`, `kayttajanimi`, `salasana`, `rooli`) VALUES
(1, 'test', '$2y$10$ccV5RGGc/5cXmc1un1/RteTc85FutdXEqI/Csd/oKrrQaj15iJR3.', 'admin'),
(2, 'tuomari1', '$2y$10$iBNvMZCoVGzha4v22I1raOJjdzkDzRXuOquAahLR8MrmW143DimUe', 'tuomari'),
(3, 'sihteeri1', '$2y$10$dLjf6hVtklYmTd8f884Ao..PuregFhPOQlBN1i9HjWobdK8ci2gb6', 'sihteeri'),
(4, 'tuomari2', '$2y$10$0tMgcI4EcruMpHXFr4a9..hYVk2SFn/Ix9FYxDW3yX5wa0njtRgQu', 'tuomari'),
(5, 'tuomari3', '$2y$10$JmAdFrANqAe/mRZMgnwQJuIXsj.VWiwcOw7mQD4BX84hwdM62tpG6', 'tuomari'),
(6, 'tuomari4', '$2y$10$o/.FfQ7cVSd4HF6EB/addOVOSM6MVjmfCXL6B6vk1ITuZ/8JaYZBm', 'tuomari'),
(7, 'tuomari5', '$2y$10$ACj..t277KXA3Qt/YGm7Z.rA2RzF540VQp9XE5Cx.rFCC4DyH5abS', 'tuomari'),
(8, 'tuomari6', '$2y$10$UU.0v7nozl0S8kTD90WXKu2Xzfw3W/FlZvQdrubfZyLZKpc8Xh2Bq', 'tuomari');

-- --------------------------------------------------------

--
-- Rakenne taululle `tulostaulu`
--

CREATE TABLE `tulostaulu` (
  `aikaid` int(11) NOT NULL,
  `joukkueid` int(11) NOT NULL,
  `era` enum('Alkuera','Kerailyera','Valiera','Finaali') NOT NULL,
  `tehtava1aika` varchar(10) NOT NULL,
  `tehtava2aika` varchar(10) NOT NULL,
  `tehtava3aika` varchar(10) NOT NULL,
  `kokonaisaika` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joukkue_id` (`joukkue_id`);

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
-- Indexes for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  ADD PRIMARY KEY (`aikaid`),
  ADD KEY `joukkueid` (`joukkueid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `joukkueet`
--
ALTER TABLE `joukkueet`
  MODIFY `joukkueid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  MODIFY `aikaid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `arvotut_erat`
--
ALTER TABLE `arvotut_erat`
  ADD CONSTRAINT `arvotut_erat_ibfk_1` FOREIGN KEY (`joukkue_id`) REFERENCES `joukkueet` (`joukkueid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
