<?php




class PasswortManager {

    public $table = "passwoerter";

    public function __construct() {
        
    }

    /**
     * Liest die Daten einer Ident aus
     */
    public function get($id) {
        
        // Request
        $req = new Request();

        // Query
        $req->get($this->table, $id);

        return $req->answer();
    }
}
