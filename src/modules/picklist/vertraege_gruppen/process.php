<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
// class DtVertraegeKlauseln extends Dt {

//     // Die Spezialfunktion ├╝berschreiben
//     public function editCustomColumn($row, $key, $value, $default) {

//         return $default;
//     }
// }


// Get Variable ├╝bergeben
$dt = new Dt($_GET , "vertraege_gruppen");



// Verarbeiten
$dt->process();

// Output
$dt->output();

?>