<?php

/**
 * Rechnung (Dokument)
 * 
 * ACHTUNG! Nicht verwechseln mit der Klasse Rechnungen!
 * 
 * 
 */
class RechnungDoc extends Document {


    // Constuctor
    function __construct($options = []) {

        // Parent Constuctor
        parent::__construct($options);

    }

    // Name des Ordners
    function getFolderName() {
        return 'rechnungen';
    }

    // Name des Dokuments
    function getSaveName() {
        return "rechnung";
    }

    // Daten für die Rechnung auslesen
    function getData() {

        // Neue Auftrag API erstellen
        $auftrag = new Auftrag();

        // Daten 
        $this->data = $auftrag->get(100000)['data'];

        // TODO: Diese Daten müssen noch ergänzt werden
        $this->data['ansprechpartner_name'] = 'Tobias Pitzer';
        $this->data['ansprechpartner_telefon'] = '+49 661 90253-18';
        $this->data['ansprechpartner_email'] = 't.pitzer@buerosystemhaus.de';
        $this->data['rechnungsnummer'] = '123456789';
        $this->data['rechnungsdatum'] = date('d.m.Y');

        // Positionen Summe
        $this->data['positionen_summe'] = $auftrag->pos->getAllById(100000)['data'];

        // Positionen 
        $this->data['positionen'] = $auftrag->pos->getAllById(100000)['data'];
    }

    // Zusammenbauen der Rechnung
    function build() {

        $this->data['erstellt_datum']  = new DateTime($this->data['erstellt_datum']);
        $this->data['liefertermin']  = new DateTime($this->data['liefertermin']);


        // Liste 
        $list = [
            ['<strong>Auftragsnummer:</strong>', '<strong>' . $this->data['id'] . '</strong>'],
            ['Auftragsdatum', $this->data['erstellt_datum']->format('d.m.Y')],
            ['<br>'],
            ['Rechnungsnummer', $this->data['rechnungsnummer']],
            ['Rechnungsdatum', $this->data['rechnungsdatum']],
            ['Liefer / Leistungsdatum', $this->data['liefertermin']->format('d.m.Y')],
        ];

        if ($this->data['lieferanschrift_id'] != $this->data['rechnungsanschrift_id']) {

            $empfaenger = $this->getEmpfeaengerById($this->data['lieferanschrift_id']);
            
            array_push($list, [
                'Lieferanschrift',
                $this->simpleFormatAdresse($empfaenger)
            ]);
        }

        $list = array_merge($list, [
            ['<br>'],
            ['Ansprechpartner', $this->data['ansprechpartner_name']],
            ['Telefon', $this->data['ansprechpartner_telefon']],
            ['E-Mail', $this->data['ansprechpartner_email']],
        ]);

        // Standard Header setzen
        $this->standardHead(1, $this->data['rechnungsanschrift_id'], $list, "RE-" . $this->data['rechnungsnummer']);

        // Name der Rechnung
        $this->writeHeadline('Rechnung');

        // Positionen überarbeiten
        $f = new Formatter();

        $pos = [
            'header' => ['Pos', 'Bezeichnung', 'Menge', 'Einzelpreis', 'Gesamtpreis'],
            'style' => ['width:15%;text-align:left;', 'width:40%;text-align:left;', 'width:3%;text-align:center;', 'width:15%;text-align:right;', 'width:15%;text-align:right;'],
        ];

        foreach ($this->data['positionen'] as $key => $value) {
            $temp = [
                $value['reihenfolge'],
                $value['hersteller_bezeichnung'] . " " . $value['artikel_bezeichnung'],
                $f->autoFloat($value['menge'], 1),
                $f->betrag($value['vk']) . " €",
                $f->betrag($value['netto_gesamt']) . " €"
            ];

            array_push($pos, $temp);
        }

        // Positionsdaten setzen
        $this->arrayToTable($pos);


        // 
        $array  = [
            // ['Hier kann noch ein Text mit diversen Hinweisen stehen'],
            'footer' => [
                $this->data['zahlungsbedingung_text'],
                '',
                'Netto<br>MwSt. 19%<br>Brutto',
                $f->betrag($this->data['positionen_summe']['netto']) . " €<br>" . $f->betrag($this->data['positionen_summe']['mwst']) . " €<br>" . $f->betrag($this->data['positionen_summe']['brutto']) . " €"
            ],
            'style' => ['width:65%;text-align:left;', 'width:5%;text-align:left;', 'width:15%;text-align:left;', 'width:15%;text-align:right;'],
        ];

        // Metadaten speichern!
        $this->arrayToTable($array);
    }

    // Zugferd Rechnung erstellen
    function mkZugferd() {

    }

    // Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {    
        // TODO: Hier muss noch die Berechtigung geklärt werden!
        return true;
    }
}
