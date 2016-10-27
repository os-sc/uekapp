USE umf_db;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `umf_db`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
  `index` int(11) NOT NULL,
  `question` varchar(45) NOT NULL,
  `answers` varchar(45) NOT NULL,
  `answercounts` int(11) NOT NULL,
  `public` bit(1) NOT NULL,
  `allowmulti` bit(1) NOT NULL,
  `checkdupes` bit(1) NOT NULL,
  `date` date NOT NULL,
  `creator` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `index` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hashedpw` varchar(250) NOT NULL,
  `regdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`index`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`index`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `polls`
--
ALTER TABLE `polls`
  MODIFY `index` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `index` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;