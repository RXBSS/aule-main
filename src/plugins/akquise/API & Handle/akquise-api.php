<?php



class Akquise {

    public $table = "akquise";

    function __construct() {
        // Do Something at Construction
    }



    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    public function getAkquisePositionen($id) {

        $req = new Request();

        $query = "
            SELECT ap.*, ap.text AS positionenText, ag.bezeichnung AS ablehnungsGrundBezeichnung, ap.wiedervorlage AS wiedervorlagAP, ap.zeitstempel AS zeitstempelAP, am.text AS meilensteinText, ak.*, a.* ,s.*, s1.bereich AS akquiseStatus, s1.bezeichnung AS akquiseBezeichnung, ap.wiedervorlage AS positionenWiedervorlage, m.vorname AS bearbeiterVorname, m.nachname AS bearbeiterNachnem, m2.vorname AS wechselVorname, m2.nachname AS wechselNachname
            FROM akquise_positionen ap
            LEFT JOIN akquise a on ap.akquise_id = a.id and ap.akquise_id = 1
            LEFT JOIN akquise_aktionen ak on a.aktion_id = ak.id
            LEFT JOIN mitarbeiter m on ap.bearbeiter_id = m.id
            LEFT JOIN mitarbeiter m2 on ap.bearbeiter_wechsel = m2.id
            LEFT JOIN status s on s.status_id = ap.art AND s.bereich = 'akquise_positionen'
            LEFT JOIN status s1 on s1.status_id = a.status AND s1.bereich = 'akquise'
            LEFT JOIN akquise_meilenstein am ON am.id = ap.meilenstein_id
            LEFT JOIN akquise_ablehnungsgrund ag ON ag.id = ap.ablehnungsgrund_id
            WHERE ap.akquise_id = '" . $id . "'
            ORDER BY zeitstempelAP ASC;
        ";

        $req->getMultiQuery($query, true);

        return $req->answer();
    }

    public function getAkquisePosition($id) {

        global $db;
        $data = false;
        $arr = [];

        $query = "SELECT * FROM `akquise_positionen` WHERE `akquise_positionen`.`akquise_id` = '" . $id . "' ORDER BY `akquise_positionen`.`zeitstempel` ASC  ";
        $result = $db->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }

