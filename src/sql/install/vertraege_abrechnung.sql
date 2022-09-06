CREATE TABLE `vertraege_abrechnung` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `vertrags_id` int(11) DEFAULT NULL,
    `kosten` decimal(10, 2) DEFAULT NULL,
    `faelligkeit` date DEFAULT NULL,
    `abrechnungsart` varchar(11) DEFAULT NULL COMMENT 'Vertragsart Pauschale | Zähler',
    `abgerechnet_id` int(11) DEFAULT NULL COMMENT 'Id der Rechnungsnummer, NULL = nicht abgerechnet',
    `status_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;