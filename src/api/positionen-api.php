<?php

use LDAP\Result;

/**
 * Hier werden alle Dinge gemacht, die bei allen Positionen gleich sind
 * Siehe dazu auch die Handle Datei unter "src/pages/positionen-handle.php"
 * 
 * Dazu gehören zum Beispiel: 
 * 
 * 
 * - Handling von Positionen und Sortierung der Reihenfolge
 * 
 * - Auftrag-Positionen
 * - Bestell-Positionen
 * - Liefer-Positionen
 * - ...
 * 
 */
class Positionen {


    function __construct($table = false, $refSpaltenName = false) {

        // Prüfen ob eine Tabelle angegeben wurde
        if (!$table) {
            throw new Exception("Keine Tabelle angegeben!", 1);
        }

        // Prüfen ob eine Tabelle angegeben wurde
        if (!$refSpaltenName) {
            throw new Exception("Der Name der Referenz-Spalte in der die ID steht wurde nicht mit angegeben!", 1);
        }

        // Variablen festlegen
        $this->table = $table;
        $this->ref = $refSpaltenName;
    }

    /**
     * Die Query holt die Daten immer aus der View
     * Die View muss immer mit _v angegeben sein1
     * 
     */
    public function getSelectQuery() {
        return "
            SELECT p.*, a.bezeichnung AS artikel_bezeichnung, h.bezeichnung AS hersteller_bezeichnung, a.ek AS artikel_ek, a.vk AS artikel_vk
            FROM `" . $this->table . "_v` p
            LEFT JOIN `artikel` a ON p.artikel_id = a.id
            LEFT JOIN `hersteller` h ON a.hersteller_id = h.id
        ";
    }

    // Get 
    public function getByPosId($posId) {

        // Main Request
        $req = new Request();
        $query = $this->getSelectQuery() . " WHERE `p`.`id` = '" . $posId . "'";
        $req->getQuery($query);

        // Request
        if ($req->success) {
            $req->result = $this->convertToFloat($req->result);
        }

        // Rückgabe
        return $req->answer();
    }

    // Get All
    public function getAllById($referenzId) {

        // Main Request
        $req = new Request();

        // Query
        $query = $this->getSelectQuery() . " WHERE `p`.`" . $this->ref . "` = '" . $referenzId . "' ORDER BY `p`.`reihenfolge`;";
        $req->getMultiQuery($query);

        // Request
        if ($req->success) {

            // Schleife durch die Ergebnisse
            foreach ($req->result as $key => $value) {

                // Überschreiben
                $req->result[$key] = $this->convertToFloat($value);
            }
        }

        // Rückgabe
        return $req->answer();
    }

    /**
     * Gibt die Referenz anhand einer Pos Id zurück
     */
    public function getRefByPosId($posId) {

        // Main Request
        $req = new Request();

        // Query
        $query = "SELECT `" . $this->ref . "` FROM `" . $this->table . "` WHERE `id` = '" . $posId . "';";

        // Query
        $req->getQuery($query);

        // Antwort
        return $req->answer();
    }

    /**
     * Gibt die Referenz anhand einer Pos Id zurück
     */
    public function getRefByPosIds($posIds) {

        // Main Request
        $req = new Request();

        $posIds = (is_array($posIds)) ? $posIds : [$posIds];

        // Query
        $query = "SELECT `" . $this->ref . "` FROM `" . $this->table . "` WHERE `id` IN ('" . implode("','", $posIds) . "') GROUP BY `" . $this->ref . "`;";

        // Query
        $req->getMultiQuery($query);

        if ($req->success) {

            $res = [];

            foreach ($req->result as $key => $value) {
                $res[] = $value[$this->ref];
            }

            $req->result = $res;
        }

        // Antwort
        return $req->answer();
    }


    /**
     * Berechnen eine Position
     */
    public function convertToFloat($input) {

        // Feste Feldnamen die immer in Float Konvertiert werden, wenn Sie vorhanden sind
        $array = [
            'menge', 
            'liefern', 'bestellen', 
            'ek', 'ek_gesamt', 'vk', 'vk_inkl_rabatt',
            'rabatt_wert', 'rabatt_wert_gesamt', 'rabatt_prozent', 
            'netto_gesamt', 'netto_inkl_rabatt_gesamt', 
            'steuer', 'steuer_wert', 'steuer_wert_gesamt', 
            'brutto', 'brutto_gesamt', 
            'marge', 'marge_gesamt', 'marge_prozent', 'marge_inkl_rabatt', 'marge_inkl_rabatt_gesamt', 'marge_inkl_rabatt_prozent'
        ];

        // Schleife
        foreach($array AS $value) {
            if(isset($input[$value])) {
                $input[$value] = floatval($input[$value]);
            }
        }

        if(isset($input['rabatt_wert'])) {
            $input['rabatt_aktiv'] = (($input['rabatt_wert']) > 0) ? true : false;
        }



        // Rückgabe
        return $input;
    }

