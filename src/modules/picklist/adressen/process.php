<?php include('./../../../01_init.php');


// Get Variable übergeben
$dt = new Dt($_GET , "adressen");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>