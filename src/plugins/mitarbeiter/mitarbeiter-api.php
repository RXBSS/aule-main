<?php

class Mitarbeiter {

public $table = "mitarbeiter";

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

    
    public function getMitarbeiter($vorname, $nachname) {
        global $db;
        $data = false;
        $arr = [];
        
        $query = "SELECT * FROM `".$this->table."` WHERE `vorname` = '".$vorname."' AND `nachname` = '".$nachname."' ";

        $result = $db->query($query);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }

        return $arr;
    }

    

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

            if(!$req->data['nummer']) {
                $req->data['nummer'] = false;
            } 

            // Wenn Mehr anzeigen geschlossen ist werden alle werte die dort drin liegen auf false gesetzt
            if($data['trigger-on-off'] == "0") {
                $req->data['geburtstag'] = false;
                $req->data['eintrittsdatum'] = false;
                $req->data['austrittsdatum'] = false;
                $req->data['aktiv'] = false;
                $req->data['auszubildender'] = false;
                $req->data['geschlecht'] = false;
            }



        // $req->checkDuplicate('Diese Email ist bereits vergeben', $this->table, 'email', $data['email']);

        // if($req->error) {

            $process = [
                ['t', 'nummer'],
                ['t', 'vorname'],
                ['t', 'nachname'],
                ['t', 'strasse'],
                ['s', 'laender', 'land'],
                ['t', 'plz'],
                ['t', 'ort'],
                ['t', 'telefon'],
                ['t', 'mobiltelefon'],
                ['t', 'email'],
                ['t', 'email_geschaeftlich'],
                ['dt', 'geburtstag'],
                ['dt', 'eintrittsdatum'],
                ['dt', 'austrittsdatum'],
                ['c', 'aktiv'],
                ['c', 'auszubildender'],
                ['s', 'geschlecht']
            ];

            
            $req->insert($this->table, $process);
        // }

        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

        // $req->checkDuplicate('Diese Email ist bereits vergeben', $this->table, 'email', $data['email'], $id);

        // if(!$req->error) {

            if(!$req->data['nummer']) {
                $req->data['nummer'] = false;
            }


            $process = [
                ['t', 'nummer'],
                ['t', 'vorname'],
                ['t', 'nachname'],
                ['t', 'strasse'],
                ['s', 'laender', 'land'],
                ['t', 'plz'],
                ['t', 'ort'],
                ['t', 'telefon'],
                ['t', 'mobiltelefon'],
                ['t', 'email'],
                ['t', 'email_geschaeftlich'],
                ['dt', 'geburtstag'],
                ['dt', 'eintrittsdatum'],
                ['dt', 'austrittsdatum'],
                ['c', 'aktiv'],
                ['c', 'auszubildender'],
                ['s', 'geschlecht']
            ];

            
            $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        // }

        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $query = "DELETE  `".$this->table."` WHERE `id` = '".$id."';";
        
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