CREATE TABLE `_mail_historie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zeitstempel` datetime NOT NULL,
  `empfaenger` text(254) DEFAULT NULL,
  `cc` text(254) DEFAULT NULL,
  `bcc` text(254) DEFAULT NULL,
  `betreff` text(254) DEFAULT NULL,
  `sender` text(254) DEFAULT NULL,
  `reply` text(254) DEFAULT NULL,
  `anhaenge` text(254) DEFAULT NULL,
  `ergebnis` int(11) DEFAULT NULL,
  `debug` int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;