CREATE TABLE `wareneingaenge_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bestellung_id` int(11) NOT NULL,
    `lieferung_id` int(11) NOT NULL,
    `artikel_id` int(11) NOT NULL,
    `bestellmenge` decimal(18, 6) NOT NULL DEFAULT 0.000000,
    `liefermenge` decimal(18, 6) NOT NULL DEFAULT 0.000000,
    `seriennummer` varchar(254) NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;