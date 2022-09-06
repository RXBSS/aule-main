<?php

class Adressen {

    public $table = "adressen";
    public $table_2 = "adressen_oeffnungszeiten";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id, true);

        return $req->answer();
    }

    // Holt die Adresse und das Land ausgeschrieben -- Benutzt in Verträge
    public function getAdressenLand($id) {

        $request = new Request();

        $query = "
            SELECT a.*, l.de
            FROM `".$this->table."` a
            LEFT JOIN _laender l ON l.code = a.land
            WHERE a.id = '".$id."'
            
        ";
        
        $request->getQuery($query);

        return $request->answer();

    }

    public function getData($id) {
        $request = new Request();

        $query = "
            SELECT a.*, a2.name AS rechnungsempfaenger_name
                FROM `" . $this->table . "` a
                LEFT JOIN `" . $this->table . "` a2 ON a.rechnungsempfaenger_id = a2.id
            WHERE a.`id` = '" . $id . "'";
        
        $request->getQuery($query);

        return $request->answer();
    }

    public function getAdressen($strasse, $plz) {
        global $db;
        $data = false;
        $arr = [];

        $query = "SELECT * FROM `" . $this->table . "` WHERE `strasse` = '" . $strasse . "' AND `plz` = '" . $plz . "' ";

        $result = $db->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $arr[] = $row;
            }
        }

        return $arr;
    }

    public function onlyGetName($id) {

        global $db;
        $data = false;

        $query = "
            SELECT `name`
            FROM `" . $this->table . "`
            WHERE `id` = '" . $id . "'";

        $result = $db->query($query);
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }


    public function getBranche($id) {
        
        global $db;
        $data = false;

        $query = "
            SELECT *
            FROM `branche`
            WHERE `id` = '" . $id . "'";

        $result = $db->query($query);
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        if ($data['trigger-on-off'] == "0") {
            $req->data['website'] = false;
            $req->data['steuernummer'] = false;
            $req->data['umsatzsetuer_id'] = false;
            $req->data['fahrtzeit'] = false;
            $req->data['kilometer'] = false;
            $req->data['latitude'] = false;
            $req->data['longitude'] = false;
        }


        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        // if(!$req->error) {

        $process = [
            ['t', 'name'],
            ['t', 'place_id'],
            ['t', 'namenszusatz'],
            ['t', 'strasse'],
            ['t', 'plz'],
            ['t', 'ort'],
            ['s', 'laender', 'land'],
            ['t', 'telefon'],
            ['t', 'telefax'],
            ['t', 'email'],
            ['t', 'website'],
            ['t', 'steuernummer'],
            ['t', 'umsatzsetuer_id'],
            ['t', 'fahrtzeit'],
            ['t', 'kilometer'],
            ['t', 'latitude'],
            ['t', 'longitude'],
            ['c', 'ist_kunde'],
            ['c', 'ist_lieferant'],
            ['c', 'ist_hersteller']
        ];

        // Ergebnis
        $req->insert($this->table, $process);

        // } 

        // Antwort schreiben
        return $req->answer();
    }

    public function edit($id, $data) {

        global $db;
        $success = $error = false;

        $req = new Request($data);

        if (isset($data['email'])) {
            $req->checkDuplicate('Diese E-Mail ist bereits vergeben!', $this->table, 'email', $data['email'], $id);
        } else if (isset($data['email_rechnungen'])) {
            $req->checkDuplicate('Diese E-Mail ist bereits vergeben!', $this->table, ['email', 'email_rechnungen'], $req->data['email_rechnungen'], $id);
        }


        if (isset($req->data['rechnungsempfaenger']) && $req->data['rechnungsempfaenger'] == 'rechnungsempfaenger') {
            $req->data['betreiber_strasse'] = false;
            $req->data['betreiber_land'] = false;
            $req->data['betreiber_plz'] = false;
            $req->data['betreiber_ort'] = false;
        }

        // DatetTime auf Null setzen falls das Feld nicht gefüllt ist
        if (isset($data['trigger-on-off']) && $data['trigger-on-off'] == "0") {
            $req->data['website'] = false;
            $req->data['fahrtzeit'] = false;
            $req->data['kilometer'] = false;
            $req->data['latitude'] = false;
            $req->data['longitude'] = false;
        }

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        if (!$req->error || (isset($data['email']) && $data['email'] == false)) {

            $process = [
                ['t', 'name'],
                ['t', 'place_id'],
                ['t', 'namenszusatz'],
                ['t', 'strasse'],
                ['t', 'plz'],
                ['t', 'ort'],
                ['s', 'laender', 'land'],
                ['t', 'telefon'],
                ['t', 'telefax'],
                ['t', 'email'],
                ['t', 'email_rechnungen'],
                ['t', 'website'],
                ['t', 'steuernummer'],
                ['t', 'umsatzsetuer_id'],
                ['t', 'fahrtzeit'],
                ['t', 'kilometer'],
                ['t', 'latitude'],
                ['t', 'longitude'],
                ['c', 'ist_kunde'],
                ['c', 'ist_lieferant'],
                ['t', 'lieferant_bezeichnung'],
                ['c', 'ist_hersteller'],
                ['t', 'hersteller_bezeichnung'],
                ['t', 'lieferantennummer'],
                ['t', 'kundennummer'],
                ['t', 'rechnungsempfaenger'],
                ['t', 'betreiber_strasse'],
                ['s', 'betreiber_land'],
                ['t', 'betreiber_plz'],
                ['t', 'betreiber_ort']
            ];



            // Ergebnis
            // WHERE `id` = 1
            // WHERE `id` = '1'
            $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');
        }

        // Antwort schreiben
        return $req->answer();
    }

    public function delete($id) {

        global $db;
        $success = $error = false;

        $query = "DELETE  `" . $this->table . "` WHERE `id` = '" . $id . "';";

        if ($db->query($query)) {
            $success = true;
        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }

    public function getLaender($code) {
        global $db;
        $data = false;

        $query = "SELECT de FROM `_laender` WHERE `code` = '" . $code . "'";

        $result = $db->query($query);
        if ($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }

    // Holt den Shortname des Landes
    public function getCode($de) {

        $req = new Request();

        $de = str_replace(" ", "", $de);

        $query = "
            SELECT code FROM `_laender` WHERE de = '".$de."';
        ";

        $req->getMultiQuery($query);

        return $req->answer();

    }

    // Holt den Ausgeschrriebenen Name
    public function getDE($code) {

        $req = new Request();

        // $de = str_replace(" ", "", $de);

        $query = "
            SELECT de FROM `_laender` WHERE code = '".$code."';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // öffnungszeiten - wird noch Implementiert
    public function newAO($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // $req->checkDuplicate('Es wurde ein Dublette gefunden!', $this->table, 'name', $data['name']);

        // Prüfen ob ein Fehler kam, wenn nicht weitermachen
        // if(!$req->error) {

        $process = [];

        // Ergebnis
        $req->insert($this->table2, $process);

        // } 

        // Antwort schreiben
        return $req->answer();
    }


    /**
     * Kunden Dinge
     * 
     * 
     * 
     * 
     */
    function editKunde($id, $data, $email) {

        $adresse = new Adressen();


        // Wenn 
        // Dublettenprüfung Kundennummer

        $req = new Request($data);

       


        // Wenn E-Mail Rechnung deaktiviert ist
        if (!$req->data['kunde_email_rechnung_benutzerdefiniert']['checked']) {
            $req->data['kunde_email_rechnung_adresse'] = false;
        }

        // Rechnungsempfänger, dann das Feld leeren
        if ($req->data['ist_betreiber'] == 0) {

            $req->data['rechnungsempfaenger_id'] = false;

            
        }


        // Wenn ist_kunde Checkbox aus ist dann sollen keine Daten abgeschickt werden
        if($req->data['ist_kunde']['checked'] === 'false') {
            $req->data['kunden_nummer'] = false;
            $req->data['ist_betreiber'] = false;
            $req->data['rechnungsempfaenger_id'] = false;
            $req->data['kunde_email_rechnung'] = false;
            $req->data['kunde_email_rechnung_adresse'] = false;
            $req->data['kunde_gesperrt'] = false;
            $req->data['kunde_gesperrt_grund'] = false;
            $req->data['kunde_gesperrt_mitarbeiter'] = false;
            $req->data['kunde_gesperrt_datum'] = false;
            $req->data['auslieferungsart'] = false;
        }
        
        // Wenn Kunde Email Toggler Aus ist dann sollen dann Standard Daten mitgeben
        if(isset($req->data['kunde_email_rechnung']['checked']) && $req->data['kunde_email_rechnung']['checked'] === 'false') {
            // $req->data['kunde_email_rechnung'] = false;
            // $req->data['kunde_email_rechnung_adresse'] = false;
            // $req->data['kunde_email_rechnung_benutzerdefiniert'] = false;

            $req->data['kunde_email_rechnung']['checked'] = true;
            $req->data['kunde_email_rechnung_adresse'] = $email;

        }
 
        // Wenn Kunde Kontosperre Toggler Aus ist dann sollen keine Daten geschickt werde
        if(isset($req->data['kunde_gesperrt']['checked']) && $req->data['kunde_gesperrt']['checked'] === 'false') {
            $req->data['kunde_gesperrt'] = false;
            $req->data['kunde_gesperrt_grund'] = false;
            $req->data['kunde_gesperrt_mitarbeiter'] = false;
            $req->data['kunde_gesperrt_datum'] = false;
        }

        // Wenn der Kunde schon eine Kudennnummer hat dann soll keine neue vergeben werden
        if($id) {

            // Holt die Aktuelle Daten zum prüfen ob es schon eine Kundenummer gibt
            $resAdresse = $adresse->get($id);

            // Wenn der Kunde noch keine Kundennummer hat
            if(!$resAdresse['data']['kunden_nummer']) {

                // Wenn der Kundenstatus auf Neukunde oder Stammkunde geändert wurde dann --- COUNT
                if($req->data['kundenstatus'] == 'neukunde' || $req->data['kundenstatus'] == 'stammkunde') {

                    $adresse = new Adressen();

                    // Holt die neuste Kundennumer
                    $neuesteKundennummer = $adresse->getNeuesteKundennummer();

                    // Wenn es schon keine Kundennummer gibt
                    if($neuesteKundennummer['data'][0]['kunden_nummer'] > 0) {
                        $req->data['kunden_nummer'] = $neuesteKundennummer['data'][0]['kunden_nummer'] + 1;
                    }

                    // Ansonsten ist es die ersten
                    else {
                        $req->data['kunden_nummer'] = 1;
                    }
                }

            }


        }


        // DuplettenPrüfung auf Email
        $req->checkDuplicate("Diese Email Rechnungsadresse ist bereits vergeben!", $this->table, 'kunde_email_rechnung_adresse', $req->data['kunde_email_rechnung_adresse'], $id);

        // Wenn Kein Error
        if(!$req->error) {
            $process = [
                ['c', 'ist_kunde'],
                ['t', 'kunden_nummer'],

                ['s', 'branche'],
                ['t', 'kundenstatus'],
                ['t', 'unternehmensgroeße'],
                ['t', 'it_situation'],

                ['t', 'ist_betreiber'],
                ['s', 'rechnungsempfaenger_id'],
                ['c', 'kunde_email_rechnung'],
                ['t', 'kunde_email_rechnung_adresse'],
                ['c', 'kunde_gesperrt'],
                ['s', 'kunde_gesperrt_grund'],
                ['s', 'kunde_gesperrt_mitarbeiter'],
                ['dt', 'kunde_gesperrt_datum'],
                ['s', 'auslieferungsart']
                
            ];

            
            // Ergebnis
            $req->update($this->table, $process, "WHERE `id` = '" . $id . "'");
        }

        return $req->answer();
    }

    public function editLieferant($id, $data) {

        $adresse = new Adressen();
    
        // Ersetz alle Komma mit Punkten
        // $dataReplace = $adresse->replaceKomma($data);

        $req = new Request($data);

        // Wenn Checkox ist_lieferant ausgeschaltet ist sollen keine Daten ausgeschaltet werden
        if($req->data['ist_lieferant']['checked'] === 'false') {
            $req->data['lieferanten_nummer'] = false;
            $req->data['lieferant_bezeichnung'] = false;
            $req->data['lieferant_unsere_kundennummer'] = false;
        }

        // Wenn Checkbox Zahlungsbedingungen ausgeschaltet ist
        if($req->data['lieferant_zahlungsbedingung']['checked'] === 'false') {
            $req->data['lieferant_zahlungsbedingung_tage'] = false;
            $req->data['lieferant_zahlungsbedingung_kreditwert'] = false;
            $req->data['lieferant_zahlungsbedingung_skonto_tage'] = false;
            $req->data['lieferant_zahlungsbedingung_skonto'] = false;

        }

        // Wenn Checkbox Mindermengen ausgeschaltet ist
        if($req->data['lieferant_mindermengenzuschlag']['checked'] === 'false') {
            $req->data['lieferant_mindermengenzuschlag_schwelle'] = false;
            $req->data['lieferant_mindermengenzuschlag_zuschlag'] = false;
            
        }

        // Wenn Checkbox Versand / Versicherung ausgeschaltet ist
        if($req->data['lieferant_versand_versicherung']['checked'] === 'false') {
            $req->data['lieferant_versand_versicherung_betrag'] = false;
            $req->data['lieferant_versand_versicherung_versicherung'] = false;
            $req->data['lieferant_versand_versicherung_freibetrag'] = false;
        }

         // Wenn Checkbox Skonto ausgeschaltet ist
         if($req->data['skonto-checkbox']['checked'] === 'false') {
            $req->data['lieferant_zahlungsbedingung_skonto_tage'] = false;
            $req->data['lieferant_zahlungsbedingung_skonto'] = false;
        }

        // TODO: Funktion schreiben die alle Punkt ersetzt
        $req->data['lieferant_zahlungsbedingung_kreditwert'] =  str_replace(",", ".", $req->data['lieferant_zahlungsbedingung_kreditwert']);
        $req->data['lieferant_zahlungsbedingung_skonto'] =  str_replace(",", ".", $req->data['lieferant_zahlungsbedingung_skonto']);
        $req->data['lieferant_mindermengenzuschlag_schwelle'] =  str_replace(",", ".", $req->data['lieferant_mindermengenzuschlag_schwelle']);
        $req->data['lieferant_mindermengenzuschlag_zuschlag'] =  str_replace(",", ".", $req->data['lieferant_mindermengenzuschlag_zuschlag']);
        $req->data['lieferant_versand_versicherung_betrag'] =  str_replace(",", ".", $req->data['lieferant_versand_versicherung_betrag']);
        $req->data['lieferant_versand_versicherung_versicherung'] =  str_replace(",", ".", $req->data['lieferant_versand_versicherung_versicherung']);
        $req->data['lieferant_versand_versicherung_freibetrag'] =  str_replace(",", ".", $req->data['lieferant_versand_versicherung_freibetrag']);


        // Dupplettenprüfung auf die Lieferantennummer
        $req->checkDuplicate('Diese Lieferantennummer ist bereits vergeben!', $this->table, 'lieferanten_nummer', $req->data['lieferanten_nummer'], $id);

        // Wenn Dupplettenprüfung erfolgreich war
        if(!$req->error) {
            $process = [
                ['c', 'ist_lieferant'],
                ['t', 'lieferanten_nummer'],
                ['t', 'lieferant_bezeichnung'],
                ['t', 'lieferant_unsere_kundennummer'],
                ['t', 'lieferant_bestellung_email'],

                ['c', 'lieferant_zahlungsbedingung'],
                ['t', 'lieferant_zahlungsbedingung_tage'],
                ['t', 'lieferant_zahlungsbedingung_kreditwert'],
                ['t', 'lieferant_zahlungsbedingung_skonto_tage'],
                ['t', 'lieferant_zahlungsbedingung_skonto'],

                ['c', 'lieferant_mindermengenzuschlag'],
                ['t', 'lieferant_mindermengenzuschlag_schwelle'],
                ['t', 'lieferant_mindermengenzuschlag_zuschlag'],

                ['c', 'lieferant_versand_versicherung'],
                ['t', 'lieferant_versand_versicherung_betrag'],
                ['t', 'lieferant_versand_versicherung_versicherung'],
                ['t', 'lieferant_versand_versicherung_freibetrag']


                
            ];

            $req->update($this->table, $process, "WHERE `id` = '" . $id . "'");
        }

        return $req->answer();

    }

    public function editHersteller($id, $data) {

        $req = new Request($data);

        

        // Wenn ist_hersteller Checkbox nicht gesetzt ist sollen keine Daten abgeschickt werden
        if($req->data['ist_hersteller']['checked'] === 'false') {

            // echo "<pre>";
            // print_r($req);
            // echo "</pre>";

            // die();
            $req->data['hersteller_nummer'] = false;
            $req->data['hersteller_bezeichnung'] = false;
        }

        $process = [
            ['c', 'ist_hersteller'],
            ['t', 'hersteller_nummer'],
            ['t', 'hersteller_bezeichnung']
        ];

        $req->update($this->table, $process, "WHERE `id` = '". $id ."'");

        return $req->answer();

    }

    // Holt die Aktuelle Kundennummer
    public function getNeuesteKundennummer() {

        $req = new Request();

        $query =  "
            SELECT `adressen`.`kunden_nummer` FROM `adressen`  
            ORDER BY `adressen`.`kunden_nummer`  DESC
            LIMIT 1;
        ";

        $req->getMultiQuery($query);

        return $req->answer();


    }


    // Open Dialog Callback Funktion
    public function neueAdresse($data) {

        $data['ist_kunde'] = 1;
        $data['kundenstatus'] = 'interessent';

        $req = new Request($data);

        $process =  [
            ['t', 'name'],
            ['t', 'strasse'],
            ['s', 'land'],
            ['t', 'plz'],
            ['t', 'ort'],
            ['t', 'telefon'],
            ['t', 'place_id'],
            ['t', 'email'],
            ['t', 'ist_kunde'],
            ['t', 'kundenstatus']
        ];

        $req->insert($this->table, $process);

        return $req->answer();

    }

    // Löscht die Adressen Kontakte aus der Adresse raus
    public function deleteVisitenkarte($data) {


        $req = new Request($data); 

        $query = "
        
            DELETE FROM `adressen_kontakte`
            WHERE adressen_kontakte.adressen_id = '".$data['adressen_id']."' AND adressen_kontakte.kontakte_id = '".$data['kontakte_id']."';
                
        ";

        $req->deleteQuery($query);

        return $req->answer();

    }

    // Entfernt das Komma durch einen Punkt
    public function replaceKomma($data) {

        $arr = [];

        // Geht alle Daten durch
        foreach($data as $key => $value) {

            // Wenn das Value eine  Nummer ist
            // if(is_numeric($value)) {
                $arr[] = str_replace(",", ".", $value);
            // }

        }

        // Rückgabe
        return $arr;

    }

    // Bearbeiten der Adresse über die Details Positionen 
    public function adressenPos($data) {

        $req = new Request($data);

        // in zwei Arrays aufteilen einmal RE und LF
        $resultLf = $resultRe = false;

        $adresse = new Adressen();

        // **************************************************
        // Rechnungsadressen
        // **************************************************

        $re = [
            're_name' => $data['re_name']['text'],
            're_value' => $data['re_name']['value'],
            're_strasse' => $data['re_strasse'],
            're_land' => $data['re_land'],
            're_plz' => $data['re_plz'],
            're_ort' => $data['re_ort']
        ];

        $resultRe = $adresse->re($re);

        
        // **************************************************
        // Lieferadressen
        // **************************************************

        // Wenn die Lieferadressen verschieden der Rechnungsadresse ist
        if($data['lf_name']['value'] != $data['re_name']['value']) {

            $lf = [
                'lf_name' => $data['lf_name']['text'],
                'lf_value' => $data['lf_name']['value'],
                'lf_strasse' => $data['lf_strasse'],
                'lf_land' => $data['lf_land'],
                'lf_plz' => $data['lf_plz'],
                'lf_ort' => $data['lf_ort']
            ];

            $resultLf = $adresse->lf($lf);

        }

       echo "<pre>";
       print_r($resultLf);
       print_r($resultRe);
       echo "</pre>";
       die();

        // return $req->answer();

    }

    // Update Funktion für Rechnungsadresse der Positionen Adressen Details
    public function re($re) {

        echo "<pre>";
        print_r($re);
        echo "</pre>";
        die();


        $req = new Request($re);

        // Erstellt das Process Array für RE
        $processRe = [
            ['t', 'name', 're_name'],
            ['t', 'strasse', 're_strasse'],
            ['t', 'land', 're_land'],
            ['t', 'plz', 're_plz'],
            ['t', 'ort', 're_ort']
        ];

        // Update Funktion für RE
        $req->update($this->table, $processRe, "WHERE `id` = '". $re['re_value'] ."'");

        
        return $req->answer();

    }

    // Update Funktion für Lieferadressen der Positionen Adressen Details
    public function lf($lf) {

        $req = new Request($lf);

        // Erstellt das Process Array für RE
        $processLf = [
            ['t', 'name', 'lf_name'],
            ['t', 'strasse', 'lf_strasse'],
            ['t', 'land', 'lf_land'],
            ['t', 'plz', 'lf_plz'],
            ['t', 'ort', 'lf_ort']
        ];

        // Update Funktion für RE
        $req->update($this->table, $processLf, "WHERE `id` = '". $lf['lf_value'] ."'");

        return $req->answer();

    }
   
}
