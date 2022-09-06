<?php

class Artikelgruppen {

    public $table = "artikel_gruppen";

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

        $req = new Request($data);

        global $db;
        global $app;

        $success = $error = $id = false;

        if(!$req->hasDuplicate($this->table, "bezeichnung", $data["bezeichnung"])) {
            // Query
            
            $process = [
                ['t', 'bezeichnung'], 
                ['s', 'artikel_zuordnung', 'zuordnung_id']
            ];

            $req->insert($this->table, $process);

        } else {
            $error = "Die Artikelgruppe ist bereits vergeben!";
            
        }

        

        return $req->answer();
    }

    public function edit($id, $data) {

        $req = new Request($data);

        global $db;
        global $app;
        $success = $error = false;

        if(!$req->hasDuplicate($this->table, "bezeichnung", $id)) {

            $process = [
                ['t', 'bezeichnung'], 
                ['s', 'artikel_zuordnung', 'zuordnung_id']
            ];

            $req->update($this->table, $process, 'WHERE `id` = '.$id.'');

        } else {
            $error = "Die Artikelgruppe ist bereits vergeben!";
        }
        
        return $req->answer();

    }

    
    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $id = (is_array($id)) ? $id : [$id];
        

        $query = "DELETE FROM `".$this->table."` WHERE `id` IN ('".implode("','",$id)."');";

        if($db->query($query)) {
            $success = true;
            
            // Für jede ID dies und das machen

        } else {
            $error = $db->error;
        }

        return [
            'success' => $success,
            'error' => $error
        ];
    }

    public function getArtikelZuordnung($id) {

        global $db;
        $data = false;
        
        $query = "SELECT * FROM `artikel_zuordnung` WHERE `id` = '".$id."'";
        $result = $db->query($query);
        if($result->num_rows == 1) {
            $data = $result->fetch_assoc();
        }
        
        return $data;
    }
}
?>