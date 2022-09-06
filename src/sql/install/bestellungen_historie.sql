CREATE TABLE `bestellungen_historie` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `identifier` varchar(254) COLLATE latin1_german2_ci DEFAULT NULL COMMENT 'Eindeutige Identifizieren des Events',
    `zeitstempel` datetime NOT NULL,
    `referenz_id` int(11) DEFAULT NULL,
    `referenz_id2` int(11) DEFAULT NULL,
    `referenz_id3` int(11) DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL COMMENT 'Der Benutzer der die Veränderung durchgeführt hat',
    `daten` text COLLATE latin1_german2_ci DEFAULT NULL COMMENT 'Weitere Daten, die hinterlegt werden sollen',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;