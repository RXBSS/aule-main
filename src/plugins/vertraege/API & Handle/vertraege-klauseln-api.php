<?php

class VertraegeKlauseln {

public $table =  "vertraege_klauseln";

    function __construct() {
        // Do Something at Construction
    }

    // Einfache Get Klauseln
    public function getKlausel($id) {

        // Request
        $req = new Request();

        $req->get($this->table, $id);

        // Query
        // $query = "
        //     SELECT a.*
        //     FROM vertraege_klauseln a
        //     INNER JOIN (
        //         SELECT klausel_referenz_id, MAX(version) version
        //         FROM vertraege_klauseln
        //         GROUP BY klausel_referenz_id
        //     ) b ON a.klausel_referenz_id = b.klausel_referenz_id AND a.version = b.version;
        // ";



        // // Query Abfrage
        // $req->getMultiQuery($query);

        // Rückgabe
        return $req->answer();
    }

    public function get($id) {

        $req = new Request();

        // Query
        $query = "
        
            SELECT vk.*, vg.bezeichnung as vertragsgruppenParagraph
            FROM vertraege_klauseln vk
            LEFT JOIN vertraege_gruppen vg ON vg.id = vk.gruppen_id
            WHERE vk.id = '".$id."';

        ";

        // Query Abfrage
        $req->getMultiQuery($query);

        // Rückgabe
        return $req->answer();
    }

