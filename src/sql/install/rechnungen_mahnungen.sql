CREATE TABLE `rechnungen_mahnungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `rechnung_id` int(11) NOT NULL,
    `mahnung_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;