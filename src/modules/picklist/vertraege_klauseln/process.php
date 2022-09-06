<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraegeKlauseln extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn Vertragsart status_id
        if($key == 'status_id') {
            
            // Wenn der Status 1 also Entwurf ist
            // if($default == '1') {
            //     $default = "<i class='fas fa-edit'> </i> Entwurf";
            // } 

            // // Wenn der Status 2 also Aktiv ist
            // else if($default == '2') {

            //     $default = "<i class='fas fa-circle text-success'></i> Aktiv" ;
                
            // }

            // else if($default == '3') {

            //     $default = "<i class='fas fa-circle text-danger'></i> Alte Version" ;
                
            // }
        }

        // Wenn der zeige auf Version steht
        else if($key == 'version') {
            $default = $default.". Version";
        }

        // Wenn der Zeiger auf Text ist
        else if($key == 'text') {
            $default = strip_tags($default);
        }

        return $default;
    }
}


// Get Variable übergeben
$dt = new DtVertraegeKlauseln($_GET , "vertraege_klauseln");


if(isset($_GET['additional']) && $_GET['additional'] == 'only_aktiv') {
    $dt->fixedFilter = "`vertraege_klauseln`.`status_id` = 2 AND `vertraege_klauseln`.`geloescht` = 0";

} else {
    $dt->fixedFilter = "`vertraege_klauseln`.`geloescht` = 0";

}

// $dt->fixedFilter = "`vertraege_klauseln`.`geloescht` = 0";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>