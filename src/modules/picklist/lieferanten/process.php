<?php include('./../../../01_init.php');

// Get Variable übergeben
$dt = new Dt($_GET , "lieferanten");

// Add Filter;
$dt->fixedFilter = "`adressen`.`ist_lieferant` = '1'";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>