CREATE TABLE `mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referenz_id` int(11) NOT NULL,
  `referenz_art` varchar(100) NOT NULL,
  `empfaenger` varchar(254) NOT NULL,
  `versender` varchar(254) NOT NULL,
  `betreff` varchar(254) DEFAULT NULL,
  `text` text DEFAULT NULL,
  `erstellt` datetime DEFAULT NULL,
  `geplant` datetime DEFAULT NULL,
  `versendet` datetime DEFAULT NULL,
  `ergebnis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;