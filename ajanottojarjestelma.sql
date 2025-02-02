-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 03.02.2025 klo 13:53
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
-- Rakenne taululle `erat`
--

CREATE TABLE `erat` (
  `id` int(100) NOT NULL,
  `vaihe` enum('alkuera','kerailyera','valiera','finaali') NOT NULL,
  `joukkue_id` int(100) NOT NULL,
  `tehtava1_aika` varchar(10) DEFAULT NULL,
  `tehtava2_aika` varchar(10) DEFAULT NULL,
  `tehtava3_aika` varchar(10) DEFAULT NULL,
  `kokonaisaika` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vedos taulusta `erat`
--

INSERT INTO `erat` (`id`, `vaihe`, `joukkue_id`, `tehtava1_aika`, `tehtava2_aika`, `tehtava3_aika`, `kokonaisaika`) VALUES
(1, 'alkuera', 1, '05:12:89', '12:22:99', '24:22:78', '24:22:78'),
(2, 'alkuera', 2, '5:50:79', '8:23:66', '14:44:65', '14:46:88'),
(3, 'alkuera', 3, '4:55:23', '9:55:56', '15:40:43', '15:40:43'),
(4, 'kerailyera', 1, '4:34:65', '9:45:23', '14:54:78', '14:54:78'),
(5, 'valiera', 1, '5:10:33', '10:12:42', '14:56:88', '14:56:88'),
(6, 'finaali', 1, '3:59:43', '10:05:22', '16:21:44', '16:21:44');

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
(3, 'sihteeri1', '$2y$10$dLjf6hVtklYmTd8f884Ao..PuregFhPOQlBN1i9HjWobdK8ci2gb6', 'sihteeri');

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
-- Vedos taulusta `tulostaulu`
--

INSERT INTO `tulostaulu` (`aikaid`, `joukkueid`, `era`, `tehtava1aika`, `tehtava2aika`, `tehtava3aika`, `kokonaisaika`) VALUES
(1, 1, 'Alkuera', '00:01.200', '00:00.752', '00:00.841', '00:02.793'),
(2, 3, 'Kerailyera', '00:00.984', '00:00.896', '00:00.792', '00:02.672'),
(3, 8, 'Finaali', '00:08.025', '00:05.039', '00:06.618', '00:19.683');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `erat`
--
ALTER TABLE `erat`
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
-- AUTO_INCREMENT for table `erat`
--
ALTER TABLE `erat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `joukkueet`
--
ALTER TABLE `joukkueet`
  MODIFY `joukkueid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kayttajat`
--
ALTER TABLE `kayttajat`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  MODIFY `aikaid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `erat`
--
ALTER TABLE `erat`
  ADD CONSTRAINT `erat_ibfk_1` FOREIGN KEY (`joukkue_id`) REFERENCES `joukkueet` (`joukkueid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
