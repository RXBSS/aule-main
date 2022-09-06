<?php

use Mpdf\Tag\P;

/**
 * Angebote API 
 */
class AngebotePositionen extends Positionen {

    // Hier alles was nicht über die Klasse "Positionen" gemacht wird


    public function edit($posId, $data) {

        // Daten
        $req = new Request($data);

        // Rabatt zurücksetzen
        if(!$req->data['rabatt_aktiv']['checked']) {
            $req->data['rabatt_wert'] = 0;
        }

        // Verarbeitungsarray
        $process = [
            ['n', 'menge'],
            ['n', 'ek'],
            ['n', 'vk'],
            ['n', 'steuer'],
            ['n', 'rabatt_wert'],
            ['t', 'langtext'],
            ['t', 'notiz']
        ];
        
        // Ergebnis
        $req->update($this->table, $process, "WHERE `id` = '" . $posId . "'");
        
        // Antwort schreiben
        return $req->answer();
    }



}