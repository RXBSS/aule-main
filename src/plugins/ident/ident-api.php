<?php


class Ident {

    public $table = "ident";

    public function __construct() {
    }

    /**
     * Liest die Daten einer Ident aus
     */
    public function get($id) {

        // Request
        $req = new Request();

        // Abfrage
        $query = "
            SELECT 
                    i.*, 
                    a1.name AS be_name,  a1.strasse AS be_strasse,  a1.plz AS be_plz,  a1.ort AS be_ort, 
                    a2.name AS re_name,  a2.strasse AS re_strasse,  a2.plz AS re_plz,  a2.ort AS re_ort,
                    artikel.bezeichnung AS artikel_bezeichnung, h.bezeichnung AS artikel_hersteller

                FROM `" . $this->table . "` i
                LEFT JOIN `adressen` a1 ON i.betreiber_id = a1.id
                LEFT JOIN `adressen` a2 ON i.rechnungsempfaenger_id = a2.id
                LEFT JOIN `artikel` artikel ON i.artikel_id = artikel.id
                LEFT JOIN `hersteller` h ON artikel.hersteller_id = h.id

            WHERE i.`id` = '" . $id . "'";



        // Query
        $req->getQuery($query);

        // Überprüfen ob es eine Haupt-Id ist
        $req->result['is_haupt_id'] = ($req->result['haupt_id']) ? false : true;

        return $req->answer();
    }

    /**
     * Get Links
     * - Sortiert auch immer richtig!
     * - Das ist wichtig zu wissen!
     * 
     */
    public function getLink($id) {

        $req = new Request();

        // Die Daten ID abholen, die angefragt wurde
        $main = $this->get($id);

        if ($main['success']) {

            // Die ID nach der gesucht werden muss
            $searchId = ($main['data']['is_haupt_id']) ? $main['data']['id'] : $main['data']['haupt_id'];

            // Alle Verlinkten IDs
            $links = $this->getLinkedIds($searchId);

            // Übernehmen
            $req->adapt($links);

            // Abfrage durchführen
            foreach($req->result AS $key => $value) {
                $req->result[$key]['requested'] = ($id == $key) ? true : false;          
                $req->result[$key]['data'] = ($id == $key) ? $main['data'] : $this->get($key)['data'];
            }

            // Sortiert so, dass die Haupt-Id immer oben ist
            array_multisort(array_column($req->result, 'main'), SORT_DESC, $req->result);
            // TODO: Hier sollte ggf. noch eine Reihenfolge festgelegt werden. Dann könnte man ADF, Papierkassetten, etc. immer in der gleichen Reihenfolge anlegen.

        } else {
            $req->adapt($main);
        }

        return $req->answer();
    }

    // 
    public function getLinkedIds($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT id, haupt_id FROM `" . $this->table . "` WHERE `id` = '" . $id . "' OR `haupt_id` = '" . $id . "';
        ";

        // Query
        $req->getMultiQuery($query);

        // Neues Ergebnis
        $newResult = [];

        // Ergebnis anpassen
        foreach($req->result AS $key => $value) {
            $newResult[$value['id']] = [
                'id' => $value['id'],
                'haupt_id' => ($value['haupt_id']) ? $value['haupt_id'] : $value['id'],
                'main' => ($value['haupt_id']) ? false : true
            ];
        }

        $req->result = $newResult;

        // Rückgabe
        return $req->answer();
    }
}
