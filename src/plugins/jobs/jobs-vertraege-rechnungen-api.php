<?php 


/**
 * 
 */
class JobVertraegeRechnungen extends Job {


    // Mache was
    public function do() {

        $abrechnungApi = new VertraegeAbrechnung();
        $rechnungen = new Rechnungen();

        // Holt Alle Fälligen Abrechnungen
        $resultAbrechnung = $abrechnungApi->getFaellig();

    //    echo "<pre>";
    //    print_r($resultAbrechnung);
    //    echo "</pre>";
    //    die();

        // Schleife geht Alle Fälligen durch
        if($resultAbrechnung['success'] && count($resultAbrechnung['data']) > 0 ){

            foreach($resultAbrechnung['data'] as $key => $value) {

                $req = new Request();

                // Wenn die Referenz ID noch nicht vorhanden ist dann kann eine neue Rechnung erstellt werden
                $req->checkDuplicateCombination('Rechnung Vorhanden', 'rechnungen', ['referenz_id' => $value['id'], 'herkunft' => 'vertrag']);

                // Wenn keine Fehler
                if (!$req->error) {

                    // Erzeugt eine Rechnung
                    $result = $rechnungen->create([
                        'adresse_id' => $value['adresse_id'],
                        'herkunft' => 'vertrag',
                        'referenz_id' => $value['id'],
                        'netto' => $value['kosten']
                    ]);

                    echo "<pre>";
                    print_r($result['log']);
                    echo "</pre>";

                } else {

                    echo "<pre>";
                    print_r("Es wurde keine Rechnung Erstellt. Rechnungen für > vertrag < mit > Ref.ID: ". $value['id'] ." < bereits vorhanden.");
                    echo "</pre>";
                }


                

            }

        }

    }   



}






?>