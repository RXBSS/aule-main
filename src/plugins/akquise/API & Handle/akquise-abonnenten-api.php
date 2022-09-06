<?php

class AkquiseAbo {

public $table = "akquise_abonnenten";

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

    public function getAkquiseAbonnenten($id) {

        $req = new Request();

        $req->getByKey('akquise_abonnenten', 'akquise_id', $id);

        return $req->answer();
    }

    // Holt alle IDs über eine Akquise die Abonniert wurde
    public function getAkquiseAbo($id) {

        global $db;
        $data = false;
        $arr = [];
        
        $query = "SELECT * FROM `akquise_abonnenten` WHERE `akquise_abonnenten`.`akquise_id` = '".$id."' ";
        $result = $db->query($query);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }

        return $arr;
    }

    public function getAkquiseAboMultiple($data) {
     
        $id = "";
        if($_POST['task'] == 'getAkquiseAbo') {
            $id = $_POST['data'];
        } else {
            $id = $data;
        }

        $req = new Request();

        $query = "SELECT * FROM `" . $this->table . "` WHERE `akquise_id` = '" . $id . "' AND `mitarbeiter_id` = '" . $_SESSION['user']['id'] . "' ;";

        $req->getQuery($query);

        return $req->answer();

    }

    // Wenn ein Mitarbeiter die Akquise Abonniert hat // Sichtbar sein
    public function getAkquiseAboNotification() {
     
        $req = new Request();

        $query = "SELECT * FROM `" . $this->table . "` WHERE `mitarbeiter_id` = '" . $_SESSION['user']['id'] . "' AND `abonniert` = 1 ;";

        $req->getMultiQuery($query);

        return $req->answer();

    }

    

    // Neu erstellen
    public function setAbo($data) {

        $akquiseAbo = new AkquiseAbo();

        $akquise = new Akquise();

        // Notification 
        $notification = new Notification();

        // Prüfen ob der Mitarbeiter schon in der Akquise Aboniert ist
        $res = $akquiseAbo->getAkquiseAboMultiple($data);

        // NOTIFICATION status nicht erfolgreich
        $notificationData = [
            'data' =>  $data,
            'user_id' => $_SESSION['user']['id'],
            'aktion' => ''
        ];

        // Abonniert Data
        $aboData = [
            'akquise_id' =>  $data,
            'bearbeiter_id' => $_SESSION['user']['id'],
            'art',
            'text'
        ];

        // Wenn kein Abo vorhanden ist
        if(!$res['success']) {

            $newData = [
                'mitarbeiter_id' => $_SESSION['user']['id'],
                'akquise_id' => $data,
                'abonniert' => 1
            ];

            $req = new Request($newData);

            $process = [
                ['t', 'mitarbeiter_id'],
                ['t', 'akquise_id'],
                ['t', 'abonniert']
            ];

            $req->insert($this->table, $process);


            // Wenn es Erfolgreich war
            if($req->success) {

                // NOTIFICATION ABONNIERT
                $notificationData['aktion'] = 'akquise_abonniert';
                $notification->new($notificationData);

                // ABONNIERT Soll mit in der Timeline als Position aufgenommen werden 
                $aboData['art'] = 10;
                $aboData['text'] = 'akquise_abonniert';
                $akquiseAbo->akquisePositionenAbo($aboData);


            }


        } 
        
        // Wenn ein Abo Vorhanden ist
        else {

            // Wenn Abonniert ist und deaboniert werden soll
            if($res['data']['abonniert'] == '1') {

                $newData = [
                    'mitarbeiter_id' => $_SESSION['user']['id'],
                    'akquise_id' => $data,
                    'abonniert' => 0
                ];

                // NOTIFICATION deabonniert
                $notificationData['aktion'] = 'aqkuise_deabonniert';

                // Abonniert soll mit in der Timeline aufgenommen werden
                $aboData['art'] = 11;
                $aboData['text'] = 'aqkuise_deabonniert';

            } 
            
            // Wenn Deaboniert ist und Abonniert werden soll
            else {

                $newData = [
                    'mitarbeiter_id' => $_SESSION['user']['id'],
                    'akquise_id' => $data,
                    'abonniert' => 1
                ];

                // NOTIFICATION abonniert
                $notificationData['aktion'] = 'akquise_abonniert';

                // Abonnniert
                $aboData['art'] = 10;
                $aboData['text'] = 'akquise_abonniert';

            }
            
            $req = new Request($newData);

            $process = [
                ['t', 'mitarbeiter_id'],
                ['t', 'akquise_id'],
                ['t', 'abonniert']
            ];

            $req->update($this->table, $process, "WHERE id = '".$res['data']['id']."'");

            // Wenn es Erfolgreich angepast wurde
            if($req->success) {

                // NOTIFICATION ausführen
                $notification->new($notificationData);

                // Abonniert soll mit in der Timeline aufgenommen werden
                $akquiseAbo->akquisePositionenAbo($aboData);


            }

        }
       
        return $req->answer();

    }

    // Funktion die das Abonnieren oder Deabonnieren mit in die Timeline setzt
    public function akquisePositionenAbo($data) {

        // Req
        $req = new Request($data);

        // Process Array
        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'art'],
            ['t', 'text']
        ];

        // Insert Query
        $req->insert('akquise_positionen', $process);

        // Response
        return $req->answer();

    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $query = "UPDATE `".$this->table."` SET 
            `field1` = '".$data['field1']."',
            `field2` = '".$data['field2']."'
            WHERE `id` = '".$id."';
         ";

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