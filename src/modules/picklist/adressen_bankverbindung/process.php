<?php include('./../../../01_init.php');



// Get Variable übergeben
$dt = new Dt($_GET , "adressen_bankverbindung");

// Add Filter
$dt->fixedFilter = "`adressen_bankverbindung`.`adressen_id` = '".$_GET['additional']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();


?>