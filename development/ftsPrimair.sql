-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 11, 2017 at 11:46 AM
-- Server version: 10.1.20-MariaDB
-- PHP Version: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ftsPrimair`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountNr` int(10) NOT NULL,
  `lijnNr` int(10) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `schoolKlasId` varchar(30) NOT NULL,
  `naam` varchar(30) NOT NULL,
  `achterNaam` varchar(30) NOT NULL,
  `actief` tinyint(1) NOT NULL,
  `magInloggen` tinyint(1) NOT NULL,
  `vestigingId` int(10) NOT NULL,
  `gebruikersNaam` varchar(50) NOT NULL,
  `wachtwoord` varchar(50) NOT NULL,
  `klantId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountNr`, `lijnNr`, `isAdmin`, `schoolKlasId`, `naam`, `achterNaam`, `actief`, `magInloggen`, `vestigingId`, `gebruikersNaam`, `wachtwoord`, `klantId`) VALUES
(1, 1, 0, '', 'Naomi', 'Berkelaar', 1, 1, 0, 'naomiberkelaar', 'test123', 0),
(3, 1, 1, '0', 'pietje', 'puk', 0, 1, 0, 'pietjepuk', 'test124', 0);

-- --------------------------------------------------------

--
-- Table structure for table `besturingssysteem`
--

