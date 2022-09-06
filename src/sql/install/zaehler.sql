CREATE TABLE `zaehler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `zaehler` (`id`, `bezeichnung`) VALUES
(1, 'Schwarz/Weiß DIN A4'),
(2, 'Farbe DIN A4'),
(3, 'Farbe DIN A4 - Akzent'),
(4, 'Farbe DIN A4 - Light'),
(5, 'Scans'),
(6, 'Meter'),
(7, 'Karten');
