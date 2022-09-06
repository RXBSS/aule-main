CREATE TABLE `vertraege_klauseln_vertraege` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `vertraege_id` int(11) DEFAULT NULL,
    `vorlagen_id` int(11) DEFAULT NULL COMMENT 'ID der Art',
    `klausel_id` int(11) DEFAULT NULL,
    `geloescht` int(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;