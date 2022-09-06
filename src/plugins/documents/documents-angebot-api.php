<?php

/**
 * Auftragsbestätigung
 * 
 * 
 */
class AngebotDoc extends Document {

    // Constuctor
    function __construct($id, $options = []) {

        // Lieferung Id
        $this->id = $id;

        // Parent Constuctor
        parent::__construct($options);
    }

    // Name des Ordners
    function getFolderName() {
        return 'angebote';
    }

    // Name des Dokuments
    function getSaveName() {
        return "angebot_".$this->data['id'];
    }

    // Name des Dokuments
    function getTitle() {
        return "Angebot ".$this->data['id'];
    }

    // Daten für die Rechnung auslesen
    function getData() {

        // Neue Auftrag API erstellen
        $api = new Angebote();

        // Daten 
        $this->data = $api->get(1)['data'];

        $this->data['positionen'] = $api->pos->getAllById(1)['data'];
        $this->data['positionen_summe'] = $api->pos->getSum(1)['data'];

       


    }


    // Zusammenbauen der Rechnung
    function build() {


        
        // $this->data['erstellt_datum']  = $this->data['erstellt_datum'];
        // $this->data['liefertermin']  = new DateTime($this->data['liefertermin']);

        // Liste 
        $list = [
            ['<strong>Angebotsnummer:</strong>', '<strong>' . $this->data['id'] . '</strong>'],
            ['Angebotsdatum', 'XXX']
        ];

        // $this->data['erstellt_datum']->format('d.m.Y')

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
        $this->standardHead(1, $this->data['rechnungsanschrift_id'], $list, "AG-" . $this->data['id']);

        // Name der Rechnung
        $this->writeHeadline('Angebot');

        // Positionen überarbeiten
        $f = new Formatter();

        $pos = [
            'header' => ['Pos', 'Bezeichnung', 'Menge', 'Einzelpreis', 'Gesamtpreis'],
            'style' => ['width:15%;text-align:left;', 'width:40%;text-align:left;', 'width:3%;text-align:center;', 'width:15%;text-align:right;', 'width:15%;text-align:right;'],
        ];


        $artikel = new Artikel(); 
        

        foreach ($this->data['positionen'] as $key => $value) {

            $data = $artikel->getAttributesText($value['artikel_id']);

            // echo "<pre>";
            // print_r($value);
            // die();
            
            
            $temp = [
                $value['reihenfolge'],
                "<strong>".$value['hersteller_bezeichnung'] . " " . $value['artikel_bezeichnung']."</strong><br>".$data['data'],
                $f->autoFloat($value['menge'], 1),
                $f->betrag($value['vk']) . " €",
                $f->betrag($value['netto_gesamt']) . " €"
            ];

            array_push($pos, $temp);
        }

        // Positionsdaten setzen
        $this->arrayToTable($pos);

        
        $this->summen($this->data['positionen_summe']);

    }


    
    function checkPermission($dokId, $userId, $userTable) {
        // Die Berechtigung muss in der jeweiligen Dokumenteklasse geprüft werden
        // TODO:!!!!
        return true;
    }
}
