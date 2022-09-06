CREATE TABLE `artikel_zuordnung` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(254) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

INSERT INTO
  `artikel_zuordnung` (`id`, `bezeichnung`)
VALUES
  (1, 'Standard Artikel'),
  (2, 'Verbrauchsmaterial / Ersatzteil'),
  (3, 'Dienstleistung / Arbeitszeit'),
  (4, 'Hardware'),
  (5, 'Software'),
  (6, 'Lizenz');