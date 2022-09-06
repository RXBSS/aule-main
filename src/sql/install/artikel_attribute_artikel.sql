CREATE TABLE `artikel_attribute_artikel` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id` int(11) NOT NULL,
    `attribute_id` int(11) NOT NULL,
    `value` varchar(254) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;