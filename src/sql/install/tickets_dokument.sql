CREATE TABLE `tickets_dokument` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ticket_id` int(11) DEFAULT NULL,
    `file` varchar(512) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;