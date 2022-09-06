CREATE TABLE `artikel_in_modell` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id` int(11) NOT NULL,
    `modell_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
