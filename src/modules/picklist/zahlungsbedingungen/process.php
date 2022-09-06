<?php include('./../../../01_init.php');

class DtZahlungsbedingungen extends Dt {


    public function editCustomColumn($row, $key, $value, $default) {

        if($key == 'tage' || $key == 'skonto_tage') {
            $default = $default.' Tage';
        } else if($key =='skonto_prozent') {
            $default = $default.' %';
        }
        
        return $default;
    }

}

// Get Variable übergeben
$dt = new DtZahlungsbedingungen($_GET , "zahlungsbedingungen");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>