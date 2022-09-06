CREATE TABLE `vertraege_vorlagen` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `bezeichnung` varchar(512) DEFAULT NULL,
    `beschreibung` text DEFAULT NULL,
    `mitarbeiter_id` int(11) DEFAULT NULL COMMENT 'Wer die Klausel erstellt hat',
    `timestamp` datetime DEFAULT NULL COMMENT 'Wann die Klausel angelegt wurde',
    `referenz_id` int(11) DEFAULT NULL,
    `status_id` int(11) DEFAULT NULL,
    `version` int(11) DEFAULT NULL,
    `laufzeit` int(11) DEFAULT NULL,
    `laufzeit_interval` varchar(11) DEFAULT NULL,
    `verlaengerung_laufzeit` int(11) DEFAULT NULL,
    `verlaengerung_laufzeit_interval` varchar(11) DEFAULT NULL,
    `kuendigungsfrist_laufzeit` int(11) DEFAULT NULL,
    `kuendigungsfrist_laufzeit_interval` varchar(11) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;