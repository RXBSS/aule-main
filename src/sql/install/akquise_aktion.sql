CREATE TABLE `akquise_aktionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(254) NOT NULL,  
    `zeitstempel` datetime DEFAULT NULL,
    `ersteller_id` int(11) DEFAULT NULL,
    `entwurf` int(11) NOT NULL DEFAULT 1,
    `wiedervorlage_nach` int(11) DEFAULT NULL COMMENT 'Anzahl Tage',
    `standard_meilensteine` int(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;