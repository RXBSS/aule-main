CREATE TABLE `vertraege_klauseln` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mitarbeiter_id` int(11) DEFAULT NULL COMMENT 'Wer die Klausel erstellt hat',
  `timestamp` datetime DEFAULT NULL COMMENT 'Wann die Klausel angelegt wurde',
  `gruppen_id` int(11) DEFAULT NULL,
  `klausel_referenz_id` int(11) DEFAULT NULL COMMENT 'Bei Versionen zeigt es auf eine alte Klausel',
  `status_id` int(11) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `standard` int(11) DEFAULT 0,
  `version` int(11) DEFAULT NULL,
  `auschluss_klassen` int(11) DEFAULT NULL COMMENT 'Selbe Gruppierung heben sich auf',
  `geloescht` int(11) DEFAULT 0 COMMENT 'Als Gelöscht Markieren',
  PRIMARY KEY (`id`)
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;