    // Summe aller Positionen auslesen
    public function getSum($referenzId) {

        // Main Request
        $main = new Request();

        // Positionsdaten auslesen
        $positionen = $this->getAllById($referenzId);

        // Immer true, da es sein kann, dass es keine Positionen gibt
        $main->success = true;

        // Ergebnis
        $main->result = [
            'hasRabatt' => false,
            'ek' => 0,
            'rabatt' => 0,
            'marge' => 0,
            'marge_rabatt' => 0,
            'netto' => 0,
            'netto_rabatt' => 0,
            'steuer' => 0,
            'brutto' => 0,
            'steuer_saetze' => [],
            'marge_prozent' => [],
            'rabatt_prozent' => []
        ];

        // Wenn die Positionen ausgelesen werden können
        if ($positionen['success']) {

            // Positionen durchgehen
            foreach ($positionen['data'] as $key => $value) {

                // Einkaufspreis
                $main->result['ek'] = $main->result['ek'] + $value['ek_gesamt'];
                $main->result['rabatt'] = $main->result['rabatt'] + $value['rabatt_wert_gesamt'];
                $main->result['hasRabatt'] = ($value['rabatt_wert'] > 0) ? true : false;
                $main->result['marge'] =  $main->result['marge'] + $value['marge_gesamt'];
                $main->result['marge_rabatt'] =  $main->result['marge_rabatt'] + $value['marge_inkl_rabatt_gesamt'];
                $main->result['netto'] = $main->result['netto'] + $value['netto_gesamt'];
                $main->result['netto_rabatt'] = $main->result['netto_rabatt'] + $value['netto_inkl_rabatt_gesamt'];
                $main->result['steuer'] = $main->result['steuer'] + $value['steuer_wert_gesamt'];
                $main->result['brutto'] = $main->result['brutto'] + $value['brutto_gesamt'];

                if($value['rabatt_prozent'] > 0) {
                    $main->result['rabatt_prozent'][] = $value['rabatt_prozent'];
                }

                if($value['marge_prozent'] > 0) {
                    $main->result['marge_prozent'][] = $value['marge_prozent'];
                }


                // MwSt. Sätze
                if (!isset($main->result['steuer_saetze'][$value['steuer']])) {
                    $main->result['steuer_saetze'][$value['steuer']] = 0;
                }

                // MwSt. Sätze summieren
                $main->result['steuer_saetze'][$value['steuer']] = $main->result['steuer_saetze'][$value['steuer']] + $value['steuer_wert_gesamt'];
            }

            

            // MwSt. Sätze sortieren (aufsteigend)
            asort($main->result['steuer_saetze']);
        }

        // Rückgabe
        return $main->answer();
    }


    public function checkAdd() {
        $req = new Request();
        $req->success = true;
        return $req->answer();
    }

    /**
     * Hinzufügen neuer Artikel
     *
     */
    public function add($refId, $artikel) {

        $check = $this->checkAdd();

        if ($check['success']) {

            // Request
            $artikelApi = new Artikel();

            // Artikel normalisieren
            $artikel = (is_array($artikel)) ? $artikel : [$artikel];

            // Reihenfolge
            $reihenfolge = $this->getNextOrderNumber($this->getAllById($refId));

            // Leeres Positionen Array
            $pos = [];

            // Schleife durch alle Artikel
            foreach ($artikel as $value) {

                // Artikel Infos auslesen
                $artikelData = $artikelApi->get($value);

                if ($artikelData['success']) {

                    // Array
                    $pos[] = [
                        'reihenfolge' => $reihenfolge,
                        $this->ref => $refId,
                        'artikel_id' => $value,
                        'menge' => 1,
                        'ek' => isset($artikelData['data']['ek']) ? $artikelData['data']['ek'] : 0,
                        'vk' => isset($artikelData['data']['vk']) ? $artikelData['data']['vk'] : 0,
                        'steuer' => 19.0
                    ];
                    // Reihenfolge hochzählen
                    $reihenfolge++;

                } else {

                    // TODO: Wenn ein Artikel nicht gefunden wird
                    // Sollte eigentlich nicht vorkommen!
                }
            }



            // Request
            $req = new Request($pos);

            // Verarbeitungsarray
            $process = [
                ['t', 'reihenfolge'],
                ['t', $this->ref],
                ['t', 'artikel_id'],
                ['t', 'menge'],
                ['t', 'ek', 'ek', '0'],
                ['t', 'vk', 'vk', '0'],
                ['t', 'steuer'],
            ];

            // Ergebnis
            $req->insertMultiple($this->table, $process);

            // Antwort
            return $req->answer();

            // Wenn es nicht möglich ist
        } else {
            return $check;
        }
    }


