<?php 

$_system_id = 2;

include('includes/01_init_orthor.php');

class Aule extends App {
    
    // Überschreibe die init User Funktion
    function initUser() {
       
        // User Api wird nun aus einer anderen Tabelle bezogen
        $this->user = new User('mitarbeiter');
    }
}

// App Initalisieren
$app = new Aule();

// Temporär!!!!
if(!$app->user->isLoggedIn()) {
    $app->user->doLogin(11,  true);
}

?>