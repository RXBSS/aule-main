<?php

class Zahlungsbedingungen {

public $table = "zahlungsbedingungen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {
        
        global $db;
        $data = false;
        
        $query = "SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'";
        $result = $db->query($query);
        if($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // $req->checkDuplicate('Es wurde ein Dublette gefunden!', $this->table, 'name', $data['name']);

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        // if(!$req->error) {

            $process = [
                ['t', 'bezeichnung'],
                ['t', 'text'],
                ['c', 'abbuchung'],
                ['t', 'tage'],
                ['t', 'skonto_prozent'],
                ['t', 'skonto_tage'],
            ];

            // Ergebnis
            $req->insert($this->table, $process);

        // } 

        // Antwort schreiben
        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);


        $process = [
            ['t', 'bezeichnung', 'bezeichnung', $data['bezeichnung']],
            ['t', 'text', 'text', $data['text']],
            ['c', 'abbuchung', 'abbuchung', $data['abbuchung']],
            ['t', 'tage', 'tage', $data['tage']],
            ['t', 'skonto_prozent', 'skonto_prozent', $data['skonto_prozent']],
            ['t', 'skonto_tage', 'skonto_tage', $data['skonto_tage']]
        ];

        // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');
        

        // Antwort schreiben
        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $id = (is_array($id)) ? $id : [$id];

        $query = "DELETE FROM `".$this->table."` WHERE `id` IN ('".implode("','",$id)."');";
        
        if($db->query($query)) {
            $success = true;
        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }
}
?>