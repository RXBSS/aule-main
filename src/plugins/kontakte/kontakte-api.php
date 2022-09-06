<?php

class Kontakte {

public $table = "kontakte";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {
        
        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    public function getKontakteAdresse($id) {

        $req = new Request();

        $query = "
            SELECT ak.*, k.*
            FROM `adressen_kontakte` ak
            LEFT JOIN `kontakte` k ON k.id = ak.kontakte_id
            WHERE ak.id = '".$id."'
        ";

        $req->getQuery($query);

        return $req->answer();

    }

    // Holt den neu angelegte adressen id
    public function getAdressenKontakt($id) {

       $req = new Request();

        $query = "
            SELECT *
            FROM `adressen_kontakte` ak
            LEFT JOIN `".$this->table."` k ON k.id = ak.kontakte_id
            WHERE ak.id = '".$id."';
        ";

       $req->getQuery($query);

        return $req->answer();
    }

    // TODO: Umbennen
    public function getCardView($id) {
        
        // global $db;
        // $data_kontakte = $error = false;
        // $arr = [];
        
        // $query = "SELECT * FROM `".$this->table."` WHERE `adressen_id` = '".$id."'";
        // $result = $db->query($query);
        // if($result->num_rows > 0) {
        //     while($row = $result->fetch_assoc()) {
        //         $arr[] = $row;
        //     }
        // } 

        // return $arr;

        $req = new Request();

        $query = "
            SELECT ak.*, k.*
            FROM `adressen_kontakte` ak
            LEFT JOIN `kontakte` k ON k.id = ak.kontakte_id 
            WHERE `ak`.`adressen_id` = '".$id."';
        ";

       $req->getMultiQuery($query, true);

        return $req->answer();

    }

     // TODO: Umbennen
     // GET Kontakte über die akquise id
     public function getKontakteAkquise($id) {
        
        global $db;
        $data_kontakte = $success = $error = false;
        $arr = [];
        
        $query = "SELECT * FROM `".$this->table."` WHERE `akquise_id` = '".$id."'";

        $result = $db->query($query);

        // Wenn die Abfrage okey ist
        if($result) {
            $success = true;

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
    
                    $arr[] = $row;
                }
            } 
        }

        return [
            'success' => $success,
            'data' => $arr
        ];
        
        
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        $req->checkDuplicate('Diese Email ist bereits vergeben', $this->table, 'email', $data['email']);

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        if(!$req->error) {

            $process = [
                ['t', 'vorname'],
                ['t', 'nachname'],
                // ['t', 'adressen_id', 'adressen_id'],
                // ['t', 'abteilung'],
                // ['t', 'funktion'],
                ['t', 'email'],
                ['t', 'telefon'],
                ['t', 'mobil'],
                ['s', 'geschlecht'],
                ['s', 'titel'],
                ['dt', 'geburtstag'],
                ['t', 'telefax'],
                // ['c', 'account', 'kundenportal']

            ];

            // Ergebnis
            $req->insert($this->table, $process);

        } 

        // Wenn es Erfolgreich war
        if($req->success) {

            $kontakt_adressen = new AdressenKontakte();

            $newData = [
                'adressen_id' => (isset($req->data['adressen_id']) ) ? $req->data['adressen_id'] : false,
                'kontakte_id' => $req->result,
                'abteilung' => $req->data['abteilung'],
                'funktion' => $req->data['funktion'],
            ];

            $kontakt_adressen->newKontakteCustom($newData);

        }
       

        // Antwort schreiben
        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        if(is_array($id)) {
            $id = $id['value'];
        }

        $req = new Request($data);

        if(isset($data['email'])) {
            $req->checkDuplicate('Diese E-Mail ist bereits vergeben!', $this->table, 'email', $data['email'], $id);
        }

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        if(!$req->error) {


            $process = [
                ['t', 'vorname'],
                ['t', 'nachname'],
                // ['t', 'adressen_id', 'adressen_id'],
                // ['t', 'abteilung'],
                // ['t', 'funktion'],
                ['t', 'email'],
                ['t', 'telefon'],
                ['t', 'mobil'],
                ['s', 'geschlecht'],
                ['s', 'titel'],
                ['dt', 'geburtstag'],
                ['t', 'telefax'],
                // ['c', 'account', 'kundenportal'],
                ['s', 'kontosperre_grund']
            ];

            // Ergebnis
            $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

            

        } 

        // Wenn es Erfolgreich war
        if($req->success && (isset($req->data['adressen_id']) && $id)) {

            $kontakt_adressen = new AdressenKontakte();

            $newData = [
                'adressen_id' =>  ($req->data['adressen_id']) ? $req->data['adressen_id'] : false,
                'kontakte_id' => $id,
                'abteilung' => $req->data['abteilung'],
                'funktion' => $req->data['funktion'],
            ];

            $kontakt_adressen->editViaAdressen($newData);

        }

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
            
            // Für jede ID dies und das machen

        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }

    // Funktion die ein neuen Kontakt erstell überall im ERP Systm möglicj
    public function newKontakt($data) {

        $req = new Request($data);

        $req->checkDuplicate('Diese E-Mail ist bereits vergeben!', $this->table, 'email', $data['email']);

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        if(!$req->error) {

            $process =  [
                ['c', 'geschlecht'],
                ['s', 'titel'],
                ['t', 'vorname'],
                ['t', 'nachname'],
                ['t', 'email'],
                ['t', 'telefon']
            ];

            $req->insert($this->table, $process);

        }

        // Wenn die Insert Query Erfolgreich war
        if($req->success) {

            // 
            $adressen_kontakte = new AdressenKontakte();

            $query = "
                INSERT INTO `adressen_kontakte` SET
                    `adressen_id` = '".$req->data['adressen_id']."',
                    `kontakte_id` = '".$req->result."'
            ";

            $req->insertQuery($query);

        }

        return $req->answer();

    }
}
?>