-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2025 at 11:03 AM
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
-- Database: `uusiajanottojarjestela`
--

-- --------------------------------------------------------

--
-- Table structure for table `tulostaulu`
--

CREATE TABLE `tulostaulu` (
  `aikaid` int NOT NULL,
  `joukkueid` int NOT NULL,
  `era` enum('Alkuera','Kerailyera','Valiera','Finaali') NOT NULL,
  `tehtava1aika` varchar(10) NOT NULL,
  `tehtava2aika` varchar(10) NOT NULL,
  `tehtava3aika` varchar(10) NOT NULL,
  `kokonaisaika` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tulostaulu`
--

INSERT INTO `tulostaulu` (`aikaid`, `joukkueid`, `era`, `tehtava1aika`, `tehtava2aika`, `tehtava3aika`, `kokonaisaika`) VALUES
(1, 1, 'Alkuera', '00:01.200', '00:00.752', '00:00.841', '00:02.793'),
(2, 3, 'Kerailyera', '00:00.984', '00:00.896', '00:00.792', '00:02.672');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `tulostaulu`
--
ALTER TABLE `tulostaulu`
  MODIFY `aikaid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
