<?php include('./../../../01_init.php');

class DtNotification extends Dt {

    public function editCustomColumn($row, $key, $value, $default){
        
        if($key == 'vorname') {
            
            // Vorname und Nachname zusammen Schreiben
            $default = $row['_vorname'].' '.$row['_nachname'];
        } else if($key == 'zeitstempel_gelesen') {
            
            // Wenn es keine Zeitstempel Gibt
            if($default == NULL) {
                $default =  "<i class='fa-solid fa-eye'></i><strong> Nicht gelesen </strong>";
            } else {
                $date = new DateTime($default);
                $default = '<strong>'.$date->format('d.m.Y').'</strong>'.' um '. '<strong>' .$date->format('H:m'). ' </strong> ' .' Uhr';
            }
        } else if($key == 'data') {
            $default = "Zu gehörige ID: ". "<strong>" .$default."</strong>";
        } 

        return $default;
    }

}

// Get Variable übergeben
$dt = new DtNotification($_GET , "notification");

// Man sollte nur seinen eigenen Notifications Sehen
if(isset($_GET['additional'])) {

  
    // Entweder die Notification Gehört mir ODER Ich habe Sie abonniert dann sehe ich dich restlichen Einträge zu dieser ID auch
    $dt->fixedFilter = "`notification`.`user_id` != '".$_GET['additional']."' AND `notification`.`mitarbeiter_abo` = '".$_GET['additional']."'";

}

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>