<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraegeKlauselnVorlagen extends Dt {

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
$dt = new DtVertraegeKlauselnVorlagen($_GET , "vertraege_klauseln_vorlagen");

if(isset($_GET['additional'])) {

    $dt->fixedFilter = " (`vertraege_klauseln_vorlagen`.`vorlagen_id` = '".$_GET['additional'][0]."' AND `vertraege_klauseln_vorlagen`.`geloescht` = 0) OR (`vertraege_klauseln_vorlagen`.`vorlagen_id` IS NULL AND `vertraege_klauseln_vorlagen`.`geloescht` = 0 AND `vertraege_klauseln`.`status_id` = '2')";

}

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>