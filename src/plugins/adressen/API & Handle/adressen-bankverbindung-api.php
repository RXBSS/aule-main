<?php

class AdressenBank {

public $table = "adressen_bankverbindung";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {
        
        global $db;
        $data = false;
        
        $query = "SELECT * FROM `".$this->table."` WHERE `id` = '".$id."'";
        $result = $db->query($query);
        if($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }

        return $data;
    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;


        $req = new Request($data);

        $req->checkDuplicate('Die IBAN ist bereits vergeben!', $this->table, 'iban', $data['iban']);

        if(!$req->error) {

            $req->data['bank'] = $data['bank']." ".$data['ort'];

            $process = [
                ['t', 'adressen_id'],
                ['t', 'iban'],
                ['t', 'bic'],
                ['t', 'bank']
            ];

            $req->insert($this->table, $process);
        
        }


        return $req->answer();



        // Dupletten Prüfung IBAN

        // Wenn es KEINE Duplette gibt
        
            // Query
            // $query = "INSERT INTO `".$this->table."` SET 
            //     `adressen_id` = '".$data['adressen_id']."',
            //     `iban` = '".$data['iban']."',
            //     `bic` = '".$data['bic']."',
            //     `bank` = '".$data['bank']." ".$data['ort']." '
            // ";
            
            // if($db->query($query)) {
            //     $id = $db->insert_id;

            //     $success = true;
            // } else {
            //     $error = $db->error;
            // }

            // return [
            //     'success' => $success,
            //     'error' => $error,
            //     'id' => $id
            // ];
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

        $req->data['bank'] = $data['bank']." ".$data['ort'];

        $process = [
            ['t', 'iban'],
            ['t', 'bic'],
            ['t', 'adressen_id'],
            ['t', 'bank']
        ];

        // Ergebnis
        $req->update($this->table, $process, 'WHERE `id` = '.$data['id'].'');


        // Antwort schreiben
        return $req->answer();
    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $id = (is_array($id)) ? $id : [$id];

        $query = "DELETE FROM `".$this->table."` WHERE `id` IN ('".implode("','",$id)."');";
        
        if($db->query($query)) {
            $success = true;
        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }
}
?>