CREATE TABLE `status` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `status_id` varchar(100) NOT NULL,
    `bereich` varchar(100) NOT NULL,
    `bezeichnung` varchar(100) NULL DEFAULT NULL,
    `icon` varchar(100) NULL DEFAULT NULL,
    `farbe` varchar(100) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

INSERT INTO `status` (`status_id`, `bereich`, `bezeichnung`, `icon`, `farbe`) VALUES

    /* Bitte nach Name sortieren und nicht formatieren */

    /* Akquise Status */
    (0, 'akquise', 'Offen', NULL, NULL),
    (1, 'akquise', 'Erfolgreich',NULL, NULL),
    (2, 'akquise', 'Nicht Erfolgreich', NULL, NULL),
    (3, 'akquise', 'Gelöscht', NULL, NULL),

    /* Akquise Positionen */
    (0, 'akquise_positionen', 'Telefon', 'fa-solid fa-phone-flip', NULL),
    (1, 'akquise_positionen', 'Telefonisch nicht erreicht', 'fa-solid fa-phone-slash', NULL),
    (2, 'akquise_positionen', 'Mail', 'fa-solid fa-envelope', NULL),
    (3, 'akquise_positionen', 'Gespräch', 'fa-solid fa-people-arrows-left-right', NULL),
    (4, 'akquise_positionen', 'Sonstiges', 'fa-solid fa-circle-info', NULL),
    (5, 'akquise_positionen', 'Sonstiges', 'fa-solid fa-retweet', NULL),

    /* Akquise Positionen Status in der Timeline */
    (6, 'akquise_positionen', 'Offen', 'fa-solid fa-hourglass text-info', NULL),
    (7, 'akquise_positionen', 'Erfolgreich', 'fa-solid fa-thumbs-up text-primary', NULL),
    (8, 'akquise_positionen', 'Nicht Erfolgreich', 'fa-solid fa-thumbs-down text-danger', NULL),
    (9, 'akquise_positionen', 'Gelöscht', 'fa-solid fa-trash', NULL),

    /* Akquise Positionen Abonniert in der Timeline */
    (10, 'akquise_positionen', 'Abonniert', 'fa-solid fa-bell', NULL),
    (11, 'akquise_positionen', 'Deabonniert', 'fa-solid fa-bell-slash', NULL),

    /* Akquise Positionen Meilenstein Icon */
    (12, 'akquise_positionen', 'Meilenstein', 'fa-solid fa-flag', NULL),
    (13, 'akquise_positionen', 'Wiedervorlage', 'fa-solid fa-clock', NULL),

    /* Angebote */
    (1, 'angebote', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'angebote', 'Offen', '<i class=\"fa-regular fa-circle text-warning\"></i>', NULL),
    (3, 'angebote', 'Angenommen', '<i class=\"fa-solid fa-check-double text-success\"></i>', NULL),
    (4, 'angebote', 'Abgelehnt', '<i class=\"fa-solid fa-xmark text-danger\"></i>', NULL),

    /* Artikel */
    (1, 'artikel', 'Aktiv', '', NULL),
    (2, 'artikel', 'Inaktiv', '<i class=\"fa-solid fa-xmark text-warning\"></i>', NULL),
    (3, 'artikel', 'Gesperrt', '<i class=\"fa-solid fa-ban text-danger\"></i>', NULL),

    /* Artikel - Ident */
    (1, 'artikel_ident_typ', 'Stand Alone', NULL, NULL),
    (2, 'artikel_ident_typ', 'Option', NULL, NULL),
    (3, 'artikel_ident_typ', 'Beides', NULL, NULL),

    /* Artikel Dokumente */
    (1, 'artikel_dokumente', 'Datenblatt / Prospekt', NULL, NULL),
    (2, 'artikel_dokumente', 'Service-Handbuch', NULL, NULL),
    (3, 'artikel_dokumente', 'Benutzer-Handbuch', NULL, NULL),
    
    /* Aufträge */
    (1, 'auftraege', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'auftraege', 'Offen', '<i class=\"fa-solid fa-circle text-danger\"></i>', NULL),
    (3, 'auftraege', 'Beliefert', '<i class=\"fa-solid fa-check text-success\"></i>', NULL),
    (4, 'auftraege', 'Erledigt', '<i class=\"fa-solid fa-check-double text-success\"></i>', NULL),

    /* Aufträge Lieferungen */
    (1, 'auftraege_lieferungen', 'Kommissioniert', NULL, NULL),
    (2, 'auftraege_lieferungen', 'Versendet', NULL, NULL),
    (3, 'auftraege_lieferungen', 'in Auslieferung', NULL, NULL),
    (4, 'auftraege_lieferungen', 'zur Abholung', NULL, NULL),

    /* Bestellungen */
    (1, 'bestellungen', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'bestellungen', 'Offen', '<i class=\"fa-solid fa-circle text-danger\"></i>', NULL),
    (3, 'bestellungen', 'Teillieferung', '<i class=\"fa-solid fa-circle text-warning\"></i>', NULL),
    (4, 'bestellungen', 'Vollständig', '<i class=\"fa-solid fa-check-double text-success\"></i>', NULL),

    /* Bestellungen */
    (1, 'bestellungen_art', 'Manuelle Bestellung', '<i class=\"fa-solid fa-xmark\"></i>', NULL),
    (2, 'bestellungen_art', 'Gedruckt', '<i class=\"fa-solid fa-print\"></i>', NULL),
    (3, 'bestellungen_art', 'E-Mail', '<i class=\"fa-solid fa-envelope-open-text\"></i>', NULL),
    (4, 'bestellungen_art', 'Schnittstelle', '<i class=\"fa-solid fa-usb\"></i>', NULL),

    /* Lieferungen */
    (0, 'lieferungen', 'Standard', NULL, NULL),
    (1, 'lieferungen', 'Abholung', NULL, NULL),
    (2, 'lieferungen', 'Versand', NULL, NULL),
    (3, 'lieferungen', 'Direktlieferung', NULL, NULL),
    (4, 'lieferungen', 'Techniker', NULL, NULL),

    /* Rechnungen */
    (1, 'rechnungen', 'Offen', NULL, NULL),
    (2, 'rechnungen', 'Teilweise Bezahlt', NULL, NULL),
    (3, 'rechnungen', 'Bezahlt', NULL, NULL),
    
    /* Software / Firmware - Arten */
    (1, 'software', 'Produktiv', NULL, NULL),
    (2, 'software', 'Beta', '<i class=\"fa-solid fa-triangle-exclamation text-warning\"></i>', NULL),
    (3, 'software', 'Alpha', '<i class=\"fa-solid fa-triangle-exclamation text-danger\"></i>', NULL),
    (4, 'software', 'Experimentell', '<i class=\"fa-solid fa-triangle-exclamation text-danger\"></i>', NULL),
    (5, 'software', 'Special', '<i class=\"fa-solid fa-triangle-exclamation text-info\"></i>', NULL),

    /* Tickets */
    (1, 'tickets', 'Neues Ticket', '<i class=\"fa-solid fa-plus\"></i>', '#03A9F4'),
    (2, 'tickets', 'in Bearbeitung (BS)', '<i class=\"fa-solid fa-settings\"></i>', '#FFEB3B'),
    (3, 'tickets', 'in Bearbeitung (Kunde)', '<i class=\"fa-solid fa-settings\"></i>', '#2196F3'),
    (4, 'tickets', 'Erledigt', '<i class=\"fa-solid fa-check-double\"></i>', '#7ab929'),

    (1, 'tickets_verlauf', 'Öffentlich', 'fa-solid fa-user-group', NULL),
    (2, 'tickets_verlauf', 'Intern', 'fa-solid fa-user-shield', NULL),
    (3, 'tickets_verlauf', 'Entwurf', 'fa-solid fa-pen-ruler', NULL),


    /* Wareneingang */
    (0, 'wareneingang', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (1, 'wareneingang', 'Erfasst', '<i class=\"fa-solid fa-check text-success\"></i>', NULL),

    /* Verträge */
    (1, 'vertraege', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'vertraege', 'Aktiv', '<i class=\"fa-solid fa-circle text-success \"></i>', NULL),
    (2.1, 'vertraege', 'Warten auf Authorisierung', '<i class=\"fa-solid fa-lock\"></i>', NULL),
    (2.2, 'vertraege', 'Authorisiert', '<i class=\"fa-solid fa-unlock\"></i>', NULL),
    (2.3, 'vertraege', 'Gekündigt', '<i class=\"fa-solid fa-trash-alt\"></i>', NULL),
    (3, 'vertraege', 'Inaktiv', '<i class=\"fa-solid fa-circle text-danger\"></i>', NULL),

    /* Verträge Vorlagen */
    (1, 'vertraege_vorlagen', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'vertraege_vorlagen', 'Aktiv', '<i class=\"fa-solid fa-circle text-success\"></i>', NULL),
    (3, 'vertraege_vorlagen', 'Alte Version', '<i class=\"fa-solid fa-circle text-danger\"></i>', NULL),

    /* Verträge Abrechnung */
    (0, 'vertraege_abrechnung', 'Nicht Fällig', '<i class="fa-solid fa-hourglass-half"></i>', NULL),
    (1, 'vertraege_abrechnung', 'Fällig', '<i class="fa-solid fa-xmark"></i>', NULL),
    (2, 'vertraege_abrechnung', 'Abgerechnet', '<i class="fa-solid fa-check"></i>', NULL),

    /* Zählerstand Anleitungen */
    (1, 'zaehlerstaende_anleitungen', 'Entwurf', '<i class=\"fa-solid fa-edit\"></i>', NULL),
    (2, 'zaehlerstaende_anleitungen', 'Techniker prüfen', '<i class=\"fa-solid fa-user-clock text-warning\"></i>', NULL),
    (3, 'zaehlerstaende_anleitungen', 'Veröffentlicht', '<i class=\"fa-solid fa-user-tie text-success\"></i>', NULL);