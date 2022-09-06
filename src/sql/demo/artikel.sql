/*

INSERT INTO `artikel` (`id`, `herstellernummer`, `ean`, `bezeichnung`, `hersteller_id`, `zuordnung_id`, `zuordnung_details_id`, `artikel_gruppe_id`, `langtext`, `notiz`, `bild`, `bestandsfuehrung`, `ident`, `auto_bestand_aktiv`, `auto_bestand_min`, `auto_bestand_max`, `feste_preise`, `ek`, `vk`, `uhg`, `artikel_hoehe`, `artikel_breite`, `artikel_tiefe`, `verpackung_hoehe`, `verpackung_breite`, `verpackung_tiefe`) VALUES
(100000, 'AA2M121', NULL, 'ineo +250i', 1, 5, 0, 1000, 'Hier kommt der Langtext', 'und hier die Notiz', NULL, 1, 1, 0, NULL, NULL, 0, '12.200000', '21.400000', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100001, 'AAV81D0', NULL, 'TN-328K', 1, 2, 0, 1, NULL, NULL, NULL, 1, 0, 1, 2, 5, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100002, 'AAV82D0', NULL, 'TN-328Y', 1, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100003, 'AAV83D0', NULL, 'TN-328M', 1, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100004, 'AAV84D0', NULL, 'TN-328C', 1, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100005, '3011560', NULL, 'TN-328K', 19, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100006, '3011561', NULL, 'TN-328C', 19, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100007, '3011562', NULL, 'TN-328M', 19, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100008, '3011563', NULL, 'TN-328Y', 19, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100009, '24B6009', '7346464987531', 'Toner 24B6009', 3, 2, 0, 1, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

*/


INSERT INTO `artikel` (`id`, `status_id`, `herstellernummer`, `ean`, `bezeichnung`, `hersteller_id`, `zuordnung_id`, `zuordnung_details_id`, `artikel_gruppe_id`, `langtext`, `notiz`, `bild`, `bestandsfuehrung`, `ident`, `auto_bestand_aktiv`, `auto_bestand_min`, `auto_bestand_max`, `feste_preise`, `ek`, `vk`, `uhg`, `ident_typ_id`, `ident_irreversibel`, `zaehler`, `software`, `garantie`, `garantie_standard_laenge`, `garantie_standard_art`, `garantie_erweitert_laenge`, `garantie_erweitert_art`, `artikel_hoehe`, `artikel_breite`, `artikel_tiefe`, `verpackung_hoehe`, `verpackung_breite`, `verpackung_tiefe`) VALUES
(100000, 1, 'AA2M121', '', 'Ineo +250i', 1, 4, 0, 1000, 'Langtext', 'Notizen', NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, 0, 1, 0, 1, 12, 1, 36, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(100001, 1, 'AAYHWY1', '', 'DF-632 - Originaleinzug', 1, 4, 0, 1013, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100002, 1, 'AAV5WY8', '', 'PC-216 - Papierkassetten 500 Blatt', 1, 4, 0, 1014, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100003, 1, 'A0PDW2T', '', 'LK-105v4 - OCR Modul', 1, 6, 0, 1015, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100004, 1, '', '', 'Kartenleser TWN4', 146, 4, 0, 1016, NULL, NULL, NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 3, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100005, 1, '12345678', '', 'Alter Artikel', 1, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100006, 1, '87654321', '', 'Neuer Artikel', 1, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100007, 1, '99999999', '', 'Noch neuerer Artikel', 1, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100008, 1, '88888888', '', 'I bims 1 Alternativ', 3, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100009, 1, '77777777', '', 'I bims 2 Alternativ', 4, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100010, 1, '66666666', '', 'I bims 3 Alternativ', 5, 2, 0, 4, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100011, 1, 'AAV81D0', '', 'TN-328K Toner Black', 1, 2, 0, 1, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100012, 1, 'AAV82D0', '', 'TN-328Y Toner Yellow', 1, 2, 0, 1, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100013, 1, 'AAV83D0', '', 'TN-328M Toner Magenta', 1, 2, 0, 1, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100014, 1, 'AAV84D0', '', 'TN-328C Toner Cyan', 1, 2, 0, 1, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100015, 1, 'AA2K121', '', 'Ineo +300i', 1, 4, 0, 1000, 'Langtext', 'Notizen', NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, 0, 1, 0, 1, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100016, 1, 'AA2J121', '', 'Ineo +360i', 1, 4, 0, 1000, 'Langtext', 'Notizen', NULL, 1, 1, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, 0, 1, 0, 1, 12, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100017, 1, 'AAMNWY1', '', 'DF-714 Dual-Scan Originaleinzug', 1, 4, 0, 1013, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(100018, 1, 'AAV5WY1', '', 'PC-116 - Papierkassette 500 Blatt', 1, 4, 0, 1014, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100019, 1, 'AAV5WY9', '', 'PC-416 Großraumkassette 2.500 Blatt DIN A4', 1, 4, 0, 1014, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100020, 1, 'AAV5WY6', '', 'PC-417 Großraumkassette 1500/1000 Blatt', 1, 4, 0, 1014, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100021, 1, '9967008725', '', 'DK-516x Unterschrank', 1, 4, 0, 1014, NULL, NULL, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 2, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
