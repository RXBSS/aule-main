<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("ist_lieferant", 1);
$q->createComplete("adressen", ["lieferant_bezeichnung"], "id");




?>