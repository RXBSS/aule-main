<?php

class AkquisePosition {

public $table = "akquise_positionen";

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

    // Funktion die die letzen 3 Einträge aus der Datenbank holt
    public function getHistory() {

        $req = new Request();

        $query = "
            SELECT MAX(ap.zeitstempel) AS last_call, ap.*, a.*, ad.name AS adressenName, ak.name as aktionName, m.vorname AS mitarbeiterVorname, m.nachname AS mitarbeiterNachname
            FROM `akquise_positionen` ap 
            LEFT JOIN `akquise` a ON a.id = ap.akquise_id
            LEFT JOIN `adressen` ad ON ad.id = a.adressen_id
            LEFT JOIN `akquise_aktionen` ak ON ak.id = a.aktion_id
            LEFT JOIN `mitarbeiter` m ON m.id = ap.bearbeiter_id
            WHERE ap.bearbeiter_id  = '".$_SESSION['user']['id']."'
            GROUP BY ap.akquise_id
            ORDER BY last_call DESC 
            LIMIT 8;
        ";

        $req->getMultiQuery($query, true);

        return $req->answer();

    }

    public function getAkquise($id) {
        $req = new Request();

        $req->get('akquise', $id);

        return $req->answer();
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        // Get Akquise für Wiedervorlage
        $akquise = new AkquisePosition();
        $res = $akquise->getAkquise($data['post']['additional']['id']);

        // Notification 
        $notification = new Notification();

        // Daten vorbereiten
        $newData = [
            'akquise_id' => $data['post']['additional']['id'],
            'bearbeiter_id' => $data['post']['additional']['sessionID'],
            'art' => '',
            'text' => '',
            'ersteller' => $data['post']['formData']['bearbeiter_id'],
            'wiedervorlage',
            'kundentermin',
            'bearbeiter_wechsel'
        ];


        // NOTIFICATION status nicht erfolgreich
        $notificationData = [
            'data' =>  $data['post']['additional']['id'],
            'user_id' => $_SESSION['user']['id'],
            'aktion' => '',
            'text' => ''
        ];

        // Wenn Kein Icon Mitgegeben wurde aber es einen Text gibt UND Zuständigkeit Aktiv
        if($data['post']['additional']['text'] && $data['post']['formData']['bearbeiter_id']['value'] && $data['post']['formData']['art'] === 'false') {
            $data['post']['formData']['art'] = '5';
        }

        // Wenn Kein Icon Mitgegeben aber es gibt einen Text UND wiedervorlage Aktiv
        if($data['post']['additional']['text'] && $data['post']['formData']['wiedervorlageDatum'] &&  $data['post']['formData']['art'] === 'false') {
            $data['post']['formData']['art'] = '4';
        }


        // Wenn nur die WIEDERVORLAGE geändert wird
        if($data['post']['additional']['text'] == '' && $data['post']['formData']['wiedervorlageDatum']) {

            $akquisePos = new AkquisePosition();

            // Daten Vorbereiten
            $newData['text'] = 'change_wiedervorlage';
            $newData['art'] = 13;
            $newData['wiedervorlage'] = $data['post']['formData']['wiedervorlageDatum']." ". $data['post']['formData']['wiedervorlageUhrzeit'];

            // Notification Data Abändern
            $notificationData['aktion'] = 'akquise_change_wiedervorlage';

            // Set Notification
            $notification->new($notificationData);

            // DAmit die Wiedervorlage in der Position Tabelle geändert wird
            $resAkquisePos = $akquisePos->insertOnlyWiedervorlage($newData);
           
            // Damit die Wiedervorlage in der Haupttabelle geändert wird
            $resAkquise = $akquisePos->akquiseDates($newData);

            // Wenn es Erfolgreich war
            if($resAkquisePos['success'] == 1 && $resAkquise['success'] == 1) {
                $success = true;
            } else {
                $error = true;
            }

           

        // Wenn Nur ZUSTÄNDIGKEIT gewechselt wird
        } else if($data['post']['additional']['text'] == '' && $data['post']['formData']['bearbeiter_id']['value']) {

            $date = new DateTime();

            $akquisePos = new AkquisePosition();

            // Daten Vorbereiten
            $newData['text'] = 'change_bearbeiter';
            $newData['art'] = 5;
            $newData['bearbeiter_wechsel'] = $data['post']['formData']['bearbeiter_id']['value'];
            $newData['wiedervorlage'] = $date->format('d.m.Y H:i:s');

            // Notification
            // $notificationData['aktion'] = 'change_zustaendigkeit_akquise';

            // Set Notification
            // $notification->new($notificationData);


            // Zuständigkeit in der Haupttabeelle ändern
            $zustaendigkeit = $akquise->zustaendigkeitAendern($newData);
            $aktion = $akquise->akquiseAktion($newData);

            // Damit die Wiedervorlage in der Haupttabelle geändert wird
            $resAkquise = $akquisePos->akquiseDates($newData);

            // Wenn es Erfolgreich war
            if($zustaendigkeit['success'] == 1 && $aktion['success'] == 1) {
                $success = true;
            } else {
                $error = true;
            }

        } else {

          

            // Wenn die Activation Checkbox Benutzer Definierte Zeit Unchecked ist
            if($data['post']['formData']['mehrAnzeigenZeitstempel']['checked'] === 'false') {
                $data['post']['formData']['zeitstempelDatum']  = "";
            }

            // Wenn die Activation Checkbox Wiedervorlage Unchecked ist
            if($data['post']['formData']['wiedervorlagemehrAnzeigen']['checked'] === 'false') {
                $data['post']['formData']['wiedervorlageDatum']  = "";
            } 


            // Query MAIN
            $query = "INSERT INTO `".$this->table."` SET 
                `akquise_id` = '".$data['post']['additional']['id']."',
                `zeitstempel` = ".((!$data['post']['formData']['zeitstempelDatum']) ? "DEFAULT" : "'".$data['post']['formData']['zeitstempelDatum']." ". $data['post']['formData']['zeitstempelUhrzeit']."'").",
                `bearbeiter_id` = '".$data['post']['additional']['sessionID']."',
                `bearbeiter_wechsel` = ".((!$data['post']['formData']['bearbeiter_id']['value']) ? "DEFAULT" : "'".$data['post']['formData']['bearbeiter_id']['value']."'").",
                `art` = '".$data['post']['formData']['art']." ',
                `text` = '".$data['post']['additional']['text']." ',
                `wiedervorlage` = ".((!$data['post']['formData']['wiedervorlageDatum']) ? "DEFAULT" : "'".$data['post']['formData']['wiedervorlageDatum']." ". $data['post']['formData']['wiedervorlageUhrzeit']."'").",
                `kundentermin` = ".((!$data['post']['formData']['kundenterminDatum']) ? "DEFAULT" : "'".$data['post']['formData']['kundenterminDatum']." ". $data['post']['formData']['kundenterminUhrzeit']."'")."
                ";
            
            // Wenn es eine eigene Wiedervorlage gibt dann soll die auch in Akquise Haupttabelle Geändert werden
            if($data['post']['formData']['wiedervorlageDatum']) {

                $akquisePos = new AkquisePosition();

                // Daten vorbereiten
                $newData['wiedervorlage'] = $data['post']['formData']['wiedervorlageDatum']." ". $data['post']['formData']['wiedervorlageUhrzeit'];

                // In die Positionen Tabelle mit übernehmen die Wiedervorlage
                $akquisePos->akquiseDates($newData);

                // Notification
                $notificationData['aktion'] = 'akquise_change_wiedervorlage';

                // Set Notification
                $notification->new($notificationData);

            }

            // Wenn es eine eigenen Kundentermin gibt dann soll die auch in der Akquise Haupttabelle Geändert werden
            if($data['post']['formData']['kundenterminDatum']) {

                $akquisePos = new AkquisePosition();

                // Daten vorbereiten
                $newData['kundentermin'] = $data['post']['formData']['kundenterminDatum']." ". $data['post']['formData']['kundenterminUhrzeit'];

                // In die Positionen Tabelle mit übernehmen die Wiedervorlage
                $akquisePos->akquiseDates($newData);

                // Notification
                $notificationData['aktion'] = 'akquise_change_kundentermin';

                // Set Notification
                $notification->new($notificationData);
            }

            // Wenn es Erfolgreich war
            if($db->query($query)) {
                $id = $db->insert_id;

                $success = true;

                // Notification
                $notificationData['aktion'] = 'akquise_add_text';
                $notificationData['text'] = $data['post']['additional']['text'];

                // Zuständigkeit wurde geändert
                if($data['post']['compareData']['bearbeiter_id']['nachher']['value']) {

                    $date = new DateTime();

                    // Daten Vorbereiten
                    $newData['wiedervorlage'] = $date->format('d.m.Y H:i:s');

                    // 
                    $requ = new Request($newData);

                    $process = [
                        ['dt', 'wiedervorlage']
                    ];
    
                    // Update Wieder
                    $requ->update($this->table, $process, "WHERE `id` = '" . $db->insert_id . "'");
                }

                // Set Notification
                $notification->new($notificationData);

            } else {
                $error = $db->error;
            }

            // Zuständigkeit ändern
            if($data['post']['compareData']['bearbeiter_id']['nachher']['value']) {

                $akquisePos = new AkquisePosition();

                // Daten Vorbereiten
                $newData['text'] = $data['post']['formData']['bearbeiter_id']['text'].' ist nun Bearbeiter der Akquise';
                $newData['art'] = 5;

                // $akquise->zustaendigkeitAendern($newData);
                $akquise->akquiseAktion($newData);

                $date = new DateTime();

                // Daten Vorbereiten
                $newData['wiedervorlage'] = $date->format('d.m.Y H:i:s');

                // $zustaendigkeit = $akquise->zustaendigkeitAendern($newData);
    
                // Damit die Wiedervorlage in der Haupttabelle geändert wird
                $resAkquise = $akquisePos->akquiseDates($newData);

                // $changeWiedervorlage = $akquisePos->akquiseWiedervorlage($newData);

                // return $requ->answer();
    

                // Notification
                // $notificationData['aktion'] = 'change_zustaendigkeit_akquise';

                // Set Notification
                // $notification->new($notificationData);

            }

        }


        return [
            'success' => $success,
            'error' => $error,
            'id' => $id,
            // 'bearbeiterId' => $bearbeiterID,
            // 'akquiseId' => $data['post']['additional']['id'],
        ];
    }

