<?php include('./../../../01_init.php');


// Eigene Klasse erstellen
class DtBestellung extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        if ($key == 'status_name') {
            $default = $row['_status_icon'] . " " . $default;
        }

        return $default;
    }
}




// Get Variable übergeben
$dt = new DtBestellung($_GET, "bestellungen");

// Verarbeiten
$dt->process();

// Output
$dt->output();
