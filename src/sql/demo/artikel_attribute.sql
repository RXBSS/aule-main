-- Daten einfügen
INSERT INTO `artikel_attribute` (`id`, `bezeichnung`, `beschreibung`, `datentyp`, `data`, `pflichtfeld`, `reihenfolge`, `system`) VALUES
(1000, 'Farbgerät', 'Ist es ein Farb-Gerät', 'ja-nein', NULL, NULL, 5, 0),
(1001, 'Druckgeschwindigkeit (Farbe)', 'Die Druckgeschwindigkeit in Seiten pro Minute in Farbe', 'zahl', NULL, NULL, 1, 0),
(1002, 'Druckgeschwindigkeit (SW)', 'Drcukgeschwindigkeit in Schwarz Weiß', 'zahl', NULL, NULL, 2, 0),
(1003, 'Duplex (Doppelseitig)', 'Kann das Gerät doppelseitig', 'ja-nein', NULL, NULL, 6, 0),
(1004, 'Monatliches Volumen', 'das empfohlene monatliche Volumen', 'zahl', NULL, NULL, 4, 0),
(1005, 'Integriertes Fax', 'Wenn das Gerät eine integrierte Fax-Funktion hat.', 'ja-nein', NULL, NULL, 7, 0),
(1006, 'Dualscanner', 'Scannt Vorder- und Rückseite in einem Durchlauf', 'ja-nein', NULL, NULL, 8, 0),
(1007, 'Standard-Kassetten', 'Die Anzahl und Kapazität der Standard-Kassetten', 'textfeld', NULL, NULL, 3, 0),
(1008, 'Scangeschwindigkeit', 'Scan-Geschwindigkeit', 'zahl', NULL, NULL, 4, 0);