-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Gegenereerd op: 14 jan 2017 om 20:20
-- Serverversie: 10.1.20-MariaDB
-- PHP-versie: 7.0.14

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
-- Gegevens worden geëxporteerd voor tabel `account`
--

INSERT INTO `account` (`accountNr`, `lijnNr`, `isAdmin`, `schoolKlasId`, `naam`, `achterNaam`, `actief`, `magInloggen`, `vestigingId`, `gebruikersNaam`, `wachtwoord`, `klantId`) VALUES
(1, 1, 0, '', 'Naomi', 'Berkelaar', 1, 1, 0, 'naomiberkelaar', 'test123', 0),
(2, 2, 1, '0', 'Jan', 'Modaal', 1, 1, 0, 'janmodaal', 'test124', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bedrijf`
--

CREATE TABLE `bedrijf` (
  `bedrijfsId` int(10) NOT NULL,
  `naam` varchar(20) NOT NULL,
  `website` text NOT NULL,
  `kvkNr` int(20) NOT NULL,
  `btwNr` int(20) NOT NULL,
  `adres` varchar(50) NOT NULL,
  `stad` varchar(30) NOT NULL,
  `postC` varchar(10) NOT NULL,
  `tel` varchar(15) NOT NULL
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
  `catOmschrijving` text NOT NULL
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

--
-- Gegevens worden geëxporteerd voor tabel `commentaar`
--

INSERT INTO `commentaar` (`commentaarId`, `commOmschrijving`, `typeCommentaar`, `datum`, `accountNr`, `ticketId`) VALUES
(1, 'commentaaromschrijving', '', '2017-01-12', 1, 2);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `doorsturing`
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

--
-- Gegevens worden geëxporteerd voor tabel `doorsturing`
--

INSERT INTO `doorsturing` (`doorstuurId`, `vanLijn`, `naarLijn`, `opmerking`, `accountNr`, `datum`, `ticketId`) VALUES
(10, 1, 2, 'Kan geen oplossing gevonden worden', 1, '2017-01-13', 2),
(11, 1, 2, 'Ticket kan op lijn 1 niet opgelosd worden', 1, '2017-01-13', 1),
(12, 2, 1, 'Gewoon een herinstallatie, geen lijn 2 taak.', 2, '2017-01-13', 1),
(13, 1, 2, 'Toch te lastig, hanglul!', 1, '2017-01-13', 1);

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
  `bedrijfsId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `klant`
--

INSERT INTO `klant` (`klantId`, `klantAchternaam`, `klantNaam`, `klantTel`, `klantAdres`, `klantPostc`, `klantStad`, `klantEmail`, `instantieId`, `bedrijfsId`) VALUES
(1, 'Mijnkipema', 'Jasper', '0620532107', 'vanderspekstraat 20', '1111 BB', 'Hilversum', 'jaspermijnkipema@gmail.com', 0, 0),
(2, 'Vanderspek', 'Djoey', '0620532107', 'gabberstraat 20', '1111 BB', 'Baarn', 'rainbowhighinthesky@gmail.com', 0, 0);

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

--
-- Gegevens worden geëxporteerd voor tabel `oplossingen`
--

INSERT INTO `oplossingen` (`oplossingId`, `definitief`, `oplossOmschrijving`, `datumFix`, `accountNr`, `ticketId`) VALUES
(1, 0, 'Oplossingstekst', '2017-01-11', 1, 2),
(2, 0, 'Tweede oplossing', '2017-01-13', 2, 2);

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
  `schoolKlasCode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `subCategorie`
--

CREATE TABLE `subCategorie` (
  `subCategorieId` int(10) NOT NULL,
  `subCatomschrijving` text NOT NULL,
  `categorieId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `terugsturing`
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
  `instantieId` int(10) DEFAULT NULL,
  `streefdatum` date DEFAULT NULL,
  `redenTeLaat` text,
  `klantTevreden` tinyint(1) NOT NULL,
  `fstAccountNr` int(10) NOT NULL,
  `aangewAccountNr` int(10) NOT NULL,
  `klantId` int(10) NOT NULL,
  `subCategorieId` int(10) NOT NULL,
  `binnenkomstId` int(10) NOT NULL,
  `vVLaptopTypeId` int(10) NOT NULL,
  `besturingssysteemId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `ticket`
--

INSERT INTO `ticket` (`ticketId`, `inBehandeling`, `probleem`, `trefwoorden`, `prioriteit`, `aantalXterug`, `terugstuurLock`, `lijnNr`, `datumAanmaak`, `nogBellen`, `instantieId`, `streefdatum`, `redenTeLaat`, `klantTevreden`, `fstAccountNr`, `aangewAccountNr`, `klantId`, `subCategorieId`, `binnenkomstId`, `vVLaptopTypeId`, `besturingssysteemId`) VALUES
(1, 1, 'Grafwindows werkt voor geen ene meter', 'kut,windows', 1, 0, 0, 2, '2016-12-31', 1, 0, '2015-06-30', 'Te weinig tijd op de afdeling', 0, 1, 0, 1, 0, 0, 0, 0),
(2, 1, 'Koffieautomaat werkt niet', 'koffie,kutzooi', 1, 0, 0, 1, '2017-01-01', 0, NULL, '2020-06-01', NULL, 0, 2, 0, 1, 0, 0, 0, 0);

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
  `vVLaptopTypeOm` text NOT NULL,
  `vVLaptopMerkId` int(10) NOT NULL
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
-- Indexen voor tabel `bedrijf`
--
ALTER TABLE `bedrijf`
  ADD PRIMARY KEY (`bedrijfsId`);

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
-- Indexen voor tabel `doorsturing`
--
ALTER TABLE `doorsturing`
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
-- Indexen voor tabel `veelVoorkomendeLaptopTypes`
--
ALTER TABLE `veelVoorkomendeLaptopTypes`
  ADD PRIMARY KEY (`vVLaptopTypeId`);

--
-- Indexen voor tabel `vestigingen`
--
ALTER TABLE `vestigingen`
  ADD PRIMARY KEY (`vestigingId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `account`
--
ALTER TABLE `account`
  MODIFY `accountNr` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `bedrijf`
--
ALTER TABLE `bedrijf`
  MODIFY `bedrijfsId` int(10) NOT NULL AUTO_INCREMENT;
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
  MODIFY `commentaarId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `doorsturing`
--
ALTER TABLE `doorsturing`
  MODIFY `doorstuurId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT voor een tabel `instantie`
--
ALTER TABLE `instantie`
  MODIFY `instantieId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `klant`
--
ALTER TABLE `klant`
  MODIFY `klantId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `oplossingen`
--
ALTER TABLE `oplossingen`
  MODIFY `oplossingId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- AUTO_INCREMENT voor een tabel `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `veelVoorkomendelaptopMerken`
--
ALTER TABLE `veelVoorkomendelaptopMerken`
  MODIFY `vVLaptopMerkId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `veelVoorkomendeLaptopTypes`
--
ALTER TABLE `veelVoorkomendeLaptopTypes`
  MODIFY `vVLaptopTypeId` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `vestigingen`
--
ALTER TABLE `vestigingen`
  MODIFY `vestigingId` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
