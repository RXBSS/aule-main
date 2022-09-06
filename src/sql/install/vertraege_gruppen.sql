CREATE TABLE `vertraege_gruppen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(512) DEFAULT NULL,
    `reihenfolge` int(11) DEFAULT NULL,
    `version` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

