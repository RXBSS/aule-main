<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class PicklistSoftwareVersions extends Picklist {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        if($key == 'art') {
            $default = trim($row['_art_icon']." ".$row['_art']);
        }
        
        if($key == 'versionsnummer' && ($row['_anmerkungen'] || $row['_sperre'])) {



            $default = trim((($row['_sperre']) ? "<i class=\"fa-solid fa-circle-minus text-danger\"></i> " : "").(($row['_anmerkungen']) ? "<i class=\"fa-solid fa-circle-info text-info\"></i> " : "").$row['_versionsnummer']);
        }


        return $default;
    }
}

// Get Variable übergeben
$dt = new PicklistSoftwareVersions($_GET , "software-versionen");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>