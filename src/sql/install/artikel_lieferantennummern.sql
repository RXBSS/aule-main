CREATE TABLE `artikel_lieferantennummern` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nummer` varchar(254) NOT NULL,
    `artikel_id` int(11) NOT NULL,
    `lieferant_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;