    public function akquiseWiedervorlage() {
        
    }

    // Löschen
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

    // Wenn der bearbeiter geändert wurde wird dass auch in der Haupttabelle Akquise übernommen
    public function akquiseAktion($data) {

        global $db;
        $success = $error = $id = false;

        // Query
        $query = "UPDATE `akquise` SET 
            `bearbeiter_id` = '".$data['ersteller']['value']."'
             WHERE `id` = '".$data['akquise_id']."' ;
        ";
        
        // Erfolg
        if($db->query($query)) {
            $id = $db->insert_id;

            $success = true;
        
            // Notification 
            $notification = new Notification();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data['akquise_id'],
                'text' =>  $data['text'],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'change_zustaendigkeit_akquise'
            ];

            $notification->new($notificationData);

        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error,
            'id' => $id,
            'query' => $query
        ];
    }

    // Ändert die Wiedervorlage und einen Kundentermin
    public function akquiseDates($data) {

        $req = new Request($data);

        // 
        $process = [
            ['dt', 'wiedervorlage'],
            ['dt', 'kundentermin']
        ];

        // Insert Query
        $req->update('akquise', $process, "WHERE `id` = '" . $data['akquise_id'] . "'");

        return $req->answer();



        // global $db;
        // $success = $error = false;

        // $query = "UPDATE `akquise` SET 
        //     `wiedervorlage` = '".$data['wiedervorlage']."'
        //     WHERE `id` = '".$data['akquise_id']."';
        //  ";

        // if($db->query($query)) {
        //     $success = true;

        // } else {
        //     $error = $db->error;
        // }

        // return [
        //     'success' => $success,
        //     'query' => $query,
        //     'error' => $error
        // ];
    }

    // Zuständigkeit (Bearbeiter) der Akquise wird geändert
    public function zustaendigkeitAendern($data) {

        $req = new Request($data);

        // 
        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'bearbeiter_wechsel'],
            ['dt', 'wiedervorlage'],
            ['t', 'art'],
            ['t', "text"]
        ];

        // Insert Query
        $req->insert($this->table, $process);

        return $req->answer();

    }

    public function insertOnlyWiedervorlage($data) {

        $req = new Request($data);

        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'wiedervorlage'],
            ['t', 'art'],
            ['t', "text"]
        ];

        // Insert Query
        $req->insert($this->table, $process);

        // Erfolg
        if($req->success) {

            // Notification 
            $notification = new Notification();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data['akquise_id'],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'change_wiedervorlage_akquise'
            ];

            $notification->new($notificationData);

        }

        return $req->answer();

    }
}
?>