CREATE TABLE `vertraege_positionen_zaehler` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `positionen_id` int(11) NULL DEFAULT NULL,
    `zaehler_id` int(11) NULL DEFAULT NULL,
    `pauschale` decimal(10,2) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;