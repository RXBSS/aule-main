<?php include('./../../../01_init.php');


// Eigene Klasse erstellen
class DtLieferung extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        if ($key == 'status') {

            $icon = $this->getRowStatus($row);

            // 0 = Offen bzw. 0
            // 1 = Teilweise
            // 2 = Vollständig 
            // 3 = Überlieferung
            $array = [
                '<i class="fa-solid fa-circle text-danger"></i>',
                '<i class="fa-solid fa-circle text-warning"></i>',
                '<i class="fa-solid fa-circle text-success"></i>',
                '<i class="fa-solid fa-exclamation-triangle text-warning"></i>',
            ];

            // Rückgabe
            $default = $array[$icon];
        } else if ($key == 'seriennummer') {

            if($row['_has_seriennummer'] == 0) {
                $default = "<em>keine</em>";
            }

            
        } else if ($key == 'status_nummer') {
            $default = $this->getRowStatus($row);
        }


        return $default;
    }

    function getRowStatus($row) {
        $b = floatVal($row['_bestellmenge']);
        $l = floatVal($row['_liefermenge']);

        // 
        return ($l == 0) ? 0 : (($b == $l) ? 2 : (($b > $l) ? 1 : 3));
    }


}



// Get Variable übergeben
$dt = new DtLieferung($_GET , "wareneingaenge_lieferungen2");

// Fixed Filter
$dt->fixedFilter = "`wareneingaenge_positionen`.`lieferung_id` = '".$_GET['additional']['auftrag']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>