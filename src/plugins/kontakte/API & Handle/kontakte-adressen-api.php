<?php

class AdressenKontakte {

    public $table =  "adressen_kontakte";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $query = "
            SELECT ak.*, a.name
            FROM ".$this->table." ak

            LEFT JOIN adressen a ON a.id = ak.adressen_id
            WHERE ak.id = '".$id."';
        ";

        $req->getMultiQuery($query);

        return $req->answer();
    }

    // Neu erstellen
    public function new($data, $kontakte_id) {

        $req = new Request($data);

        // Diese Adresse ist schon angelegt
        // $req->checkDuplicate('An dieser Adresse ist bereits ein Job verzeichnet', $this->table, 'adressen_id', $data['adressen_id']['value']);
        $req->checkDuplicateCombination('An dieser Adresse ist bereits ein Job verzeichnet', $this->table, ['adressen_id' => $data['adressen_id']['value'], 'kontakte_id' => $kontakte_id]);


        // Wenn es Keine Dupleete gibt
        if(!$req->error) {

            $req->data['kontakte_id'] = $kontakte_id;

            $process = [
                ['s', 'adressen_id'],
                ['t', 'kontakte_id'],
                ['t', 'abteilung'],
                ['t', 'funktion']
            ];

            $req->insert($this->table, $process);

        }


        return $req->answer();
    }

    // Es wird nur eine Adresse zu einem Kontak hinzugefügt
    public function onlyAdresse($data) {

        $req = new Request($data);

        $query = "";

        // Geht alle Adressen durch die Ausgewählt wurden
        foreach($data['data'] as $key => $value) {

            // Query
            $query = "
                INSERT INTO `".$this->table."` SET
                adressen_id = '".$value[1]."',
                kontakte_id = '".$data['id']."';
            ";

            // Insert
            $req->insertQuery($query);
        }

        // Rückgabe
        return $req->answer();
  
    }

 
    public function edit($id, $data, $kontakte_id) {

        $req = new Request($data);

        // Diese Adresse ist schon angelegt
        $req->checkDuplicateCombination('An dieser Adresse ist bereits ein Job verzeichnet', $this->table, ['adressen_id' => $data['adressen_id']['value'], 'kontakte_id' => $kontakte_id], $id);

        // Wenn es Keine Dupleete gibt
        if(!$req->error) {

            $req->data['kontakte_id'] = $kontakte_id;

            $process = [
                ['s', 'adressen_id'],
                ['t', 'kontakte_id'],
                ['t', 'abteilung'],
                ['t', 'funktion']
            ];

            $req->update($this->table, $process, 'WHERE `id` = '. $id .'');


        }


        return $req->answer();


    }

    public function editViaAdressen($data) {

        $req = new Request($data);

    //    echo "<pre>";
    //    print_r($req);
    //    echo "</pre>";

        $process = [
            ['t', 'abteilung'],
            ['t', 'funktion']
        ];

        $req->update($this->table, $process, 'WHERE `adressen_id` = '. $req->data['adressen_id'] .' AND `kontakte_id` = '. $req->data['kontakte_id'] .'');


        // echo "<pre>";
        // print_r($req);
        // echo "</pre>";

        // die();
 
        return $req->answer();

    }

    public function delete($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->table, $id);

        // Rückgabe
        return $req->answer();
    }

    // Löscht den Kontakt aus der Adresse wieder raus
    public function deleteAdressenKontakte($data) {

        $req = new Request($data);

        // Geht alle IDs durch
        foreach($data['id'] as $key => $value) {

            // Query
            $query = "
                DELETE FROM ".$this->table." 
                WHERE `adressen_id` = '".$data['adressen_id']."' and kontakte_id = '".$value."'
            ";

           
            $req->deleteQuery($query);
        }

        // Rückgabe
        return $req->answer();

    }

    // Wenn der Kontakt selber angelegt wurde
    public function newKontakteCustom($data) {

        $req = new Request($data);

        // Wenn es ein Array ist dann ist es ein Select
        if(is_array($req->data['adressen_id'])) {
            $test = ['s', 'adressen_id'];
        } else {
            $test = ['t', 'adressen_id'];
        }

        $process = [
            $test,
            ['t', 'kontakte_id'],
            ['t', 'abteilung'],
            ['t', 'funktion']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    } 

    // Wenn der Kontakt Autoamtsiche angelegt wurde über PICKLISTE
    public function newKontakt($data) {

        $req = new Request($data);

        // Schleife damit mehrere Kontakte Gleichzeitig angelegt werden können
        foreach ($req->data[1] as $key => $value) {

            $query = "
                INSERT INTO `adressen_kontakte` SET
                    `adressen_id` = '".$data[0]."',
                    `kontakte_id` = '".$value[1]."'
            ";

            $req->insertQuery($query);

        }

        return $req->answer();

    }

    // Wenn der Kontakt selber angelegt wurde
    public function submitAdressenKontakt($data) {

        $req = new Request($data);

        $process = [
            ['t', 'kontakte_id'],
            ['t', 'adressen_id'],
            ['t', 'abteilung'],
            ['t', 'funktion']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    } 

}
?>