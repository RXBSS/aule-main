CREATE TABLE `bestellungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `status_id` int(11) NOT NULL,
    `lieferant_id` int(11) NOT NULL,
    `ersteller_id` int(11) NOT NULL,
    `erstell_datum` datetime DEFAULT NULL,
    `bestell_art` int(11) DEFAULT NULL,
    `bestell_datum` datetime DEFAULT NULL,
    `besteller_id` int(11) DEFAULT NULL,
    `bestell_email` varchar(254) DEFAULT NULL,
    `liefertermin` date DEFAULT NULL,
    `direktlieferung` int(11) DEFAULT NULL,
    `text` text DEFAULT NULL,   
    `dokument` int(11) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