CREATE TABLE `besturingssysteem` (
  `besturingssysteemId` int(10) NOT NULL,
  `besturingssysteemOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `binnenkomstType`
--

CREATE TABLE `binnenkomstType` (
  `binnenkomstId` int(10) NOT NULL,
  `binnenkomstTypeOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `categorieId` int(10) NOT NULL,
  `catOmschrijving` text NOT NULL,
  `subCategorieId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `commentaar`
--

CREATE TABLE `commentaar` (
  `commentaarId` int(10) NOT NULL,
  `commOmschrijving` text NOT NULL,
  `typeCommentaar` text NOT NULL,
  `datum` date NOT NULL,
  `accountNr` int(10) NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `doorsturing`
--

CREATE TABLE `doorsturing` (
  `doorstuurId` int(10) NOT NULL,
  `vanLijn` int(10) NOT NULL,
  `naarLijn` int(10) NOT NULL,
  `opmerking` text NOT NULL,
  `accountNr` int(10) NOT NULL,
  `datum` date NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `instantie`
--

CREATE TABLE `instantie` (
  `instantieId` int(10) NOT NULL,
  `instantieNaam` varchar(30) NOT NULL,
  `proriteit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `klant`
--

CREATE TABLE `klant` (
  `klantId` int(10) NOT NULL,
  `klantAchternaam` varchar(30) NOT NULL,
  `klantNaam` varchar(30) NOT NULL,
  `klantTel` varchar(15) NOT NULL,
  `klantAdres` varchar(50) NOT NULL,
  `klantPostc` varchar(30) NOT NULL,
  `klantStad` varchar(30) NOT NULL,
  `klantEmail` varchar(50) NOT NULL,
  `instantieId` int(10) NOT NULL,
  `locatieId` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `klant`
--

INSERT INTO `klant` (`klantId`, `klantAchternaam`, `klantNaam`, `klantTel`, `klantAdres`, `klantPostc`, `klantStad`, `klantEmail`, `instantieId`, `locatieId`) VALUES
(1, 'Mijnkipema', 'Jasper', '0620532107', 'vanderspekstraat 20', '1111 BB', 'Baarn', 'jaspermijnkipema@gmail.com', 0, 0),
(2, 'Vanderspek', 'Djoey', '0620532107', 'gabberstraat 20', '1111 BB', 'Baarn', 'rainbowhighinthesky@gmail.com', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locatie`
--

CREATE TABLE `locatie` (
  `locatieId` int(10) NOT NULL,
  `locOmschrijving` varchar(30) NOT NULL,
  `vestigingId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `oplossingen`
--

CREATE TABLE `oplossingen` (
  `oplossingId` int(10) NOT NULL,
  `definitief` tinyint(1) NOT NULL,
  `oplossOmschrijving` text NOT NULL,
  `datumFix` date NOT NULL,
  `accountNr` int(10) NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `oplossingen`
--

INSERT INTO `oplossingen` (`oplossingId`, `definitief`, `oplossOmschrijving`, `datumFix`, `accountNr`, `ticketId`) VALUES
(1, 1, '...', '2017-01-11', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `protocolSettings`
--

CREATE TABLE `protocolSettings` (
  `dagenNaVerlopen` int(10) NOT NULL,
  `maxXTerug` int(10) NOT NULL,
  `gebruikerDNActief` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `schoolKlassen`
--

CREATE TABLE `schoolKlassen` (
  `schoolKlasId` int(11) NOT NULL,
  `schoolKlasCode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subCategorie`
--

CREATE TABLE `subCategorie` (
  `subCategorieId` int(10) NOT NULL,
  `subCatomschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `terugsturing`
--

CREATE TABLE `terugsturing` (
  `terugstuurId` int(10) NOT NULL,
  `vanLijn` int(10) NOT NULL,
  `naarLijn` int(10) NOT NULL,
  `opmerking` text NOT NULL,
  `accountNr` int(10) NOT NULL,
  `datum` date NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketId` int(10) NOT NULL,
  `inBehandeling` tinyint(1) NOT NULL,
  `probleem` text NOT NULL,
  `trefwoorden` text NOT NULL,
  `prioriteit` int(10) NOT NULL,
  `aantalXterug` int(10) NOT NULL,
  `terugstuurLock` tinyint(1) NOT NULL,
  `lijnNr` int(10) NOT NULL,
  `datumAanmaak` date NOT NULL,
  `nogBellen` tinyint(1) NOT NULL,
  `log` text,
  `streefdatum` date DEFAULT NULL,
  `klantTevreden` tinyint(1) NOT NULL,
  `fstAccountNr` int(10) NOT NULL,
  `aangewAccountNr` int(10) NOT NULL,
  `klantId` int(10) NOT NULL,
  `categorieId` int(10) NOT NULL,
  `binnenkomstId` int(10) NOT NULL,
  `vVLaptopTypeId` int(10) NOT NULL,
  `besturingssysteemId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketId`, `inBehandeling`, `probleem`, `trefwoorden`, `prioriteit`, `aantalXterug`, `terugstuurLock`, `lijnNr`, `datumAanmaak`, `nogBellen`, `log`, `streefdatum`, `klantTevreden`, `fstAccountNr`, `aangewAccountNr`, `klantId`, `categorieId`, `binnenkomstId`, `vVLaptopTypeId`, `besturingssysteemId`) VALUES
(1, 1, 'Grafwindows werkt voor geen ene meter', 'kut,windows', 1, 0, 0, 1, '2016-12-31', 0, '0', '2018-06-30', 0, 1, 0, 1, 0, 0, 0, 0),
(2, 1, 'Koffieautomaat werkt niet', 'koffie,kutzooi', 1, 0, 0, 1, '2017-01-01', 0, NULL, '2020-06-01', 0, 1, 0, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `veelVoorkomendelaptopMerken`
--

CREATE TABLE `veelVoorkomendelaptopMerken` (
  `vVLaptopMerkId` int(10) NOT NULL,
  `vVLaptopMerkOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `veelVoorkomendeLaptopTypes`
--

CREATE TABLE `veelVoorkomendeLaptopTypes` (
  `vVLaptopTypeId` int(10) NOT NULL,
  `vVLaptopTypeOm` text NOT NULL,
  `vVLaptopMerkId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vestigingen`
--

CREATE TABLE `vestigingen` (
  `vestigingId` int(10) NOT NULL,
  `vesOmschrijving` varchar(50) NOT NULL,
  `afdeling` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountNr`);

--
-- Indexes for table `besturingssysteem`
--
ALTER TABLE `besturingssysteem`
  ADD PRIMARY KEY (`besturingssysteemId`);

--
-- Indexes for table `binnenkomstType`
--
ALTER TABLE `binnenkomstType`
  ADD PRIMARY KEY (`binnenkomstId`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorieId`);

--
-- Indexes for table `commentaar`
--
ALTER TABLE `commentaar`
  ADD PRIMARY KEY (`commentaarId`);

--
-- Indexes for table `doorsturing`
--
ALTER TABLE `doorsturing`
  ADD PRIMARY KEY (`doorstuurId`);

--
-- Indexes for table `instantie`
--
ALTER TABLE `instantie`
  ADD PRIMARY KEY (`instantieId`);

--
-- Indexes for table `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantId`);

--
-- Indexes for table `locatie`
--
ALTER TABLE `locatie`
  ADD PRIMARY KEY (`locatieId`);

--
-- Indexes for table `oplossingen`
--
ALTER TABLE `oplossingen`
  ADD PRIMARY KEY (`oplossingId`);

--
-- Indexes for table `schoolKlassen`
--
ALTER TABLE `schoolKlassen`
  ADD PRIMARY KEY (`schoolKlasId`);

--
-- Indexes for table `subCategorie`
--
ALTER TABLE `subCategorie`
  ADD PRIMARY KEY (`subCategorieId`);

--
-- Indexes for table `terugsturing`
--
ALTER TABLE `terugsturing`
  ADD PRIMARY KEY (`terugstuurId`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketId`);

--
-- Indexes for table `veelVoorkomendelaptopMerken`
--
ALTER TABLE `veelVoorkomendelaptopMerken`
  ADD PRIMARY KEY (`vVLaptopMerkId`);

--
-- Indexes for table `veelVoorkomendeLaptopTypes`
--
ALTER TABLE `veelVoorkomendeLaptopTypes`
  ADD PRIMARY KEY (`vVLaptopTypeId`);

--
-- Indexes for table `vestigingen`
--
ALTER TABLE `vestigingen`
  ADD PRIMARY KEY (`vestigingId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountNr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `besturingssysteem`
--
ALTER TABLE `besturingssysteem`
  MODIFY `besturingssysteemId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `binnenkomstType`
--
ALTER TABLE `binnenkomstType`
  MODIFY `binnenkomstId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `commentaar`
--
ALTER TABLE `commentaar`
  MODIFY `commentaarId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `doorsturing`
--
ALTER TABLE `doorsturing`
  MODIFY `doorstuurId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `instantie`
--
ALTER TABLE `instantie`
  MODIFY `instantieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `klant`
--
ALTER TABLE `klant`
  MODIFY `klantId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `locatie`
--
ALTER TABLE `locatie`
  MODIFY `locatieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oplossingen`
--
ALTER TABLE `oplossingen`
  MODIFY `oplossingId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `schoolKlassen`
--
ALTER TABLE `schoolKlassen`
  MODIFY `schoolKlasId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subCategorie`
--
ALTER TABLE `subCategorie`
  MODIFY `subCategorieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terugsturing`
--
ALTER TABLE `terugsturing`
  MODIFY `terugstuurId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `veelVoorkomendelaptopMerken`
--
ALTER TABLE `veelVoorkomendelaptopMerken`
  MODIFY `vVLaptopMerkId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `veelVoorkomendeLaptopTypes`
--
ALTER TABLE `veelVoorkomendeLaptopTypes`
  MODIFY `vVLaptopTypeId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `vestigingen`
--
ALTER TABLE `vestigingen`
  MODIFY `vestigingId` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
