<?php

class VertraegeAbrechnung {

public $table =  "vertraege_abrechnung";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Holt alle Abrechnugnen die Fällig sind
    public function getFaellig() {

        $req = new Request();

        // Query
        $query = "
            SELECT va.*, v.vn_adresse as adresse_id
            FROM vertraege_abrechnung va

            LEFT JOIN vertraege v ON v.id = va.vertrags_id

            WHERE va.status_id = '1';
        ";

        // Abfragen
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    public function getAll() {

        $req = new Request();

        $query = "
            SELECT *
            FROM vertraege_abrechnung va
            WHERE va.status_id = '0' AND va.faelligkeit <= NOW();
        ";

        // ORDER BY va.abrechnungszeitpunkt ASC;

        // Query Abfrage
        $req->getMultiQuery($query, true);

        return $req->answer();

    }

    public function getByVertragsID($id) {
        
        $req = new Request();

        $query = "
            SELECT vertraege_abrechnung.*, status.status_id as statusID, status.icon as statusIcon
            FROM vertraege_abrechnung
            LEFT JOIN status ON status.status_id = vertraege_abrechnung.status_id AND status.bereich = 'vertraege_abrechnung'
            WHERE vertrags_id = '".$id."'
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        return $req->answer();

    }

    // Neu erstellen
    public function new($vertragsId, $data) {

        $req = new Request($data);

    //    echo "<pre>";
    //    print_r($req);
    //    echo "</pre>";
    //    die();

        // 
        $req->data['vertrags_id'] = $vertragsId;

        // Wenn die Checkbox Pauschale Angehakt ist dann Handelt es sich um eine Pauschale
        if($req->data['pauschale']['checked'] == 'true') {
            $req->data['art'] = 'P';

        // Wenn die Checkbox Zähler Angehakt ist dann handelt es sich um einen Zaehler
        } if($req->data['zaehler']['checked'] == 'true') {
            $req->data['art'] = 'Z';

        // Wenn beide Checkboxen Angehakt sind dann handelt es sich um Zaehler und Pauschale
        } if($req->data['pauschale']['checked']  == 'true' && $req->data['zaehler']['checked'] == 'true') {
            $req->data['art'] = 'PZ';
        }


        $process = [
            ['t', 'vertrags_id'],
            ['t', 'art'],
            ['s', 'pauschale_abrechnung_interval'],
            ['s', 'pauschale_abrechnung_kalendarium'],
            ['n', 'gesamtpauschale_preis'],
            ['s', 'kosten_interval'],
            ['s', 'zaehler_abrechnung_interval'],
            ['s', 'zaehler_abrechnung_kalendarium']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    }

    public function edit($abrechnungID, $data) {

        $req = new Request($data);

        // Wenn die Checkbox Pauschale Angehakt ist dann Handelt es sich um eine Pauschale
        if($req->data['pauschale-trigger']['checked'] == 'true') {
            $req->data['art'] = 'P';

        // Wenn die Checkbox Zähler Angehakt ist dann handelt es sich um einen Zaehler
        } if($req->data['zaehler-trigger']['checked'] == 'true') {
            $req->data['art'] = 'Z';

        // Wenn beide Checkboxen Angehakt sind dann handelt es sich um Zaehler und Pauschale
        } if($req->data['pauschale-trigger']['checked']  == 'true' && $req->data['zaehler-trigger']['checked'] == 'true') {
            $req->data['art'] = 'PZ';
        }

        $process = [
            ['t', 'art'],
            ['s', 'pauschale_abrechnung_interval'],
            ['s', 'pauschale_abrechnung_kalendarium'],
            ['n', 'gesamtpauschale_preis'],
            ['s', 'kosten_interval'],
            ['s', 'zaehler_abrechnung_interval'],
            ['s', 'zaehler_abrechnung_kalendarium']
        ];


        $req->update($this->table, $process, 'WHERE `id` = '. $abrechnungID .'');

        return $req->answer();

    }

    public function delete($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->tableZaehler, $id);

        // Rückgabe
        return $req->answer();
    }
}
?>