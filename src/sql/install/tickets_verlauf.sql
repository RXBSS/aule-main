CREATE TABLE `tickets_verlauf` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ticket_id` int(11) NOT NULL,
    `art` varchar(254) COLLATE latin1_german2_ci DEFAULT NULL,
    `event` varchar(254) COLLATE latin1_german2_ci DEFAULT NULL,
    `person_id` varchar(11) COLLATE latin1_german2_ci DEFAULT NULL,
    `text` text COLLATE latin1_german2_ci,
    `status` int(11) DEFAULT NULL,
    `status_vorher` int(11) DEFAULT NULL,
    `zeitstempel` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;