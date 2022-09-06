
INSERT INTO `adressen` (`id`, `name`, `namenszusatz`, `branche`, `strasse`, `plz`, `ort`, `land`, `telefon`, `telefax`, `email`, `website`, `steuernummer`, `umsatzsetuer_id`, `fahrtzeit`, `kilometer`, `latitude`, `longitude`, `ist_kunde`, `kunden_nummer`, `kundenstatus`, `unternehmensgroeße`, `it_situation`, `ist_betreiber`, `rechnungsempfaenger_id`, `kunde_email_rechnung`, `kunde_email_rechnung_adresse`, `kunde_gesperrt`, `kunde_gesperrt_grund`, `kunde_gesperrt_mitarbeiter`, `kunde_gesperrt_datum`, `ist_lieferant`, `lieferanten_nummer`, `lieferant_kundennummer`, `lieferant_bezeichnung`, `lieferant_bestellung_email`, `lieferant_bestellung_art`, `lieferant_zahlungsbedingung`, `lieferant_zahlungsbedingung_tage`, `lieferant_zahlungsbedingung_kreditwert`, `lieferant_zahlungsbedingung_skonto_tage`, `lieferant_zahlungsbedingung_skonto`, `lieferant_mindermengenzuschlag`, `lieferant_mindermengenzuschlag_schwelle`, `lieferant_mindermengenzuschlag_zuschlag`, `lieferant_versand_versicherung`, `lieferant_versand_versicherung_betrag`, `lieferant_versand_versicherung_versicherung`, `lieferant_versand_versicherung_freibetrag`, `ist_hersteller`, `hersteller_nummer`, `hersteller_bezeichnung`, `auslieferungsart`, `place_id`) VALUES
(1, 'Peter Nielsen', NULL, NULL, 'Jungmannstr. 53', 24105, 'Kiel', 'DE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(2, 'addvalue GmbH', NULL, NULL, 'Ernst-Barlach-Straße 20', 36041, 'Fulda', 'DE', NULL, NULL, 'info@addvalue.de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(3, 'Parzeller Verlag GmbH & Co. KG', NULL, NULL, 'Steinweg 26', 36037, 'Fulda', 'DE', NULL, NULL, 'info@parzeller.de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(4, 'JUMO GmbH & Co.KG', NULL, NULL, 'Moritz-Juchheim-Straße 1', 36039, 'Fulda', 'DE', NULL, NULL, 'mail@jumo.net', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(5, 'bb Klostermann GmbH', NULL, NULL, 'Carl-Zeiss-Str. 6', 36088, 'Hünfeld', 'DE', NULL, NULL, 'info@bb-klostermann.de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '', 'interessent', 'false', 'false', 0, NULL, 1, 'info@bb-klostermann.de', 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(6, 'Beate Schreiber', NULL, NULL, 'Osterloher Weg 22', 25421, 'Pinneberg', 'DE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(7, 'Beckhoff Automation GmbH & Co. KG', NULL, NULL, 'Hülshorstweg 20', 33415, 'Verl', 'DE', NULL, NULL, 'info@beckhoff.de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(8, 'Henkel & Reiss GmbH', NULL, NULL, 'Harmerzer Str. 15', 36041, 'Fulda', 'DE', NULL, NULL, 'info@henkel-reiss.de', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(9, 'SYSTEAM GmbH', NULL, NULL, 'Industriestraße 8', 96250, 'Ebensfeld', 'DE', '+49 9573 92210', '+49 9573 9221199', 'info@systeam.de', 'systeam.de', '9/212/116/30636', 'DE132457929', NULL, NULL, NULL, NULL, 0, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 'SYSTEAM', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(10, 'ALSO Deutschland GmbH', NULL, NULL, 'Lange Wende 43', 59494, 'Soest', 'DE', '+49 2921 990', '+49 2921 991199', 'info@also.com', 'also.de', NULL, 'DE245320175', NULL, NULL, NULL, NULL, 0, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 'ALSO', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 'standard', NULL),
(11, 'Konica Minolta Business Solutions Deutschland GmbH', 'Develop', NULL, 'Europaallee 17', 30855, 'Langenhagen', 'DE', '+49 511 74040', '+49 511 741050', NULL, NULL, NULL, 'DE228895321', NULL, NULL, NULL, NULL, 0, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 'Develop', 'bestellung@develop.de', 3, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, 'Develop', 'standard', NULL),
(12, 'ELO Digital Office GmbH', NULL, NULL, 'Tübinger Straße 43', 70178, 'Stuttgart', 'DE', '+49 711 8060890', ' +49 711 80608919', 'info@elo.com', 'elo.com', NULL, 'DE812471516', NULL, NULL, NULL, NULL, 0, NULL, '', '', '', 0, NULL, 0, NULL, 0, NULL, NULL, NULL, 1, NULL, NULL, 'ELO', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, 1, NULL, 'ELO', 'standard', NULL),
(13, 'Bürosystemhaus Schäfer GmbH & Co. KG', '', NULL, 'Haimbacher Straße 24', 36041, 'Fulda', 'DE', '+49 661 902530', '', 'info@also.com', 'https://www.buerosystemhaus.de/', '', '', '00:01:00', '0.20', 0.9999900, 0.9999900, 1, '54655', 'neukunde', 'false', 'false', 0, NULL, 1, 'info@also.com', 1, 'stören', 1004, '2022-01-25', 1, '12345', NULL, 'fgdfgd', '', NULL, 1, 15, '20.00', 52, 5, 1, '50.00', '120.36', 1, '7.99', '7.99', '60.98', 1, '', '', 'standard', '');