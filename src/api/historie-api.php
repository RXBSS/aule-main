<?php

/**
 * Die Klasse dient dazu eine Historie zu führen und diese auch wieder auszulesen
 * Folgende Felder sind Pflichtfelder eine Historie
 * 
 * 
 * 
 */
class History {

    /**
     * Historie
     */
    public function __construct($name) {

        if (!$name) {
            throw "Es wurde keine Name mitgegeben!";
        }

        // Name + _historie ist der Name der Datenbank
        $this->table = $name . "_historie";
    }

    /**
     * Vollständige Funktion
     * 
     * // Vollständig
     * $history->write('some', 20, 11, ['foo' => 'bar']);
     * 
     * // Für den aktuell angemeldeten Benutzer
     * $history->write('some', 20, true, ['foo' => 'bar']);
     * 
     * // Mehrere Ref IDs
     *  $history->write('some', [10,20,30], true, ['foo' => 'bar']);
     * 
     */
    public function write($identifier, $refId = false, $userId = false, $daten = false) {

        // Gloabl App
        global $app;

        // Prüfen, dass der Identifier mitgegeben wurde
        if (!$identifier) {
            throw new Exception("Es wurde kein Identifier mitgegeben!");
        }

        // Daten normalisieren
        $refId1 = (is_array($refId)) ? $refId[0] : $refId;
        $refId2 = (is_array($refId) && isset($refId[1])) ? $refId[1] : false;
        $refId3 = (is_array($refId) && isset($refId[2])) ? $refId[2] : false;
        $daten = (is_array($daten)) ? json_encode($daten) : $daten;


        // Wenn der Benutzer auf true steht, dann den aktuellen Benutzer auslesen
        if ($userId === true) {

            // Prüfen, dass der Benutzer eingeloggt ist
            if (!$app->user->isLoggedIn()) {
                throw new Exception("Der Benutzer ist nicht eingeloggt! Es kann keine Historie geschrieben werden!");
            }

            // Daten verändern!
            $userId = ($userId === true) ? $_SESSION['user']['id'] : $userId;
        }

        // Neuer Request
        $req = new Request([
            'identifier' => $identifier,
            'zeitstempel' => date("Y-m-d H:i:s"),
            'referenz_id' => $refId1,
            'referenz_id2' => $refId2,
            'referenz_id3' => $refId3,
            'user_id' => $userId,
            'daten' => $daten,
        ]);

        // Verarbeitungsarray
        $process = [
            ['t', 'identifier'],
            ['dt', 'zeitstempel'],
            ['t', 'referenz_id'],
            ['t', 'referenz_id2'],
            ['t', 'referenz_id3'],
            ['t', 'user_id'],
            ['t', 'daten']
        ];

        // Ergebnis
        $req->insert($this->table, $process);

        // Rückgabe
        return $req->answer();
    }


    /**
     * Historie auslesen
     * 
     */
    public function getByIdentifier($identifier = false, $ref1 = false, $ref2 = false, $ref3 = false) {

        // Query erstellen
        $query = "
            SELECT h.*, m.vorname, m.nachname
                FROM `" . $this->table . "` h 
                LEFT JOIN `mitarbeiter` m ON h.user_id = m.id
        ";

        // Filter erstellen
        $filter = [];

        // Abfrage
        if ($identifier) {$filter[] = "`identifier` = '".$identifier."'";}
        if ($ref1) {$filter[] = "`referenz_id` = '".$ref1."'";}
        if ($ref2) {$filter[] = "`referenz_id2` = '".$ref2."'";}
        if ($ref3) {$filter[] = "`referenz_id3` = '".$ref3."'";}

        if(count($filter) > 0) {
            $query .= "WHERE ".implode(" AND ", $filter);
        }

        // Request
        $req = new Request();

        // Get Query
        $req->getMultiQuery($query, true);

        // Schleife zum ggf. Verarbeiten von JSON
        foreach($req->result AS $key => $value) {
            $dataAsJson = json_decode($value['daten'], true);
            $req->result[$key]['daten'] = (json_last_error() === 0) ? $dataAsJson : $value['daten'];
        }

        // Antworten
        return $req->answer();
    }

    // Referenz auslesen
    public function getByReference($ref1 = false, $ref2 = false, $ref3 = false, $identifier = false) {
        return $this->getByIdentifier($identifier, $ref1, $ref2, $ref3);
    }
}
