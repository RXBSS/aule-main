<?php

/**
 * Artikel-Klasse
 */


/**
 * Diese Klasse übernimmt die Artikel-Verwaltung. 
 * 
 * Dies umfasst auch: 
 * - Lager- und Bestandführung
 * 
 * 
 * @author Tobias Pitzer <t.pitzer@buerosystemhaus.de>
 * @todo Hier gibt es noch was zu tun
 * @version 1.0.0
 * 
 */
class Artikel {

    /**
     * Die Tabelle in der die Artikel zu finden sind
     */
    public $table = "artikel";
    public $tableBestand = "artikel_bestand";
    public $tableBewegung = "artikel_bewegung";
    public $tableZaehler = "artikel_zaehler";
    public $tableLink = "artikel_verknuepfungen";

    /**
     * Constuctor
     * Es muss nichts angegeben werden um die Artikel API zu erstellen
     * 
     */
    function __construct() {
        // Do Something at Construction
    }


    /**
     * Funktion zum Auslesen eines Artikels
     *
     * @param float $id Hier wird die ID des Artikels übergeben
     * @param float $byHersteller Hier wird die ID des Artikels übergeben
     * @return array Ein Array mit den vollständigen Daten zu einem Artikel.
     * 
     */
    function get($id, $mitHerstellerNr = false) {

        // Request
        $req = new Request();

        // Simple Get
        $query = "
            SELECT 
                a.*, 
                z.bezeichnung AS zuordnung, 
                g.bezeichnung AS artikel_gruppe, 
                h.bezeichnung AS hersteller,
                s.bezeichnung AS status_bezeichnung

            FROM artikel a 
            LEFT JOIN artikel_zuordnung z ON a.zuordnung_id = z.id
            LEFT JOIN artikel_gruppen g ON a.artikel_gruppe_id = g.id
            LEFT JOIN hersteller h ON a.hersteller_id = h.id
            LEFT JOIN status s ON a.status_id = s.status_id AND s.bereich = 'artikel'
            WHERE " . (($mitHerstellerNr) ? "a.herstellernummer = '" . $id . "'" : "a.id = '" . $id . "'");

        $req->getQuery($query);

        // Wenn es Daten gibt
        if (!$req->error) {

            // Attribute
            $attributes = $this->getArtikelAttributes($id);

            // Request
            $req->result['attribute'] = $this->fomatArtikelAttributes($attributes['data']);
            $req->result['attribute_daten'] = $attributes['data'];
            $req->result['attribute_text'] = $this->getAttributesText($id);
        }

        // Antwort schreiben
        return $req->answer();
    }


    /**
     * Erstellt einen neuen Artikel
     *
     * @param array $data Die Daten, die in der Regel aus der Form erhalten werden
     * @param array $attributes Die Attribute aus der Form
     * @return integer Gibt die ID zurück
     * 
     */
    function new($data, $attributes) {

        // Request
        $req = new Request($data);

        // Dublettenprüfung
        $req->checkDuplicate("Herstellernummer", $this->table, "herstellernummer", $data["herstellernummer"]);
        $req->checkDuplicate("EAN", $this->table, "ean", $data["ean"]);

        // Prüfen ob weitergemacht werden soll
        if (!$req->error) {

            // Verarbeitungsarray
            $process = [
                ['t', 'herstellernummer'],
                ['t', 'ean'],
                ['t', 'bezeichnung'],
                ['s', 'hersteller', 'hersteller_id'],
                ['s', 'zuordnung', 'zuordnung_id'],
                ['s', 'artikelgruppe', 'artikel_gruppe_id'],
            ];

            // Ergebnis
            $req->insert($this->table, $process);

            // Wenn die Eintragung geklappt hat, dann die Artikelattribute eintragen
            if (!$req->error) {

                $result = $this->setArtikelAttributes($req->result, $attributes);

                // Zurodnung Wert
                $zuordnung = $req->getSelectValue($data["zuordnung"]);

                // Lager setzen - Bei 3 = Arbeitszeit, keine Bestandsführung
                $this->setLager($req->result, [
                    'bestandsfuehrung' => ($zuordnung == 3) ? false : true,
                    'ident' => ($zuordnung == 5) ? true : false
                ]);

                // Wenn es nicht erfolgreich war, Fehlermeldung setzen
                if (!$result['success']) {
                    $req->error = $result['error'];
                    $req->success = $result['success'];
                }
            }
        }

        // Antwort schreiben
        return $req->answer();
    }


