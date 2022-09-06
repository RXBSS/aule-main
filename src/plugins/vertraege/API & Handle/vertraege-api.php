<?php

class Vertraege {

    public $table = "vertraege";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $query = "
            SELECT 
                v.*, 
                vn.id AS vertragsnehmerID, vn.name AS name, vn.strasse as strasse, vn.plz as plz, vn.ort as ort, vn.land as land, vn.kunde_gesperrt as kunde_gesperrt,
                m.id as idGeschaeftsfuehrer, m.vorname as vornameGeschaeftsfuehrer, m.nachname as nachnameGeschaeftsfuehrer,
                m2.id as sachbearbeiterID, m2.vorname as sachbearbeiterVorname, m2.nachname as nachnameSachbearbeiter,
                k.id as idKunde, k.vorname as vornameKunde, k.nachname as nachnameKunde,
                vv.id as vertragsvorlagenID, vv.bezeichnung as vertragsvorlagenBezeichnung,
                m3.vorname as aktiviererVorname, m3.nachname as aktiviererNachname
            FROM " . $this->table . " v

            LEFT JOIN adressen vn ON vn.id = v.vn_adresse
            LEFT JOIN mitarbeiter m ON m.id = v.authorisierer_id
            LEFT JOIN kontakte k ON k.id = v.sachbearbeiterkunde_id
            LEFT JOIN vertraege_vorlagen vv ON vv.id = v.vorlagen_id
            LEFT JOIN mitarbeiter m2 ON m2.id = v.sachbearbeiter_id
            LEFT JOIN mitarbeiter m3 ON m3.id = v.aktivierter_id

            WHERE v.id = '" . $id . "';
        ";


        $req->getQuery($query);

        // Vertragsende ausrechnen
        if ($req->result['laufzeit']) {
            $req->result['vertragsende'] = new DateTime($req->result['vertragsbeginn']);
            $req->result['vertragsende']->add(new DateInterval("P" . $req->result['laufzeit'] . $req->result['laufzeit_interval']));
            $req->result['vertragsende'] = $req->result['vertragsende']->format('Y-m-d');
        }

        if ($req->result['verlaengerung_laufzeit']) {
            $req->result['verlaengerung_laufzeit_ende'] = new DateTime($req->result['vertragsende']);
            $req->result['verlaengerung_laufzeit_ende']->add(new DateInterval("P" . $req->result['verlaengerung_laufzeit'] . $req->result['verlaengerung_laufzeit_interval']));
        }


        if ($req->result['kuendigungsfrist_laufzeit']) {
            $req->result['kuendigungsfrist_laufzeit_ende'] = new DateTime($req->result['vertragsende']);
            $req->result['kuendigungsfrist_laufzeit_ende']->sub(new DateInterval("P" . $req->result['kuendigungsfrist_laufzeit'] . $req->result['kuendigungsfrist_laufzeit_interval']));
        }

