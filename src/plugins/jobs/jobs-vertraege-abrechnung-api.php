<?php


/**
 * Dieser Job prüft die Abrechnung und erstellt ggf. neue Abrechnungen
 * 
 */
class JobVertraegeAbrechnungen extends Job {

    public function set() {
        $this->table = "vertraege_abrechnung";
        $this->jobName = "abrechnung";
    }

    // Mache was
    public function do() {

        // $date = new DateTime("2027-08-01");
        $req = new Request();

        // LogArray
        $arrayLog = [];

        // Current Date
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('Y-m-d H:i:s');

        $abrechnungApi = new VertraegeAbrechnung();

        // Holt Alle Abrechnugn die noch nicht abgerechnet wurde
        $result = $abrechnungApi->getAll();

        // Öffnet eine Neue Datei
        // $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/abrechnung_job_" . str_replace(['-', ':', " "], ['_', '_', "_"], $currentDate) . ".txt", "w+");

        if ($result['success'] && isset($result['data']) && count($result['data']) > 0) {

            // Schreibt in die Datei rein
            // fwrite($file, date("d.m.Y H:i:s") . " - Daten Abfrage erfolgreich.");
            $arrayLog[] = [
                'timestamp' => date('Y-m-d H:i:s'),
                'text' => "Verträgeabrechnung Job wird gestartet."
            ];

            // Schleife geht die Einträge Durch
            foreach ($result['data'] as $key => $value) {

                // "\n".fwrite($file, date("d.m.Y H:i:s") . " - Abrechnung ID: " . $value['id'] .  " wurde aktualisiert. ");
                $arrayLog[] = [
                    'abrechnungs_id' => $value['id'],
                    'timestamp' => date('Y-m-d H:i:s'),
                    'text' => "Abrechnung ID: " . $value['id'] .  " wurde aktualisiert. "
                ];

                $req->data['status_id'] = 1;

                // Process Array
                $process = [
                    ['t', 'status_id']
                ];


                // INsert Query
                $req->update('vertraege_abrechnung', $process, 'WHERE `id` = ' . $value['id'] . '');

            }

            // Wenn Req Erfolgrecih war
            if($req->success) {
                // fwrite($file, "\n".date("d.m.Y H:i:s") . " - Job Erfolgreich abgeschlossen");
               
                $arrayLog[] =  [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'text' => "Job Erfolgreich abgeschlossen."
                ];

            } else {
                // fwrite($file, "\n".date("d.m.Y H:i:s") . " - Job ist Fehlgeschlagen");
            
                $arrayLog[] = [
                    'timestamp' => date('Y-m-d H:i:s'),
                    'text' => "Job ist Fehlgeschlagen."
                ];
            
            }

        } else {

            $arrayLog[] = [
                'timestamp' => date('Y-m-d H:i:s'),
                'text' => "Keine Daten zum Aktualisieren vorhanden."
            ];

        }

       echo "<pre>";
       print_r($arrayLog);
       echo "</pre>";
       die();

        

        return $req->answer();

    }

    // Sortiert die Abrechnugnen
    public function sort($result) {

        // Daten
        $data = [];

        // Sortieren nach VertragsID
        // Schliefe durch alle Klauseln
        foreach ($result['data'] as $key => $value) {


            // Prüfen ob es diesen Vertrag Noch nicht Gab -- dann neu Setzen
            if (!isset($data[$value['vertrags_id']])) {

                // Paragraph initalisieren
                $data[$value['vertrags_id']] = [];
            }

            // Ansonsnten Value direkt zu der Vorhandenen Vertrags Id hinzufügen
            $data[$value['vertrags_id']][] = $value;
        }

        return $data;
    }
}
