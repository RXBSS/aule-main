CREATE TABLE `kassenbuch` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(100) DEFAULT NULL,
    `datum` date DEFAULT NULL,
    `betrag` decimal(10, 2) DEFAULT NULL,
    `konto` varchar(20) DEFAULT NULL,
    `uebertragen` int(11) NOT NULL,
    `insert_by` int(11) DEFAULT NULL,
    `insert_date` datetime DEFAULT NULL,
    `update_by` int(11) DEFAULT NULL,
    `update_date` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8;