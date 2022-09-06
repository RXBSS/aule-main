<?php

class VertraegePos {

public $table =  "vertraege_positionen";

    function __construct() {
        // Do Something at Construction
    }

    public function get($id) {

        $req = new Request();

        $req->get($this->table, $id);

        return $req->answer();
    }

    // Holt die Positionen über die Vertrags ID
    public function getByIDArtikel($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT vp.*, i.*
            FROM `".$this->table."` vp
            LEFT JOIN ident i ON i.id = vp.ident_id
            WHERE vp.id = '".$id."'
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }


    // Lädt Alle Positions Daten und Artikel Daten
    public function getPositionen($id) {

        $req = new Request();

        $result = $this->getByIDArtikel($id);

        // $result = (isset($result[0])  ? $result[0] : $result);

      

        // Wenn Success
        if($result['success']) {

            $query = "

                SELECT vp.*, a.bezeichnung as artikelBezeichnung,  z.bezeichnung as zaehlerBezeichnung, z.id as zaehler_id, vpz.pauschale as zaehlerPauschale
                FROM vertraege_positionen vp
                
                LEFT JOIN ident i ON i.id = vp.ident_id
                LEFT JOIN artikel a ON a.id = i.artikel_id
                LEFT JOIN artikel_zaehler az ON az.artikel_id = a.id
                LEFT JOIN zaehler z ON z.id = az.zaehler_id
                LEFT JOIN vertraege_positionen_zaehler vpz ON vpz.positionen_id = vp.id AND vpz.zaehler_id = z.id
                
                WHERE vp.ident_id = '".$result['data'][0]['ident_id']."' AND vp.vertrags_id = '".$result['data'][0]['vertrags_id']."';

            ";

            // Query Abfrage
            $req->getMultiQuery($query, true);

                // Rückgabe
            return $req->answer();



            
            
        }
       
    }

    public function getPosByZaehler($posId, $zaehler_id) {

        $req = new Request();

        $query = "
            SELECT *
            FROM vertraege_positionen_zaehler
            WHERE positionen_id = '".$posId."' AND zaehler_id = '".$zaehler_id."';

        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
            

    }

