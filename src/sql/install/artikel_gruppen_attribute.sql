-- Create
CREATE TABLE `artikel_gruppen_attribute` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikelgruppe_id` int(11) NOT NULL,
    `attribute_id` int(11) NOT NULL,
    `pflichtfeld` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- Data
INSERT INTO `artikel_gruppen_attribute` (`id`, `artikelgruppe_id`, `attribute_id`, `pflichtfeld`) VALUES
(1, 1, 1, NULL),
(2, 1, 2, NULL),
(3, 1, 3, NULL),
(4, 2, 1, NULL),
(5, 2, 2, NULL),
(6, 2, 3, NULL);