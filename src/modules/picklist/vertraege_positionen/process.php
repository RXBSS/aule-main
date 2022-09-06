<?php include('./../../../01_init.php');

// Get Variable übergeben
$dt = new Dt($_GET , "vertraege_positionen");

// Add Filter
$dt->fixedFilter = "`vertraege_positionen`.`vertrags_id` = '".$_GET['additional']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>