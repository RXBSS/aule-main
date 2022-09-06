CREATE TABLE `vertraege_klauseln_vorlagen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `vorlagen_id` int(11) DEFAULT NULL COMMENT 'ID der Art',
    `klausel_id` int(11) DEFAULT NULL COMMENT 'ID der Klausel',
    `geloescht` int(11) NOT NULL DEFAULT 0 COMMENT 'Als Gelöscht Markieren',
    PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 10 DEFAULT CHARSET = utf8mb4;