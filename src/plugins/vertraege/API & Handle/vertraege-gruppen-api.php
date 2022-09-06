<?php

class VertraegeGruppen {

public $table =  "vertraege_gruppen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Hotl die Höchste Zahl der Reihenfolge
    public function getReihenfolge() {

        $req = new Request();

        // Query
        $query = "
            SELECT reihenfolge
            FROM `vertraege_gruppen` 
            ORDER BY `reihenfolge` DESC
            LIMIT 1;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // Holt Die höchste Zahl der Reihenfolge
        $resultReihenfolge = $this->getReihenfolge();

        // Wenn es keine Daten gibt ist es der erste Eintrag
        if(count($resultReihenfolge['data']) == 0 ) {
            $req->data['reihenfolge'] = 1;
        } else {

            // Reihenfolge Eins Hochzählen
            $req->data['reihenfolge'] = $resultReihenfolge['data'][0]['reihenfolge'] + 1;
        }

        $process = [
            ['t', 'bezeichnung'],
            ['t', 'reihenfolge'],
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

        $process = [
            ['t', 'bezeichnung']
        ];

        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        return $req->answer();

    }

    // Reihenfolge Ändern
    public function posShift($data) {

        $req = new Request();

        $success = $error = false;

        $colID = "";

        // Wenn id ID des Meilensteins in einem Array ist
        if(is_array($data['data']['colID'])) {
            $colID = $data['data']['colID'][0];
        } else {
            $colID = $data['data']['colID'];
        }

        // Holt sich erstmal alle Daten der Positionen Gruppen
        $req->getMultiQuery("SELECT * FROM `".$this->table."` ");

        // Schrreibt es in die Variable Positionen
        $positionen = $req->answer();
       
        // Wenn was zurück gekommen ist
        if($positionen['success']) {

            // Init der API Positionen
            $pos = new Positionen($this->table, 'id');

            // Positionen verschieben
            $pos->shift($positionen['data'], $data['data']['direction'], $colID);

            // Erfolgreich
            $success = true;

        }

        // Wenn nichts zurück gekommen ist
        else {
            $error = true;
        }

        // Rückgabe
        return ([
            'success' => $success,
            'error' => $error,
            'pos' => $pos
        ]);

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $req = new Request($id);

        $req->deleteMultiple($this->table, $id);

        return $req->answer();
    }
}