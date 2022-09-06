CREATE TABLE `bestellungen_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `reihenfolge` int(11) DEFAULT NULL,
    `bestellung_id` int(11) DEFAULT NULL,
    `artikel_id` int(11) DEFAULT NULL,
    `bestellmenge` decimal(18, 6) NOT NULL DEFAULT '0',
    `liefermenge` decimal(18, 6) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;