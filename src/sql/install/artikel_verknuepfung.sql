CREATE TABLE `artikel_verknuepfungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id1` int(11) NOT NULL,
    `artikel_id2` int(11) NOT NULL,
    `art_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;