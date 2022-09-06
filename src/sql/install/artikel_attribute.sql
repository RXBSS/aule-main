-- Erstellen
CREATE TABLE `artikel_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(254) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL,
  `datentyp` varchar(254) DEFAULT NULL COMMENT 'String, Integer, Betrag, Liste, ...',
  `data` text DEFAULT NULL COMMENT 'Wird nur beim Datentyp Liste gefüllt',
  `pflichtfeld` int(11) DEFAULT NULL,
  `reihenfolge` int(11) DEFAULT NULL,
  `system` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Daten einfügen
INSERT INTO
  `artikel_attribute` (
    `id`,
    `bezeichnung`,
    `beschreibung`,
    `datentyp`,
    `data`,
    `pflichtfeld`,
    `reihenfolge`,
    `system`
  )
VALUES
  (
    1,
    'Farbe',
    'Auswahl für die Farbe im Bereich CMYK.',
    'liste',
    '{\n    \"values\": [\n        \"Black (BK);\",\n        \"Cyan (C)\",\n        \"Magenta (M)\",\n        \"Yellow (Y)\",\n        \"Cyan/Magenta/Yellow (CMY)\",\n        \"Alle (CMYK)\",\n        \"Keine\"\n    ],\n    \"default\": 0\n}',
    1,
    1,
    1
  ),
  (
    2,
    'Haltbarkeit',
    'Die Haltbarkeit von Ersatz / Verbrauchsmaterialien. Dies sollte bei Toner/Tinte der Norm ISO / IEC 19752 entsprechen um einen einheitlichen Wert zu erreichen.',
    'zahl',
    NULL,
    1,
    2,
    1
  ),
  (
    3,
    'Herstellungsart',
    'Die Angabe meist bei Toner und Tinte, aber auch bei Heizung darüber, wie ein Artikel hergestellt wurde.\n\nOriginal = Originalware direkt vom Hersteller\nAlternativ = Alternative Ware von einem Fremdhersteller\nRebuild/Remanufactured = Recyceltes Material wiede aufgearbeitet\nRefill = Material das wieder aufgefüllt wurde.',
    'liste',
    '{\n    \"values\": [\n        \"Original\",\n        \"Alternativ\",\n        \"Rebuild/Remanufactured\",\n        \"Refill\"\n    ],\n    \"default\": 0\n}',
    1,
    3,
    1
  );