    /**
     * Bearbeiten Funktion
     * - Diese Funktion sollte in der Regel überschrieben werde, da bei jeder Position unterschiedliche Dinge gespeichert werden
     */
    public function edit($posId, $data) {
        $req = new Request();
        $req->error = "Diese Funktion wurde in der `positionen-api` aufgerufen und muss überschrieben werden, da es keine Standardlösung gibt!";
        return $req->answer();
    }

    /**
     * Bearbeiten Funktion
     * - Diese Funktion sollte in der Regel überschrieben werde, da bei jeder Position unterschiedliche Dinge gespeichert werden
     */
    public function editMultiple($posId, $data) {
        $req = new Request();
        $req->error = "Diese Funktion wurde in der `positionen-api` aufgerufen und muss überschrieben werden, da es keine Standardlösung gibt!";
        return $req->answer();
    }


    public function checkDelete() {
        $req = new Request();
        $req->success = true;
        return $req->answer();
    }

    public function delete($posIds) {

        $check = $this->checkDelete();

        // Wenn man löschen darf
        if ($check['success']) {

            // Artikel normalisieren
            $posIds = (is_array($posIds)) ? $posIds : [$posIds];

            // Referenz Ids
            $refIds = $this->getRefByPosIds($posIds);

            // Request
            $req = new Request();

            if ($refIds['success']) {

                // Löschen
                $req->deleteMultiple($this->table, $posIds);

                // Neu sortieren
                foreach ($refIds['data'] as $refId) {
                    $this->reorderByRefId($refId);
                }
            } else {
                $req->adapt($refIds);
            }

            return $req->answer();
        } else {
            return $check;
        }
    }


    public function deleteAllByRef($refId) {

        $req = new Request();

        // Positionsdaten
        $pos = $this->getAllById($refId);

        // Delete Array
        if ($pos['success']) {

            $del = [];

            foreach ($pos['data'] as $key => $value) {
                $del[] = $value['id'];
            }

            $result = $this->delete($del);

            $req->adapt($result);
        } else {
            $req->adapt($pos);
        }

        return $req->answer();
    }



    public function reorderByRefId($refId) {

        $req = new Request();

        $pos = $this->getAllById($refId);

        if ($pos['success']) {
            $result = $this->reorder($pos);
            $req->success = true;
        } else {
            $req->adapt($pos);
        }

        return $req->answer();
    }

    // Reorder
    public function reorder($pos) {

        // Initalisieren
        $success = true;
        $querys = [];
        $i = 1;

        if ($pos['success']) {

            // Normalisieren
            $pos = $this->normalizePos($pos);

            $array = [];

            foreach ($pos as $key => $value) {
                $array[] = $i++;
            }

            $success = $this->changeColumn($pos, "reihenfolge", $array);

            // Wenn keine Daten da waren
        } else {
            $success = false;
        }

        // Erfolg zurückgeben
        return $success;
    }

    public function getNextOrderNumber($pos) {

        // Rückgabe
        return ($pos['success']) ? end($pos['data'])['reihenfolge'] + 1 : 1;
    }


    // Schliefe
    public function orderIds($pos, $ids) {

        $pos = $this->orderPos($pos);

        $inOrder = [];

        foreach ($pos as $key => $value) {
            if (in_array($value['id'], $ids)) {
                $inOrder[] = $value['id'];
            }
        }

        return $inOrder;
    }


    // Verschieben
    public function shiftById($refId, $direction, $posId) {

        // Positionen auslesen
        $pos = $this->getAllById($refId);

        return $this->shift($pos, $direction, $posId);
    }


    // Verschieben
    public function shift($pos, $direction, $posIds) {

        // Normalisieren
        $pos = $this->normalizePos($pos);

        $posIds = (is_array($posIds)) ? $posIds : [$posIds];

        // Sortieren, damit kann die Reihenfolge aus der GUI egal sein
        $posIds = $this->orderIds($pos, $posIds);

        if ($direction == 'down' || $direction == 'top') {
            $posIds = array_reverse($posIds);
        }



        foreach ($posIds as $value) {

            // Position verändern
            $pos = $this->shiftKeyInPos($pos, $direction, $value);
        }

        // Schreiben der Veränderung
        return $this->changeColumnByChangedPos($pos, 'reihenfolge');
    }

