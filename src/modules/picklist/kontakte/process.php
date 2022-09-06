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
$dt = new DtKontakte($_GET , "kontakte");

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
// die();

// Add Filter
if(isset($_GET['additional'])) {

    if(isset($_GET['additional']) && $_GET['additional'][1] == 'akquise') {
        $dt->fixedFilter = "`kontakte`.`akquise_id` = '".$_GET['additional'][0]."'";


    } else if (isset($_GET['additional']) && $_GET['additional'][1] == 'adressen'){
        $dt->fixedFilter = "`adressen_kontakte`.`adressen_id` = '".$_GET['additional'][0]."'";


    } 
} else {
    // echo "TEST";
}

// Verarbeiten
$dt->process();


// Output
$dt->output();

?>