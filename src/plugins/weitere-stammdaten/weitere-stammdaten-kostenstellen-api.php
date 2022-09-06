<?php

class Kostenstellen {

public $table = "kostenstellen";

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
            ['t', 'bezeichnung'],
            ['c', 'verkaeufe'],
            ['c', 'einkaeufe']
        ];
            
        $req->insert($this->table, $process);

        return $req->answer();

    }

    public function edit($id, $data) {

        global $db;
        $success = $error = false;

        $req = new Request($data);

        $process = [
            ['t', 'bezeichnung'],
            ['c', 'verkaeufe'],
            ['c', 'einkaeufe']
        ];
            
        $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

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