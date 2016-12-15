-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 15 dec 2016 om 13:59
-- Serverversie: 10.1.19-MariaDB
-- PHP-versie: 7.0.13

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
-- Tabelstructuur voor tabel `account`
--

CREATE TABLE `account` (
  `accountNr` int(10) NOT NULL,
  `lijnNr` int(10) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `accountHouder` varchar(50) NOT NULL,
  `schoolKlasId` varchar(30) NOT NULL,
  `naam` varchar(30) NOT NULL,
  `achterNaam` varchar(30) NOT NULL,
  `actief` tinyint(1) NOT NULL,
  `magInloggen` tinyint(1) NOT NULL,
  `vestigingId` int(10) NOT NULL,
  `wachtwoord` varchar(50) NOT NULL,
  `klantId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `besturingssysteem`
--

CREATE TABLE `besturingssysteem` (
  `besturingssysteemId` int(10) NOT NULL,
  `besturingssysteemOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `binnenkomstType`
--

CREATE TABLE `binnenkomstType` (
  `binnenkomstId` int(10) NOT NULL,
  `binnenkomstTypeOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categorie`
--

CREATE TABLE `categorie` (
  `categorieId` int(10) NOT NULL,
  `catOmschrijving` text NOT NULL,
  `subCategorieId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `commentaar`
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
-- Tabelstructuur voor tabel `doorsluisKoppeling`
--

CREATE TABLE `doorsluisKoppeling` (
  `doosluisKoppelingId` int(10) NOT NULL,
  `datumTerugstuur` date NOT NULL,
  `doorstuurId` int(10) NOT NULL,
  `terugstuurId` int(10) NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `Doorsturing`
--

CREATE TABLE `Doorsturing` (
  `doorstuurId` int(10) NOT NULL,
  `lijn2-3` tinyint(1) NOT NULL,
  `opmerking` text NOT NULL,
  `accountNr` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `instantie`
--

CREATE TABLE `instantie` (
  `instantieId` int(10) NOT NULL,
  `instantieNaam` varchar(30) NOT NULL,
  `proriteit` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `klant`
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

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locatie`
--

CREATE TABLE `locatie` (
  `locatieId` int(10) NOT NULL,
  `locOmschrijving` varchar(30) NOT NULL,
  `vestigingId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oplossingen`
--

CREATE TABLE `oplossingen` (
  `oplossingId` int(10) NOT NULL,
  `definitief` tinyint(1) NOT NULL,
  `oplossOmschrijving` text NOT NULL,
  `datumFix` date NOT NULL,
  `accountNr` int(10) NOT NULL,
  `ticketId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `protocolSettings`
--

CREATE TABLE `protocolSettings` (
  `dagenNaVerlopen` int(10) NOT NULL,
  `maxXTerug` int(10) NOT NULL,
  `gebruikerDNActief` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schoolKlassen`
--

CREATE TABLE `schoolKlassen` (
  `schoolKlasId` int(11) NOT NULL,
  `schoolKlasOmschrijvnig` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subCategorie`
--

CREATE TABLE `subCategorie` (
  `subCategorieId` int(10) NOT NULL,
  `subCatomschrijving` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `terugsturing`
--

CREATE TABLE `terugsturing` (
  `terugstuurId` int(10) NOT NULL,
  `lijn2_1` tinyint(1) NOT NULL,
  `lijn3_2` tinyint(1) NOT NULL,
  `opmerking` text NOT NULL,
  `accountNr` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `ticket`
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
  `verlopen` tinyint(1) NOT NULL,
  `streefdatum` date DEFAULT NULL,
  `klantTevreden` tinyint(1) NOT NULL,
  `fstAccountNr` int(10) NOT NULL,
  `aangewAccountNr` int(10) NOT NULL,
  `klantId` int(10) NOT NULL,
  `categorieId` int(10) NOT NULL,
  `commentaarId` int(10) NOT NULL,
  `oplossingId` int(10) NOT NULL,
  `binnenkomstId` int(10) NOT NULL,
  `vVLaptopMerkId` int(10) NOT NULL,
  `vVLaptopTypeId` int(10) NOT NULL,
  `besturingssysteemId` int(10) NOT NULL,
  `doosluisKoppelingId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `veelVoorkomendelaptopMerken`
--

CREATE TABLE `veelVoorkomendelaptopMerken` (
  `vVLaptopMerkId` int(10) NOT NULL,
  `vVLaptopMerkOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `veelVoorkomendeLaptopTypes`
--

CREATE TABLE `veelVoorkomendeLaptopTypes` (
  `vVLaptopTypeId` int(10) NOT NULL,
  `vVLaptopTypeOm` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vestigingen`
--

CREATE TABLE `vestigingen` (
  `vestigingId` int(10) NOT NULL,
  `vesOmschrijving` varchar(50) NOT NULL,
  `afdeling` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountNr`);

--
-- Indexen voor tabel `besturingssysteem`
--
ALTER TABLE `besturingssysteem`
  ADD PRIMARY KEY (`besturingssysteemId`);

--
-- Indexen voor tabel `binnenkomstType`
--
ALTER TABLE `binnenkomstType`
  ADD PRIMARY KEY (`binnenkomstId`);

--
-- Indexen voor tabel `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorieId`);

--
-- Indexen voor tabel `commentaar`
--
ALTER TABLE `commentaar`
  ADD PRIMARY KEY (`commentaarId`);

--
-- Indexen voor tabel `doorsluisKoppeling`
--
ALTER TABLE `doorsluisKoppeling`
  ADD PRIMARY KEY (`doosluisKoppelingId`);

--
-- Indexen voor tabel `Doorsturing`
--
ALTER TABLE `Doorsturing`
  ADD PRIMARY KEY (`doorstuurId`);

--
-- Indexen voor tabel `instantie`
--
ALTER TABLE `instantie`
  ADD PRIMARY KEY (`instantieId`);

--
-- Indexen voor tabel `klant`
--
ALTER TABLE `klant`
  ADD PRIMARY KEY (`klantId`);

--
-- Indexen voor tabel `locatie`
--
ALTER TABLE `locatie`
  ADD PRIMARY KEY (`locatieId`);

--
-- Indexen voor tabel `oplossingen`
--
ALTER TABLE `oplossingen`
  ADD PRIMARY KEY (`oplossingId`);

--
-- Indexen voor tabel `schoolKlassen`
--
ALTER TABLE `schoolKlassen`
  ADD PRIMARY KEY (`schoolKlasId`);

--
-- Indexen voor tabel `subCategorie`
--
ALTER TABLE `subCategorie`
  ADD PRIMARY KEY (`subCategorieId`);

--
-- Indexen voor tabel `terugsturing`
--
ALTER TABLE `terugsturing`
  ADD PRIMARY KEY (`terugstuurId`);

--
-- Indexen voor tabel `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketId`);

--
-- Indexen voor tabel `veelVoorkomendelaptopMerken`
--
ALTER TABLE `veelVoorkomendelaptopMerken`
  ADD PRIMARY KEY (`vVLaptopMerkId`);

--
-- Indexen voor tabel `vestigingen`
--
ALTER TABLE `vestigingen`
  ADD PRIMARY KEY (`vestigingId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `besturingssysteem`
--
ALTER TABLE `besturingssysteem`
  MODIFY `besturingssysteemId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `binnenkomstType`
--
ALTER TABLE `binnenkomstType`
  MODIFY `binnenkomstId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `commentaar`
--
ALTER TABLE `commentaar`
  MODIFY `commentaarId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `doorsluisKoppeling`
--
ALTER TABLE `doorsluisKoppeling`
  MODIFY `doosluisKoppelingId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `Doorsturing`
--
ALTER TABLE `Doorsturing`
  MODIFY `doorstuurId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `locatie`
--
ALTER TABLE `locatie`
  MODIFY `locatieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `oplossingen`
--
ALTER TABLE `oplossingen`
  MODIFY `oplossingId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `schoolKlassen`
--
ALTER TABLE `schoolKlassen`
  MODIFY `schoolKlasId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `subCategorie`
--
ALTER TABLE `subCategorie`
  MODIFY `subCategorieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `terugsturing`
--
ALTER TABLE `terugsturing`
  MODIFY `terugstuurId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `veelVoorkomendelaptopMerken`
--
ALTER TABLE `veelVoorkomendelaptopMerken`
  MODIFY `vVLaptopMerkId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `vestigingen`
--
ALTER TABLE `vestigingen`
  MODIFY `vestigingId` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
