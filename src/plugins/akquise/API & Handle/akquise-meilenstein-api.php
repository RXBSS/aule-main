<?php

class AkquiseMeilenstein {

public $table =  "akquise_meilenstein";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // TODO: PERFOMCANCE NICHT GUT
    public function getReihenfolge($id) {

        $req = new Request();

        // Wenn die ID NICHT false ist
        if($id) {

            $query = "
                SELECT * FROM `akquise_meilenstein` 
                WHERE aktion_id = '".$id."'
                ORDER BY `reihenfolge` DESC
                LIMIT 1;
            ";
        } else {
            $query = "
                SELECT * FROM `akquise_meilenstein` 
                WHERE aktion_id IS NULL
                ORDER BY `reihenfolge` DESC
                LIMIT 1;
            ";
        }


        $req->getMultiQuery($query, true);

        return $req->answer();
    }

    // Holt alle Meilensteine
    public function getMeilensteine($id, $bool) {

        $req = new Request();

        $standardMeilensteine = ""; 

        // Wenn die Standard Meilensteine Erlaubt sind
        if($bool) {
            $standardMeilensteine = "OR am.aktion_id IS NULL";
        }

        $query = "
        
            SELECT am.*, am.id AS akquiseMeilensteinID, a.*,
                (SELECT COUNT(*) FROM `akquise_positionen` WHERE akquise_id = a.id AND meilenstein_id = am.id)  AS isInAqkuise
            FROM `akquise_meilenstein` am
            LEFT JOIN `akquise` a ON am.aktion_id = a.aktion_id ".$standardMeilensteine."
            WHERE a.id = '".$id."'
            ORDER BY am.reihenfolge ASC;; 
        ";

        $req->getMultiQuery($query, true);

        return $req->answer();
    }

    public function getMeilensteinMitarbeiter($id) {

        $req = new Request();

        $query = "
            SELECT ap.*, m.vorname AS bearbeiterVorname, m.nachname AS bearbeiterNachname
            FROM akquise_positionen ap
            LEFT JOIN akquise a ON a.id = ap.akquise_id
            LEFT JOIN akquise_meilenstein am ON am.id = ap.meilenstein_id
            LEFT JOIN mitarbeiter m ON m.id = ap.bearbeiter_id
            WHERE a.id = '".$id."' and `ap`.`meilenstein_id` IS NOT NULL;
        ";

        $req->getMultiQuery($query, true);

        return $req->answer();
    }

    public function getAll($id) {

        $req = new Request();

        $request = new Request();

        $query = "SELECT * FROM akquise WHERE id = '".$id."'";

        $request->getQuery($query);

        $aktion = '';

        // Wenn die Akquise eine Aktion zugeordnet wurde
        if($request->result['aktion_id']) {

            $query = "
                SELECT akquise_meilenstein.bezeichnung
                FROM akquise_meilenstein, akquise
                WHERE akquise_meilenstein.aktion_id = akquise.aktion_id AND akquise.id = '".$id."';
            ";

            $req->getMultiQuery($query);
        
        // Wenn die Akquise keiner Aktion dazu gehört
        } else {

            $query = "
                SELECT * FROM akquise_positionen WHERE akquise_id = '".$id."' AND meilenstein = '1';
            ";
            
            $req->getMultiQuery($query);

        }

        return $req->answer();
    }

    public function getPos($id) {

        $req = new Request();

        $query = "
            SELECT * FROM akquise_positionen WHERE akquise_id = '".$id."' AND meilenstein = '1';
        ";
    
        $req->getMultiQuery($query);

        // Result
        return $req->answer();


    }

    // Edit Task Meilensteine
    public function getEdit($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT COUNT(*) as anzahlMeilenstein FROM akquise_positionen WHERE 
        ";

        // Beim Löschen sind es meistens mehrer IDS gleichzeitig
        if(is_array($id)) {

           

            foreach($id as $key => $value) {

                // Wenn es nur eine ID gibt
                if($key == '0') {
                    $query .= "meilenstein_id = '".$value."'";
                }

                // Wenn es mehr als eine ID gibt dann wird es immer mit OR drangehängt
                if($key > 0) {
                    $query .= "or meilenstein_id = '".$value."'";
                }

            }


        // Beim editieren ist es meistens nur eine id
        } else {
            $query .= "
                meilenstein_id = '".$id."' ;
            ";

        }

        $req->getMultiQuery($query);

        // Return
        return $req->answer();

        


       



    }

