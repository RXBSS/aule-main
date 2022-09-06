<?php include('./../../../01_init.php');

class DtAkquiseAktion extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {

        if($key == 'vorname') {
            $default = $row['_vorname'].' '.$row['_nachname'];

        }
        
        return $default;
    }

}

// Get Variable übergeben
$dt = new DtAkquiseAktion($_GET , "akquise_aktionen");




// Verarbeiten
$dt->process();

// Output
$dt->output();

?>