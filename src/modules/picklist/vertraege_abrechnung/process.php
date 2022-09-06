<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtVertraegeAbrechnung extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {

        if($key == 'abrechnungsart') {

            $default = ( ($default == "P") ? 'Pauschale' : "Zähler"); 

        }

        return $default;
    }


}


// Get Variable übergeben
$dt = new DtVertraegeAbrechnung($_GET , "vertraege_abrechnung");

if(isset($_GET['additional'])) {

    $dt->fixedFilter = " `vertraege_abrechnung`.`vertrags_id` = '".$_GET['additional'][0]."' ";

}

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>