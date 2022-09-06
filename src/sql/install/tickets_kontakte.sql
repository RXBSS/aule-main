CREATE TABLE `tickets_kontakte` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ticket_id` int(11) DEFAULT NULL,
    `kontakte_id` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

