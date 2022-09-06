CREATE TABLE `angebote` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `status_id` int(11) NOT NULL,
    `lieferanschrift_id` int(11) DEFAULT NULL,
    `rechnungsanschrift_id` int(11) DEFAULT NULL,
    `besteller_id` int(11) NOT NULL,
    `ersteller_id` int(11) NOT NULL,
    `erstellt_datum` datetime NOT NULL,
    `bearbeiter_id` int(11) NOT NULL,
    `liefertermin` date DEFAULT NULL,
    `kostenstelle_id` int(11) DEFAULT NULL,
    `zahlungsbedingung_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;