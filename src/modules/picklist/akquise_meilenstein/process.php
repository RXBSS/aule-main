<?php include('./../../../01_init.php');

class DtAkquise extends Dt {
    
    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn es die Aktion ID ist
        if($key == 'aktion_id') {

            // Wenn der Default nicht Null ist
            if($default) {

                $default = "Gehört zur Aktion";
            }

            // Wenn der Default Null ist
            else {

                $default = "Gehört <strong>nicht</strong> zur Aktion. (Standard Meilenstein)";

            

                // Reihenfolge nicht Änderbar weil es nicht zur Aktion gehört
                $row['_reihenfolge'] = "<strong>Nicht Änderbar - Keine Aktion</strong>";
                
            }
        }
         
        //    die();
        // 
        // if ($key == 'standard_meilensteine') {

        //     // Wenn die Aktion auch Standard Meilensteine Erlaubt hat
        //     if($default == '1') {


                

        //         $filterNullMeilensteine = "`akquise_meilenstein`.`aktion_id` IS NULL or";
        //     }  else {

        //         echo "<pre>";
        //         print_r("IS NICHt NULL");
        //         echo "</pre>";
        //         die();
        //     }

        // }

        return $default;

    }
}

// Get Variable übergeben
$dt = new DtAkquise($_GET , "akquise_meilenstein");

// Nur die Anzeigen die zu der Aktion passen
if(isset($_GET['additional'])) {

    $standardMeilensteine = "";

    // Wenn die Aktion auch Standard Meilenstein erlaubt
    if($_GET['additional']['setMeilenStein'] == '1') {
        $standardMeilensteine = "or `akquise_meilenstein`.`aktion_id` IS NULL";
    }

    $dt->fixedFilter = " `akquise_meilenstein`.`aktion_id` = '".$_GET['additional']['aktion_id']."' $standardMeilensteine";
}



// Verarbeiten
$dt->process();

// Output
$dt->output();

?>