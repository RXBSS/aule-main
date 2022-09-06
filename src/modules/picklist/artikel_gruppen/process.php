<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 


// Get Variable übergeben
$dt = new Dt($_GET , "artikel_gruppen");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>