    // Shift 
    public function shiftKeyInPos($pos, $direction, $posId) {

        // Positionen normalisieren & Sortieren
        $pos = $this->normalizePos($pos);
        $pos = $this->orderPos($pos);

        // Key der Position auslesen
        $key = $this->getPosById($pos, $posId);

        // Exception werfen
        if ($key === false) {
            throw new Exception("Die Positions ID ist nicht in den Daten enthalten");
        }

        $sum = count($pos);

        // Wenn die Reihenfolge überhaupt geändert werden kann
        if ($sum > 1) {

            // ist es legitim, dass verschoben werden soll
            if ((in_array($direction, ['up', 'top']) && $key > 0) || (in_array($direction, ['down', 'bottom']) && ($key + 1) < $sum)) {

                // Eine Position nach oben
                if ($direction == 'up') {
                    $pos[$key - 1]['reihenfolge'] = $pos[$key]['reihenfolge'];
                    $pos[$key]['reihenfolge'] = $pos[$key]['reihenfolge'] - 1;

                    // Eine Position nach unten
                } else if ($direction == 'down') {

                    $pos[$key + 1]['reihenfolge'] = $pos[$key]['reihenfolge'];
                    $pos[$key]['reihenfolge'] = $pos[$key]['reihenfolge'] + 1;
                } else if (in_array($direction, ['top', 'bottom'])) {

                    $prev = $next = $pos;

                    // Aufsplitten in Vorher und Nachher                    
                    $prev = array_splice($prev, 0, $key);
                    $next = array_splice($next, $key + 1);

                    // Wenn es nach oben sortiert werden soll
                    if ($direction == 'top') {
                        $prev = $this->changeColumnInArray($prev, 'reihenfolge', '*++');
                        $pos[$key]['reihenfolge'] = 1;
                    } else if ($direction == 'bottom') {
                        $next = $this->changeColumnInArray($next, 'reihenfolge', '*--');
                        $pos[$key]['reihenfolge'] = $sum;
                    }

                    // Zusammenführen
                    $pos = array_merge([$pos[$key]], $prev, $next);
                }
            }
        }

        // 
        return $pos;
    }


    // Sortiert die Positionen nach der Reihenfolge
    public function orderPos($pos) {

        $pos = $this->normalizePos($pos);

        $columns = array_column($pos, "reihenfolge");
        array_multisort($columns, SORT_ASC, $pos);

        return $pos;
    }

    // 
    public function getPosById($pos, $id) {

        $pos = $this->normalizePos($pos);

        // Schliefe durch alle Position
        foreach ($pos as $key => $value) {
            if ($value['id'] == $id) {
                return $key;
            }
        }

        return false;
    }


    /**
     *  
     * $value kann mit bestimmten Befehlen angegeben werden. 
     * Dann muss das ganze mit einem Sternchen anfangen
     * Zum Beispiel: *++ oder *--
     *
     * 
     * 
     * 
     */
    public function changeColumnInArray($pos, $setKey, $setValue) {

        $i = 0;

        // Schleife durch alle Positionen
        foreach ($pos as $key => $value) {

            // Anweisung
            if (!is_array($setValue) && substr($setValue, 0, 1) == '*') {

                // Befehl
                $befehl = substr($setValue, 1);

                if ($befehl == '++') {
                    $pos[$key][$setKey] = $pos[$key][$setKey] + 1;
                } else if ($befehl == '--') {
                    $pos[$key][$setKey] = $pos[$key][$setKey] - 1;
                }

                // Überschreiben
            } else {

                if (is_array($setValue)) {
                    $pos[$key][$setKey] = $setValue[$i];
                } else {
                    $pos[$key][$setKey] = $setValue;
                }
            }

            $i++;
        }

        return $pos;
    }

    /**
     * Diese Funktion kann genutzt werden, wenn man ein Pos Array vorab verändert und diese 
     * veränderungen in die Datenbank schreiben will
     */
    public function changeColumnByChangedPos($pos, $setKey) {

        // Positionen normalisieren
        $pos = $this->normalizePos($pos);

        // Schleife
        foreach ($pos as $key => $value) {
            $array[] = $value[$setKey];
        }

        // Column verändern
        return $this->changeColumn($pos, $setKey, $array);
    }

    // Change Column
    public function changeColumn($pos, $setKey, $setValue) {

        global $db;

        // Positionen normalisieren
        $pos = $this->normalizePos($pos);

        $success = true;

        // Validieren
        if (is_array($setValue)) {
            if (count($pos) != count($setValue)) {
                throw new Exception("Ungültige Anzahl der Spalten, die verändert werden sollen", 1);
            }
        }

        // Neue Position
        $newPos = $this->changeColumnInArray($pos, $setKey, $setValue);

        // Positionen
        foreach ($newPos as $key => $value) {
            $querys[] = "UPDATE `" . $this->table . "` SET `" . $setKey . "` = '" . $value[$setKey] . "' WHERE id = '" . $value['id'] . "'";
        }


        // Multi Query durchführen
        if (!$db->multi_query(implode(";", $querys))) {
            $success = false;
        } else {
            while ($db->next_result());
        }

        return $success;
    }


    public function normalizePos($pos) {
        return (isset($pos['success'])) ? $pos['data'] : $pos;
    }
}
