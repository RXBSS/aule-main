CREATE TABLE `artikel_bestand` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id` int(11) NOT NULL,
    `lager_id` int(11) NOT NULL,
    `bestand` decimal(18,6) NOT NULL DEFAULT 0,
    `kommission` decimal(18,6) NOT NULL DEFAULT 0,
    `bestellt` decimal(18,6) NOT NULL, 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;