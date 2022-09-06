<?php

class Inventar {

public $table = "inventar";

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

    // Todo: kann mit der obigen Funktion ersetzt werden
    // Inventar Details get Funktion
    public function getD($id) {

        $req = new Request();

        $query = "
        
            SELECT i.*, m1.vorname AS kaufpersonVorname, m1.nachname as kaufpersonNachname, m2.vorname as nutzerVorname, m2.nachname as nutzerNachname
            FROM inventar i
            LEFT JOIN mitarbeiter m1 ON m1.id = i.kaufperson_id
            LEFT JOIN mitarbeiter m2 ON m2.id = i.nutzer_id
            WHERE i.id = '".$id."';
        ";

        $req->getQuery($query);

        return $req->answer();
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // Wenn es keine Abschreibung gibt
        if(!$data['abschreibezeitraum'] || $data['abschreibung']['checked'] === 'false') {
            $req->data['abschreibezeitraum'] = false; // Dann Null reinschreiben
        }
       
        $process = [
            ['t', 'kaufobjekt'],
            ['s', 'kaufperson_id'],
            // ['s', 'nutzer_id'],
            ['t', 'seriennummer'],
            ['dt', 'kaufdatum'],
            ['t', 'kaufpreis'],
            ['t', 'beschreibung'],
            ['t', 'abschreibezeitraum']
        ];

            // Ergebnis
        $req->insert($this->table, $process);


        // Antwort schreiben
        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

    //    echo "<pre>";
    //    print_r($data);
    //    echo "</pre>";
    //    die();

        // Wenn es keine Abschreibung gibt
        if(!$data['abschreibezeitraum'] || $data['abschreibung']['checked'] === 'false') {
            $req->data['abschreibezeitraum'] = false; // Dann Null reinschreiben
        }

        $process = [
            ['t', 'kaufobjekt'],
            ['s', 'kaufperson'],
            // ['s', 'nutzer'],
            ['t', 'seriennummer'],
            ['dt', 'kaufdatum'],
            ['t', 'kaufpreis'],
            ['t', 'beschreibung'],
            ['t', 'abschreibezeitraum']
        ];

            // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');


        // Antwort schreiben
        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $req = new Request($id);

        $req->deleteMultiple($this->table, $id);
        return $req->answer();

        // $query = "DELETE  `".$this->table."` WHERE `id` = '".$id."';";
        
        // if($db->query($query)) {
        //     $success = true;
        // } else {
        //     $error = $db->error;
        // }

        // return [
        //     'success' => $success,
        //     'error' => $error
        // ];
    }


    // Abschicken der Verleih
    public function verleihSubmit($id, $data) {

        $req = new Request($data);

        $process = [
            ['dt', 'nutzungsdauer'],
            ['t', 'nutzungsstandort'],
            ['s', 'nutzer_id'],
            ['t', 'nutzungsgrund']
        ];

            // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        // Wenn Erfolgreich war
        if($req->success) {

            $req2 = new Request($data);

            $req2->data['inventar_id'] = $id;
        
            $req2->data['timestamp'] = new DateTime();
            $req2->data['timestamp']  = $req2->data['timestamp']->format('d.m.Y H:i:s');

            // Bearbeiter ID ist der Aktuelle User
            $req2->data['bearbeiter_id'] = $_SESSION['user']['id'];
 
            $process2 = [
                ['dt', 'nutzungsdauer'],
                ['dt', 'timestamp'],
                ['t', 'nutzungsstandort'],
                ['s', 'nutzer_id'],
                ['t', 'inventar_id'],
                ['t', 'bearbeiter_id'],
                ['t', 'nutzungsgrund']
            ];

            // Ergebnis
            $req2->insert('inventar_historie', $process2);

        }


        // Antwort schreiben
        return $req->answer();
    }

    // Verleih beenden
    public function verleihBeenden($id) {

        $req = new Request();

        // Aller Werte auf Null -- Also False setzen
        $req->data['nutzungsdauer'] = false;
        $req->data['nutzungsstandort'] = false;
        $req->data['nutzer_id'] = false;
        $req->data['nutzungsgrund'] = false;

        $process = [
            ['dt', 'nutzungsdauer'],
            ['t', 'nutzungsstandort'],
            ['s', 'nutzer_id'],
            ['t', 'nutzungsgrund']
        ];

            // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');


        // Antwort schreiben
        return $req->answer();
    }

    public function getHistorie($id) {

        $req = new Request();

        $query = "
        
            SELECT ih.*, ih.nutzungsgrund as historieNutzungsgrund, i.*, m.vorname as NutzerVorname, m.nachname as NutzerNachname, m2.vorname as bearbeiterVorname, m2.nachname as bearbeiterNachname
            FROM `inventar_historie` ih

            LEFT JOIN inventar i ON i.id = ih.inventar_id
            LEFT JOIN mitarbeiter m ON m.id = ih.nutzer_id
            LEFT JOIN mitarbeiter m2 on m2.id = ih.bearbeiter_id

            WHERE ih.inventar_id = '".$id."'
            ORDER BY ih.id DESC 
            LIMIT 5;
        ";

        $req->getMultiQuery($query, true);

        return $req->answer();


    }
    
}
?>