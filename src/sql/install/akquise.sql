CREATE TABLE `akquise` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bearbeiter_id` int(11) NOT NULL COMMENT 'Mitarbeiter ID',
    `ersteller_id` int(11) DEFAULT NULL,
    `aktion_id` int(11) DEFAULT NULL COMMENT 'Akquise Aktion ID',
    `adressen_id` int(11) NOT NULL COMMENT 'Adressen ID',
    `zeitstempel` datetime DEFAULT current_timestamp(),
    `wiedervorlage` datetime DEFAULT NULL,
    `kundentermin` datetime DEFAULT NULL,
    `status` int(11) DEFAULT 0,
    `ablehnungsgrund_id` varchar(254) DEFAULT NULL,
    `ablehnungsgrund_beschreibung` varchar(512) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;