    /**
     * Edit Default Values
     * 
     */
    function edit($id, $data, $attributes) {

        // Request
        $req = new Request($data);

        // Dublettenprüfung
        $req->checkDuplicate("Herstellernummer", $this->table, "herstellernummer", $data["herstellernummer"], $id);
        $req->checkDuplicate("EAN", $this->table, "ean", $data["ean"], $id);

        // Prüfen ob weitergemacht werden soll
        if (!$req->error) {

            // Verarbeitungsarray
            $process = [
                ['t', 'herstellernummer'],
                ['t', 'ean'],
                ['t', 'bezeichnung'],
                ['s', 'hersteller', 'hersteller_id'],
                ['s', 'zuordnung', 'zuordnung_id'],
                ['s', 'artikelgruppe', 'artikel_gruppe_id'],
                ['s', 'status_id'],
            ];

            // Ergebnis
            $req->update($this->table, $process, "WHERE `id` = '" . $id . "'");

            // Wenn die Eintragung geklappt hat, dann die Artikelattribute eintragen
            if (!$req->error) {

                $result = $this->setArtikelAttributes($id, $attributes);

                // Wenn es nicht erfolgreich war, Fehlermeldung setzen
                if (!$result['success']) {
                    $req->error = $result['error'];
                    $req->success = $result['success'];
                }
            }
        }

        // Antwort schreiben
        return $req->answer();
    }




