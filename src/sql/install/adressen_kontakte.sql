CREATE TABLE `adressen_kontakte` (
    `id` INT(11) NOT NULL AUTO_INCREMENT ,
    `adressen_id` int(11) NOT NULL,
    `kontakte_id` int(1) NOT NULL,
    `adminrechte` int(1) NOT NULL DEFAULT 0,
    `abteilung` varchar(254) DEFAULT NULL,
    `funktion` varchar(254) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;