<?php

include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtAuftraege extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {  
        
        if($key == 'status_name') {
            $default = $row['_status_icon']." ".$default;
        }

        return $default;

    }
}

// Get Variable übergeben
$dt = new DtAuftraege($_GET , "angebote");

// Verarbeiten
$dt->process();

// Output
$dt->output();





?>