CREATE TABLE `software_versionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `software_id` int(11) NOT NULL,
    `versionsnummer` varchar(254) NOT NULL,
    `releasedatum` date DEFAULT NULL,
    `major` int(11) NOT NULL DEFAULT 0,
    `art_id` int(11) DEFAULT 1 COMMENT 'Produktiv, Beta, Special, ...',
    `sperre` int(11) NOT NULL DEFAULT 0,
    `anmerkungen` text DEFAULT NULL,
    `releasenotes` text DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

