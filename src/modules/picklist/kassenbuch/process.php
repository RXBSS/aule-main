<?php include('./../../../01_init.php');


// Get Variable übergeben
$dt = new Dt($_GET , "kassenbuch");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>