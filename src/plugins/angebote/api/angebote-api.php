<?php


/**
 * Angebote API 
 */
class Angebote {


    public $tableHead = "angebote";
    public $tablePos = "angebote_positionen";

    function __construct() {

        // Positionen
        $this->pos = new AngebotePositionen($this->tablePos, "angebot_id");
    }

    // Neu erstellen
    public function create($ersteller) {

        // Daten für den Auftrag
        $req = new Request([
            'status_id' => 1,
            'ersteller_id' => $ersteller,
            'bearbeiter_id' => $ersteller,
            'erstellt_datum' => date("Y-m-d H:i:s")
        ]);

        // Verarbeitungsarray
        $process = [
            ['t', 'status_id'],
            ['t', 'ersteller_id'],
            ['t', 'bearbeiter_id'],
            ['dt', 'erstellt_datum'],
        ];

        // Kostenstelle ermitteln aus dem Ersteller?

        // Ergebnis
        $req->insert($this->tableHead, $process);

        // Antwort schreiben
        return $req->answer();
    }

    /**
     * Funktion zum Auslesen
     */
    public function get($id) {

        $req = new Request();

        // Simple Get
        $query = "
            SELECT a.*, k.bezeichnung AS kostenstelle_name, z.text AS zahlungsbedingung_text, z.bezeichnung AS zahlungsbedingung_bez,
                lf.id AS lieferanschrift_id, lf.name AS lieferanschrift_name, lf.strasse AS lieferanschrift_strasse, lf.plz AS lieferanschrift_plz, lf.ort AS lieferanschrift_ort, lf.land AS lieferanschrift_land,
                re.id AS rechnungsanschrift_id, re.name AS rechnungsanschrift_name, re.strasse AS rechnungsanschrift_strasse, re.plz AS rechnungsanschrift_plz, re.ort AS rechnungsanschrift_ort, re.land AS rechnungsanschrift_land, 
                re.kunde_gesperrt AS rechnungsanschrift_gesperrt, re.kunde_gesperrt_grund AS rechnungsanschrift_gesperrt_grund, re.kunde_gesperrt_mitarbeiter AS rechnungsanschrift_gesperrt_mitarbeiter,
                a.besteller_id, kt.vorname, kt.nachname, m1.vorname AS ersteller_vorname, m1.nachname AS ersteller_nachname, m2.vorname AS bearbeiter_vorname, m2.nachname AS bearbeiter_nachname,
                'To Do' AS ansprechpartner_name, '+49 661' AS ansprechpartner_telefon, 'todo@web.de' AS ansprechpartner_email

            FROM " . $this->tableHead . " a 
            LEFT JOIN adressen lf ON a.lieferanschrift_id = lf.id
            LEFT JOIN adressen re ON a.rechnungsanschrift_id = re.id
            LEFT JOIN kontakte kt ON a.besteller_id = kt.id
            LEFT JOIN mitarbeiter m1 ON a.ersteller_id = m1.id
            LEFT JOIN mitarbeiter m2 ON a.bearbeiter_id = m2.id
            LEFT JOIN kostenstellen k ON a.kostenstelle_id = k.id
            LEFT JOIN zahlungsbedingungen z ON a.zahlungsbedingung_id = z.id
            WHERE a.id = '" . $id . "';
        ";

        // Get Query
        $req->getQuery($query);

        if ($req->success) {

            // Weiteren Daten bearbeiten
            $req->result['hat_liefertermin'] = ($req->result['liefertermin']) ? true : false;
            $req->result['lf_gleich_re'] = ($req->result['lieferanschrift_id'] == $req->result['rechnungsanschrift_id']) ? true : false;
            $req->result['besteller_name'] = trim($req->result['vorname'] . " " . $req->result['nachname']);
            $req->result['ersteller_name'] = trim($req->result['ersteller_vorname'] . " " . $req->result['ersteller_nachname']);
            $req->result['bearbeiter_name'] = trim($req->result['bearbeiter_vorname'] . " " . $req->result['bearbeiter_nachname']);
        }

        // Empfänger auslesem


        $empfaenger = $this->getEmpfaenger($id);

        if($empfaenger['success']) {
            $req->result['empfaenger'] = $req->extractValueFromMultiArray($empfaenger['data'], "kontakt_id");
        }


        // Antwort schreiben
        return $req->answer();
    }

    public function getEmpfaenger($id) {

        $req = new Request();

        // 
        $req->getMultiByKey($this->tableHead."_kontakte", "angebot_id", $id, true);


        return $req->answer();
    }


    public function entwurfSpeichern($id, $data) {

        // Request
        $req = new Request($data);

        // Process Array
        $process = [
            ['t', 'angebot_id'],
            ['t', 'kontakt_id']
        ];

        // Empfänger Data
        $eData = [];

        if(is_array($req->data['empfaenger']) && count($req->data['empfaenger']) > 0) {

            // Empfänger speichern
            foreach($req->data['empfaenger'] AS $key => $value) {
                
                $eData[] = [
                    'angebot_id' => $id,
                    'kontakt_id' => $value['value']
                ];
            }
        }
        
        // 
        $subreq = new Request($eData);
        $subreq->supplement("angebote_kontakte", $process, "angebot_id", 1, "kontakt_id");

        // Verarbeitungsarray
        $process = [
            ['s', 'lieferanschrift_id'],
            ['s', 'rechnungsanschrift_id'],
            // ['t', 'herkunft'],
            // ['t', 'referenz'],
            ['t', 'liefertermin'],
            ['s', 'kostenstelle_id'],
            // ['s', 'besteller', 'besteller_id'],
            //['s', 'zahlungsbedingung_id'],
            // ['c', 'teillieferung'],
        ];

        // Ergebnis
        $req->update($this->tableHead, $process, "WHERE `id` = '" . $id . "'");

        // Antwort schreiben
        return $req->answer();
    }

    /**
     * Stell sicher, dass der Entwurf zum Angebot werden kann
     * 
     */
    public function entwurfValidieren($id) {

        $req = new Request();
        $req->success = true;

        return $req->answer();
    }

    public function createDocument($id) {

        $req = new Request();

        // Dokumente erstellen
        $doc = new AngebotDoc($id);
        $result = $doc->create();

        return $req->answer($result);
    }
}