    /**
     * Löschen
     */
    function delete($id) {

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


    // Aritkel Attribute
    // ********************************


    /**
     * Gibt die Artikel Attribute zurück
     *
     * @param boolean $artikelgruppen
     */
    function getAttributes($artikelgruppen = false) {

        global $db;
        $data = [];

        // Artikelgruppen Variable normalisieren
        $artikelgruppen = ($artikelgruppen) ? ((is_array($artikelgruppen)) ? $artikelgruppen : [$artikelgruppen]) : false;

        // Select Query
        $query = "
            SELECT a.* 
            FROM `" . $this->table . "_attribute` a";

        // Left Join anfügen
        if ($artikelgruppen) {
            $query .= " LEFT JOIN `artikel_gruppen_attribute` av ON a.id = av.attribute_id 
                WHERE av.artikelgruppe_id IN ('" . implode("','", $artikelgruppen) . "')
            ";
        }

        // Sortierung
        $query .= " ORDER BY a.reihenfolge";

        // Datenbank Abfrage
        $result = $db->query($query);

        // Prüfen ob ein Ergebnis da ist
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['id']] = $row;
            }
        }

        return $data;
    }

    // 
    function getAttributesById($id) {

        $attributes = false;

        // ArtikelDaten holen
        $artikelData = $this->get($id);

        // Wenn es Daten gibt
        if ($artikelData['success']) {

            // Attribute auslesen
            $attributes = $this->getAttributes($artikelData['data']['artikel_gruppe_id']);
        }

        return $attributes;
    }

    function getArtikelAttributes($id) {

        // Neuer Request
        $req = new Request();

        // Query
        $query = "
            SELECT aaa.*, aa.*
                FROM `artikel_attribute_artikel` aaa
                LEFT JOIN `artikel_attribute` aa ON aaa.attribute_id = aa.id
            
            WHERE aaa.artikel_id = '" . $id . "';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    function fomatArtikelAttributes($attributes) {

        $result = [];

        if ($attributes) {
            foreach ($attributes as $key => $value) {
                $result[$value['attribute_id']] = $value['value'];
            }
        }

        // Ergebnis
        return $result;
    }


    // Setzten der Attribute
    function setArtikelAttributes($id, $attributeData) {

        global $db;

        $success = false;
        $error = false;

        $attributes = $this->getAttributesById($id);

        // Zunächst alle Löschen
        $query = "DELETE FROM `artikel_attribute_artikel` WHERE artikel_id = '" . $id . "';";

        // Query
        if ($db->query($query)) {

            // Wenn es Daten gibt
            if (count($attributeData) > 0) {

                // Fertig
                $finished = [];

                // Alle Attribute durchgehen
                foreach ($attributeData as $key => $value) {

                    // Dieses Attribute
                    // $thisAttribute = $attributes[$key];

                    // Formatieren!

                    $finished[] = "('" . $id . "', '" . $key . "','" . ((is_array($value)) ? $value['value'] : $value) . "')";
                }

                // Query erstellen
                $query = "INSERT INTO `artikel_attribute_artikel` (`artikel_id`, `attribute_id`, `value`) VALUES " . implode(",", $finished) . ";";

                // Query schreiben
                if ($db->query($query)) {
                    $success = true;
                } else {
                    $error = "Fehler beim Schreiben der neuen Attribute";
                }

                // Wenn es keine gibt
            } else {
                $success = true;
            }
        } else {
            $error = "Fehler beim Löschen der alten Attribute";
        }

        // Rückgabe
        return [
            'success' => $success,
            'error' => $error
        ];
    }


    // Attribute aus Form Extrahieren
    function getAttributesFromForm($data) {

        // Attribute
        $attributes = [];
        $length = strlen("attribute");

        // Alle Daten durchgehen
        foreach ($data as $key => $value) {

            // Attribute extrahieren
            if (substr($key, 0, $length) == "attribute") {
                $attributes[substr($key, $length)] = $value;
            }
        }

        // Zurückgeben der Attribute
        return $attributes;
    }


    public function getAttributesText($id) {
        
        $req = new Request();

        $result = $this->getArtikelAttributes($id);

        if($result['success']) {    

            $text = "";

            if($result['data']) {

                $f = new Formatter();

                // Schleife
                foreach($result['data'] AS $key => $value) {
                   $text .= $value['bezeichnung'].": ".(($value['datentyp'] == 'zahl') ? $f->autoFloat($value['value'],0) : $value['value']) ."<br>";                   
                }                
            }
        
            
            $req->result = $text;
            $req->success = true;

        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }




    // MARK: LAGER
    ##################################################


    // Lager setzen
    /**
     * Mögliche Daten
     * 
     * id
     * bestandsfuehrung
     * auto_bestand_aktiv
     * auto_bestand_min
     * auto_bestand_max
     * 
     */
    function setLager($id, $data) {

        // Neuer Request
        $req = new Request($data);

        // Standard Werte, falls 
        if (!$req->getCbStatus($req->data['bestandsfuehrung'])) {
            $req->data['auto_bestand_aktiv'] = false;
        }

        // Min- und Max löschen, falls keine Auto Bestand aktiv ist!
        if (isset($req->data['auto_bestand_aktiv']) && !$req->getCbStatus($req->data['auto_bestand_aktiv'])) {
            $req->data['auto_bestand_min'] = "";
            $req->data['auto_bestand_max'] = "";
        }

        // Verarbeitungsarray
        $process = [
            ['c', 'bestandsfuehrung'],
            ['c', 'ident'],
            ['c', 'auto_bestand_aktiv'],
            ['t', 'auto_bestand_min'],
            ['t', 'auto_bestand_max']
        ];

        // Ergebnis
        $req->update($this->table, $process, "WHERE `id` = '" . $id . "'");

        // Antwort schreiben
        return $req->answer();
    }


    /**
     * Bestand eines Artikel auslesen
     *
     */
    function getBestand($id) {

        $artikel = $this->get($id);

        // Daten
        $data = [];

        // Prüfen ob der Artikel existiert und die entsprechende Bestandführung!
        if ($artikel['success'] && $artikel['data']['bestandsfuehrung'] == 1) {

            // Neuer Request
            $req = new Request();

            // Query
            $query = "
            SELECT ab.*, l.bezeichnung AS lagername, l.hauptlager
                FROM  `artikel_bestand` ab
                LEFT JOIN `lager` l ON ab.lager_id = l.id
                WHERE artikel_id = '" . $id . "'
                ORDER BY l.hauptlager DESC;";

            // Get Multi
            $req->getMultiQuery($query, true);

            // Wenn es Daten gibt
            if (is_array($req->result) && count($req->result) > 0) {

                // Schleife
                foreach ($req->result as $key => $value) {
                    $data[$value['lager_id']] = $value;
                }

                // Falls keine Daten vorhanden sind!
            } else {
            }

            // Wenn es keine Daten gibt?
        } else {
        }

        // Gibt zurück
        return $data;
    }

    /**
     * Gibt den Bestand für ein Lager zurück. 
     * Wenn das Lager nicht gefunden werden kann, dann wird ein Fehler ausgegeben
     * // TODO: Wenn der Artikel nicht gefunden werden kann, dann wird ein Fehler ausgegeben
     * 
     * 
     * @see Artikel::getBestand()       Gibt dabei immer ein Array zurück, dass genauso wie bei der getBestand Funktion aussieht
     * @return Array Ein Array wie bei getBestand
     */
    function getLagerBestand($artikelId, $lagerId) {

        // neuer Request
        $req = new Request();

        // Lager Info auslesen
        $lagerInfo = $this->getLagerInfo($lagerId);

        // Lagerinfo
        if ($lagerInfo['success']) {

            // Artikel auslesen
            $artikel = $this->get($artikelId);

            // Prüfen, dass der Artikel existiert
            if ($artikel['success']) {

                // Bestand auslesen
                $bestand = $this->getBestand($artikelId);

                // Wenn es Daten gibt
                $hasData = (isset($bestand[$lagerId])) ? true : false;

                // Result setzen
                $req->result = [
                    'id' => ($hasData) ? $bestand[$lagerId]['id'] : false,
                    'artikel_id' => $artikelId,
                    'lager_id' => $lagerId,
                    'bestand' => ($hasData) ? $bestand[$lagerId]['bestand'] : 0,
                    'kommission' => ($hasData) ? $bestand[$lagerId]['kommission'] : 0,
                    'bestellt' => ($hasData) ? $bestand[$lagerId]['bestellt'] : 0,
                    'lagername' => $lagerInfo['data']['bezeichnung'],
                    'hauptlager' => $lagerInfo['data']['hauptlager']
                ];

                // Erfolgreich
                $req->success = true;
            } else {
                $req->adapt($artikel);
            }
        } else {
            $req->adapt($lagerInfo);
        }

        return $req->answer();
    }

    /**
     * Gibt die Informationen zu dem Lager aus
     * // TODO: Dies muss vermutlich in eine eigene Lager API ausgelagert werden
     * 
     */
    function getLagerInfo($lagerId) {

        // Neuer Request
        $req = new Request();

        $req->get("lager", $lagerId);

        return $req->answer();
    }

    /**
     * Diese Funktion soll eigentlich dazu da sein, aus mehreren Lagern den Bestand zusammen zu suchen
     * Hier müssen aber noch Regeln getroffen werden, wie und wann das Möglich ist, etc
     * 
     * TODO: Ist momentan fest auf das Hauptlager programmiert
     * 
     */
    function getBestandVerfuegbar($id) {

        // Bestand
        $bestand = $this->getBestand($id);

        $value = 0;

        // Alle Bestände durchgehen
        foreach ($bestand as $lInfo) {

            // TODO: Erstmal nur aus dem Hauptlager
            if ($lInfo['bestand'] > 0 && $lInfo['lager_id'] == 1) {
                $value = $value + $lInfo['bestand'];
            }
        }

        return $value;
    }

    /**
     * Bestand setzen
     * 
     */
    function changeBestandAuftrag($artikelId, $lagerId, $aenderung, $ref) {

        $req = new Request();

        // Validieren der Veränderung
        $r1 = $this->validateNullMenge($artikelId, $lagerId, 'bestand', $aenderung);

        // Wenn die Änderung des Bestands vorgenommen werden kann
        if ($r1['success']) {

            // Bestand setzen
            $r2 = $this->setBestand($artikelId, $lagerId, [
                'bestand' => $r1['data']['bestand_neu']
            ]);

            // Wenn der Bestand gesetzt werden konnte
            if ($r2['success']) {

                // Bewegung erstellen
                $r3 = $this->setBewegung([
                    "artikel_id" => $artikelId,
                    "quelllager_id" => $lagerId,
                    "ziellager_id" => false,
                    "ursprung" => 'lf',
                    "veraenderung" => $aenderung,
                    "vorher" => $r1['data']['bestand'],
                    "nachher" => $r1['data']['bestand_neu'],
                    "referenz_id" => $ref['ref1'],
                    "referenz_id2" => $ref['ref2'],
                    "referenz_id3" => $ref['ref3'],
                    "user_id" =>  $ref['user_id']
                ]);

                $req->adapt($r3);
            } else {
                $req->adapt($r2);
            }
        } else {
            $req->adapt($r1);
        }

        return $req->answer();
    }

    /**
     * Bestellen
     * 
     * // TODO: Direktlieferungen?
     * 
     * Diese Funktion wurde geschrieben, als die Bestellung ging
     * 
     * 
     */
    function changeBestelltBestellung($artikelId, $lagerId, $aenderung) {

        $req = new Request();

        // Validieren der Veränderung
        $r1 = $this->validateNullMenge($artikelId, $lagerId, 'bestellt', $aenderung);

        // Wenn die Änderung des Bestands vorgenommen werden kann
        if ($r1['success']) {

            // Bestand setzen
            $r2 = $this->setBestand($artikelId, $lagerId, [
                'bestellt' => $r1['data']['bestellt_neu']
            ]);

            $req->adapt($r2);

            // TODO: Soll es auf eine Bestell-Bewegung geben?

        } else {
            $req->adapt($r1);
        }

        return $req->answer();
    }

    /**
     * 
     */
    function changeLagerUmbuchung($artikelId, $vonLager, $anLager, $aenderung, $ref) {

        $req = new Request();

        // Validieren der Veränderung
        $r1 = $this->validateNullMenge($artikelId, $vonLager, 'bestand', ($aenderung < 0) ? abs($aenderung) : -$aenderung);

        if ($r1['success']) {

            $r2 = $this->validateNullMenge($artikelId, $anLager, 'bestand', $aenderung);

            if ($r2['success']) {

                $r3 = $this->setBestand($artikelId, $vonLager, [
                    'bestand' => $r1['data']['bestand_neu']
                ]);

                if ($r3['success']) {

                    $r4 = $this->setBestand($artikelId, $anLager, [
                        'bestand' => $r2['data']['bestand_neu']
                    ]);

                    if ($r4['success']) {

                        // Bewegung erstellen
                        $r5 = $this->setBewegung([
                            "artikel_id" => $artikelId,
                            "quelllager_id" => $vonLager,
                            "ziellager_id" => $anLager,
                            "ursprung" => 'lg',
                            "veraenderung" => $aenderung,
                            "vorher" => $r1['data']['bestand'],
                            "nachher" => $r1['data']['bestand_neu'],
                            "vorher2" => $r2['data']['bestand'],
                            "nachher2" => $r2['data']['bestand_neu'],
                            "referenz_id" => $ref['ref1'],
                            "referenz_id2" => $ref['ref2'],
                            "referenz_id3" => $ref['ref3'],
                            "user_id" =>  $ref['user_id']
                        ]);

                        $req->adapt($r5);
                    }
                }
            } else {
                $req->adapt($r2);
            }
        } else {
            $req->adapt($r1);
        }

        return $req->answer();
    }

    /**
     * $aenderung = +1  
     * 
     */
    function changeWareneingang($artikelId, $lagerId, $aenderung, $ref) {

        $req = new Request();

        // Validieren der Veränderung
        $r1 = $this->validateNullMenge($artikelId, $lagerId, 'bestand',  $aenderung);

        if ($r1['success']) {

            // Validieren der Veränderung
            $r2 = $this->validateNullMenge($artikelId, $lagerId, 'bestellt',  ($aenderung < 0) ? abs($aenderung) : -$aenderung);

            if ($r2['success']) {

                // Anpassen
                $r3 = $this->setBestand($artikelId, $lagerId, [
                    'bestand' => $r1['data']['bestand_neu'],
                    'bestellt' => $r2['data']['bestellt_neu']
                ]);

                if ($r3['success']) {

                    // Bewegung erstellen
                    $r4 = $this->setBewegung([
                        "artikel_id" => $artikelId,
                        "quelllager_id" => $lagerId,
                        "ziellager_id" => false,
                        "ursprung" => 'we',
                        "veraenderung" => $aenderung,
                        "vorher" => $r1['data']['bestand'],
                        "nachher" => $r1['data']['bestand_neu'],
                        "referenz_id" => $ref['ref1'],
                        "referenz_id2" => $ref['ref2'],
                        "referenz_id3" => $ref['ref3'],
                        "user_id" =>  $ref['user_id']
                    ]);

                    $req->adapt($r4);
                }

            } else {
                $req->adapt($r2);
            }
        } else {
            $req->adapt($r1);
        }

        return $req->answer();
    }



    /**
     * Validiert ob die Buchung der Menge möglich ist
     * 
     * $art = Kann nur bestand oder bestellt sein (später noch Kommission)
     */
    function validateNullMenge($artikelId, $lagerId, $art, $aenderung) {

        // Neuer Request
        $req = new Request();

        if (is_numeric($aenderung)) {

            // Validierung
            if ($art == 'bestand' || $art == 'bestellt') {

                // Bestand auslesen
                $bestand = $this->getLagerBestand($artikelId, $lagerId);

                if ($bestand['success']) {

                    // Neuer Wert
                    $neuerWert = $bestand['data'][$art] + $aenderung;

                    // Neuer Wert
                    if ($neuerWert >= 0) {
                        $req->success = true;
                        $req->result = $bestand['data'];
                        $req->result[$art . "_neu"] = $neuerWert;
                    } else {
                        $req->error = "Der Wert würde Negativ sein!";
                    }
                } else {
                    $req->adapt($bestand);
                }
            } else {
                $req->error = "Die Funktion kann nur für `bestand` und `bestellt` genutzt werden!";
            }
        } else {
            $req->error = "Kein Nummerischer Wert bei der Änderung angegeben!";
        }

        // Ergebnis
        return $req->answer();
    }



    /**
     * ACHTUNG - Diese Funktion ersetzt eine komplette Spalte im Artikel bestand oder fügt sie hinzu. 
     * Die Funktion darf nur von einer Funktion aufgerufen werden, die auch die Historie beschreibt
     *  
     * 
     * // Welche Szenarieren gibt es für die Bestandsänderung?
     * 
     * 
     * 
     * 
     * 
     * $data = Muss einen, kann aber auch mehr enthalten von `bestand`, `kommission`, `bestellt`
     */
    function setBestand($artikelId, $lagerId, $data) {

        // Request
        $req = new Request();

        // Query
        $query = "SELECT * FROM `" . $this->tableBestand . "` WHERE `artikel_id` = '" . $artikelId . "' AND `lager_id` = '" . $lagerId . "';";

        // Query
        $req->getQuery($query);

        // Wenn die Daten schon vorhanden sind, dann müssen Sie nur angepasst werden
        if ($req->success) {

            // Aktualisieren
            $req2 = new Request($data);

            $process = [];

            // Schliefe
            foreach ($data as $key => $value) {
                $process[] = ['t', $key];
            }

            // Einfügen
            $req2->updateById($this->tableBestand, $process, $req->result['id']);

            // Wenn die Daten noch nicht vorhanden sind, dann müssen Sie komplett angelegt werden
        } else {

            // Neuer Request
            $req2 = new Request([
                'artikel_id' => $artikelId,
                'lager_id' => $lagerId,
                'bestand' => (isset($data['bestand'])) ? $data['bestand'] : 0,
                'kommission' => (isset($data['kommission'])) ? $data['kommission'] : 0,
                'bestellt' => (isset($data['bestellt'])) ? $data['bestellt'] : 0,
            ]);

            // Update durchführen
            $process = [
                ['t', 'artikel_id'],
                ['t', 'lager_id'],
                ['t', 'bestand'],
                ['t', 'kommission'],
                ['t', 'bestellt']
            ];

            // Einfügen
            $req2->insert($this->tableBestand, $process);
        }

        return $req2->answer();
    }


    /**
     * Daten übergeben
     */
    function setBewegung($data) {

        // Protkoll erstellen
        $req = new Request($data);

        $req->data['zeitstempel'] = date('Y-m-d H:i:s');

        // Verarbeiten
        $process = [
            ["dt", "zeitstempel"],
            ["t", "artikel_id"],
            ["t", "quelllager_id"],
            ["t", "ziellager_id"],
            ["t", "ursprung"],
            ["t", "veraenderung"],
            ["t", "vorher"],
            ["t", "nachher"],
            ["t", "vorher2"],
            ["t", "nachher2"],
            ["t", "referenz_id"],
            ["t", "referenz_id2"],
            ["t", "referenz_id3"],
            ["t", "user_id", null, '0']
        ];

        // Insert
        $req->insert($this->tableBewegung, $process);

        return $req;
    }



    // MARK: Preise
    ############################################

    // 
    function getPreise($id) {
    }

    // Gibt den Bestand in Gruppen zurück
    function setPreise($id, $data) {

        // Neuer Request
        $req = new Request($data);

        // Verarbeitungsarray
        $process = [
            ['c', 'feste_preise'],
            ['t', 'ek'],
            ['t', 'vk'],
            ['t', 'uhg']
        ];

        // Ergebnis
        $req->update($this->table, $process, "WHERE `id` = '" . $id . "'");

        // Antwort schreiben
        return $req->answer();
    }


    // MARK: Ident
    // 

    function addZaehler($id, $zaehler) {

        // Normalisieren
        $zaehler = (is_array($zaehler)) ? $zaehler : $zaehler;

        $array = [];

        foreach ($zaehler as $value) {

            $array[] = [
                'artikel_id' => $id,
                'zaehler_id' => $value
            ];
        }


        // Mehrere 
        $req = new Request($array);

        // Process Array
        $process = [
            ['t', 'artikel_id'],
            ['t', 'zaehler_id'],
        ];

        // Request hinzufügen
        $req->insertMultiple($this->tableZaehler, $process);

        return $req->answer();
    }

    function removeZaehler($zaehler) {

        // TODO: Hier muss geprüft werden, dass keine Identnummern mit diesem Zähler hinterlegt sind
        // $this->hasIdent($id);


        // Normalisieren
        $zaehler = (is_array($zaehler)) ? $zaehler : $zaehler;

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->tableZaehler, $zaehler);

        // Rückgabe
        return $req->answer();
    }

    // 
    function hasIdent($id) {
        return true;
    }



    // MARK: Links
    // ##########################################

    function getLinks($artikelId, $withData = false) {

        $req = new Request();

        // Query
        $query = "SELECT * FROM `" . $this->tableLink . "` WHERE `artikel_id1` = '" . $artikelId . "' OR `artikel_id2` = '" . $artikelId . "';";

        // Ergebnis
        $req->getMultiQuery($query, true);

        // Alle Links
        // Link Array
        $linkArray = [
            'links' => [
                'all' => [],
                '1a' => [],
                '1b' => [],
                '2' => [],
                '3' => [],
            ],
            'artikel' => [],
            'artikel-links' => []
        ];

        // Wenn die Abfrage erfolgreich war
        if ($req->success) {

            // Artikel ID hinzufügen
            $linkArray['artikel'][] = $artikelId;

            // Schliefe durch alle Links
            foreach ($req->result as $key => $value) {

                // Zweite Id
                $pos = ($value['artikel_id1'] == $artikelId) ? 2 : 1;
                $secondaryId = $value['artikel_id' . $pos];

                // Real Art
                $art = ($value['art_id'] == 1) ? (($pos == 1) ? "1a" : "1b") : $value['art_id'];

                // Alle Links
                $temp = [
                    'id' => $secondaryId,
                    'art' => $art
                ];

                // In die Array packen
                $linkArray['links']['all'][] = $temp;
                $linkArray['links'][$art][] = $secondaryId;

                // Link Array
                $linkArray['artikel'][] = $secondaryId;
                $linkArray['artikel-links'][] = $secondaryId;
            }

            // Eindeutiges Array
            $linkArray['artikel'] = array_unique($linkArray['artikel']);
            $linkArray['artikel-links'] = array_unique($linkArray['artikel-links']);

            // Wenn auch die Daten zu den Artikel ausgelesen werden sollen
            // -- Kostet Performance
            if ($withData) {

                // initalisieren
                $linkArray['artikel-data'] = [];

                // Schliefe durch alle Artikel
                foreach ($linkArray['artikel'] as $value) {
                    $linkArray['artikel-data'][$value] = $this->get($value);
                }
            }

            // Link Array als Ergebnis übernehmen
            $req->result = $linkArray;
        } else {
            $req->adapt($req);
        }

        return $req->answer();
    }


    /**
     * Erstellt eine Verlinkung zwischen Artikeln
     */
    function createLink($artikelId, $linkTo, $art) {

        $req = new Request();

        // 1 wird automatisch zu 1a -
        $art = strtolower(strval($art));

        // Plausibilitätsprüfungen: 
        // -- Prüfen, dass der Artikel existiert!
        // -- Ein Vorgänger kann kein Nachfolger und ein Nachfolger kein Vorgänger sein
        // -- Ein Vorgänger/Nachfolger kann kein Alternativ sein

        if (in_array($art, ["1a", "1b", "2", "3"])) {

            // Daten des Verlinkungsartikel aussuchen
            $artikelData = $this->get($artikelId);
            $linkToData = $this->get($linkTo);

            // Prüfen, dass Daten für beide vorhanden sind
            if ($artikelData['success'] && $linkToData['success']) {

                // TODO: Status der Artikel prüfen? - Sollte ein inaktiver Artikel verlinkt werden können?


                // Alle Links auslesen
                $links = $this->getLinks($artikelId, false);

                // Wenn alle Links ausgelesen werden konnten
                if ($links['success']) {

                    $continue = true;
                    $hasError = false;

                    // Validieren
                    // ----------
                    if (in_array($linkTo, $links['data']['artikel-links'])) {

                        // Alle Links durchgehen
                        foreach ($links['data']['links']['all'] as $v) {

                            // Nur wenn der Artikel betroffen ist
                            if ($v['id'] == $linkTo) {

                                $b = $v['art'];

                                // Wenn das gleiche noch einmal gesetzt werden soll
                                if ($art == $b) {
                                    $continue = false;

                                    // Wenn bereits eine andere Verlinkung existiert
                                } else {

                                    // Wenn diese andere Verlinkung verboten ist
                                    if (
                                        ($art == '1a' && ($b == '1b' || $b == '2')) ||
                                        ($art == '1b' && ($b == '1a' || $b == '2')) ||
                                        ($art == '2' && ($b == '1a' || $b == '1b'))
                                    ) {

                                        $continue = false;
                                        $hasError = true;
                                    }
                                }
                            }
                        }
                    }

                    // Prüfen ob weiter gemacht werden kann
                    if ($continue) {

                        // Hier wird die Verlinkung angelegt!
                        $subReq = new Request([
                            'artikel_id1' => ($art == '1a') ? $linkTo : $artikelId,
                            'artikel_id2' => ($art == '1a') ? $artikelId : $linkTo,
                            'art_id' => ($art == '1a' || $art == '1b') ? 1 : $art
                        ]);

                        // 
                        $process = [
                            ['t', 'artikel_id1'],
                            ['t', 'artikel_id2'],
                            ['t', 'art_id']
                        ];

                        // Insert
                        $subReq->insert($this->tableLink, $process);

                        // Übernehmen
                        $req->adapt($subReq);
                    } else {

                        // Wenn bereits eine Verlinkung vorhanden ist
                        if ($hasError) {
                            $req->error = "Es ist bereits eine Verlinkung vorhanden";
                            $req->log[] = "Es ist bereits eine Verlinkung vorhanden";
                        } else {
                            $req->success = true;
                            $req->log[] = "Genau die gleiche Verbindung existiert bereit. Es wird nichts unternommen";
                        }
                    }
                } else {
                    $req->adapt($links);
                }

                // Bei einem Fehler
            } else {
                if (!$artikelData['success']) {
                    $req->adapt($artikelData);
                    $req->error = "Der Stammartikel konnte nicht gefunden werden";
                } else {
                    $req->adapt($linkToData);
                    $req->error = "Der zu Verlinkende Artikel konnte nicht gefunden werden";
                }
            }
        } else {
            $req->error = "Es wurde eine ungültige Art angegeben";
        }

        // Rückgabe
        return $req->answer();
    }

    /**
     *  Erstellt mehere Links
     */
    function createLinks($artikelId, $linkTo, $art) {

        // Link To als Array
        $linkTo = is_array($linkTo) ? $linkTo : [$linkTo];

        // Sortieren
        sort($linkTo);

        // Art
        $art = strtolower(strval($art));


        // 
        $req = new Request();

        $req->success = true;

        // Alle Link
        $allLinks = [];

        // Alle Links in ein Array packen
        foreach ($linkTo as $value) {
            $allLinks[] = ['from' => $artikelId, 'to' => $value];
        }

        // Cross Links - nur bei Art 2 - in das Array packen
        if ($art == "2" && count($linkTo) > 1) {

            // Schleife
            foreach ($linkTo as $v1) {
                foreach ($linkTo as $v2) {
                    if ($v1 != $v2 && $v2 > $v1) {
                        $allLinks[] = ['from' => $v1, 'to' => $v2];
                    }
                }
            }
        }

        // Alle die Bereits inserted waren
        $inserted = [];

        foreach ($allLinks as $value) {

            $result = $this->createLink($value['from'], $value['to'], $art);

            // Wenn es einen Fehler gab
            if ($result['success']) {

                // 
                if ($result['data']) {

                    // Lösch-Array 
                    $inserted[] = $result['data'];
                }
            } else {
                $req->adapt($result);
                break;
            }
        }

        // Löschen, die bereits angelegt wurden!
        if (!$req->success) {
            $subreq = new Request();
            $subreq->deleteMultiple($this->tableLink, $inserted);
            // loggen?
        } else {



            $req->result = $inserted;
        }

        // Rückgabe
        return $req->answer();
    }


    /**
     * Entfernt eine Verlinkung 
     * 
     */
    function removeLink($ids) {

        // TODO: Ggf. muss hier noch mehr getan werden

        $req = new Request();
        $req->deleteMultiple($this->tableLink, $ids);
        return $req->answer();
    }



    // Ident Bereich bearbeiten
    function identEdit($artikelId, $data) {

        $req = new Request($data);

        // Process 
        $process = [
            ['t', 'ident_typ_id'],
            ['c', 'ident_irreversibel'],
            ['c', 'zaehler'],
            ['c', 'software'],
            ['c', 'garantie']
        ];

        // Update
        $req->updateById($this->table, $process, $artikelId);

        // Antworten
        return $req->answer();
    }
}
