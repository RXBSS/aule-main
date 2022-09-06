<?php include('./../../../01_init.php');


// Get Variable übergeben
$dt = new Dt($_GET , "wareneingaenge_positionen");

// Fixed Filter
$dt->fixedFilter = "`wareneingaenge_positionen`.`bestellung_id` = '".$_GET['additional']['auftrag']."'";

// Wenn 
if($_GET['additional']['artikel'] != 'false') {
    $dt->fixedFilter .= " AND `wareneingaenge_positionen`.`artikel_id` IN ('".implode("','",$_GET['additional']['artikel'])."')";
}

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>