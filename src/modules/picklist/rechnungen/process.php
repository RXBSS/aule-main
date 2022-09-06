<?php include('./../../../01_init.php');

// Eigene Klasse erstellen
class DtRechnungen extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {  
        
        if($key == 'status_name') {
            $default = $row['_status_icon']." ".$default;


        // Übersetzen
        } else if($key == 'herkunft') {

            $default = ucfirst($default);

        } else if($key == 'ursprung_oeffnen') {

             // Auftrag
             $array = [
                'auftrag' => '<a target="_blank" style="padding-left: 10px;" href="auftrag-details?id='.$row['_referenz_id'].'"><i class="fa-solid fa-external-link-alt"></i> Auftrag öffnen</a>',
                'vertrag' => '<a target="_blank" style="padding-left: 10px;" href="vertraege-details?id='.$row['_referenz_id'].'"><i class="fa-solid fa-external-link-alt"></i> Öffnen</a>',
                'ticket' => '<a target="_blank" style="padding-left: 10px;" href="ticket-details?id='.$row['_referenz_id'].'"><i class="fa-solid fa-external-link-alt"></i> Öffnen</a>'
            ];
            
            $default = $array[$row['_herkunft']];            

       
        } else if($key == 'dokument_oeffnen') {
            $default = '<a href="javascript:void(0);"><i class="fa-solid fa-file-pdf"></i> Dokument öffnen</a>';
        }

        return $default;
    }
    public function editCustomColumnAfter($row, $key, $value, $default) {  
        
        if($key == 'gezahlt') { 

            $status = [
                1 => "<strong class='text-danger'>".$default."</strong>",
                2 => "<strong class='text-warning'>".$default."</strong>",
                3 => "<strong class='text-success'>".$default."</strong>",
                4 => "<strong class='text-info'>".$default."</strong>",
            ];  

            $default = $status[$row['_status_id']];

        }

        return $default;
    }


}

// Get Variable übergeben
$dt = new DtRechnungen($_GET , "rechnungen");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>