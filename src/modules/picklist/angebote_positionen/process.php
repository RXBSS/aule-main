<?php include('./../../../01_init.php');



// Eigene Klasse erstellen
class DtAngebotePos extends Dt {

    
    public function editCustomColumnAfter($row, $key, $value, $default) {

        if($key == 'reihenfolge') {

            $infos = [];

            if(strlen($row['_langtext']) > 0) {
                $infos[] = "Es gibt einen Langtext";
            }

            if(strlen($row['_notiz']) > 0) {
                $infos[] = "Es gibt eine interne Notiz";
            }

            // TODO: Beim Hover kann hier noch angegeben werden, was es für Infos gibt

            $default = (count($infos) > 0) ? "<div class='d-flex justify-content-between'><div>".$default."</div><div><i class='fa-solid fa-info-circle text-info'></i></div>" : $default;
        }

        if($key == 'vk') {
            if($row['_ek'] == 0 || $row['_vk'] == 0) {
                $default = "<i class='fa-solid fa-exclamation-triangle text-warning'></i> ".$default;
            }
        }

        if($key == 'rabatt_kombi') {
            $formatter = new Formatter();
            $default = $formatter->betrag(floatval($row['_rabatt_wert']))." (".$formatter->autoFloat(floatval($row['_rabatt_prozent']),0)." %)";
        }

        return $default;
    }

    
}


// Get Variable übergeben
$dt = new DtAngebotePos($_GET , "angebote_positionen");

// Festen Filter
$dt->fixedFilter = "`angebote_positionen_v`.`angebot_id` = '".$_GET['additional']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>