CREATE TABLE `angebote_kontakte` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `angebot_id` int(11) NOT NULL,
    `kontakt_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;