<?php

/**
 * Rechnungen
 * 
 */
class BestellungDoc extends Document {


    // Constuctor
    function __construct($bestellId, $options = []) {

        // Lieferung Id
        $this->bestellId = $bestellId;

        // Parent Constuctor
        parent::__construct($options);
    }

    // Name des Ordners
    function getFolderName() {
        return 'bestellung';
    }

    // Name des Dokuments
    function getSaveName() {
        return "bestellung_" . $this->data['bestellung']['id'];
    }

    // Name des Dokuments
    function getTitle() {
        return "Bestellung ".$this->data['bestellung']['id'];
    }


    /**
     * Daten für den Lieferschein auslesen
     * 
     */
    function getData() {

        // Neue Auftrag API erstellen
        $bestellung = new Bestellung();

        // Daten sammeln
        $besResult = $bestellung->get($this->bestellId);
        
        // Positionen
        $besPosResult = $bestellung->getPositions($this->bestellId);
 
        // Daten Array ausgeben
        $this->data['bestellung'] = $besResult['data'];
        $this->data['pos'] = ($besPosResult['success']) ? $besPosResult['data'] : [];

        // TODO: Diese Daten müssen noch ergänzt werden
        $this->data['ansprechpartner_name'] = 'Tobias Pitzer';
        $this->data['ansprechpartner_telefon'] = '+49 661 90253-18';
        $this->data['ansprechpartner_email'] = 't.pitzer@buerosystemhaus.de';
    }

    // Zusammenbauen der Rechnung
    function build() {

        // Formatter
        $f = new Formatter();

        // Erstell Datum
        $erstellDatum = new DateTime($this->data['bestellung']['erstell_datum']);

        // KOPFZEILE 
        // *************************************************************************

        // Liste 
        $list = [
            ['<strong>Bestellnummer:</strong>', '<strong>' . $this->data['bestellung']['id'] . '</strong>'],
            ['Bestelldatum', $erstellDatum->format('d.m.Y')],
            ['<br>'],
            ['Liefertermin', (($this->data['bestellung']['hat_liefertermin']) ? date('d.m.Y',strtotime($this->data['bestellung']['liefertermin'])) : "<em>keine Angaben</em>")],
        ];

        $list = array_merge($list, [
            ['<br>'],
            ['Ansprechpartner', $this->data['ansprechpartner_name']],
            ['Telefon', $this->data['ansprechpartner_telefon']],
            ['E-Mail', $this->data['ansprechpartner_email']],
        ]);

        // Standard Header setzen
        $this->standardHead(1, $this->data['bestellung']['lieferant_id'], $list, "BS-" . $this->data['bestellung']['id']);

        // ÜBERSCHRIFT 
        // *************************************************************************

        // Name der Rechnung
        $this->writeHeadline('Bestellung');

        if($this->data['bestellung']['text']) {
            $this->mpdf->WriteHTML('<p>'.$this->multiLineText($this->data['bestellung']['text']).'</p><br>');
        }

        $this->mpdf->WriteHTML('<p><strong>Lieferung an Adresse</strong><br>Bürosystemhaus Schäfer GmbH & Co. KG, Haimbacher Straße 24, 36041 Fulda</p><br>');


        // POSITIONEN 
        // *************************************************************************

        // Positionen
        $pos = [
            'header' => ['Pos', 'Artikel', 'Intern', 'Bezeichnung', 'Bestellmenge'],
            'style' => ['width:3%;text-align:left;', 'width:15%;text-align:left;', 'width:15%;text-align:left;', 'width:59%;text-align:left;', 'width:7%;text-align:right;']
        ];

        // Schliefe durch alle Positionen
        foreach ($this->data['pos'] as $key => $value) {
            $temp = [
                $value['reihenfolge'],
                $value['herstellernummer'],
                $value['artikel_id'],
                $value['hersteller_bezeichnung'] . " " . $value['artikel_bezeichnung'],
                $f->autoFloat(floatval($value['bestellmenge']), 1)
            ];

            array_push($pos, $temp);
        }
    

        // Positionsdaten setzen
        $this->arrayToTable($pos);

        // FOOTER 
        // *************************************************************************

        $array  = [
            // ['Hier kann noch ein Text mit diversen Hinweisen stehen'],
            'footer' => [
                'Es gelten unsere üblichen Zahlungsmodalitäten',
                '',
                'Netto<br>MwSt. 19%<br>Brutto',
                '0,00 €<br>0,00 €<br>0,00 €'
            ],
            'style' => ['width:65%;text-align:left;', 'width:5%;text-align:left;', 'width:15%;text-align:left;', 'width:15%;text-align:right;'],
        ];

        // Metadaten speichern!
        $this->arrayToTable($array, true);
    }

    // Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {    
        // TODO: Hier muss noch die Berechtigung geklärt werden!
        return true;
    }
}
