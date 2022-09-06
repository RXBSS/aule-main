--
-- Create User Table
--
CREATE TABLE `_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vorname` varchar(254) DEFAULT NULL,
  `nachname` varchar(254) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL,
  `passwort` varchar(254) DEFAULT NULL,
  `gesperrt` int(1) DEFAULT 0 NOT NULL,
  `passwort_reset` varchar(254) DEFAULT NULL,
  `einstellungen` TEXT DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
