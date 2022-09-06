<?php

class Zaehler {

public $table = "zaehler";

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

        $process = [
            ['t', 'bezeichnung']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

        $process = [
            ['t', 'bezeichnung']
        ];

        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $req = new Request($id);

        $req->deleteMultiple($this->table, $id);

        return $req->answer();
    }
}
?>