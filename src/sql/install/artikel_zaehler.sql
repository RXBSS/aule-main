CREATE TABLE `artikel_zaehler` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `artikel_id` int(11) NOT NULL,
    `zaehler_id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;