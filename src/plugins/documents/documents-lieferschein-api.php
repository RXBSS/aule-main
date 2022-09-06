<?php

/**
 * Rechnungen
 * 
 * 
 */
class LieferscheinDoc extends Document {


    // Constuctor
    function __construct($id, $options = []) {

        // Lieferung Id
        $this->id = $id;

        // Parent Constuctor
        parent::__construct($options);
    }

    // Name des Ordners
    function getFolderName() {
        return 'lieferscheine';
    }

    // Name des Dokuments
    function getSaveName() {
        return "lieferschein_" . $this->data['lieferung']['id'];
    }

    // Name des Dokuments
    function getTitle() {
        return "Lieferschein ".$this->data['lieferung']['id'];
    }


    /**
     * Daten für den Lieferschein auslesen
     * 
     */
    function getData() {

        // Neue Auftrag API erstellen
        $lieferung = new AuftraegeLieferungen();
        $auftrag = new Auftrag();

        // Lieferung auslesen
        $lfResult = $lieferung->get($this->id);

        // Positionen
        $lfPosResult = $lieferung->pos->getAllById($this->id);

        // Auftrag Daten auslesen
        $afResult = $auftrag->get($lfResult['data']['auftrag_id']);

        // TODO: Fehlerausgabe muss noch geklärt werden

        // Daten Array ausgeben
        $this->data['lieferung'] = $lfResult['data'];
        $this->data['pos'] = $lfPosResult['data'];
        $this->data['auftrag'] = $afResult['data'];


        // TODO: Diese Daten müssen noch ergänzt werden
        $this->data['ansprechpartner_name'] = 'Tobias Pitzer';
        $this->data['ansprechpartner_telefon'] = '+49 661 90253-18';
        $this->data['ansprechpartner_email'] = 't.pitzer@buerosystemhaus.de';

        // echo "<pre>";
        // print_r($this->data);
    }




    /*
    // Name des Dokuments
    function getSaveName($archive) {

        // Wenn die Rechnung archiviert werden soll
        if ($this->options['archive']) {
            $this->name = "lieferschein_" . $this->data['lieferung']['id'];

            // Wenn Sie nur für den Preview gilt
        } else {
            $this->name = "lieferschein_preview_" . $this->data['lieferung']['id'];
        }
    }
*/


    // Zusammenbauen der Rechnung
    function build() {

        // Formatter
        $f = new Formatter();

        // Erstell Datum
        $this->data['lieferung']['lieferdatum']  = new DateTime($this->data['lieferung']['zeitstempel']);
        $this->data['auftrag']['auftragsdatum']  = new DateTime($this->data['auftrag']['erstellt_datum']);

        // KOPFZEILE 
        // *************************************************************************

        // Liste 
        $list = [
            ['<strong>Liefernummer:</strong>', '<strong>' . $this->data['lieferung']['id'] . '</strong>'],
            ['Lieferdatum',  $this->data['lieferung']['lieferdatum']->format('d.m.Y')],
            ['<br>'],
            ['Auftragsnummer', $this->data['auftrag']['id']],
            ['Auftragsdatum', $this->data['auftrag']['auftragsdatum']->format('d.m.Y')],
        ];

        $list = array_merge($list, [
            ['<br>'],
            ['Ansprechpartner', $this->data['ansprechpartner_name']],
            ['Telefon', $this->data['ansprechpartner_telefon']],
            ['E-Mail', $this->data['ansprechpartner_email']],
        ]);

        // Standard Header setzen
        $this->standardHead(1, $this->data['auftrag']['lf_id'], $list, "LF-" . $this->data['lieferung']['id']);

        // ÜBERSCHRIFT 
        // *************************************************************************

        // Name der Rechnung
        $this->writeHeadline('Lieferschein');

        // TODO: Bestimmte Lieferanweisungen!
        $this->mpdf->WriteHTML('<p>Lieferanweisungen und Bestellnummer des Kunden</p><br>');


        // POSITIONEN 
        // *************************************************************************

        // Positionen
        $pos = [
            'header' => ['Pos', 'Artikel', 'Bezeichnung', '<span style="color:#999;">Auftrag</span>', 'Menge'],
            'style' => ['width:3%;text-align:left;', 'width:15%;text-align:left;', 'width:59%;text-align:left;', 'width:7%;text-align:center;', 'width:7%;text-align:center;']
        ];

        // Schliefe durch alle Positionen
        foreach ($this->data['pos'] as $key => $value) {
            $temp = [
                $value['reihenfolge'],
                $value['artikel_id'],
                $value['hersteller_bezeichnung'] . " " . $value['artikel_bezeichnung'],
                '<span style="color:#999;">' . $f->autoFloat($value['menge'], 1) . "</span>",
                $f->autoFloat($value['lieferung_menge'], 1)
            ];

            array_push($pos, $temp);
        }

        // Positionsdaten setzen
        $this->arrayToTable($pos);

        // FOOTER 
        // *************************************************************************

        $pos = [
            ['', '<br><br><hr>'],
            ['', 'Unterschrift Kunde'],
            'style' => ['width:60%;text-align:left;', 'width:40%;text-align:left;']
        ];

        // Positionsdaten setzen
        $this->arrayToTable($pos, true);
    }

    // Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {    
        // TODO: Hier muss noch die Berechtigung geklärt werden!
        return true;
    }

}
