CREATE TABLE `vertraege_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `vertrags_id` int(11) NULL DEFAULT NULL COMMENT 'Vetrags ID', 
    `ident_id` int(11) NULL DEFAULT NULL COMMENT 'Artikel ID', 
    `beschreibung` varchar(254) NULL DEFAULT NULL,
    `pauschale` decimal(10,2) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;