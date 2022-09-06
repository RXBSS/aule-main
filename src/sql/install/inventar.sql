CREATE TABLE `inventar` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `kaufobjekt` varchar(254) DEFAULT NULL,
    `kaufperson_id` int(3) DEFAULT NULL COMMENT 'Mitarbeiter ID',
    `nutzer_id` int(3) DEFAULT NULL COMMENT 'Mitarbeiter ID - Nutzer/ Verleih an',
    `nutzungsdauer` date DEFAULT NULL,
    `nutzungsgrund` text DEFAULT NULL,
    `nutzungsstandort` varchar(512) DEFAULT NULL COMMENT 'Wo liegt das Objekt',
    `seriennummer` varchar(50) DEFAULT NULL,
    `kaufdatum` date DEFAULT NULL,
    `kaufpreis` decimal(10,2) DEFAULT NULL,
    `beschreibung` varchar(1016) DEFAULT NULL,
    `abschreibezeitraum` int(3) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;