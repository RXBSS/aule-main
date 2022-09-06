<?php include('./../../../01_init.php');

class DtKontakte extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {

        if($value['field'] == 'geschlecht') {

            if($default == 'H') {
                $default = 'Herr';
            } else if($default == 'F') {
                $default = 'Frau';
            } else if($default == 'D') {
                $default = 'Divers';
            } else if($default == '') {
                $default= '';
            }
           
        }

        return $default;

    }

}

// Get Variable übergeben
$dt = new DtKontakte($_GET , "kontakte2");


// Verarbeiten
$dt->process();


// Output
$dt->output();

?>