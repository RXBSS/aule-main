CREATE TABLE `auftraege_lieferungen_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `lieferung_id` int(11) NOT NULL,
    `pos_id` int(11) NOT NULL,
    `menge` decimal(18,6) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;