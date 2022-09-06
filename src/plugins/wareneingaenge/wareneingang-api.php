<?php


class Wareneingang {

    // Standard Werte
    public $tableHead = "wareneingaenge";
    public $tablePos = "wareneingaenge_positionen";


    // Konstructor
    public function __construct() {
    }

    /**
     * Neuen Wareneingang erstellen
     */
    public function neu() {

        $req = new Request([
            'status_id' => 0
        ]);

        $process = [
            ['t', 'status_id']
        ];

        $req->insert($this->tableHead, $process);

        return $req->answer();
    }


    // Bestellung importieren
    public function importBestellung($lieferungId, $bestellungId) {

        // Neuer Request
        $req = new Request();

        // Ergebnis
        $res = $this->checkImportPossible($lieferungId, $bestellungId);

        // Wenn die Bestellung importiert werden kann
        if ($res['success']) {

            // Bestellung API
            $b = new Bestellung();

            // Daten
            $resPos = $b->getPositions($bestellungId);

            // Wenn die Positionsdaten ausgelesen werden konnten
            if ($resPos['success']) {

                // Überschreiben
                $resWrite = new Request($resPos['data']);

                // Lieferung ID hinzufügen
                foreach ($resWrite->data as $key => $value) {
                    $resWrite->data[$key]['lieferung_id'] = $lieferungId;
                }

                // Process Array
                $process = [
                    ['t', 'bestellung_id'],
                    ['t', 'artikel_id'],
                    ['t', 'lieferung_id'],
                    ['t', 'bestellmenge'],
                ];

                // Insert 
                $resWrite->insertMultiple($this->tablePos, $process);

                // Übernehmen
                $req->adapt($resWrite);

                // Fehlermeldung ausgeben
            } else {
                $req->adapt($resPos);
            }

            // Ansonsten die Fehlermeldung übernehmen
        } else {
            $req->adapt($res);
        }

        // Rückgabe
        return $req->answer();
    }

    // Hier muss geprüft werden, ob der Import überhaupt möglich ist
    public function checkImportPossible($lieferungId, $bestellungId) {

        // TODO: Prüfen, dass in der Lieferung, noch keine andere Lieferung eines anderen Lieferanten ist
        // TODO: Prüfen, dass die Bestellung noch nicht importiert wurde, bzw. dass Sie den entsprechenden Status hat


        $req = new Request();

        $req->success = true;


        return $req->answer();
    }




    /**
     * Row ID
     */
    public function positionBuchen($rowId, $data) {

        // Neuer Request
        $req = new Request($data);

        // Verarbeiten
        $process = [
            ['t', 'liefermenge'],
            ['t', 'bestellung_id']
        ];

        $req->update($this->tablePos, $process, "WHERE `id` = '" . $rowId . "'");
    }


    
    /**
     * Wareneingang buchen
     */
    public function buchen($id) {

        // Seriennummern prüfen
        // Bestände ändern
        
        // Status ändern

        $req = new Request([
            'status_id' => '1',
        ]);

        // Verarbeiten
        $process = [
            ['t', 'status_id']
        ];

        $req->update($this->tableHead, $process, "WHERE `id` = '" . $id . "'");

        return $req->answer();
    }   



}
