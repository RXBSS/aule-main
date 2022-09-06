CREATE TABLE `artikel_bewegung` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `zeitstempel` datetime NOT NULL,
    `artikel_id` int(11) NOT NULL,
    `quelllager_id` int(11) NOT NULL,
    `ziellager_id` int(11) NULL,
    `ursprung` varchar(2) NOT NULL,
    `veraenderung` decimal(18,6) NOT NULL,
    `vorher` decimal(18,6) NOT NULL,
    `nachher` decimal(18,6) NOT NULL,
    `vorher2` decimal(18,6) NULL,
    `nachher2` decimal(18,6) NULL,
    `referenz_id` int(11) NOT NULL,
    `referenz_id2` int(11) NULL,
    `referenz_id3` int(11) NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;