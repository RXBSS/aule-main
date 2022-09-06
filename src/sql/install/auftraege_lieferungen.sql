CREATE TABLE `auftraege_lieferungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `auftrag_id` int(11) NOT NULL,
    `zeitstempel` datetime NOT NULL,
    `status_id` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