        return $arr;
    }

    // Holt den aktuellen Status
    public function getState($id) {
        $req = new Request();

        $query = "SELECT `status` FROM `akquise` WHERE `id` = '" . $id . "' ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    public function getAllAdressen($id) {

        $req = new Request();

        $query = "SELECT `adressen_id` FROM `akquise` WHERE `aktion_id` = '" . $id . "' ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    public function getAkquiseIcon() {

        $req = new Request();
        $req->getMultiByKey('status', 'bereich', 'akquise_positionen');
        return $req->answer();
    }

    // Holt den Aktuelle Bearbeiter der Akquise
    public function getBearbeiter($id) {

        $req = new Request();

        $query = "SELECT `bearbeiter_id` FROM `akquise` WHERE `id` = '" . $id . "' ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Holz den Aktuellen Kundentermin der Akquise
    public function getKundentermin($id) {

        $req = new Request();

        $query = "SELECT `kundentermin` FROM `akquise` WHERE `id` = '" . $id . "' ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Zählt die Aktionen Status für die Statistik
    public function getStatusForStatistic($id) {

        $req = new Request();

        $query = "

            SELECT COUNT(a2.status) as erfolgreich, (SELECT COUNT(a1.status) as offen FROM akquise a1 WHERE a1.status = 0) AS offen, (SELECT COUNT(a1.status) as offen FROM akquise a1 WHERE a1.status = 2) AS nicht_erfolgreich
            FROM akquise a2
            WHERE a2.status = 1 AND aktion_id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Zählt die Aktionen Status für die Statistik
    public function getStatusForStatisticERF($id) {

        $req = new Request();

        $query = "
            SELECT COUNT(status) as Erfolgreich FROM `akquise` WHERE status = 1 AND aktion_id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Zählt die Aktionen Status für die Statistik
    public function getStatusForStatisticNOT($id) {

        $req = new Request();

        $query = "
            SELECT COUNT(status) as Nicht_Erfolgreich FROM `akquise` WHERE status = 2 AND aktion_id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Holt die Daten der Akquise Aktion
    public function getAkquiseAktion($id) {

        $req = new Request();

        $query = "
            SELECT wiedervorlage_nach FROM `akquise_aktionen` WHERE id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Holt den Ablehnungsgrun aus der Akquise_ablehnungsgrund Tabelle
    public function getAkquiseAblehnungsgrund($id) {

        $req = new Request();

        $query = "
            SELECT * FROM `akquise_ablehnungsgrund` WHERE id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Holt Alle Status der Offen sind
    public function getStatusOffen($id) {


        $akquise = new Akquise();

        // holt die Nötigen Daten aus der Zeile
        $res = $akquise->get($id);

        // Zählt alle Einträge die Offen sind
        $query = "
            SELECT a.*, adr.name AS firmenname, ak.name AS aktionname
            FROM `" . $this->table . "` a
            LEFT JOIN `adressen` adr ON `adr`.`id` = `a`.`adressen_id`
            LEFT JOIN `akquise_aktionen` ak ON `ak`.`id` = `a`.`aktion_id`
            WHERE adressen_id  = '" . $res['data']['adressen_id'] . "' AND status = '0';
            
            
        ";

        $req = new Request();

        // Übergibt die Query
        $req->getMultiQuery($query, true);

        return $req->answer();
    }

    // Funktion die den Namen des Kunden in die Aktion reinlädt
    public function getKundeName($id)  {

        $req = new Request();

        // holt die Nötigen Daten aus der Zeile
        // Zählt alle Einträge die Offen sind
        $query = "
            SELECT a.*, ak.name AS aktionName, adr.name AS kundenName
            FROM akquise a
            LEFT JOIN akquise_aktionen ak ON ak.id = a.aktion_id 
            LEFT JOIN adressen adr ON adr.id = a.adressen_id
            WHERE a.id =  '".$id."';
        ";

        // Übergibt die Query
        $req->getMultiQuery($query);

        return $req->answer();


    }

    // Lädt die TimelineForm
    public function loadTimelineForm($id) {

        $req = new Request();

        $query = "
            SELECT a.*, ak.*, m.vorname, m.nachname
            FROM `akquise` a
            LEFT JOIN `mitarbeiter` m ON m.id = a.bearbeiter_id
            LEFT JOIN `akquise_aktionen` ak ON ak.id = a.aktion_id
            WHERE a.id = '".$id."';
        ";

        $req->getMultiQuery($query);

        return $req->answer();

    }

    // Neu erstellen ------ Neuer Eintrag
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // Holt die Wiedervorlage Tage der Aktion damit es richtig eingetragen wird dem Kunden
        $akquise = new Akquise();
        $resAkquiseAktion = $akquise->getAkquiseAktion($data['res']['data']['id']);

        $post = $data['post']['data'][1];

        // Wiedervorlage Aktuelle Datum
        $wiedervorlage = new DateTime();

        // Intervall Wiedervorlage_nach
        // $interval = new DateInterval('P' . $resAkquiseAktion['data'][0]['wiedervorlage_nach'] . 'D');

        // Wenn ein neuer Kunde angelegt wird soll die Wiedervorlage nicht die von der Aktion sein sondern direkt Fällig
        $interval = new DateInterval('P0D');
        $wiedervorlage = $wiedervorlage->add($interval)->format('Y-m-d H:i:s');

        // TODO: WIEDERVORLAGE FÜGT NOCH KEIN DATUM HINZU
        // WAS IST WENN ICH JETZT 20 hinzfügen will dann SChleife

        foreach ($post as $key => $value) {

            $query = "INSERT INTO `" . $this->table . "` SET
                `bearbeiter_id` = '" . $_SESSION['user']['id'] . "',
                `ersteller_id` = '" . $_SESSION['user']['id'] . "',
                `aktion_id` = '" . $data['res']['data']['id'] . "',
                `adressen_id` = '" . $value[1] . "',
                `zeitstempel` = NOW(),
                `wiedervorlage` = '" . $wiedervorlage . "',
                `status` = '0',
                `ablehnungsgrund_id` = NULL;
            ";

            if ($db->query($query)) {
                $success = true;

                // 
                if ($_SESSION['user']['id']) {

                    // Custom Data für Abo
                    $aboData = [
                        'akquise_id' => $db->insert_id,
                        'mitarbeiter_id' => '',
                        'abonniert' => 1
                    ];


                    // Status Offen in die Timeline setzen
                    //  if($db->insert_id > 0) {

                    //     // Custom Data für Timeline Status Offen
                    //     $data = [
                    //         $db->insert_id,
                    //         'offen'
                    //     ];

                    //     // Status in die Timeline Eintragen
                    //     $akquise->statusErfolgreichOrOffen($data);
                    //     $akquise->akquisePositionStatus($db->insert_id, $data);
                    // }

                    // Für den der Angemeldet ist Automatisch einen Abo Erstellen wenn er eine Akquise Erstellt
                    $aboData['mitarbeiter_id'] = $_SESSION['user']['id'];

                    // 
                    $akquise->akquiseAbonniert($aboData);

                    // 
                    if (isset($data['bearbeiter_id']['value'])) {

                        // Für den Bearbeiter auch automatisch einen Abo Erstellen
                        $aboData['mitarbeiter_id'] = $data['bearbeiter_id']['value'];

                        // 
                        $akquise->akquiseAbonniert($aboData);
                    }

                    // **********
                    // Wenn ein neuer Kunden angelegt wird das der Status Offen angezeigt wird

                    $aboData['art'] = 6;
                    $aboData['text'] = 'status_0';
                    $aboData['wiedervorlage'] = $wiedervorlage;

                    $akquise->akquisePos($aboData);
                }
            } else {
                $error = $db->error;
            }
        }



        return [
            'success' => $success,
            'error' => $error,
            'query' => $query
        ];
    }

    // Wenn ein neuer Kunde angelegt wird soll die Position Status Offen gesetzt werden 
    public function akquisePos($data) {

        $data['bearbeiter_id'] = $_SESSION['user']['id'];

        $req = new Request($data);

        // Process Array
        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'art'],
            ['t', 'text'],
            ['t', 'wiedervorlage']
        ];

        // Query
        $req->insert('akquise_positionen', $process); 

        // Rückgabe
        return $req->answer();

    }

    public function delete($id) {

        global $db;
        $success = $error = false;

        $req = new Request($id);

        $req->deleteMultiple($this->table, $id);
        return $req->answer();
    }

    // Neuer Kunde zu einer akquise hinzugefügt
    public function newKunde($data) {

        $req = new Request($data);


        $akquise = new Akquise();
        $resAkquiseAktion = $akquise->getAkquiseAktion($req->data['aktion_id']['value']);

        $newData = new DateTime();

        // Nur wenn eine Akquise Aktion angegeben wurde ansonsten nicht
        // if ($resAkquiseAktion['success']) {

        //     // Wiedervorlage nicht mehr 10 Tage oder die von der Aktion sondern erstmal direkt fällig
        //     $add = $newData->add(new DateInterval('P' . $resAkquiseAktion['data'][0]['wiedervorlage_nach'] . 'D'));
        //     $format = $add->format('Y-m-d H:i:s');

        //     // Wenn es keinen Aktion vorhanden ist dann Automatisch Wiedervorlage auf 10 Tage setzen
        // } else {
        //     $add = $newData->add(new DateInterval('P10D'));
        //     $format = $add->format('Y-m-d H:i:s');
        // }

        // Wiedervorlage nicht mehr 10 Tage oder die von der Aktion sondern erstmal direkt fällig
        $add = $newData->add(new DateInterval('P0D'));
        $wiedervorlage = $add->format('Y-m-d H:i:s');



        // Notification 
        $notification = new Notification();

        // Notification
        $notificationData = [
            'data' =>  '',
            'user_id' => $_SESSION['user']['id'],
            'aktion' => ''
        ];

        // Ersteller wird in die Akquise Tabelle Eingepflegt
        $akquiseAktionen = new AkquiseAktionen();

        // Nur wenn es eine Akquisen Aktion ist
        // if($req->data['aktion_id']['value']) {
        //     $res = $akquiseAktionen->get($req->data['aktion_id']['value']);
        //     $req->data['ersteller_id'] = $res['data']['ersteller_id'];
        // } else {
        $req->data['ersteller_id'] = $_SESSION['user']['id'];
        // }

        $req->data['wiedervorlage'] =  $wiedervorlage;

        // Wenn der Kunde bereits in der Aktion vorhanden ist
        $req->checkDuplicateCombination("Dieser Kunden wurde bereits zu der Aktion hinzugefügt", "akquise", ['aktion_id' => $req->data['aktion_id']['value'], 'adressen_id' => $req->data['adressen_id']['value']]);

        // Wenn es keinern Eintrag gefunden wurde
        if (!$req->error) {

            // REST IST DEFAULT
            $process = [
                ['s', 'bearbeiter_id'],
                ['s', 'aktion_id'],
                ['s', 'adressen_id'],
                ['t', 'ersteller_id'],
                ['dt', 'wiedervorlage']
            ];

            $req->insert($this->table, $process);
        }

        $notificationData['data'] = $req->result;

        // Erfolg
        if ($req->success) {
            $akquise = new Akquise();

            // Kontakte Akquise - Nur wenn es einen Kontakt gibt
            if ($req->data['kontakt'] !== 'false') {
                $akquise->kontakteAkquise($req);
            }

            // Custom Data für Timeline Status Offen
            $data = [
                $req->result,
                'offen',
                $wiedervorlage
            ];

            // Status in die Timeline Eintragen
            $akquise->statusErfolgreichOrOffen($data);

            // NOTIFICATION Status wird auf Offen gesetzt
            $notificationData['aktion'] = 'akquise_status_offen';
            $notification->new($notificationData);

            // Nur wenn der Bearbeiter mit dem Angemeldeten Übereinstimmt
            if ($_SESSION['user']['id']) {

                // Custom Data für Abo
                $aboData = [
                    'akquise_id' => $req->result,
                    'mitarbeiter_id' => '',
                    'abonniert' => 1,
                    'automatisch' => true // Wenn der Mitarbeiter Automatisch Abonniert wird
                ];

                $aboData['mitarbeiter_id'] = $_SESSION['user']['id'];

                // Für den der Angemeldet ist Automatisch einen Abo Erstellen wenn er eine Akquise Erstellt
                $akquise->akquiseAbonniert($aboData);

                // Wenn der Bearbeiter ein anderer ist als der jenige der Angemeldet ist
                if ($_SESSION['user']['id'] != $req->data['bearbeiter_id']['value']) {

                    $aboData['mitarbeiter_id'] = $req->data['bearbeiter_id']['value'];

                    // Für den Bearbeiter auch automatisch einen Abo Erstellen
                    $akquise->akquiseAbonniert($aboData);
                }
            }

            // NOTIFICATIN akquise wurde erstellt
            $notificationData['aktion'] = 'create_akquise';
            $notification->new($notificationData);
        }

        return $req->answer();
    }

    // Status auf nicht Erfolgreich setzen
    public function statusNotErfolgreich($id, $data) {

        $req = new Request($data);

        // Notification 
        $notification = new Notification();

        $process = [
            ['s', 'ablehnungsgrund_id'],
            ['t', 'ablehnungsgrund_beschreibung'],
            ['t', 'status']
        ];

        // Update Query
        $req->update($this->table, $process, "WHERE id = '" . $id . "'");

        $akquise = new Akquise();

        // Positionen Tabelle
        $akquise->akquisePositionStatus($id, $data);

        // Erfolg
        if ($req->success) {

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $id,
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'akquise_status_nicht_erfolgreich'
            ];

            $notification->new($notificationData);
        }

        return $req->answer();
    }

    // Status auf Erfolgreich oder Offen setzen
    public function statusErfolgreichOrOffen($data) {

        global $db;
        $success = $error = $status = false;

        // Notification 
        $notification = new Notification();

        // Status Offen
        if ($data[1] == 'offen') {
            $status = 0;

            // Status Erfolgreich
        } else if ($data[1] == 'erfolgreich') {
            $status = 1;
        }

        // Query
        $query = "UPDATE `" . $this->table . "` SET 
            `status` = '" . $status . "'
            WHERE `id` = " . $data[0] . ";
        ";

        // Erfolg
        if ($db->query($query)) {
            $success = true;

            $akquise = new Akquise();

            $akquise->akquisePositionStatus($data[0], $data);

            // NOTIFICATION Erfolgreich oder Offe
            $notificationData = [
                'data' =>  $data[0],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => ''
            ];

            // NOTIFCATION
            if ($data[1] == 'offen') {

                // NOTIFICATION status offen
                $notificationData['aktion'] = 'akquise_status_offen';
            } else if ($data[1] == 'erfolgreich') {

                // NOTIFICATION status erfolgreich
                $notificationData['aktion'] = 'akquise_status_erfolgreich';
            }

            // Set Notification
            $notification->new($notificationData);
        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error,
            'id' => $data,
            'query' => $query
        ];
    }

    // Status auf Gelöscht setzen
    public function statusGeloescht($data) {

        global $db;
        $success = $error = $status = false;

        // Notification 
        $notification = new Notification();

        // Schleifen die alle ids auf gelöscht setzt
        foreach ($data as $key => $value) {

            $query = "UPDATE `" . $this->table . "` SET 
                `status` = '3'
                WHERE `id` = " . $value . ";
            ";

            // Erfolg
            if ($db->query($query)) {
                $success = true;

                $akquise = new Akquise();

                $akquise->akquisePositionStatus($data[0], 'gelöscht');
            } else {
                $error = $db->error;
            }
        }

        if ($success) {

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data[0],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'akquise_status_geloescht'
            ];

            $notification->new($notificationData);
        }

        return [
            'success' => $success,
            'error' => $error
            // 'query' => $query
        ];
    }

    // Status der Akquise auf Gelöscht setzen und aus der Aktion entfernen
    public function statusAkquiseGeloescht($data) {

        global $db;
        $success = $error = false;

        // Notification 
        $notification = new Notification();

        // Schleife für alle ids
        foreach ($data as $key => $value) {

            // Query
            $query = "UPDATE `" . $this->table . "` SET 
                `status` = '3',
                `aktion_id` = NULL
                WHERE `id` = " . $value . ";
            ";

            // Erfolg
            if ($db->query($query)) {
                $success = true;
            } else {
                $error = $db->error;
            }
        }
        if ($success) {

            $akquise = new Akquise();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data[0],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'akquise_aktion_geloescht'
            ];

            $notification->new($notificationData);
        }

        return [
            'success' => $success,
            'error' => $error,
            'query' => $query
        ];
    }


    // Setzt den Akquise Status in die Position Tabelle
    public function akquisePositionStatus($id, $data) {

        $akquise = new Akquise();

        $res = $akquise->get($id);

        $status = "";
        $text = "";
        $ablehnungsgrund_id  = false;

        // NOTIFICATION
        $notificationData = [
            'akquise_id' =>  $id,
            'mitarbeiter_id' => $_SESSION['user']['id'],
            'aktion' => ''
        ];

        // Wenn es wiedervorlage gibt 
        if(isset($data[2])) {
            $wiedervorlage = $data[2];
        } else {
            $wiedervorlage = false;
        }

        // Wenn Status Offen ist
        if (isset($data[1]) && $data[1] == 'offen') {
            $status = "6";
            $text = "status_0";

            $notificationData['aktion'] = 'akquise_status_offen';

            // Wenn Status Erfolgreich ist
        } else if (isset($data[1]) && $data[1] == 'erfolgreich') {
            $status = "7";
            $text = "status_1";

            $notificationData['aktion'] = 'akquise_status_erfolgreich';


            // Wenn Status Gelöscht ist
        } else if ($data == 'gelöscht') {
            $status = "9";
            $text = "status_3";

            $notificationData['aktion'] = 'akquise_status_geloescht';
        }

        // Wenn Status nicht Erolgreich ist
        else {
            $status = "8";
            $text = "status_2";
            $ablehnungsgrund_id = $data['ablehnungsgrund_id']['value'];

            $notificationData['aktion'] = 'akquise_status_nicht_erfolgreich';
        }

        //    echo "<pre>";
        //    print_r($data);
        //    echo "</pre>";
        //    die();

        // Mit in der Akquise Position aufnehmen das der Status geändert wurde
        $newData = [
            'akquise_id' => $id,
            'bearbeiter_id' => $_SESSION['user']['id'],
            'art' => $status,
            'text' => $text,
            'ablehnungsgrund_id' => $ablehnungsgrund_id,
            'wiedervorlage' => $wiedervorlage
        ];

        // Req
        $req = new Request($newData);

        // Process Array
        $process = [
            ['t', 'akquise_id'],
            ['t', 'bearbeiter_id'],
            ['t', 'art'],
            ['t', 'text'],
            ['t', 'ablehnungsgrund_id'],
            ['dt', 'wiedervorlage']
        ];

        // Insert Query
        $req->insert('akquise_positionen', $process);

        if ($req->success) {

            $akquise = new Akquise();
        }

        // Response
        return $req->answer();
    }

    // Fügt neue Ansprechpartner / Kontakte hinzu ------------------------------------------- ALLLLLLLTTTTT KANNN WEG????
    public function kontakteAkquise($reqData) {

        // New Data
        $newData = [
            'akquise_id' => $reqData->result
        ];

        // Reg
        $req = new Request($newData);

        // Notification 
        $notification = new Notification();


        // Process   
        $process = [
            ["t", 'akquise_id']
        ];

        // Schleife damit mehrere Gleichzeitig angelegt werden können
        foreach ($reqData->data['kontakt'] as $key => $kontakt_id) {
            $req->update('kontakte', $process, "WHERE `id` = '" . $kontakt_id['value'] . "'");
        }

        // Erfolg
        if ($req->success) {

            $akquise = new Akquise();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $reqData->result,
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'add_kontaktPerson_akquise'
            ];

            $notification->new($notificationData);
        }

        return $req->answer();
    }

    // Wenn ein Neuer Ansprechpartner angelegt werden soll
    public function newKontakt($data) {

        $newData = [
            'akquise_id' => $data[0],
            'req' => $data[1]
        ];

        $req = new Request($newData);

        // Notification 
        $notification = new Notification();

        $process = [
            ['t', 'akquise_id']
        ];

        // Schleife damit mehrere Kontakte Gleichzeitig angelegt werden können
        foreach ($req->data['req'] as $key => $value) {

            $req->update('kontakte', $process, "WHERE `id` = '" . $value[1] . "'");
        }

        // Erfolg
        if ($req->success) {

            $akquise = new Akquise();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data[0],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => 'add_kontaktPerson_akquise'
            ];

            $notification->new($notificationData);
        }

        return $req->answer();
    }

    // Wenn ein Kontakt wieder herausgelöscht werden soll
    public function deleteKontakt($data) {

        global $db;

        $success = $error = false;

        $newData = [
            'akquise_id' => false,
            'req' => $data
        ];

        // Akquise_ID Updaten und auf null setzen
        $req = new Request($newData);

        $process = [
            ['t', 'akquise_id']
        ];

        foreach ($req->data['req'] as $key => $value) {

            $req->update('kontakte', $process, "WHERE `id` = '" . $value . "'");
        }

        return $req->answer();
    }

    // -------------------------------------------------------------------------------
    // Akquise Abonniert
    // -------------------------------------------------------------------------------
    public function akquiseAbonniert($data) {

        $req = new Request($data);

        // Notification 
        $notification = new Notification();

        $process = [
            ['t', 'mitarbeiter_id'],
            ['t', 'akquise_id'],
            ['t', 'abonniert']
        ];

        $req->insert('akquise_abonnenten', $process);


        if ($req->success) {

            $akquise = new Akquise();

            // NOTIFICATION status nicht erfolgreich
            $notificationData = [
                'data' =>  $data['akquise_id'],
                'user_id' => $_SESSION['user']['id'],
                'aktion' => ''
            ];

            if (isset($data['automatisch'])) {
                $notificationData['aktion'] = 'akquise_automatisch_abonniert';
            } else {
                $notificationData['aktion'] = 'akquise_abonniert';
            }

            $notification->new($notificationData);
        }

        return $req->answer();
    }

    // Akquise NOTIFCAITION
    public function akquiseNotification($data) {

        $req = new Request($data);

        $process = [
            ['t', 'akquise_id'],
            ['t', 'mitarbeiter_id'],
            ['t', 'aktion'],
        ];

        $req->insert('akquise_notification', $process);

        return $req->answer();
    }

    // ------------------------------------------------------------------------------
    // GGF. EIGEN DATEI - AKQUISE AKTIONEN



}
