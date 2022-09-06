<?php include('./../../../01_init.php');





class DtAkquise extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {


        return $default;

    }

}

// Get Variable übergeben
$dt = new DtAkquise($_GET , "adressen_kontakte");

if(isset($_GET['additional'])) {

    // Add Filter
    $dt->fixedFilter = "`adressen_kontakte`.`kontakte_id` = '".$_GET['additional'][1]."'";
}



// Verarbeiten
$dt->process();

// Output
$dt->output();


?>