    // TODO: PERFOMCANCE NICHT GUT
    // Ein neuer Meilenstein wird hinzugefügt
    public function create($data) {

        // Aktion ID - Standardmäßig keine ID
        $aktion_id = false;
        $reihenfolge = false;

        $akquise_meilensteine = new AkquiseMeilenstein();

        // Wenn es eine Aktion ID gibt
        if(isset($data['additional']['aktion_id']) && $data['additional']['aktion_id'] !== 'false') {
            $result = $akquise_meilensteine->getReihenfolge($data['additional']['aktion_id']);
        } else {
            $result = $akquise_meilensteine->getReihenfolge(false);
        }

        // Nur wenn die Abfrage erfolgreich war kann weitergemacht werden
        if($result['success']) {
            
            // Wenn es eine Aktions ID in der URL gibt -- Die nehmen als Aktions ID
            if(isset($data['additional']['aktion_id'])) {
                $aktion_id = $data['additional']['aktion_id'];
            }

            // newData
            $newData = [
                'text' => $data['formData']['text'],
                'aktion_id' => $aktion_id,
                'reihenfolge' =>  (empty($result['data']) ? 1 : ++$result['data'][0]['reihenfolge'])
            ];

            $req = new Request($newData);

            $process = [
                ['t', 'text'],
                ['t', 'aktion_id'],
                ['t', 'reihenfolge']
            ];

            $req->insert('akquise_meilenstein', $process);

            return $req->answer();

        }
    }

    // Schon Vorhandnen Meilenstein Updaten
    public function update($data) {
        
        // newData
        $newData = [
            'text' => $data['formData']['text'],
            'aktion_id' => ( (isset($data['additional']['aktion_id'])) ? $data['additional']['aktion_id'] : false)
        ];

        $req = new Request($newData);

        $process = [
            ['t', 'text'],
            ['t', 'aktion_id']
        ];

        // Update
        $req->update('akquise_meilenstein', $process, "WHERE `id` = '". $data['formData']['id'] ."'");

        return $req->answer();

    }

    // Meilenstein zur Akquise hinzufügen - Meilenstein wurde erreicht
    public function new($data) {

        $newData = [
            'akquise_id' => $data['akquise_id'],
            'bearbeiter_id' => $_SESSION['user']['id'],
            'art' => '12',
            'text' => false,
            'meilenstein_id' => $data['meilenstein']
        ];

        $req = new Request($newData);

        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'text'],
            ['t', 'art'],
            ['t', 'meilenstein_id']
        ];

        $req->insert('akquise_positionen', $process);

        return $req->answer();

    }

    // Akquise Positionen eintragen
    public function akquisePositionen($data) {

        $req = new Request($data);

        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'text'],
            ['t', 'art']
        ];

        $req->insert('akquise_positionen', $process);

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
        $req->deleteMultiple($this->table, $id);

        // Rückgabe
        return $req->answer();
    }

    // Funktion die den Text zu einem Meilenstein holt
    public function getMeilensteineText($aktion_id, $data) {

        $req = new Request();

       

        if(!$aktion_id) {
            $aktion_id = "IS NULL";
        } else {
            $aktion_id = "=".$aktion_id;
        }

        $query = "
            SELECT * FROM akquise_meilenstein WHERE bezeichnung = '".$data."' AND aktion_id ".$aktion_id." ;
        ";

        $req->getMultiQuery($query);

        // // Result
        return $req->answer();


    }

    // Positionen der Meilensteine Verschieben mit der Shift API
    public function posShift($data) {

        $colID = "";

     

        // Wenn id ID des Meilensteins in einem Array ist
        if(is_array($data['data']['colID'])) {
            $colID = $data['data']['colID'][0];
        } else {
            $colID = $data['data']['colID'];
        }


        // 
        $success = $error = false;

        $req = new Request();

        // Wenn Akquise einer Aktion ID gibt zugeordnet ist
        if(isset($data['data']['id']) && $data['data']['id'] !== 'false') {
            // Holt sich erstmal alle Daten der Akquise
            $req->getMultiQuery("SELECT * FROM `akquise_meilenstein` WHERE `aktion_id` = '".$data['data']['id']."'");
        
        // Es gehört zu einer Aktion dazu aber hat keine ID
        } else if(isset($data['data']['akquise_id']) && $data['data']['akquise_id']) {

        
            // Holt erstmal alles zu einer Akquise
            $req->getQuery("SELECT * FROM `akquise` WHERE `akquise`.`id` = '".$data['data']['akquise_id']."' ");

            // Wenn es eine Aktion ID gibt
            if($req->result['aktion_id']) {
                // Holt sich erstmal alle Daten der Akquise
                $req->getMultiQuery("SELECT * FROM `akquise_meilenstein` WHERE `aktion_id` = '".$req->result['aktion_id']."'");

            }

            // Wenn es keine Aktion gibt -- IS NULL
            else {
                // Holt sich erstmal alle Daten der Akquise
                $req->getMultiQuery("SELECT * FROM `akquise_meilenstein` WHERE `aktion_id` IS NULL");
            }

            
        // Gehört zu keiner Aktion dazu
        }  else {

            // Holt sich erstmal alle Daten der Akquise
            $req->getMultiQuery("SELECT * FROM `akquise_meilenstein` WHERE `aktion_id` IS NULL");
            
        }
        
        // Schrreibt es in die Variable Positionen
        $positionen = $req->answer();

        // Wenn was zurück gekommen ist
        if($positionen['success']) {

            // Init der API Positionen
            $pos = new Positionen("akquise_meilenstein", 'id');

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

    public function getMeilensteineAktion($id) {

        $req = new Request();

        $query = " 
            SELECT * FROM ".$this->table." WHERE id = '".$id."'
        ";

        $req->getMultiQuery($query); 

        return $req->answer();
    }
}
?>