        return $req->answer();
    }


    // Holt die Adressen für die Adressen Form
    public function getAdressen($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT v.vn_adresse as vertragsnehmerID, a.name as vn_name, a.strasse as vn_strasse, a.plz as vn_plz, a.ort as vn_ort, a.land , l.de as vn_land, 
                 v.lf_adresse as lieferadresseID, a2.name as lf_name, a2.strasse as lf_strasse, a2.plz as lf_plz, a2.ort as lf_ort, a2.land , l2.de as lf_land
            FROM vertraege v
            LEFT JOIN adressen a ON a.id = v.vn_adresse
            LEFT JOIN adressen a2 on a2.id = v.lf_adresse
            LEFT JOIN _laender l on l.code = a.land
            LEFT JOIN _laender l2 on l2.code = a2.land
            WHERE v.id = '" . $id . "'
        ";

        // Query Abfrage
        $req->getQuery($query);

        // Rückgabe
        return $req->answer();
    }

    // Holt alle Klauseln einer vorlagen
    public function getKlauselnVorlagen($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege_klauseln_vorlagen
            WHERE vorlagen_id = '" . $id . "'
            
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt die Stammdaten eines Vertrages 
    public function getStammdaten($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT 
                v.*,
                m.id sachbearbeiterID, m.vorname as sachbearbeiterVorname, m.nachname as sachbearbeiterNachname,
                m2.id geschaeftsfuehrerID, m2.vorname as geschaeftsfuehrerVorname, m2.nachname as geschaeftsfuehrerNachname,
                k.id sachbearbeiterKundeID, k.vorname as sachbearbeiterKundeVorname, k.nachname as sachbearbeiterKundeNachname,
                vv.id as vorlagenID, vv.bezeichnung as vorlagenBezeichnung
            FROM vertraege v
            LEFT JOIN mitarbeiter m ON m.id = v.sachbearbeiter_id
            LEFT JOIN mitarbeiter m2 ON m2.id = v.authorisierer_id
            LEFT JOIN kontakte k ON k.id = v.sachbearbeiterkunde_id
            LEFT JOIN vertraege_vorlagen vv ON vv.id = v.vorlagen_id
            WHERE v.id = '" . $id . "';
        ";

        // Query Abfrage
        $req->getQuery($query);

        // Rückgabe
        return $req->answer();
    }

    public function getVersion($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege
            WHERE referenz_id = '" . $id . "'
            ORDER BY id DESC
            LIMIT 1;
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt alLe Information zu einem Vertrag
    public function getVertrag($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Liest die Klauseln aus
    public function getAllKlauseln($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT vkv.*, vk.*, vg.*
            FROM vertraege_klauseln_vertraege vkv
            LEFT JOIN vertraege_klauseln vk ON vkv.klausel_id = vk.id
            LEFT JOIN vertraege_gruppen vg ON vk.gruppen_id = vg.id
            WHERE vkv.vertraege_id = '" . $id . "';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Holt Alle Verträge mit einer bestimment Vorlagen ID
    public function getByVorlagenId($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT *
            FROM vertraege v
            WHERE v.vorlagen_id = '" . $id . "';
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
        } else if (count($resultKlausel['data']) == 0) {

            // 
            $req->success = "Keine Daten vorhanden";
        } else {
            $req->error = "Es ist ein Fehler aufgetreten > Vertraege API <";
        }

        // $req->adapt($req);
        return $req->answer();
    }

    // Neu erstellen
    public function new($data) {

        global $db;

        $success = $error = false;

        $vertraegeVorlagen = new VertraegeVorlagen();

        $req = new Request($data);

        // TODO: Status ID ist eigentlich Select --- Gucken warum es nicht geht
        $req->data['status_id'] = 1;
        $req->data['version'] = 1;

        // Wenn es keine Laufzeit gibt dann Null nehmen
        // $req->data['laufzeit'] = ( ($req->data['laufzeit']) ? $req->data['laufzeit'] : false);

        // Sachbearbeiter ist immer die Person die Angemeldet ist
        $req->data['sachbearbeiter_id'] = $_SESSION['user']['id'];

        // Wenn es eine Vorlage gibt
        if ($req->data['vorlagen_id']['value']) {

            // Holt Alle Klauseln aus den Vorlagen
            $resultVorlagen = $vertraegeVorlagen->getAll($req->data['vorlagen_id']['value']);
        }

        // Wenn die Laufzeit Ausgeschaltet ist
        // if($req->data['laufzeit-trigger']['checked'] == 'false') {

        //     $req->data['laufzeit'] = false;
        //     $req->data['laufzeit_interval'] = false;

        //     $req->data['verlaengerung_laufzeit'] = false;
        //     $req->data['verlaengerung_laufzeit_interval'] = false;

        //     $req->data['kuendigungsfrist_laufzeit'] = false;
        //     $req->data['kuendigungsfrist_laufzeit_interval'] = false;

        // // Wenn die Automatische Verlängerung aus ist
        // } else if($req->data['verlaengerung-trigger']['checked'] == 'false') {

        //     $req->data['verlaengerung_laufzeit'] = false;
        //     $req->data['verlaengerung_laufzeit_interval'] = false;

        //     $req->data['kuendigungsfrist_laufzeit'] = false;
        //     $req->data['kuendigungsfrist_laufzeit_interval'] = false;
        // }

        // // Wenn die Kündigungsfrist aus ist
        // else if($req->data['kuendigungsfrist-trigger']['checked'] == 'false') {

        //     $req->data['kuendigungsfrist_laufzeit'] = false;
        //     $req->data['kuendigungsfrist_laufzeit_interval'] = false;
        // }



        // Wenn es einen Vertragsvorlagen ID gibt dann Kopier auch die Laufzeiten mit rein
        if ($req->data['vorlagen_id']['value'] > 0) {

            // Holt Alle Laufzeiten der Vorlagen
            $resultLaufzeiten = $vertraegeVorlagen->get($req->data['vorlagen_id']['value']);


            // Wenn Abfrage erfgolreich war -- Wenn es Daten in Resultlaufzeiten gibt dann schreibe diese in die Req->data
            if ($resultLaufzeiten['success']) {
                $req->data['laufzeit'] = (($resultLaufzeiten['data']['laufzeit']) ? $resultLaufzeiten['data']['laufzeit'] : false);
                $req->data['laufzeit_interval'] = (($resultLaufzeiten['data']['laufzeit_interval']) ? $resultLaufzeiten['data']['laufzeit_interval'] : false);
                $req->data['verlaengerung_laufzeit'] = (($resultLaufzeiten['data']['verlaengerung_laufzeit']) ? $resultLaufzeiten['data']['verlaengerung_laufzeit'] : false);
                $req->data['verlaengerung_laufzeit_interval'] = (($resultLaufzeiten['data']['verlaengerung_laufzeit_interval']) ? $resultLaufzeiten['data']['verlaengerung_laufzeit_interval'] : false);
                $req->data['kuendigungsfrist_laufzeit'] = (($resultLaufzeiten['data']['kuendigungsfrist_laufzeit']) ? $resultLaufzeiten['data']['kuendigungsfrist_laufzeit'] : false);
                $req->data['kuendigungsfrist_laufzeit_interval'] = (($resultLaufzeiten['data']['kuendigungsfrist_laufzeit_interval']) ? $resultLaufzeiten['data']['kuendigungsfrist_laufzeit_interval'] : false);
            }
        }

        // Lieferadresse ist Standardmäßig wie die Vertragsnehmer adresse
        // $req->data['lf_adresse'] = $req->data['vn_adresse']['value'];

        $process = [
            ['t', 'status_id'],
            ['t', 'sachbearbeiter_id'],
            ['t', 'laufzeit'],
            ['t', 'laufzeit_interval'],
            ['t', 'verlaengerung_laufzeit'],
            ['t', 'verlaengerung_laufzeit_interval'],
            ['t', 'kuendigungsfrist_laufzeit'],
            ['t', 'kuendigungsfrist_laufzeit_interval'],
            // ['dt', 'vertragsbeginn'],
            ['s', 'vn_adresse'],
            // ['t', 'lf_adresse'],
            ['s', 'vorlagen_id'],
            ['t', 'version'],
        ];

        $req->insert($this->table, $process);

        // Wenn Erfolgreich war 
        if ($req->success) {

            // Neue Request
            $req2 = new Request();

            // Vertrags Referenz ID Neu setzen
            $req2->data['referenz_id'] = $req->result;

            // Process Array
            $process2 = [
                ['t', 'referenz_id']
            ];

            // Update Query Durchführen
            $req2->update($this->table, $process2, 'WHERE `id` = ' . $req->result . '');

            // Wenn es eine Vertragsvorlage gibt
            if ($req->data['vorlagen_id']['value']) {

                // Request 3
                $req3 = new Request();

                // Schleife geht durch alle Klauseln in der Vorlage und Kopiert sie in eine neue Tabelle für den Vertrag
                foreach ($resultVorlagen['data'] as $key => $value) {

                    // Daten Schreiben aus den Vorlagen 
                    $req3->data['vertraege_id'] = $req->result;
                    $req3->data['vorlagen_id'] = $value['vorlagen_id'];
                    $req3->data['klausel_id'] = $value['klausel_id'];
                    $req3->data['geloescht'] = $value['geloescht'];

                    // Process Array
                    $process3 = [
                        ['t', 'vertraege_id'],
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id'],
                        ['t', 'geloescht']
                    ];

                    // Alles in die Neue Tabelle kopieren
                    $req3->insert('vertraege_klauseln_vertraege', $process3);
                }
            }

            // ***********************************************************************************
            // Request 3
            $req4 = new Request();

            // Daten Schreiben aus den Vorlagen 
            $req4->data['vertraege_id'] = $req->result;

            // Damit direkt ein Eintrag für Kosten Erstellt wird nur mit der Vertrags ID
            $process4 = [
                ['t', 'vertraege_id']
            ];

            // Alles in die Neue Tabelle kopieren
            $req4->insert('vertraege_kosten', $process4);
        }

        return $req->answer();
    }

    // Vertrag auf Aktiv setzen
    public function vertragAktivieren($id, $data) {

        $req = new Request($data);

        // Status ID auf Aktiv -- also 2 setzen
        $req->data['status_id'] = 2;

        // Versandart ist der Print
        if ($req->data['versandart'] == 'print') {
            $req->data['mail_absender'] = false;
            $req->data['mail_empfaenger'] = false;
            $req->data['druckdatum'] = date('Y-m-d');
        }

        // Versandart ist Email
        if ($req->data['versandart'] == 'email') {
            $req->data['druckdatum'] = false;
        }

        // User der den Vetrag auf Aktiv gestellt hat
        $req->data['aktivierter_id'] = $_SESSION['user']['id'];

        // Uhrzeit wann Aktiv gestellt wurdee
        $req->data['aktiviert_date'] = date('Y-m-d H:i');

        // Process Array
        $process = [
            ['t', 'status_id'],
            ['t', 'aktivierter_id'],
            ['t', 'aktiviert_date'],
            ['s', 'authorisierer_id'],
            ['dt', 'druckdatum'],
            ['t', 'versandart'],
            ['t', 'mail_absender'],
            ['t', 'mail_empfaenger'],
            ['c', 'kunden_gesendet'],
            ['c', 'auf_fehler_geprueft']
        ];

        // Update Query
        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        // Wenn es Erfolgreich war
        if ($req->success) {

            $result = $this->get($id);

            // Wenn Pauschale
            if($result['data']['pauschale'] == '1') {
                $this->createAbrechnung($id, 'P');
            } 

            // Wenn Zähler
            if($result['data']['zaehler'] == '1') {
                $this->createAbrechnung($id, 'Z');
            } 

        }

        // Rückgabe
        return $req->answer();
    }


    // Fügt den Vertraegen eine neue Klausel hinzu
    public function addKlauselnVertraege($data) {

        // 
        $req = new Request();

        // Referenz der Klasse
        $vertraege = new Vertraege();

        // Wenn es Data id gibt dann Data id ansosnten direkt die id
        $id = ((isset($data['id'])) ? $data['id'] : $data);

        // Holt Erstmal alle Daten der ID
        $result = $vertraege->getVertrag($data['id']);

        // Wenn die Abfrage erfolgreich war
        if ($result['success']) {

            $req->data['vertraege_id'] = $data['id'];
            $req->data['vorlagen_id'] = $result['data']['vorlagen_id'];

            // Schleife geht durch alle Klauseln die von der Form gekommen sind
            foreach ($data['data'] as $value) {

                $req->data['klausel_id'] = $value[1];

                // Process Array
                $process = [
                    ['t', 'vertraege_id'],
                    ['t', 'vorlagen_id'],
                    ['t', 'klausel_id']
                ];

                // Insert Query
                $req->insert('vertraege_klauseln_vertraege', $process);
            }
        }

        // Rückgabe 
        return $req->answer();
    }



    // Holt die Klauseln aus der DB
    public function getKlauselnVertraege($id) {

        $req = new Request();

        $success = $error = false;

        // leeres Array
        $arr = [];

        $query = "
        
            SELECT vkv.*, va.*, vk.*, vg.id as reihenfolgePara, vg.bezeichnung as bezeichnung
            FROM `vertraege_klauseln_vertraege` vkv

            LEFT JOIN vertraege_vorlagen va ON va.id = vkv.vorlagen_id
            LEFT JOIN vertraege_klauseln vk ON vk.id = vkv.klausel_id
            LEFT JOIN vertraege_gruppen vg ON vg.id = vk.gruppen_id

            WHERE vkv.vertraege_id = '" . $id . "' AND vkv.geloescht = 0
            ORDER BY reihenfolgePara asc;

        ";


        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Kosten
    public function editKosten($id, $data) {


        $req = new Request($data);

        // Wenn die Checkbox Pauschale Angehakt ist dann Handelt es sich um eine Pauschale
        // if ($req->data['pauschale-trigger']['checked'] == 'true') {
        //     $req->data['art'] = 'P';

        //     // Wenn die Checkbox Zähler Angehakt ist dann handelt es sich um einen Zaehler
        // }
        $req->data = $this->setKostenData($data);

        // Process Array
        $process = [
            ['c', 'zaehler'],
            ['c', 'pauschale'],
            ['n', 'abrechnung_pauschale'],
            ['s', 'pauschale_abrechnung_interval'],
            ['s', 'pauschale_abrechnung_kalendarium'],
            ['n', 'gesamtpauschale_preis'],
            ['s', 'kosten_interval'],
            ['s', 'zaehler_abrechnung_interval'],
            ['s', 'zaehler_abrechnung_kalendarium'],
            ['c', 'zaehler_einheitlich'],
            ['c', 'zaehler_freimenge']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        // Wenn es Erfoglreich war
        if($req->success) {

            $req->data['gesamtpauschale_preis'] = intval($req->data['gesamtpauschale_preis']);

            // Wenn es eine Gesamt Pauschale Gab sollen Alle Preise aus den Positionen wieder rausgelöscht werden
            if($req->data['gesamtpauschale_preis'] > 0) {

                $req2 = new Request();

                $req2->data['pauschale'] = false;

                // Process Array
                $process2 = [
                    ['t', 'pauschale']
                ];

                // Update Query
                $req2->update('vertraege_positionen', $process2, 'WHERE `vertrags_id` = ' . $id . '');

            }

            // Wir Holen uns Erstmal Alle Positionen mit der Vertrags ID XY
            $req3 = new Request();
            $req3->getMultiQuery('SELECT * FROM vertraege_positionen WHERE vertrags_id = "'.$id.'"');
            $resultPos = $req3->answer();

            $req4 = new Request();

            // Wenn es Einheitliche Preise gibt
            if($req->data['zaehler_einheitlich'] != '0' || (isset($req->data['zaehler_einheitlich']['checked']) && $req->data['zaehler_einheitlich']['checked'] == 'true') ) {

                // SChleife geht durch alle Positionen
                foreach($resultPos['data'] as $key1 => $value1) {

                    // Schleife geht durch Alle Positionen Zaehler
                    foreach($req->data as $key2 => $value2) {

                        if(explode ("-", $key2)[0] == 'zaehler' && isset(explode ("-", $key2)[1])) {

                            $req4->data['zaehler_id'] = explode ("-", $key2)[1]; 
                            $req4->data['pauschale'] = ( explode("-", $value2)[0] != '') ? explode ("-", $value2)[0] : false;
                            $req4->data['positionen_id'] = $value1['id'];

                            $process4 = [
                                ['t', 'positionen_id'],
                                ['t', 'zaehler_id'],
                                ['t', 'pauschale']
                            ];

                            $req4->update('vertraege_positionen_zaehler', $process4, 'WHERE `zaehler_id` = '. explode ("-", $key2)[1] .' AND `positionen_id` = '.$value1['id'].' ');

                        } 
                        
                    }
                }
            } else {

                // Alle Zähler auf False/ Null setzen
                foreach($resultPos['data'] as $key1 => $value1) {

                    $req4->data['pauschale'] = false;

                    $process4 = [
                        ['t', 'pauschale']
                    ];

                    $req4->update('vertraege_positionen_zaehler', $process4, 'WHERE `positionen_id` = '.$value1['id'].' ');

                }

            }
        }

        return $req4->answer();
    }

    public function setKostenData($data) {

         // TODOOOOO  Aus vertrage Api Geklaut -- Doppelt sollte auch mit !checked gehen --- Prüfen warum es nicht geht jetzt auf die schnell erstmal egal
         if ($data['gesamtpauschale-trigger']['checked'] == 'false' ) {
            $data['gesamtpauschale_preis'] = false;
        }

        if ($data['pauschale']['checked'] == 'false') {
            $data['pauschale_abrechnung_interval'] = false;
            $data['pauschale_abrechnung_kalendarium'] = false;
            $data['kosten_interval'] = false;
        }

        if ($data['zaehler']['checked'] == 'false') {
            $data['zaehler_abrechnung_interval'] = false;
            $data['zaehler_abrechnung_kalendarium'] = false;
            $data['zaehler_einheitlich'] = 0;
            
        }

        return $data;
    }

    // Edit Laufzeiten
    public function editLaufzeiten($id, $data) {

        $req = new Request($data);

        // Setzen Laufzeit 
        $req->data = $this->setLaufzeitData($req->data);

        // Process Array
        $process = [
            ['dt', 'vertragsbeginn'],
            ['t', 'laufzeit'],
            ['s', 'laufzeit_interval'],
            ['t', 'verlaengerung_laufzeit'],
            ['s', 'verlaengerung_laufzeit_interval'],
            ['t', 'kuendigungsfrist_laufzeit'],
            ['s', 'kuendigungsfrist_laufzeit_interval'],
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Setzt die Kunden Unterschrift auf Ja
    public function kundenUnterschrift($id) {

        $req = new Request();

        // Setzt unterschrift auf Ja
        $req->data['kunden_unterschrift'] = 1;

        // Process Array
        $process = [
            ['t', 'kunden_unterschrift']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }



    // Fügt eine Neue Adressen hinzu
    public function editAdressen($id, $data) {

        $req = new Request($data);

        $process = [
            // ['s', 'lf_adresse'],
            ['s', 'vn_adresse']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Stammdaten Editieren
    public function editStammdaten($id, $data) {

        $req = new Request($data);

        $process = [
            ['s', 'vorlagen_id'],
            ['s', 'sachbearbeiterkunde_id'],
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Vertragsvorlage im Vertag ändern
    public function changeVorlage($data) {

        $req = new Request($data);
        $req2 = new Request();

        // Erstmall Alle Klauseln Löschen mit der Vertragsid
        $resultDelete = $this->deleteKlausel($data['id']);

        // Wenn das löschen Erfolgreich war die neue Vorlage setzen
        if ($resultDelete['success']) {

            // Holt Alle Klauseln der Vorlagen
            $resultKlausel = $this->getKlauselnVorlagen($data['vorlagenId']);

            // Schleife die Alle Klauseln durchgeht und dann das in Vertraeg Klauseln schreibt
            if ($resultKlausel['success'] && (count($resultKlausel['data']) > 0)) {

                foreach ($resultKlausel['data'] as $key => $value) {

                    $req->data['vertraege_id'] = $data['id'];
                    $req->data['vorlagen_id'] = $value['vorlagen_id'];
                    $req->data['klausel_id'] = $value['klausel_id'];
                    $req->data['geloescht'] = $value['geloescht'];

                    // Process Array
                    $process = [
                        ['t', 'vertraege_id'],
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id'],
                        ['t', 'geloescht']
                    ];

                    $req->insert('vertraege_klauseln_vertraege', $process);
                };
            }
        }

        // Direkt die Vorlagen in den Verträge Stammdaten Ändern ohne das Speichern gedrückt werden müssen
        // Vorlage ist jetzt die neue Vorlagen
        $req2->data['vorlagen_id'] = $data['vorlagenId'];

        // Process Array
        $process2 = [
            ['t', 'vorlagen_id']
        ];

        // Update Query
        $req2->update($this->table, $process2, 'WHERE `id` = ' . $data['id'] . '');

        return $req2->answer();
    }

    public function edit($id, $data) {

        global $db;
        $success = $error = false;

        $req = new Request($data);

        // Wenn das Feld leer ist dann schreib Null In das Feld
        $req->data['laufzeit'] = (($req->data['laufzeit']) ? $req->data['laufzeit'] : false);

        // Setzen Laufzeit 
        $req->data = $this->setLaufzeitData($req->data);

        $process = [
            ['t', 'laufzeit'],
            ['s', 'laufzeit_interval'],
            ['t', 'verlaengerung_laufzeit'],
            ['s', 'verlaengerung_laufzeit_interval'],
            ['t', 'kuendigungsfrist_laufzeit'],
            ['s', 'kuendigungsfrist_laufzeit_interval'],
            ['s', 'sachbearbeiterkunde_id'],
            ['dt', 'vertragsbeginn'],
            ['dt', 'gekuendigt_am'],
            ['s', 'vn_adresse'],
            ['s', 'vorlagen_id'],
            ['t', 'version'],
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }


    /**
     *  
     */
    public function setLaufzeitData($data) {

        if (!$data['laufzeit-trigger']['checked'] || !$data['verlaengerung-trigger']['checked'] || !$data['kuendigungsfrist-trigger']['checked']) {
            $data['kuendigungsfrist_laufzeit'] = false;
            $data['kuendigungsfrist_laufzeit_interval'] = false;
        }

        if (!$data['laufzeit-trigger']['checked'] || !$data['verlaengerung-trigger']['checked']) {
            $data['verlaengerung_laufzeit'] = false;
            $data['verlaengerung_laufzeit_interval'] = false;
        }

        if (!$data['laufzeit-trigger']['checked']) {
            $data['laufzeit'] = false;
            $data['laufzeit_interval'] = false;
        }

        return $data;
    }


    // Wenn der Vertrag Gekündigt wird
    public function submitKuendigen($id, $data) {

        // Request
        $req = new Request($data);

        // Gekündigt Status auf 1 setzen
        $req->data['gekuendigt'] = 1;

        $process = [
            ['s', 'gekuendigt_kontakt_id'],
            ['dt', 'gekuendigt_am'],
            ['t', 'gekuendigt'],
            ['t', 'gekuendigt_grund']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    // Neue Version von einem Vertrag
    public function vertragVersionNeu($id) {

        // Request
        $req = new Request();

        // Instanz der Klasse
        $vertrag = new Vertraege();

        // Holt alle Daten des Vertrages 
        $result = $vertrag->get($id);

        // Wenn die Abfrage erfolgreich watr
        if ($result['success']) {

            // Alle Daten in ein neues req Setzen
            $req->data = $result['data'];

            // Holt die MAX Version der Refernz ID
            $resultVersion = $vertrag->getVersion($result['data']['referenz_id']);

            // Var für Version die dann überschrieben wird
            $version = "";

            // Erhöht die höchste Version dieser Klausel
            if (!empty($resultVersion['data']) && is_array($result['data'])) {

                // Version Hochzählen
                $version = $resultVersion['data'][0]['version'] + 1;
            }

            // Dann ist es die 2 Version der Klausel
            else {

                // Version Hochzählen
                $version = $result['data']['version'] + 1;
            }

            // Version hochzählen
            $req->data['version'] = $version;

            // Klausel Referenz auf die Aktuelle ID
            $req->data['referenz_id'] = $result['data']['referenz_id'];

            // Status Erneut auf Entwurf setzen
            $req->data['status_id'] = 1;

            $req->data['authorisierer_id'] = false;
            $req->data['sachbearbeiterkunde_id'] = false;

            // Process Array
            $process = [

                ['t', 'vn_adresse'],
                ['t', 'vorlagen_id'],
                ['t', 'referenz_id'],
                ['t', 'sachbearbeiter_id'],
                ['t', 'sachbearbeiterkunde_id'],
                ['t', 'status_id'],
                ['t', 'laufzeit'],
                ['t', 'laufzeit_interval'],
                ['t', 'verlaengerung_laufzeit'],
                ['t', 'verlaengerung_laufzeit_interval'],
                ['t', 'kuendigungsfrist_laufzeit'],
                ['t', 'kuendigungsfrist_laufzeit_interval'],
                ['t', 'vertragsbeginn'],

                ['t', 'pauschale'],
                ['t', 'zaehler'],
                ['t', 'abrechnung_pauschale'],
                ['t', 'pauschale_abrechnung_interval'],
                ['t', 'pauschale_abrechnung_kalendarium'],
                ['t', 'gesamtpauschale_preis'],
                ['t', 'kosten_interval'],
                ['t', 'zaehler_abrechnung_interval'],
                ['t', 'zaehler_abrechnung_kalendarium'],
                ['t', 'zaehler_einheitlich'],
                ['t', 'zaehler_freimenge'],

                ['t', 'version']

                // ['t', 'authorisierer_id'],

                // ['t', 'gekuendigt_am'],
                // ['t', 'gekuendigt'],
                // ['t', 'gekuendigt_grund'],
            ];

            // Query Insert
            $req->insert($this->table, $process);

            // Referenz der Klasse
            $vertraege = new Vertraege();

            // Holt alle Klauseln
            $resultKlauseln = $vertraege->getAllKlauseln($id);

            // Wenn es Erfolgreich war und es Daten gibt
            if ($resultKlauseln['success'] || ($resultKlauseln['data'] && isset($resultKlauseln['data']))) {

                $req2 = new Request();

                // Schleife geht durch alle Schleifen durch und Erstellt mit der neuen ID die Klauseln
                foreach ($resultKlauseln['data'] as $key => $value) {

                    // Vorlagen ID ist die neue ID
                    $req2->data['vertraege_id'] = $req->result;
                    $req2->data['vorlagen_id'] = $value['vorlagen_id'];
                    $req2->data['klausel_id'] = $value['klausel_id'];

                    $process2 = [
                        ['t', 'vertraege_id'],
                        ['t', 'vorlagen_id'],
                        ['t', 'klausel_id'],
                    ];

                    // Fügt die neuen Klauseln Hinzu
                    $req2->insert('vertraege_klauseln_vertraege', $process2);
                }
            }
        }

        // Rückgabe
        return $req->answer();
    }

    // Vertrag auf Aktiv stellen
    public function aktivStellen($id, $data) {

        // Request
        $req = new Request();

        // Status auf Aktiv setzen
        $req->data['status_id'] = 2;

        // Process Array
        $process = [
            ['t', 'status_id']
        ];

        // Update Query
        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        // Rückgabe
        return $req->answer();
    }

    public function delete($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple('vertraege', $id);

        // Rückgabe
        return $req->answer();
    }

    public function deleteKlausel($id) {

        // Request
        $req = new Request();

        $query = "
            DELETE FROM vertraege_klauseln_vertraege WHERE vertraege_id = '" . $id . "';
        ";

        $req->deleteQuery($query);

        // Mehrere Löschen
        // $req->deleteMultiple('vertraege_klauseln_vertraege', $id);

        // Rückgabe
        return $req->answer();
    }


    // Löscht eine Klauseln aus dem Vetrag heraus
    public function deleteVertragKlausel($id) {
    }

    // Funktion die über die Aktivation (je nachdem ob eingeschaltet oder nicht) die jeweiligen Werte auf Null setzt
    public function turnIntoFalse() {
    }







    // ABRECHNUNG
    // --------------------


    public function createAbrechnung($id, $abrechnungsArt) {

        $req = new Request();

        $result = $this->get($id);

        if ($result['success']) {

            // Erstellen der Abrechnung            
            if ($result['data']['status_id'] == '2') {

                // Abrechnungs Interval
                $abrechnungInterval = [
                    "M" => 1,
                    "Q" => 3,
                    "Y" =>  12
                ];

                

                // 
                $vertragsende = "";
                $vertragsbeginn = new DateTime($result['data']['vertragsbeginn']);

                // Wenn es eine Laufzeit gibt
                if ($result['data']['laufzeit']) {
                    $vertragsende = new DateTime($result['data']['vertragsende']);
                }

                // Wenn es keine Laufzeit gibt dann Erstmal für 3 Jahre Abrechnen
                else {
                    $vertragsende = $vertragsbeginn->add(new DateInterval( "P3Y" ));
                }

                $interval = $this->calcInterval($result, $abrechnungsArt);

                // Hier Kommen die Abrechnungen Rein
                $array = [];

                // Schleife geht durch die Daten
                while ($vertragsbeginn < $vertragsende) {

                    // $array[] = [
                    //     $vertragsbeginn->format('Y-m-d'),
                    //     $ergebnis,
                    // ];

                    $req->data['kosten'] = "";

                    // Wenn Pauchale
                    if($result['data']['pauschale'] == '1' && $abrechnungsArt == 'P') {
                        $req->data['abrechnungsart'] = 'P';

                        $preis = 0;

                        // Wenn es einen Gesamtpauschalt Preis Gibt der Größer ist als 0
                        if(isset($result['data']['gesamtpauschale_preis']) && intval($result['data']['gesamtpauschale_preis']) > 0) {
                            $preis = $result['data']['gesamtpauschale_preis'];
                        
                        // Preis errechnet sich aus Allen Positionen
                        } else {
                            
                            $posApi = new VertraegePos();
                            $resultPos = $posApi->getSumPauschalPos($id);

                            // 
                            $preis = $resultPos['data'][0]['summePauschale'];

                        }
                        
                        // Abrechnungspreis
                        $abrechnungskosten = $preis;

                        // Dieser Preis wird abgerechnet
                        $ergebnis = $abrechnungskosten * $abrechnungInterval[$result['data']['pauschale_abrechnung_interval']] / $abrechnungInterval[$result['data']['kosten_interval']];

                        $req->data['kosten'] = $ergebnis;

                    }

                    // Wenn Zähler
                    if($result['data']['zaehler'] == '1' && $abrechnungsArt == 'Z') {
                        $req->data['abrechnungsart'] = 'Z';
                        $req->data['kosten'] = false;
                    }

                    $req->data['vertrags_id'] = $id;
                    $req->data['faelligkeit'] = $vertragsbeginn->format('Y-m-d');
                    $req->data['status_id'] = 0;
                    

                    // Hier Insert
                    $process = [
                        ['t', 'vertrags_id'],
                        ['t', 'status_id'],
                        ['t', 'faelligkeit'],
                        ['t', 'kosten'],
                        ['t', 'abrechnungsart']
                    ];

                    $req->insert('vertraege_abrechnung', $process);

                    // Hinzufügne
                    $vertragsbeginn->add(new DateInterval($interval));


                }

                // Rückgabe
                // return $array;
            }

        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }

    public function calcInterval($result, $abrechnungsArt) {

        //  Abrechung Monatlich, Quaratl oder Jährlich
        $istAbrechnung = [
            'M' => 1,
            "Q" => 3,
            "Y" => 1,
        ];


        // Wenn die Ist Intervaal Vorhanden (PAUSCHALE) ist wird Dynamisch Hinzugefpügt (Monatlich (P1M), Quartal (P3M), Jährlich (P1Y))
        if (isset($result['data']['pauschale_abrechnung_interval']) && $istAbrechnung[$result['data']['pauschale_abrechnung_interval']] && $abrechnungsArt == 'P') {
            $interval = "P" . $istAbrechnung[$result['data']['pauschale_abrechnung_interval']] . "" . $result['data']['pauschale_abrechnung_interval'];
        }

        // Wenn die Ist Intervaal Vorhanden (ZAEHLER) (Monatlich (P1M), Quartal (P3M), Jährlich (P1Y))
        else if (isset($result['data']['zaehler_abrechnung_interval']) && $istAbrechnung[$result['data']['zaehler_abrechnung_interval']] && $abrechnungsArt == 'Z') {
            $interval = "P" . $istAbrechnung[$result['data']['zaehler_abrechnung_interval']] . "" . $result['data']['zaehler_abrechnung_interval'];
        }

        return $interval;

    }
}
