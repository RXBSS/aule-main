<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraegeKlauselnVertraege extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn der Zeige auf Text steht
        if($key == 'text') {
            $default = strip_tags($default);
        }

        return $default;
    }
}


// Get Variable übergeben
$dt = new DtVertraegeKlauselnVertraege($_GET , "vertraege_klauseln_vertraege");

if(isset($_GET['additional'])) {

    $dt->fixedFilter = " (`vertraege_klauseln_vertraege`.`vertraege_id` = '".$_GET['additional'][0]."' AND `vertraege_klauseln_vertraege`.`geloescht` = 0)";

}

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>