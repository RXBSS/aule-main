CREATE TABLE `zaehlerstaende_anleitungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(254) DEFAULT NULL,
    `hersteller_id` int(11) DEFAULT NULL,
    `inhalt` text DEFAULT NULL,
    `status_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;