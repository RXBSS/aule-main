<?php include('./../../../01_init.php');

class IdentPicklist extends Picklist {

    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn es eine Haupt Id ist
        if($key == 'haupt_id') {    
            $default = ($row['_haupt_id']) ? "<i class=\"fa-solid fa-turn-up fa-rotate-90\"></i> ".$row['_haupt_id'] : "<i class=\"fa-solid fa-circle\"></i> ".$row['_id'] ;
        }

        return $default;
    }

}


// Get Variable übergeben
$dt = new IdentPicklist($_GET , "ident");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>