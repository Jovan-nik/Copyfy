-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2024 at 06:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `copyfy`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `ID_korisnika` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `registration_time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`ID_korisnika`, `email`, `user_name`, `password`, `registration_time`) VALUES
(24, 'luxpalacinke@gmail.com', 'Luxpalacinke', '$2y$10$oPm6Ds66I.jeZsVJ5ZGISutCo0gSA1CSMpD3e7upFoQteGaZb9ULC', '2024-03-13 18:11:43'),
(25, 'terzicognjen1@gmail.com', 'Terza', '$2y$10$R0gXljEJtQlPqhM3PFujNevAwdM.kLycPsxq37ebQCrQnRwt1nkWO', '2024-03-13 20:08:43'),
(26, 'nikodinovicjovan1@gmail.com', 'Jovance', '$2y$10$aNzuPG2AiFaplXutjOC6zuSvgA2shnmMQDEWql/AApRDSHqs8nmnq', '2024-03-13 21:55:50'),
(27, 'lukamarkovic2017@gmai.com', 'Bordzija', '$2y$10$cJ5P10K53TFReliukkLjFecnVJ6uxnexe//WukMRYE1FjhLCU.Oay', '2024-03-16 22:24:43'),
(28, 'nikolaslavkovic8@gmail.com', 'Dzoni', '$2y$10$Yvb1lbamKVSSc1sW4/leN.FGzbfo5PrwxxvR6zOMVD827WZtKWDtm', '2024-03-19 10:19:55');

-- --------------------------------------------------------

--
-- Table structure for table `nove_lozinke`
--

CREATE TABLE `nove_lozinke` (
  `ID_nove_lozinke` int(11) NOT NULL,
  `ID_korisnika` int(11) NOT NULL,
  `kod` varchar(10) NOT NULL,
  `vreme_kreiranja` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `nove_lozinke`
--

INSERT INTO `nove_lozinke` (`ID_nove_lozinke`, `ID_korisnika`, `kod`, `vreme_kreiranja`) VALUES
(11, 26, '7mhmWT', '2024-03-20 18:13:26'),
(12, 26, 'pItLL4', '2024-03-20 18:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `objava`
--

CREATE TABLE `objava` (
  `ID_objave` int(11) NOT NULL,
  `ID_teme` int(11) NOT NULL,
  `ID_korisnika` int(11) NOT NULL,
  `naslov` varchar(50) NOT NULL,
  `tekst` text NOT NULL,
  `slika` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `objava`
--

INSERT INTO `objava` (`ID_objave`, `ID_teme`, `ID_korisnika`, `naslov`, `tekst`, `slika`) VALUES
(18, 6, 26, 'Topalko vs Vucic', 'Topalko ne podnosi predsednika republike', 'images/topalko.jpg'),
(19, 7, 26, 'Golf 7 valja mu spoiler', 'Zlatan Radenkovic sponzor', 'images/golf7.jpg'),
(20, 1, 27, 'Hakaton – FON – 1. mesto', 'Na velikom Hakatonu nadamo se prvaci', 'images/hakatonci.jpg'),
(21, 7, 26, 'Auto skola Lider DB036', 'Najbolja autoskola u gradu', 'images/renolalider.jpg'),
(22, 10, 26, 'James Webb teleskop bolji od Hubbla', 'Najnoviji Nasin teleskop pokazao se kao pobednik', 'images/james.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tema`
--

CREATE TABLE `tema` (
  `ID_teme` int(11) NOT NULL,
  `naziv` varchar(50) NOT NULL,
  `opis` text NOT NULL,
  `ion_icon` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tema`
--

INSERT INTO `tema` (`ID_teme`, `naziv`, `opis`, `ion_icon`) VALUES
(1, 'Programiranje', 'Tema za programiranje, veb programiranje i sve ostalo te sorte', 'desktop-outline'),
(2, 'Sport', 'Tema za sport', 'football-outline'),
(3, 'Gaming', 'Tema za gejming', 'game-controller-outline'),
(4, 'Business', 'Tema za posao/biznis', 'analytics-outline'),
(5, 'Crypto', 'Tema za kripto valute', 'wallet-outline'),
(6, 'Poznati', 'O poznatima iz regiona', 'star-outline'),
(7, 'Kola', 'Za ljubitelje automobila', 'car-sport-outline'),
(8, 'Istorija', 'Za istoricare', 'calendar-outline'),
(9, 'Moda', 'Za modne fanatike', 'shirt-outline'),
(10, 'Astronomija', 'Za astronome', 'telescope-outline'),
(11, 'Muzika', 'Za muzicare', 'musical-notes-outline'),
(12, 'Filmovi', 'Sedma umetnost', 'film-outline'),
(13, 'Nauka', 'Za naucnike', 'flask-outline'),
(14, 'Putovanja', 'Za turizam', 'flask-outline'),
(15, 'Obrazovanje', 'Edukacija', 'school-outline'),
(16, 'Prognoza', 'Meteorologija', 'rainy-outline'),
(17, 'Uradi sam', 'DIY kod kuce', 'construct-outline'),
(18, 'Ishrana', 'Za nutricioniste', 'restaurant-outline'),
(19, 'Medicina', 'Medicina', 'pulse-outline'),
(20, 'Matematika', '4 znacajna limesa', ''),
(21, 'Knjizevnost', 'Svetska knjizevnost', ''),
(22, 'Stolarstvo', 'Izrada namestaja', '');

-- --------------------------------------------------------

--
-- Table structure for table `up_vote`
--

CREATE TABLE `up_vote` (
  `ID_upvote` int(11) NOT NULL,
  `ID_korisnika` int(11) NOT NULL,
  `ID_objave` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `up_vote`
--

INSERT INTO `up_vote` (`ID_upvote`, `ID_korisnika`, `ID_objave`) VALUES
(24, 26, 18),
(25, 25, 20),
(26, 25, 19),
(27, 25, 18),
(28, 26, 20),
(29, 26, 21),
(30, 28, 18),
(31, 28, 19),
(32, 28, 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`ID_korisnika`);

--
-- Indexes for table `nove_lozinke`
--
ALTER TABLE `nove_lozinke`
  ADD PRIMARY KEY (`ID_nove_lozinke`),
  ADD KEY `ID_korisnika` (`ID_korisnika`);

--
-- Indexes for table `objava`
--
ALTER TABLE `objava`
  ADD PRIMARY KEY (`ID_objave`);

--
-- Indexes for table `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`ID_teme`);

--
-- Indexes for table `up_vote`
--
ALTER TABLE `up_vote`
  ADD PRIMARY KEY (`ID_upvote`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `ID_korisnika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `nove_lozinke`
--
ALTER TABLE `nove_lozinke`
  MODIFY `ID_nove_lozinke` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `objava`
--
ALTER TABLE `objava`
  MODIFY `ID_objave` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tema`
--
ALTER TABLE `tema`
  MODIFY `ID_teme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `up_vote`
--
ALTER TABLE `up_vote`
  MODIFY `ID_upvote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nove_lozinke`
--
ALTER TABLE `nove_lozinke`
  ADD CONSTRAINT `nove_lozinke_ibfk_1` FOREIGN KEY (`ID_korisnika`) REFERENCES `korisnik` (`ID_korisnika`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
