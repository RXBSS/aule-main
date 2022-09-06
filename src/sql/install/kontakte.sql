CREATE TABLE `kontakte` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `intern` int(11) DEFAULT 0,
    `geschlecht` varchar(1) DEFAULT NULL,
    `titel` varchar(254) DEFAULT NULL,
    `vorname` varchar(80) DEFAULT NULL,
    `nachname` varchar(80) DEFAULT NULL,
    `telefon` varchar(60) DEFAULT NULL,
    `telefax` varchar(60) DEFAULT NULL,
    `mobil` varchar(60) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `geburtstag` date DEFAULT NULL,
    `einstellungen` text DEFAULT NULL,
    `passwort` varchar(254) DEFAULT NULL,
    `kontosperre_grund` varchar(255) DEFAULT NULL,
    `akquise_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;