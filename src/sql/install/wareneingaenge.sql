CREATE TABLE `wareneingaenge` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `status_id` int(11) DEFAULT 0,
    `lieferant_id` int(11) DEFAULT NULL,
    `liefernummer` varchar(254) DEFAULT NULL,
    `lieferdatum` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;