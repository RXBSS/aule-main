<?php

class AkquiseAktionen {

public $table = "akquise_aktionen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {
        
        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();

    }

    // Neu erstellen
    public function new($data) {

        global $db;
        $success = $error = $id = false;

        $req = new Request($data);

        // Ersteller ist immer der User
        $req->data['ersteller_id'] = $_SESSION['user']['id'];

        // Processs
        $process = [
            ['t', 'name'],
            ['c', 'entwurf'],
            ['t', 'ersteller_id'],
            ['dt', 'zeitstempel'],
            ['t', 'wiedervorlage_nach'],
            ['c', 'standard_meilensteine']
        ];

        // Insert
        $req->insert($this->table, $process);

        // Rückgabe
        return $req->answer();
    }

    public function edit($id, $data) {
        
        global $db;
        $success = $error = false;

        $req = new Request($data);

        $process = [
            ['t', 'name'],
            ['c', 'entwurf'],
            ['s', 'ersteller_id'],
            ['dt', 'zeitstempel'],
            ['t', 'wiedervorlage_nach'],
            ['c', 'standard_meilensteine']
        ];

        $req->updateById($this->table, $process, $id);

        return $req->answer();

    }

    public function delete($id) {
        
        global $db;
        $success = $error = false;

        $query = "DELETE  `".$this->table."` WHERE `id` = '".$id."';";
        
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

    public function getAkquiseAktionen() {
        $req = new Request();

        global $db;
        $success = $error = $data = false;
        
        $query = "SELECT COUNT(name) FROM `".$this->table."`";
        $result = $db->query($query);
        if($result->num_rows > 0) {

            $success = true;
            $data = $result->fetch_assoc();
        } else {
            $error = "Keine Daten!";
        }

        return [
            'success' => $success,
            'error' => $error,
            'data' => $data
        ];

    }
}
?>