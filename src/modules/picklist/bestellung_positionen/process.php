<?php include('./../../../01_init.php');

// Get Variable übergeben
$dt = new Dt($_GET , "bestellung_positionen");

$dt->fixedFilter = "`bestellungen_positionen`.`bestellung_id` = '".$_GET['additional']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>