    // Holt alle Standard Klauseln
    public function getStandard() {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_klauseln
            WHERE standard = '1';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt die neuste Version
    public function getVersion($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_klauseln
            WHERE klausel_referenz_id = '".$id."'
            ORDER BY id DESC
            LIMIT 1;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt die Klauseln aus der DB
    public function getKlauseln($id) {

        $req = new Request();

        $success = $error = false;
        
        // leeres Array
        $arr = [];

        // Query
        $query = "
            SELECT vv.*, va.*, vk.*, vg.id as reihenfolgePara, vg.bezeichnung as bezeichnung
            FROM `vertraege_klauseln_vorlagen` vv 
            LEFT JOIN vertraege_vorlagen va ON va.id = vv.vorlagen_id
            LEFT JOIN vertraege_klauseln vk ON vk.id = vv.klausel_id
            LEFT JOIN vertraege_gruppen vg ON vg.id = vk.gruppen_id
            WHERE (vv.vorlagen_id = '".$id."' AND vv.geloescht = 0) OR (vv.vorlagen_id IS NULL AND vv.geloescht = 0)
            ORDER BY reihenfolgePara asc;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

        // Wenn Vertragsgruppen Array ist
        // if(isset($data['vertraegeart_id']) ) {

        //     // Schleife geht durch alle Vertragsgruppen ID
        //     // foreach($data['vertraegegruppen'] as $key => $value) {

        //         // Query
        //         $query = "
        //             SELECT vk.*, va.*, vg.*
        //             FROM vertraege_klauseln vk
        //             LEFT JOIN vertraege_art va ON va.id = '".$data['vertraegeart_id']."'
        //             LEFT JOIN vertraege_gruppen vg ON vg.id = '".$value[2]."'
        //             WHERE (vk.vertraegeart_id = '". $data['vertraegeart_id']  ."' AND vk.vertraegegruppen_id = '". $value[2] ."') OR (vk.vertraegeart_id IS NULL AND vk.vertraegegruppen_id = '". $value[2] ."') ;

        //         ";

        //         // Query Abfrage
        //         $req->getMultiQuery($query);

        //         $arr[] = $req->result;

        //     }

           

        //     // Wenn erfolgreich
        //     if($req->success) {
        //         $success = true;
        //     } else {
        //         $error = true;
        //     }
            
        // } else {
        //     $error = true;
        // }

        // // Todo: andere Lösung -> mit $req->adapt() ???? 
        // // Wennn echo dann direkt Front end wenn return dann geht es erstmal an Handle -> brauche eh andere Lösung dafür
        // echo json_encode([
        //     'success' => $success,
        //     'error' => $error,
        //     'data' => $arr
        // ]);





    }

    // Holt alle Klauseln mit einer bestimmen Vertragegruppen
    public function getKlauselnByGruppe($vertraegegruppen_id) {

        $req = new Request(); 

        // Query
        $query = "
            SELECT *
            FROM `".$this->table."`
            WHERE gruppen_id = '".$vertraegegruppen_id."';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    } 

    // holt die Version der Gruppen
    public function getGruppenVersion($id) {

        $req = new Request(); 

        $req->get('vertraege_gruppen', $id); 

        return $req->answer();

    }

    // Holt die Klauseln bei der Referenz ID 
    public function getByKlauselRefenz($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT vk.*, m.vorname as mitarbeiterVorname, m.nachname as mitarbeiterNachname
            FROM vertraege_klauseln vk
            LEFT JOIN mitarbeiter m ON m.id = vk.mitarbeiter_id
            WHERE vk.klausel_referenz_id = '".$id."'
            ORDER BY vk.version DESC;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    
    // Holt alle Vertragsarten wo die Klausel verwendet wird
    public function klauselVerwendetIn($id) {
        

        $req = new Request();

        // Query
        $query = "
            SELECT vv.bezeichnung
            FROM vertraege_klauseln_vorlagen vkv

            LEFT JOIN vertraege_klauseln vk ON vk.id = vkv.klausel_id
            LEFT JOIN vertraege_vorlagen vv ON vv.id = vkv.vorlagen_id

            WHERE vkv.klausel_id = '".$id."'
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Zählt alle Klauseln Einträge
    public function countKlausel() {

        $req = new Request(); 


        // MARK: Brauch man gar nichz

        // Query
        $query = "
            SELECT COUNT(id) as eintraegeKlausel
            FROM `".$this->table."` vk
            WHERE vk.geloescht = 0;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    // Neu erstellen
    public function newKlausel($data) {

        $req = new Request($data);
        $req2 = new Request($data);

        

    //    echo "<pre>";
    //    print_r($data);
    //    echo "</pre>";
    //    die();

        // Wenn es schon eine Klauseln für den Vertrag gibt 
        // $req->checkDuplicateCombination('Für diesen Vertrag wurde schon eine Klausel angelegt!', $this->table, ['vertraegegruppen_id' => $data['vertraegegruppen_id']['value'], 'vertraegeart_id' => $data['vertraegeart_id']['value'] ]);

        // Wenn keine Duplette gefunden wurde
        // if(!$req->error) {

        // $vertrageKlauseln = new VertraegeKlauseln();

        // Holt die Aktuelle Version der Gruppen
        // $result = $vertrageKlauseln->getGruppenVersion($req2->data['vertraegegruppen_id']['value']);

 
        // Wenn die Abfrage erfolgreich war
        // if($result['success']) {

        //     // Wenn die Aktuelle Version ungleich mit der Version ist die mitgegeben wurde aus der Form
        //     if($result['data']['version'] != $req->data['version']) {

        //         $vertrageKlauseln->updateGruppenVersion($req2->data['vertraegegruppen_id']['value'], $req->data['version']);

        //         $vertrageKlauseln->updateKlauselnVersion($req2->data['vertraegegruppen_id']['value'], $req->data['version']);


        //     } 

        // Version auf 1 Setzen
        $req->data['version'] = 1;

        // Wenn Aktiv gesetzt ist dann den Status direkt auf Aktiv setzen ansonsten Entwurf
        $req->data['status_id'] = ( ($req->data['status_aktiv']['checked'] == 'true') ? 2 : 1);

        // Mitarbeiter der angemeldet ist hat die Klausel angelegt
        $req->data['mitarbeiter_id'] = $_SESSION['user']['id'];

        // Uhrzeit wann die Klausel angelegt wurde
        $date = new DateTime(); 
        $date = $date->format("d.m.Y H:i:s");

        $req->data['timestamp'] = $date;

      

        $process = [
            ['t', 'text'],
            ['s', 'gruppen_id'],
            ['t', 'status_id'],
            ['c', 'standard'],
            ['t', 'version'],
            ['t', 'auschluss_klassen'],
            ['t', 'mitarbeiter_id'],
            ['dt', 'timestamp']
        ];

        $req->insert($this->table, $process);

        // Wenn es Erfolgreich war
        if($req->success) {

            // Request
            $req2 = new Request();

            // Klauselreferenz ID auf die die ID setzen
            $req2->data['klausel_referenz_id'] = $req->result;

            // Process Array
            $process2 = [
                ['t', 'klausel_referenz_id']
            ];

            // Update Query Durchführen
            $req2->update($this->table, $process2, 'WHERE `id` = '. $req->result .'');

            // Wenn Klausel Standard ist dann direkt in die Klausel Vorlagen einfügen
            if($req->data['standard']['checked'] == 'true') {

                $req3 = new Request();

                // Referenz der Klasse
                $vertrageVorlagen = new VertraegeVorlagen();

                // Alle Vorlagen die Existieren holen
                $result = $vertrageVorlagen->getVorlagen();

                // Gelöscht auf 0 setzen
                $req3->data['geloescht'] = 0;

                // Klausel ID auf die Aktuelle Vergebene ID setzen
                $req3->data['klausel_id'] = $req->result;

                // Wenn es Erolgreich war und es Daten gibt
                if($result['success'] || (isset($result['data']) && $result['data'])) {

                    // Geht Schleife durch alle Vorlagen durch
                    foreach($result['data'] as $key => $value) {

                        // Vorlagen ID ist ID der Date
                        $req3->data['vorlagen_id'] = $value['id'];
                        
                        $process3 = [
                            ['t', 'vorlagen_id'],
                            ['t', 'klausel_id'],
                            ['t', 'geloescht']
                        ];

                        $req3->insert('vertraege_klauseln_vorlagen', $process3);
 
                    }

                    
                // Wenn Keine Vorlage Existiert dann Null
                } else {

                    // Vertrags Vorlage auf Null setzen weil Stanadard ist für alle Gültig
                    $req3->data['vorlagen_id'] = false;

                    $process3 = [
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id'],
                        ['t', 'geloescht']
                    ];
    
                    // Insert in die Tabele
                    $req3->insert('vertraege_klauseln_vorlagen', $process3);

                }

            }


        }

        return $req2->answer();
    }



    // Funktion die die Gruppen Version Updated
    public function updateGruppenVersion($id, $version) {

        $req = new Request();

        // Version in Req reinschreiben
        $req->data['version'] = $version;
 
        // Process Array mit der neuen Version
        $process = [
            ['t', 'version']
        ];

        // Update Query
        $req->update('vertraege_gruppen', $process, 'WHERE `id` = '. $id .'');

        // Rückgabe
        return $req->answer();

    }

    // Updatet Alle alten Klauseln auf die neue Version
    public function updateKlauselnVersion($vertraegegruppen_id, $version) {

        $req = new Request(); 

       
        $vertrageKlauseln = new VertraegeKlauseln();

        // Holt erst alle Klauseln mit der vertraegegruppen
        $result = $vertrageKlauseln->getKlauselnByGruppe($vertraegegruppen_id);

        $req->data['gruppen_id'] = "";
        $req->data['text'] = "";
        $req->data['standard'] = "";
        $req->data['version'] = "";
        $req->data['auschluss_klassen'] = "";


        // Schleife geht durch alle Einträge durch und ändert die Version
        foreach($result['data'] as $key => $value) {

            $req->data['gruppen_id'] = $value['gruppen_id'];
            $req->data['text'] = $value['text'];
            $req->data['standard'] = $value['standard'];
            $req->data['version'] = $version;
            $req->data['auschluss_klassen'] = $value['auschluss_klassen'];

            // Process Array
            $process = [
                ['t', 'gruppen_id'],
                ['t', 'text'],
                ['t', 'standard'],
                ['t', 'version'],
                ['t', 'auschluss_klassen'],
            ];
            
            // Query
            $req->insert($this->table, $process);

        }

        // Rückgabe
         return $req->answer();


    }

    // Wie Edit aber Insert neue Version
    public function editKlausel($id, $data) {

        $req = new Request($data);

        // // Holt die Aktuellste Version der Klausel
        // $vertrageKlauseln = new VertraegeKlauseln();

        // // Holt die Aktuellen Daten
        // $result = $vertrageKlauseln->getVersion($req->data['klausel_referenz_id']); 

        // // Wenn die Abfrage Okey ist dann die Version Hochsetzen
        // if($result['success']) {

        //     // Wenn die Texte unterschiedlich sind
        //     // if($result['data'][0]['text'] != $req->data['text']) {


        //         // Var für Version die dann überschrieben wird
        //         $version = "";

        //         // Erhöht die höchste Version dieser Klausel
        //         if( !empty($result['data']) && is_array($result['data']) ) {

        //             // Version Hochzählen
        //             $version = $result['data'][0]['version'] + 1;
        //         }
                
        //         // Dann ist es die 2 Version der Klausel
        //         else {

        //             // Version Hochzählen
        //             $version = $req->data['version'] + 1;

        //         }

        //         // Version überschreiben mit der Neuen Version
        //         $req->data['version'] = $version;

        //     // }
          

        //     // Wenn Die Klausel Referenz leer ist --- Klausel Refernz
        //     if(isset($result['data'][0]['klausel_referenz_id']) && $result['data'][0]['klausel_referenz_id'] != null) {
                    
        //         // Klausel Refernz
        //         $req->data['klausel_referenz_id'] = $result['data'][0]['klausel_referenz_id'];
        //     }

        //     // Ansonste ist es die aktuelle ID
        //     else {
        //         $req->data['klausel_referenz_id'] = $id;

        //     }

        // Process Array
        $process = [
            ['t', 'text'],
            ['s', 'gruppen_id'],
            ['c', 'standard']
        ];

            // Update Query
        $req->update($this->table, $process, 'WHERE `id` = '. $id .'');


        // }

        return $req->answer();

    }

    // Klausel Entwurf loeschen
    public function entwurfLoeschen($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->table, $id);

        // Wenn das Löschen Erfolgreich war
        if($req->success) {

            // Request
            $req2 = new Request();

            // Query
            $query = "DELETE FROM vertraege_klauseln_vorlagen WHERE vertraege_klauseln_vorlagen.klausel_id = '".$id."'";

           echo "<pre>";
           print_r($query);
           echo "</pre>";
           die();

            // Query Ausführen
            $req2->deleteQuery($query);

        }

        // Rückgabe
        return $req->answer();
    
    }

    // Klausel Version Aktivieren
    public function klauselAktivieren($id) {

        // Request
        $req = new Request();

        // Referenz der Klassen
        $vertrageKlauseln = new VertraegeKlauseln();

        // Get Funktion 
        $result = $vertrageKlauseln->getKlausel($id); 

        // Wenn es Erfolgreich war
        if($result['success']) {

            $req2 = new Request();

            $req2->data['status_id'] = 3;

            // Process Array
            $process2 = [
                ['t', 'status_id']
            ];

            // Setz alle Anderen außer die aktuelle Version auf "Alte Version" 
            $req2->update($this->table, $process2, 'WHERE `klausel_referenz_id` = '. $result['data']['klausel_referenz_id'] .' AND id != '.$id.'');

        }

        // Status Id auf Aktiv setzen
        $req->data['status_id'] = 2;

        // Process Array
        $process = [
            ['t', 'status_id']
        ];

        // Update Query
        $req->update($this->table, $process, 'WHERE `id` = '. $id .'');

        return $req->answer();

    }

    // Neue Version der Klausel Veröffentlichen
    public function klauselVersionNeu($id) {

        // Request
        $req = new Request();
        $req2 = new Request();

        // Instanz der Klasse
        $vertrageKlauseln = new VertraegeKlauseln();

        // Holt alle Daten der Klausel 
        $result = $vertrageKlauseln->getKlausel($id);

        // Wenn die Abfrage erfolgreich watr
        if($result['success']) {

            // Alle Daten in ein neues req Setzen
            $req2->data = $result['data'];

            // Holt die MAX Version der Refernz ID
            $resultVersion = $vertrageKlauseln->getVersion($result['data']['klausel_referenz_id']); 

            // Var für Version die dann überschrieben wird
            $version = "";

            // Erhöht die höchste Version dieser Klausel
            if( !empty($resultVersion['data']) && is_array($result['data']) ) {

                // Version Hochzählen
                $version = $resultVersion['data'][0]['version'] + 1;
            }
            
            // Dann ist es die 2 Version der Klausel
            else {

                // Version Hochzählen
                $version = $result['data']['version'] + 1;

            }

            // Version hochzählen
            $req2->data['version'] = $version;

            // Klausel Referenz auf die Aktuelle ID
            $req2->data['klausel_referenz_id'] = $result['data']['klausel_referenz_id'];

            // Status Erneut auf Entwurf setzen
            $req2->data['status_id'] = 1;

            // Mitarbeiter der angemeldet ist hat die neue Verseion Klausel angelegt
            $req2->data['mitarbeiter_id'] = $_SESSION['user']['id'];

            // Uhrzeit wann die Klausel angelegt wurde
            $date = new DateTime(); 
            $date = $date->format("d.m.Y H:i:s");

            $req2->data['timestamp'] = $date;

           // Process Array
            $process = [
                ['t', 'gruppen_id'],
                ['t', 'klausel_referenz_id'],
                ['t', 'status_id'],
                ['t', 'version'],
                ['t', 'text'],
                ['t', 'auschluss_klassen'],
                ['t', 'geloescht'],
                ['t', 'mitarbeiter_id'],
                ['dt', 'timestamp']
            ];

            // Query Insert
            $req2->insert($this->table, $process);

        }

        // Rückgabe
        return $req2->answer();

    }


    public function deleteKlausel($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple('vertraege_klauseln_vorlagen', $id);

        // Rückgabe
        return $req->answer();

        // Request
        // $req = new Request();

        // // 
        // $vertrageKlauseln = new VertraegeKlauseln();

        // $req2 = new Request();

        // // Query
        // $query = "DELETE FROM vertraege_klauseln_vorlagen WHERE vertraege_klauseln_vorlagen.klausel_id = '".$id."'";

        // // Query Ausführen
        // $req2->deleteQuery($query);


        // // Rückgabe
        // return $req->answer();
  
        // // Wenn id nicht leer ist
        // // if(!empty($id)) {

        //     // Aufruf der Funktion in den Klauseln
        //     // $result = $vertrageKlauseln->deleteHelper($id, $this->table); 

        //     // Wenn das erfolgreich war sollen Alles IDs auf in der vertraege_vorlagen als Gelöscht markiert werden
        //     // if($result->success) {

        //         // Aufruf der Funktion in den Klauseln
        //         $req = $vertrageKlauseln->deleteHelper($id, "vertraege_klauseln_vorlagen"); 

        //     // }

        // // }

        // // Rückgabe
        // return $req->answer();
    }

    public function deleteHelper($id, $table) {

        $req = new Request();

        // gelöscht Markieren
        $req->data['geloescht'] = 1;

        // Schleife geht durch alle IDs
        foreach($id as $key => $value) {

            // Nur Als Gelöscht markieren
            $process = [
                ['t', 'geloescht']
            ];

            // Wenn Vertraege Vorlagen dann andere Where Bedingung
            $where = ( ($table == 'vertraege_klauseln_vorlagen') ? "WHERE klausel_id = '" . $value . "'" : "WHERE id = '" . $value . "'");

            // Update Query
            $req->update($table, $process, $where);

        }

        return $req;

    }

    // Lädt die Timeline Daten
    public function loadTimeline($id) {

        $success = $error = false;

        // Request
        $req = new Request();

        // Referenz der Klasse
        $vertrageKlauseln = new VertraegeKlauseln();

        // Holt Alle Daten zu der Klausel
        $result = $vertrageKlauseln->getKlausel($id);

        // Wenn die Abfrage erfolgreich war
        if($result['success']) {

            $req->data = $vertrageKlauseln->getByKlauselRefenz($result['data']['klausel_referenz_id']);

            // Wenn die Abfrage der Referenzz Id erfolgreich war
            if($req->data['success'] == '1') {
                $success  = true;
            } else {
                $error = "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!";
            }

        }

        return [
            'success' => $success,
            'error' => $error,
            'data' => $req->data,
        ];

    }
}
