CREATE TABLE `example_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `reihenfolge` int(11) DEFAULT NULL,
    `referenz_id` int(11) DEFAULT NULL,
    `artikel_id` int(11) DEFAULT NULL,
    `menge` decimal(18, 6) NOT NULL DEFAULT '0',
    `ek` decimal(18, 6) NOT NULL DEFAULT '0',
    `vk` decimal(18, 6) NOT NULL DEFAULT '0',
    `steuer` decimal(18, 1) NOT NULL DEFAULT '0',
    `rabatt_betrag` decimal(18, 6) NOT NULL DEFAULT '0',
    `rabatt_prozent` decimal(18, 6) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;

INSERT INTO `example_positionen` (`id`, `reihenfolge`, `referenz_id`, `artikel_id`, `menge`, `ek`, `vk`, `steuer`, `rabatt_betrag`, `rabatt_prozent`) VALUES
(1, 1, 100000, 100015, '1.000000', '0.000000', '0.000000', '0.0', '0.000000', '0.000000');