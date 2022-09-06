CREATE TABLE `software` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `hersteller_id` int(11) NOT NULL,
    `bezeichnung` varchar(254) NOT NULL,
    `beschreibung` text DEFAULT NULL,
    `firmware` int(11) NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;