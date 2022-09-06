<?php

class artikelAttribute {

public $table = "artikel_attribute";

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

        $req = new Request();

        global $db;
        $success = $error = $id = false;

        if(!$req->hasDuplicate($this->table, "bezeichnung", $data["bezeichnung"])) {
            // Query 
                $query = "INSERT INTO `".$this->table."` SET 
                `bezeichnung` = '".$data['bezeichnung']."',
                `beschreibung` = ".(($data['beschreibung']) ? "'".$data['beschreibung']."'" : "NULL").",
                `datentyp` = ".(($data['datentyp']['text'] != '- Bitte Wähle -') ? "'".$data['datentyp']['text']."'" : "NULL").",
                `pflichtfeld` = ".(($data['pflichtfeld']['text'] != '- Bitte Wähle -') ? "'".$data['pflichtfeld']['text']."'" : "NULL").",
                `reihenfolge` = ".(($data['reihenfolge']) ? "'".$data['reihenfolge']."'" : "NULL")."
            ";

            if($db->query($query)) {
                $id = $db->insert_id;
                $success = true;
            } else {
                $error = $db->error;
            }
        } else {
            $error = "Das Attribut ist bereits vergeben!";
        }
        

        return [
            'success' => $success,
            'error' => $error,
            'id' => $id
        ];
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request();

        if(!$req->hasDuplicate($this->table, "bezeichnung", $id)) {
            $query = "UPDATE `".$this->table."` SET 
            `bezeichnung` = '".$data['bezeichnung']."',
            `beschreibung` = ".(($data['beschreibung']) ? "'".$data['beschreibung']."'" : "NULL").",
            `datentyp` = ".(($data['datentyp']['text'] != '- Bitte Wähle -') ? "'".$data['datentyp']['text']."'" : "NULL").",
            `pflichtfeld` = ".(($data['pflichtfeld']['text'] != '- Bitte Wähle -') ? "'".$data['pflichtfeld']['text']."'" : "NULL").",
            `reihenfolge` = ".(($data['reihenfolge']) ? "'".$data['reihenfolge']."'" : "NULL")."
            WHERE `id` = '".$id."';
         ";

            if($db->query($query)) {
                $success = true;
            } else {
                $error = $db->error;
            }
        } else {
            $error = "Das Attribut ist bereits vergeben!";
        }
     

        return [
            'success' => $success,
            'error' => $error
        ];

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