    // Holt die Positionen über die Vertrags ID
    public function getPositionenWithVertragsID($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT vp.*, a.*
            FROM `".$this->table."` vp
            LEFT JOIN ident i ON i.id = vp.ident_id
            LEFT JOIN artikel a ON a.id = i.artikel_id
            WHERE vp.vertrags_id = '".$id."'
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    // lädt Alle Zähller die es gibt
    public function getZaehler($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT z.*, vpz.pauschale
            FROM zaehler z
            LEFT JOIN artikel_zaehler az ON az.zaehler_id = z.id
            LEFT JOIN artikel a ON a.id = az.artikel_id
            LEFT JOIN ident i ON i.artikel_id = a.id
            LEFT JOIN vertraege_positionen vp ON vp.ident_id = i.id
            LEFT JOIN vertraege_positionen_zaehler vpz ON vpz.zaehler_id = z.id AND vpz.positionen_id = vp.id
            WHERE vp.vertrags_id = '".$id."';
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();


    }

    // Summiert alle Pauschalen der Positon
    public function getSumPauschalPos($id) {

        $req = new Request();

        // Query
        $query = "
            SELECT SUM(vp.pauschale) as summePauschale
            FROM `".$this->table."` vp
            WHERE vp.vertrags_id = '".$id."'
        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    public function getZaehlerByIdent($id) {

        $req = new Request();

        // Query
        $query = "

            SELECT z.id as zaehler_id
            FROM zaehler z
            LEFT JOIN artikel_zaehler az ON az.zaehler_id = z.id
            LEFT JOIN artikel a ON a.id = az.artikel_id
            LEFT JOIN ident i ON i.artikel_id = a.id
            WHERE i.id = '".$id."';

        ";

        // Query Abfrage
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();

    }

    // Neu erstellen
    public function newIdentPos($data) {

        $req = new Request($data);

        // Vertrage ID
        $req->data['vertrags_id'] = $data['id'];

        // Wenn Artikel_ID ein array ist
        if(is_array($data['ident_id'])) {

            // Schleif durch alle Artikel
            foreach($data['ident_id'] as $key => $value) {
                $req->data['ident_id'] = $value;

                $process = [
                    ['t', 'vertrags_id'],
                    ['t', 'ident_id']
                ];

                // Würde jeden Artike einen Eintrag erstellen
                $req->insert($this->table, $process);

            //    echo "<pre>";
            //    print_r($req->result);
            //    echo "</pre>";
            //    die();

                // Wenn es Erfolgreich war 
                if($req->success) {

                    // Get Zaehler Bei Ident Id
                    $resultZaehler = $this->getZaehlerByIdent($req->data['ident_id']);

                    $req2 = new Request();

                    // Schleife hier nochmal durch und fügt direkt die Zähler hinzu
                    foreach($resultZaehler['data'] as $key2 => $value2) {

                        $req2->data['positionen_id'] = $req->result;
                        $req2->data['zaehler_id'] = $value2['zaehler_id'];

                        $process2 = [
                            ['t', 'positionen_id'],
                            ['t', 'zaehler_id']
                        ]; 

                        $req2->insert('vertraege_positionen_zaehler', $process2);

                    }

                }
        
            }

        }

        return $req->answer();
    }

    public function edit($id, $data) {

        $req = new Request($data);

        $getVertrag = $this->get($id);

        $process = [
            ['t', 'beschreibung'],
            ['n', 'pauschale']
        ];

        $req->update($this->table, $process, 'WHERE `id` = '. $id .'');

        // Wenn es Erfolgreich war 
        if($req->success) {

            $req2 = new Request();

            $req2->data['positionen_id'] = $req->data['positionenID'];

            // Schleife geht durch die Zähler durch und fügt die zu PositionenZähler
            foreach($req->data as $key => $value) {

                // Wenn die Erste Stelle Zaehler ist
                if(explode ("-", $key)[0] == 'zaehler') {
                    $req2->data['zaehler_id'] = explode ("-", $key)[1]; 

                    $req2->data['pauschale'] = ( explode("-", $value)[0] != '') ? explode ("-", $value)[0] : false;

                    $process2 = [
                        ['t', 'positionen_id'],
                        ['t', 'zaehler_id'],
                        ['t', 'pauschale']
                    ];

                    // Wenn für die Zaehler noch keine Position angelegt wurde dann Neu -- Insert
                    $resultZaehler = $this->getPosByZaehler($req->data['positionenID'], explode ("-", $key)[1]);

                    // Wenn Es erfoglreich war und es keine Daten gibt
                    if($resultZaehler['success']) {

                        // Wenn es noch keine Eintrag gibt -- Insert
                        if(count($resultZaehler['data']) <= 0) {
                            $req2->insert('vertraege_positionen_zaehler', $process2);
                        }

                        // wenn es schon einen Eintrag gibt -- Update
                        else {
                            $req2->update('vertraege_positionen_zaehler', $process2, 'WHERE `zaehler_id` = '. explode ("-", $key)[1] .' AND `positionen_id` = '.$req->data['positionenID'].' ');
                        }
                        
                        $req3 = new Request();

                        $req3->data['gesamtpauschale_preis'] = false;

                        $process3 = [
                            ['t',  'gesamtpauschale_preis']
                        ];

                        $req3->update('vertraege', $process3, 'WHERE `id` = '. $getVertrag['data']['vertrags_id'] . '');

                    }
                  

                }
            }

        }

        return $req->answer();

    }

    public function delete($id) {

        // Request
        $req = new Request();

        // Mehrere Löschen
        $req->deleteMultiple($this->table, $id);

        // Wenn Löschen Erfolgreich war dann auch die Zaehler Löschen
        if($req->success) {

            $req2 = new Request();

            // SChleife geht alle IDs durch und löscht die Zaehler dazu
            foreach($id as $key => $value) {

                $query = "
                    DELETE 
                    FROM vertraege_positionen_zaehler 
                    WHERE positionen_id = '".$value."';
                ";

            }
           
            $req2->deleteQuery($query);

        }

        // Rückgabe
        return $req->answer();
    }
}
?>