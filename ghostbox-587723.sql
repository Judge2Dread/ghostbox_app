-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 22. Jan 2018 um 14:32
-- Server-Version: 10.1.28-MariaDB
-- PHP-Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ghostbox_585770`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raw_files`
--

CREATE TABLE `raw_files` (
  `ID` int(11) NOT NULL,
  `FILEID` varchar(50) NOT NULL,
  `FILENAME` varchar(50) DEFAULT NULL,
  `FILEFORMATE` varchar(50) NOT NULL,
  `FILESIZE` varchar(50) NOT NULL,
  `PUBLIC` tinyint(1) NOT NULL,
  `SAVE_LOCAL` tinyint(1) NOT NULL,
  `SAVE_CLOUD` tinyint(1) NOT NULL,
  `_CREATEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_UPDATEDATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raw_file_tags`
--

CREATE TABLE `raw_file_tags` (
  `FILEID` int(11) NOT NULL,
  `TAG` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raw_user`
--

CREATE TABLE `raw_user` (
  `ID` int(11) NOT NULL,
  `FIRSTNAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(50) DEFAULT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `_CREATEDATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `_UPDATEDATE` datetime DEFAULT NULL,
  `_DELETEDATE` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `raw_user`
--

INSERT INTO `raw_user` (`ID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `_CREATEDATE`, `_UPDATEDATE`, `_DELETEDATE`) VALUES
(1, 'Patrick', 'Richter', 'test@test.de', '123', '2018-01-12 12:48:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `raw_user_settings`
--

CREATE TABLE `raw_user_settings` (
  `ID` int(11) NOT NULL,
  `DROPBOXUSERNAME` varchar(50) DEFAULT NULL,
  `DROPBOXPASSWORD` varchar(50) DEFAULT NULL,
  `SAVELOCATION_LOCAL` varchar(50) NOT NULL,
  `SAVELOCATION_CLOUD` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `raw_files`
--
ALTER TABLE `raw_files`
  ADD PRIMARY KEY (`FILEID`),
  ADD KEY `ID` (`ID`);

--
-- Indizes für die Tabelle `raw_user`
--
ALTER TABLE `raw_user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `raw_user`
--
ALTER TABLE `raw_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `raw_files`
--
ALTER TABLE `raw_files`
  ADD CONSTRAINT `ID` FOREIGN KEY (`ID`) REFERENCES `raw_user` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
