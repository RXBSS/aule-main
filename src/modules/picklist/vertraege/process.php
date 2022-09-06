<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraege extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {


        if ($key == 'status_name') {
            $default = $row['_status_icon'] . " " . $default;
        } 

        if($key == 'version') {
            if($default == null) {
                $default = "<i>Keine Version</i>";
            }
        }

        // Wenn der zeige auf Laufzeit steht
        if($key == 'laufzeit') {

            // Wenn der Default Null ist dann ist der Vertag unbefristet
            $default = ( ($default != null) ? $default." Monate" : "<b> Unbefristet </b>");

        }

        return $default;
    }
}


// Get Variable übergeben
$dt = new DtVertraege($_GET , "vertraege");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>