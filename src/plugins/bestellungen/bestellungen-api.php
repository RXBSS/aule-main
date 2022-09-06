<?php

/**
 * Bestellung
 * 
 * 
 * 
 */
class Bestellung {

    public $tableHead = "bestellungen";
    public $tablePos = "bestellungen_positionen";

    // Constructor
    function __construct() {
        $this->version = 1;
        $this->name = "Bestellung";
    }

    // Create
    function create($data) {

        // Default Werte setzen
        $data['status_id'] = 1;
        $data['erstell_datum'] = date('Y-m-d H:i:s');

        // Request
        $req = new Request($data);

        // Verarbeitungsarray
        $process = [
            ['s', 'lieferant_id'],
            ['t', 'ersteller_id'],
            ['dt', 'erstell_datum'],
            ['dt', 'liefertermin'],
            ['c', 'direktlieferung'],
            ['t', 'status_id']
        ];


        // Ergebnis
        $req->insert($this->tableHead, $process);

        // Antwort schreiben
        return $req->answer();
    }

    // Bestellung laden
    public function get($id) {

        // Request
        $req = new Request();

        $query = "
            SELECT b.*, 
                    a.lieferant_bezeichnung, a.name AS lieferant_name, a.strasse AS lieferant_strasse,  a.land AS lieferant_land, a.plz AS lieferant_plz, a.ort AS lieferant_ort, a.lieferant_bestellung_email, a.lieferant_bestellung_art,
                    'Bürosystemhaus Schäfer GmbH & Co. KG' AS empfaenger_name, 'Haimbacher Straße 24' AS empfaenger_strasse, 'DE' AS empfaenger_land, '36041' AS empfaenger_plz, 'Fulda' AS empfaenger_ort 

                FROM `" . $this->tableHead . "` b
                LEFT JOIN `adressen` a ON b.lieferant_id = a.id
            WHERE b.id = '" . $id . "'; ";

        $req->getQuery($query);

        // Liefertermin
        if ($req->success) {
            $req->result['hat_liefertermin'] = ($req->result['liefertermin']) ? true : false;
        }

        return $req->answer();
    }


    // Bearbeiten
    public function edit($bestellId, $data) {

        $req = new Request($data);

        // Verarbeiten
        $process = [
            ['t', 'status_id'],
            ['s', 'lieferant', 'lieferant_id'],
            ['dt', 'liefertermin'],
            ['c', 'direktlieferung'],
            ['t', 'text']
        ];

        // Request
        $req->updateById($this->tableHead, $process, $bestellId);

        // Rückgabe
        return $req->answer();
    }


    /**
     * Prüfen, dass der Status noch richtig ist
     */
    public function delete($bestellId) {

        $req = new Request();

        // Löschen
        $req->delete($this->tableHead, $bestellId, [
            'status_id' => 1
        ]);


        // Antworten
        return $req->answer();
    }

    /**
     * Erstellt das Dokument
     */
    function createDocument($bestellId, $type) {

        // Preview Dokument
        // Altes Dokument





    }


    function prepare($bestellungId) {

        $req = new Request();




        $r1 = $this->getPositions($bestellungId);

        // Positionen
        if ($r1['success']) {

            // TODO: Preise Validieren
            // TODO: Bestellnummern validieren

            $r2 = $this->get($bestellungId);
            $req->adapt($r2);
        } else {
            $req->adapt($r1);
            $req->error = "Es sind keine Positionen in der Bestellung";
        }

        // Rückgabe
        return $req->answer();
    }


    /**
     * Weiterverarbeiten der Bestellung
     * 
     * Verarbeitungsmethoden
     * - 1 = Keine weitere Aktion
     * - 2 = Bestellung wird gedruckt
     * - 3 = Bestellung per Mail versenden
     * - 4 = Übertragung per Schnittstelle
     */
    function process($bestellId, $data) {

        $req = new Request();

        // Daten auslesen
        // ************************
        $r1 = $this->get($bestellId);

        // TODO: Validieren!
        // TODO: Lager ID
        $lagerId = 1;

        // Falls etwas nicht passt
        if(!$r1['success']) {
            return $req->answer($r1);
        }

        // Methode
        $methode = $data['methode'];

        // Status setzen
        // *************
        $r2 = $this->setStatus($bestellId, 2);

        if(!$r2['success']) {
            return $req->answer($r2);
        }

        // Aktualisieren der Daten
        // ***********************
        $r3 = new Request([
            'bestell_art' => $methode,
            'bestell_datum' => date('Y-m-d H:i:s'),
            'besteller_id' => $data['besteller_id']
        ]);

        $process = [
            ['t', 'bestell_art'],
            ['t', 'bestell_datum'],
            ['t', 'besteller_id']
        ];

        // Sub Request
        $r3->updateById($this->tableHead, $process, $bestellId);
        
        if(!$r3->success) {
            return $req->answer($r3);
        }
        
        // Dokument erzeugen und die Daten in die Datenbank schreiben!
        // *****************
        // TODO: Hier muss noch eingestellt werden, dass ein Fehler kommt, wenn das Dokument schon existiert

        $bes = new BestellungDoc($bestellId);
        
        // Create Dokument
        $r4 = $bes->create();

        if(!$r4['success']) {
            return $req->answer($r4);
        }

        // Positionsdaten übernehmen
        // *************************
        $r5 = $this->applyPositions($bestellId, $lagerId);

        if(!$r5['success']) {
            return $req->answer($r4);
        }
        
        // Weiterverarbeitung, je nach Methode
        // ***********************************

        switch ($methode) {

            case 2:
                // TODO: Bestellung an den Drucker senden?
                break;

            case 3:
                // TODO: Bestellung per Mail versenden
                break;

            case 4:
                // TODO: Bestellung an die jeweilige Schnittstelle übergeben
                break;
        }

        // Rückgabe
        return $req->answer($r5);
    }
    
