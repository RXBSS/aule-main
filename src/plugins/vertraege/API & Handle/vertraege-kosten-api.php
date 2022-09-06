<?php

class VertraegeKosten {

    public $table =  "vertraege_kosten";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Liest die Klauseln aus
    public function getByVertragsid($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM `" . $this->table . "`
            WHERE vertrags_id = '" . $id . "';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Neu erstellen
    public function new($data) {

        $req = new Request($data);

        $process = [
            ['t', 'laufzeit'],
            ['s', 'status'],
            ['c', 'vertragsende'],
            ['dt', 'vertragsbeginn']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    }

    // Wenn Die Kosten Abgeschickt werden 
    public function editKosten($id, $data) {

        $req = new Request($data);

        // Wenn die Checkbox Pauschale Angehakt ist dann Handelt es sich um eine Pauschale
        if ($req->data['pauschale-trigger']['checked'] == 'true') {
            $req->data['art'] = 'P';

            // Wenn die Checkbox Zähler Angehakt ist dann handelt es sich um einen Zaehler
        }
        if ($req->data['zaehler-trigger']['checked'] == 'true') {
            $req->data['art'] = 'Z';

            // Wenn beide Checkboxen Angehakt sind dann handelt es sich um Zaehler und Pauschale
        }
        if ($req->data['pauschale-trigger']['checked']  == 'true' && $req->data['zaehler-trigger']['checked'] == 'true') {
            $req->data['art'] = 'PZ';
        }

        // Vertrags ID
        $req->data['vertrags_id'] = $id;

        // Process Array
        $process = [
            ['t', 'vertrags_id'],
            ['t', 'art'],
            ['n', 'abrechnung_pauschale'],
            ['s', 'pauschale_abrechnung_interval'],
            ['s', 'pauschale_abrechnung_kalendarium'],
            ['n', 'gesamtpauschale_preis'],
            ['s', 'kosten_interval'],
            ['s', 'zaehler_abrechnung_interval'],
            ['s', 'zaehler_abrechnung_kalendarium'],
            ['c', 'zaehler_einheitlich'],
            ['c', 'zaehler_freimenge']
        ];


        // Wenn es noch keine Kostenstell gibt
        $resultKosten = $this->getByVertragsid($id);

        // Es gibt eine Kostenstelle
        if (count($resultKosten['data']) > 0 && $resultKosten['success']) {
            $req->update($this->table, $process, 'WHERE `vertrags_id` = ' . $id . '');
        }

        // Es gibt keine Kostenstelle
        else {
            $req->insert($this->table, $process);
        }


        return $req->answer();
    }

    public function edit($id, $data) {

        $req = new Request($data);

        $process = [
            ['t', 'laufzeit'],
            ['s', 'status_id'],
            ['c', 'vertragsende'],
            ['dt', 'vertragsbeginn']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

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
