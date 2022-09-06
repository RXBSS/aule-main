<?php

class VertraegeVorlagen {

    public $table =  "vertraege_vorlagen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    public function getVertraegeArt($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Holt die höchste Version einer Referenz
    public function getVersion($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_vorlagen
            WHERE referenz_id = '" . $id . "'
            ORDER BY id DESC
            LIMIT 1;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt Alle Vorlagen die es gibt
    public function getVorlagen() {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_vorlagen;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Get All Klauseln From Vorlagen
    public function getAll($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_klauseln_vorlagen
            WHERE vorlagen_id = '" . $id . "';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }


    // Neu erstellen
    public function new($data) {

        $req = new Request($data);

      

        $vertraege = new Vertraege();

        $resultVertraege = $vertraege->getByVorlagenId($req->data['id']);

        foreach ($req->data['data'] as $key => $value) {

            $req->data['klausel_id'] = $value[1];
            $req->data['vorlagen_id'] = $req->data['id'];


            $process = [
                ['t', 'klausel_id'],
                ['t', 'vorlagen_id']
            ];

            $req->insert('vertraege_klauseln_vorlagen', $process);
        }

        // Wenn das Erfolgreich War Sollen Alle Klauseln auch für schon vorhandene Mietverträge geändert werden
        if($req->success) {

            // Neues Request
            $req2 = new Request();

            // Holt Alle Verträge mit der ID

            // Geht mit der Schleife durch alle Vertraege Durch
            foreach($resultVertraege['data'] as $keyV => $valueV) {

                $req2->data['vertraege_id'] = $valueV['id'];

                // Diese Schleife geht alle Klauseln durch und Fügt es für jeden Vertrag neu hinzu
                foreach ($req->data['data'] as $key => $value) {

                    $req2->data['klausel_id'] = $value[1];
                    $req2->data['vorlagen_id'] = $req->data['id'];
        
                    $process2 = [
                        ['t', 'klausel_id'],
                        ['t', 'vorlagen_id'],
                        ['t', 'vertraege_id'],
                    ];
        
                    $req2->insert('vertraege_klauseln_vertraege', $process2);
                }

            }


        }

        return $req->answer();
    }

    // Neue Vertrags Art hinzufügen
    public function newVertraegeVorlage($data) {

        $req = new Request($data);

        // Version auf 1 setzen
        $req->data['version'] = 1;

        // Status auf Entwurf setzen
        $req->data['status_id'] = 1;

        // Mitarbeiter der angemeldet ist hat die neue Verseion Klausel angelegt
        $req->data['mitarbeiter_id'] = $_SESSION['user']['id'];

        // Uhrzeit wann die Klausel angelegt wurde
        $date = new DateTime();
        $date = $date->format("d.m.Y H:i:s");
        $req->data['timestamp'] = $date;

        // Holt Alle Klauseln die Standard sind
        $vertraegeKlauseln = new VertraegeKlauseln();

        $process = [
            ['t', 'bezeichnung'],
            ['t', 'beschreibung'],
            ['t', 'version'],
            ['t', 'status_id'],
            ['t', 'mitarbeiter_id'],
            ['dt', 'timestamp']
        ];

        $req->insert($this->table, $process);

        // Wenn das Insert erfolgreich war
        if ($req->success) {

            // Request
            $req2 = new Request();

            // Klauselreferenz ID auf die die ID setzen
            $req2->data['referenz_id'] = $req->result;

            // Process Array
            $process2 = [
                ['t', 'referenz_id']
            ];

            // Update Query Durchführen
            $req2->update($this->table, $process2, 'WHERE `id` = ' . $req->result . '');

            // Holt alle standard Klauseln
            $result = $vertraegeKlauseln->getStandard();

            // wenn es Ergebnisse gibt
            if ($result['success'] && isset($result['data']) && $result['data']) {

                $req3 = new Request();

                // Schleife geht alle Standard durch und führt es der Vorlage hinzu
                foreach ($result['data'] as $key => $value) {

                    $req3->data['vorlagen_id'] = $req->result;
                    $req3->data['klausel_id'] = $value['id'];

                    $process3 = [
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id']
                    ];

                    $req3->insert('vertraege_klauseln_vorlagen', $process3);
                }
            }
        }

        return $req2->answer();
    }

    // Submit Vorlagen Stammdaten
    public function editVorlagen($id, $data) {

        $req = new Request($data);

        $vertraege = new Vertraege();
        $req->data = $this->setLaufzeitData($data);

        $process = [
            ['t', 'bezeichnung'],
            ['t', 'beschreibung'],
            ['n', 'laufzeit'],
            ['s', 'laufzeit_interval'],
            ['n', 'verlaengerung_laufzeit'],
            ['s', 'verlaengerung_laufzeit_interval'],
            ['n', 'kuendigungsfrist_laufzeit'],
            ['s', 'kuendigungsfrist_laufzeit_interval']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

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

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Vertrags Vorlage Auf Aktiv Stellen
    public function vorlageAktivieren($id) {

        $req = new Request();

        // Referenz der Klassen
        $vertrageVorlagen = new VertraegeVorlagen();

        // Get Funktion 
        $result = $vertrageVorlagen->get($id);

        // Wenn es Erfolgreich war
        if ($result['success']) {

            $req2 = new Request();

            $req2->data['status_id'] = 3;

            // Process Array
            $process2 = [
                ['t', 'status_id']
            ];

            // Setz alle Anderen außer die aktuelle Version auf "Alte Version" 
            $req2->update($this->table, $process2, 'WHERE `referenz_id` = ' . $result['data']['referenz_id'] . ' AND id != ' . $id . '');
        }

        // Status auf Aktiv also 2 setzen
        $req->data['status_id'] = 2;

        $process = [
            ['t', 'status_id']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Liest die Klauseln aus
    public function getAllKlauseln($id) {

        // Request
        $req = new Request();

        // Query
        $query = "
            SELECT vkv.*, vk.*, vg.*
            FROM vertraege_klauseln_vorlagen vkv
            LEFT JOIN vertraege_klauseln vk ON vkv.klausel_id = vk.id
            LEFT JOIN vertraege_gruppen vg ON vk.gruppen_id = vg.id
            WHERE vkv.vorlagen_id = '" . $id . "';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    /**
     * Gibt die Vertrags
     *
     */
    public function getKlauselnWithGroups($id) {

        $req = new Request();

        // Alle Klauseln auslesen
        $result = $this->getAllKlauseln($id);

        // Wenn alle Klauseln erfolgreich gelesen werden konnten
        if ($result['success']) {

            // Daten
            $data = [];

            // Schliefe durch alle Klauseln
            foreach ($result['data'] as $key => $value) {


                // Prüfen ob es diese Gruppe schon gab
                if (!isset($data[$value['gruppen_id']])) {

                    // Paragraph initalisieren
                    $data[$value['gruppen_id']] = [
                        'bezeichnung' => $value['bezeichnung'],
                        'reihenfolge' => $value['reihenfolge'],
                        'klauseln' => []
                    ];
                }


                // Ausgabe
                $data[$value['gruppen_id']]['klauseln'][] = $value;
            }

            // Nach der Reihenfolge sortieren
            usort($data, function ($a, $b) {
                return $a['reihenfolge'] <=> $b['reihenfolge'];
            });

            // Rückgabe
            $req->result = $data;
        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }

    // Klausel Preview
    public function klauselPreview($id) {

        $req = new Request();

        // Holt die Klauseln und Ordnet Sie in Gruppen
        $resultKlausel = $this->getKlauselnWithGroups($id);

        // Wenn es Erfolgreich war
        if (count($resultKlausel['data']) > 0) {

            // HTML DOM Element
            $html = "";

            // Counter
            $counter = 1;

            // Schleife erstell ein HTML Dokument
            foreach ($resultKlausel['data'] as $key => $value) {

                $html .= "§ " . $counter . " " . $value['bezeichnung'] . "";

                $html .= "<ul>";

                foreach ($value['klauseln'] as $keyV => $valueV) {

                    $html .= "<li data-klausel='" . $valueV['klausel_id'] . "'> " . strip_tags($valueV['text']) .  " </li>";
                }

                $html .= "</ul>";

                $counter++;
            }

            // $req->data['html'] = $html;

            // Rückgabe
            $req->result = $html;

            // 
            $req->success = 1;

        } else if(count($resultKlausel['data']) == 0) {

            $req->success = true;
        } else {
            $req->error = "Es ist ein Fehler aufgetretenen > Vertrage Vorlagen API <";
        }

        // $req->adapt($req);
        return $req->answer();
    }

    // eine neue Vertragsversion veröffentlichen
    public function vertragVorlagenVersionNeu($id) {

        $req = new Request();

        // Instanz der Klasse
        $vertrageVorlagen = new VertraegeVorlagen();

        // Holt alle Daten der Klausel 
        $result = $vertrageVorlagen->get($id);

        // Wenn die Abfrage erfolgreich watr
        if ($result['success']) {

            // Alle Daten in ein neues req Setzen
            $req->data = $result['data'];

            // Holt die MAX Version der Refernz ID
            $resultVersion = $vertrageVorlagen->getVersion($result['data']['referenz_id']);

            // Var für Version die dann überschrieben wird
            $version = "";

            // Erhöht die höchste Version dieser Vorlage
            if (!empty($resultVersion['data']) && is_array($result['data'])) {

                // Version Hochzählen
                $version = $resultVersion['data'][0]['version'] + 1;
            }

            // Dann ist es die 2 Version der Vorlage
            else {

                // Version Hochzählen
                $version = $result['data']['version'] + 1;
            }

            // Version hochzählen
            $req->data['version'] = $version;

            // Klausel Referenz auf die Aktuelle ID
            $req->data['referenz_id'] = $id;

            // Status Erneut auf Entwurf setzen
            $req->data['status_id'] = 1;

            // Mitarbeiter der angemeldet ist hat die neue Verseion Klausel angelegt
            $req->data['mitarbeiter_id'] = $_SESSION['user']['id'];

            // Uhrzeit wann die Klausel angelegt wurde
            $date = new DateTime();
            $date = $date->format("d.m.Y H:i:s");
            $req->data['timestamp'] = $date;

            // Process Array
            $process = [
                ['t', 'referenz_id'],
                ['t', 'status_id'],
                ['t', 'version'],
                ['t', 'bezeichnung'],
                ['t', 'beschreibung'],
                ['t', 'mitarbeiter_id'],
                ['dt', 'timestamp']
            ];

            // Query Insert
            $req->insert($this->table, $process);

            // Holt Alle Klauseln mit der Vorlagen ID
            $resultKlauseln = $vertrageVorlagen->getAll($id);

            // Wenn es Erfolgreich war und es Daten gibt
            if ($resultKlauseln['success'] || ($resultKlauseln['data'] && isset($resultKlauseln['data']))) {

                $req2 = new Request();

                // Schleife geht durch alle Schleifen durch und Erstellt mit der neuen ID die Klauseln
                foreach ($resultKlauseln['data'] as $key => $value) {

                    // Vorlagen ID ist die neue ID
                    $req2->data['vorlagen_id'] = $req->result;
                    $req2->data['klausel_id'] = $value['klausel_id'];

                    $process = [
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id'],
                    ];

                    // Fügt die neuen Klauseln Hinzu
                    $req2->insert('vertraege_klauseln_vorlagen', $process);
                }
            }
        }

        // Rückgabe
        return $req->answer();
    }

    public function deleteKlausel($id) {

        // Request
        $req = new Request();

        // 
        $vertrageVorlagen = new VertraegeVorlagen();

        // Wenn id nicht leer ist
        if (!empty($id)) {

            // Aufruf der Funktion in den Klauseln
            $result = $vertrageVorlagen->deleteHelper($id, $this->table);

            // Wenn das erfolgreich war sollen Alles IDs auf in der vertraege_vorlagen als Gelöscht markiert werden
            if ($result->success) {

                // Aufruf der Funktion in den Klauseln
                $req = $vertrageVorlagen->deleteHelper($id, "vertraege_klauseln");
            }
        }

        // Rückgabe
        return $req->answer();
    }

    public function deleteHelper($id, $table) {

        $req = new Request();

        // gelöscht Markieren
        $req->data['geloescht'] = 1;

        // Schleife geht durch alle IDs
        foreach ($id as $key => $value) {

            // Nur Als Gelöscht markieren
            $process = [
                ['t', 'geloescht']
            ];

            // Wenn Vertraege Vorlagen dann andere Where Bedingung
            $where = (($table == 'vertraege_vorlagen') ? "WHERE klausel_id = '" . $value . "'" : "WHERE id = '" . $value . "'");

            // Update Query
            $req->update($table, $process, $where);
        }

        return $req;
    }

    // Klausel Entwurf loeschen
    public function entwurfLoeschen($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->table, $id);

        // Rückgabe
        return $req->answer();
    }

    public function setLaufzeitData($data) {

        // TODOOOOO  Aus vertrage Api Geklaut -- Doppelt sollte auch mit !checked gehen --- Prüfen warum es nicht geht jetzt auf die schnell erstmal egal
        if ($data['laufzeit-trigger']['checked'] == 'false' || $data['verlaengerung-trigger']['checked'] == 'false' || $data['kuendigungsfrist-trigger']['checked'] == 'false') {
            $data['kuendigungsfrist_laufzeit'] = false;
            $data['kuendigungsfrist_laufzeit_interval'] = false;
        }

        if ($data['laufzeit-trigger']['checked'] == 'false' ||  $data['verlaengerung-trigger']['checked'] == 'false') {
            $data['verlaengerung_laufzeit'] = false;
            $data['verlaengerung_laufzeit_interval'] = false;
        }

        if ($data['laufzeit-trigger']['checked'] == 'false') {
            $data['laufzeit'] = false;
            $data['laufzeit_interval'] = false;
        }

        return $data;
    }

}
