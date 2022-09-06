<?php

class Notification {

public $table =  "notification";

    function __construct() {
        // Do Something at Construction
    }

    // Holt die Daten über den Nutzer
    public function get() {

        $success = $error = false;

        $req = new Request();

        global $db;

        // $query = "SELECT * FROM $this->table WHERE `user_id` != '".$_SESSION['user']['id']."' AND `data` = '". $value['akquise_id'] . "' ORDER BY zeitstempel_erstellt DESC LIMIT 5; ";

        // Rückgabe
        $arr = [];

        // Geht durch alle Daten -> IDs
        // foreach($data['data'] as $key => $value) {

            // Alle die nicht der Angemeldete User sind und zu (this)-akquise gehören
            $query = "SELECT * FROM $this->table WHERE `user_id` != '".$_SESSION['user']['id']."' AND `mitarbeiter_abo` = '".$_SESSION['user']['id']. "' ORDER BY zeitstempel_erstellt DESC LIMIT 5; ";

            // Result
            $result = $db->query($query);
            
            // Wenn es Ergebnis gibt
            if ($result->num_rows > 0) {

                    // Erfolg
                    $success = true;

                    // Geht durch alle Daten
                    while ($row = $result->fetch_assoc()) {
                    
                        // Rückgabe
                        $arr[] = $row;
                    }    
            
            // Wenn kein Ergebnis da ist
            } else {
                $error = true;
            }

        // }

       

        // Result
        return [
            'success' => $success,
            'error' => $error,
            'data' => $arr
        ];

    }

    // Wenn der Mitarbeiter Abonniert hat werden alle Daten geholt
    public function getStandard() {

        $req = new Request();

        // Query // ToDo: sollte die neusten 5 holen
        $query = "SELECT * FROM $this->table WHERE `user_id` = '".$_SESSION['user']['id']."' ORDER BY zeitstempel_erstellt DESC LIMIT 5; ";

        // Abfrage
        $req->getMultiQuery($query);

        // Result
        return $req->answer();

    }

    // Neu erstellen
    public function new($data) {

        $req = new Request($data);

        $akquiseAbo = new AkquiseAbo();

        /* Abfragen wer alles die Akquise Abonniert hat - Wenn keiner die Akquise Abonniert hat dann muss man auch keine Notification erstellen
            Notification wird erst immer für einen User erstellt der Abonniert hat ansonten nicht
        */
        $result = $akquiseAbo->getAkquiseAbo($req->data['data']);

        foreach($result as $key => $value) {

            // Nur wenn der Mitarbeiter ein anderer ist als der angemeldetete - Quasi Notification nur für andere Erstellen was ich selber mache will ich nicht sehen
            if($value['mitarbeiter_id'] != $_SESSION['user']['id']) {

                $req->data['mitarbeiter_abo'] = $value['mitarbeiter_id'];

                $process = [
                    ['t', 'user_id'],
                    ['t', 'aktion'],
                    ['t', 'text'],
                    ['t', 'data'],
                    ['t', 'mitarbeiter_abo'],
                    ['t', 'gelesen'],
                    ['dt', 'zeitstempel_gelesen'],
                    ['dt', 'zeitstempel_erstellt'] // Current
                ];

                $req->insert($this->table, $process);
            }

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

        $req->update($this->table, $process, 'WHERE `id` = '. $id .'');

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

    // Funktion die das gelesen überschreibt 
    public function notificationGelesen($data) {

        // current Time
        $date = new DateTime();
        $zeitstempel_gelesen = $date->format('d.m.Y H:i:s');

        $newData = [
            'gelesen' => '1',
            'zeitstempel_gelesen' => $zeitstempel_gelesen
        ];

        $req = new Request($newData);

        $process = [
            ['t', 'gelesen'],
            ['dt', 'zeitstempel_gelesen']
        ];

        // Ergebnis
        $req->update($this->table, $process, 'WHERE `data` = '.$data[0].' AND `mitarbeiter_abo` = '.$_SESSION['user']['id'].' AND `aktion` = "'.$data[1].'" ');

        // Antwort schreiben
        return $req->answer();


    }

    // Wenn einer der Einträge Nicht Gelesen wurde Prüfen
    public function getNotification() {

        $req = new Request();

        // Query 
        // Wo ich (angemeldeter) nicht der Ersteller der Notification bin aber die Akquise Abonniert habe
        $query = "SELECT * FROM $this->table WHERE `user_id` != '".$_SESSION['user']['id']."' AND `mitarbeiter_abo` = '".$_SESSION['user']['id']."' ORDER BY zeitstempel_erstellt DESC LIMIT 5;";

        // Abfrage
        $req->getMultiQuery($query, true);

        // Result
        return $req->answer();
    }
}
?>