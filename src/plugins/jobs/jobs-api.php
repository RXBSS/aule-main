<?php 

/**
 * Die Klasse, die alle Jobs Extenden
 */
class Job {




    // TODO: Protkoll für jeden Lauf erstellen
    // TODO: Datenbank pflegen
    // TODO: Prüfen ob der Job schon/noch läuft
    // ...


    // Diese Funktion sollte überschrieben werden
    public function do() {
        echo "Nothing to do :)";
    }

    // Job zum Ausführen
    public function run() {

        // Datenbank eintrag schreiben

        // $this->set();

        $this->do();
    }


}










?>