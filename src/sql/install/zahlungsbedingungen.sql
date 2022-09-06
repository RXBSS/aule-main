CREATE TABLE `zahlungsbedingungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(254) NOT NULL,
    `text` text DEFAULT NULL,
    `abbuchung` int(11) NOT NULL DEFAULT 0,
    `tage` int(11) NOT NULL DEFAULT 0,
    `skonto_prozent` int(11) NOT NULL DEFAULT 0,
    `skonto_tage` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;