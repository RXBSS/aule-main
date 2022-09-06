<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraegeVorlagen extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn der Zeiger auf Version steht
        if($key == 'version') {

            $default = $default.". Version";

        }

        // Wenn Status ID -- Gibt nur 2 Statuse
        // else if($key == 'status_id') {

        //     // Entwurf
        //     if($default == '1') {
        //         $default = "<i class='fas fa-edit'></i> Entwurf";
            
        //     // AKtiv
        //     } else if ($default == '2') {
        //         $default = "<i class='fas fa-circle text-success'></i> Aktiv";
        //     }

        //     // Alte Version
        //     else if ($default == '3') {
        //         $default = "<i class='fas fa-circle text-danger'></i> Alte Version";
        //     }

        // }

        return $default;
    }
}


// Get Variable übergeben
$dt = new DtVertraegeVorlagen($_GET , "vertraege_vorlagen");

// if(isset($_GET['additional'])) {

    // $dt->fixedFilter = "`vertraege_vorlagen`.`vertraegeart_id` = '".$_GET['additional'][0]."' AND `vertraege_vorlagen`.`geloescht` = 0";

// }

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>