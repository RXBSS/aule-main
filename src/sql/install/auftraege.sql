CREATE TABLE `auftraege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status_id` int(11) NOT NULL,
  `lieferanschrift_id` int(11) NULL,
  `rechnungsanschrift_id` int(11) NULL,
  `ersteller_id` int(11) NOT NULL,
  `erstellt_datum` datetime NOT NULL,
  `bearbeiter_id` int(11) NOT NULL,
  `angebot_id` int(11) DEFAULT NULL,
  `besteller_id` int(11) NOT NULL,
  `herkunft` varchar(254) COLLATE latin1_german2_ci DEFAULT NULL,
  `referenz` varchar(254) COLLATE latin1_german2_ci DEFAULT NULL,
  `liefertermin` date DEFAULT NULL,
  `kostenstelle_id` int(11) DEFAULT NULL,
  `zahlungsbedingung_id` int(11) DEFAULT NULL,
  `auslieferung_id` int(11) NOT NULL DEFAULT 0,
  `teillieferung` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1 COLLATE = latin1_german2_ci ROW_FORMAT = DYNAMIC;

ALTER TABLE
  `auftraege`
MODIFY
  `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 100000;