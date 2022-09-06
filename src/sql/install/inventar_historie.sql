CREATE TABLE `inventar_historie` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `inventar_id` int(11) DEFAULT NULL COMMENT 'Inventar ID',
    `nutzer_id` int(11) DEFAULT NULL COMMENT 'Mitarbeiter ID',
    `bearbeiter_id` int(11) DEFAULT NULL COMMENT 'Mitarbeiter ID -- Wer den Kommentar erstellt hat',
    `timestamp` datetime DEFAULT NULL,
    `nutzungsdauer` date DEFAULT NULL,
    `nutzungsgrund` text DEFAULT NULL,
    `nutzungsstandort` varchar(512) DEFAULT NULL COMMENT 'Wo liegt das Objekt',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;