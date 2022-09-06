CREATE TABLE `akquise_positionen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `akquise_id` int(11) NOT NULL,
    `zeitstempel` datetime DEFAULT current_timestamp(),
    `bearbeiter_id` int(11) DEFAULT NULL COMMENT 'Der den Kommentar Verfasst hat',
    `bearbeiter_wechsel` int(11) DEFAULT NULL COMMENT 'Der Aktuelle Bearbeiter der Akquise',
    `art` int(11) DEFAULT NULL,
    `text` text DEFAULT NULL,
    `wiedervorlage` datetime DEFAULT NULL,
    `kundentermin` datetime DEFAULT NULL,
    `meilenstein_id` int(11) NOT NULL DEFAULT 0,
    `ablehnungsgrund_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;