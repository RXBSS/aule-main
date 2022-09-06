CREATE TABLE `rechnungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datum` datetime NOT NULL,
    `adresse_id` int(11) NOT NULL,
    `status_id` int(11) NOT NULL,
    `herkunft` varchar(10) NOT NULL COMMENT 'auftrag, vertrag, ticket',
    `referenz_id` int(11) NOT NULL,
    `netto` decimal(18, 6) NOT NULL,
    `mwst` decimal(18, 6) NOT NULL,
    `mwst1_satz` decimal(18, 1) NOT NULL,
    `mwst1_betrag` decimal(18, 6) NOT NULL,
    `mwst2_satz` decimal(18, 1) NULL,
    `mwst2_betrag` decimal(18, 6) NULL,
    `mwst3_satz` decimal(18, 1) NULL,
    `mwst3_betrag` decimal(18, 6) NULL,
    `mahngebuehr` decimal(18, 6) NOT NULL,
    `gezahlt` decimal(18, 6) NOT NULL DEFAULT 0.000000,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;