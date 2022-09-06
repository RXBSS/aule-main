<?php


class ZaehlerstaendeAnleitungen {

    public $table = "zaehlerstaende_anleitungen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        // Simple Get
        $query = "
            SELECT 
                z.*, 
                s.bezeichnung AS status_bezeichnung,
                a.hersteller_bezeichnung
 
            FROM " . $this->table . " z
            LEFT JOIN status s ON z.status_id = s.status_id AND s.bereich = 'zaehlerstaende_anleitungen'
            LEFT JOIN adressen a ON z.hersteller_id = a.id AND a.ist_hersteller = '1'
            WHERE z.id = '" . $id . "'";

        $req->getQuery($query);

        // Slashes entfernen!
        $req->result['inhalt'] = stripslashes($req->result['inhalt']);

        return $req->answer();
    }

    // Neu erstellen
    public function new() {

        $req = new Request([
            'bezeichnung' => 'Eine Neue Anleitung',
            'status_id' => 1,
            'inhalt' => 'Hier steht der Text'
        ]);

        $process = [
            ['t', 'bezeichnung'],
            ['t', 'status_id'],
            ['t', 'inhalt']
        ];

        $req->insert($this->table, $process);

        return $req->answer();
    }

    public function edit($id, $data) {

        $req = new Request($data);

        $process = [
            ['t', 'bezeichnung'],
            ['s', 'status_id'],
            ['s', 'hersteller_id'],
            ['sn', 'inhalt', 'inhalt', 'data/images/zaehlerstaende-anleitungen']
        ];

        $req->update($this->table, $process, 'WHERE `id` = ' . $id . '');

        return $req->answer();
    }

    public function checkDelete($id) {
        $req = new Request();
        $req->success = true;
        $req->result = [
            'check' => true
        ];
        return $req->answer();
    }

    /**
     * result = false => nicht gelöscht
     * result = true => gelöscht
     * 
     */
    public function delete($id, $force = false) {

        // Request
        $req = new Request();

        // nicht gelöscht
        $req->result = 0;

        $c = true;

        if (!$force) {
            $result = $this->checkDelete($id);

            // 
            if ($result['success']) {
                if (!$result['data']['check']) {
                    $c = false;
                }
            } else {
                $c = false;
                $req->adapt($result);
            }
        }

        if ($c) {
            $req->delete($this->table, $id);
            $req->result = 1;
        }

        // Rückgabe
        return $req->answer();
    }


    public function printHtml($id) {

        $result = $this->get($id);

        if ($result['success']) {
            echo "<div class='editor-content'>".$result['data']['inhalt']."</div>";
        } else {
            echo "Es ist ein Fehler aufgetreten!";
        }
    }
}
