CREATE TABLE `tickets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `titel` varchar(254) NOT NULL,
    `erstellt` datetime NOT NULL,
    `status_id` int(11) NOT NULL,
    `ersteller_id` int(11) DEFAULT NULL,
    `verantwortlicher_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
