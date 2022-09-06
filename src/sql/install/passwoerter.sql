CREATE TABLE `passwoerter` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(254) NOT NULL,
    `benutzername` varchar(254) DEFAULT NULL,
    `passwort` varchar(254) DEFAULT NULL,
    `url` varchar(254) DEFAULT NULL,
    `beschreibung` text DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;