    // 
    function applyPositions($bestellungId, $lagerId) {

        $req = new Request();

        $r1 = $this->getPositions($bestellungId);

        if ($r1['success']) {

            // Artikel API
            $artikel = new Artikel();

            $continue = true;

            // Schliefe durch alle Positionen
            foreach ($r1['data'] as $key => $pos) {

                // 
                $r2 = $artikel->changeBestelltBestellung($pos['artikel_id'], $lagerId, $pos['bestellmenge']);

                // Result
                if (!$r2['success']) {
                    // Die bereits erfolgreichen müssen hier noch rückgängig gemacht werden!
                    $continue = false;
                    break;
                }
            }

            if ($continue) {
                $req->success = true;
            } else {
                $req->error = "Fehler beim Schreiben der Daten";
            }
        } else {
            $req->adapt($r1);
        }

        return $req->answer();
    }



    // Status setzen
    function setStatus($id, $status) {

        // Neuer Request
        $req = new Request([
            'status_id' => $status
        ]);

        // Verarbeiten
        $process = [
            ['t', 'status_id']
        ];

        // 
        $req->update($this->tableHead, $process, "WHERE `id` = '" . $id . "'");

        // Rückgabe
        return $req->answer();
    }


    // Bestellposition hinzufügen
    function simpleAddPositions($bestellung_id, $artikelIds) {

        $req = new Request();

        // Artikel Ids
        $artikelIds = (is_array($artikelIds)) ? $artikelIds : [$artikelIds];

        // Insert 
        foreach ($artikelIds as $artikelId) {
            $res = $this->simpleAddPosition($bestellung_id, $artikelId);

            // Wenn ein Fehler beim Verarbeiten auftritt
            if (!$res['success']) {
                // TODO: 
            }
        }

        $req->success = true;

        // Rückgabe
        return $req->answer();
    }

    // Artikel hinzufügen
    function simpleAddPosition($bestellung_id, $artikelId) {

        // Neuen Request
        $req = new Request([
            'bestellung_id' => $bestellung_id,
            'artikel_id' => $artikelId,
            'bestellmenge' => 1
        ]);

        // Process Array
        $process = [
            ['t', 'bestellung_id'],
            ['t', 'artikel_id'],
            ['t', 'bestellmenge']
        ];

        // Ergebnis
        $req->insert($this->tablePos, $process);

        // Antwort schreiben
        return $req->answer();
    }

    // Position löschen
    // TODO: Es darf nur gelöscht werden, wenn sich die Bestellung im Entwurfsmodus befindeet!
    function deletePositions($ids) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->tablePos, $ids);

        // Antwort schreiben
        return $req->answer();
    }

    // Positionen
    function getPositions($bestellungId) {

        $req = new Request();

        // Abfrage
        $query = "
            SELECT p.* , a.herstellernummer, a.bezeichnung AS artikel_bezeichnung, h.bezeichnung AS hersteller_bezeichnung
            FROM `" . $this->tablePos . "` p
            LEFT JOIN `artikel` a ON p.artikel_id = a.id
            LEFT JOIN `hersteller` h ON a.hersteller_id = h.id
            WHERE `bestellung_id` = '" . $bestellungId . "';            
        ";

        // Ergebnis
        $req->getMultiQuery($query);

        // Rückgabe
        return $req->answer();
    }


    // get Positions datens
    function getPosition($lineId) {

        $req = new Request();

        // Get
        $req->get($this->tablePos, $lineId);

        // Antwort schreiben
        return $req->answer();
    }

    function changePositionAmount($lineId, $direction = '+') {

        $req = new Request();

        if ($direction == '+' || $direction == '-') {

            // Daten aus der Datenbank auslesen
            $res = $this->getPosition($lineId);

            // Wenn Daten abgeholt werden konnten
            if ($res['success']) {

                $isPossible = ($direction == "+" || ($direction == '-' && $res['data']['bestellmenge'] > 1)) ? true : false;

                // Wenn es möglich ist
                if ($isPossible) {

                    // Neuer Wert
                    $neuerWert = ($direction == "+") ? $res['data']['bestellmenge'] + 1 : $res['data']['bestellmenge'] - 1;

                    // Neue Daten setzen
                    $req->setData([
                        'bestellmenge' => $neuerWert
                    ]);

                    // Process Array
                    $process = [
                        ['t', 'bestellmenge']
                    ];

                    // Update Request
                    $req->update($this->tablePos, $process, "WHERE `id` = '" . $lineId . "'");

                    // Keinen Fehler ausgeben, aber nichts machen
                } else {
                    $req->success = true;
                }
            } else {
                $req->error = "Daten in der Datenbank nicht gefunden!";
            }
        } else {
            $req->error = "Falsches Steuerzeichen übergeben";
        }

        // Antwort schreiben
        return $req->answer();
    }
}
