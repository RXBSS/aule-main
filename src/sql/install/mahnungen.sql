CREATE TABLE `mahnungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `datum` int(11) NOT NULL,
    `adresse_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;