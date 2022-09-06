<?php include('./../../../01_init.php');

// Get Variable übergeben
$dt = new Dt($_GET , "artikel_dokumente");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>