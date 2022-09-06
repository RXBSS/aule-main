CREATE TABLE `_einstellungen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(254) COLLATE latin1_german2_ci NOT NULL,
    `beschreibung` text COLLATE latin1_german2_ci,
    `berechtigung` int(11) NOT NULL DEFAULT '0',
    `global` int(11) NOT NULL DEFAULT '0',
    `adminWert` text COLLATE latin1_german2_ci,
    `binLength` int(11) DEFAULT NULL,
    `standard` text COLLATE latin1_german2_ci,
    `wert` text COLLATE latin1_german2_ci,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;