<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("bereich", "bestellungen");
$q->createComplete("status", ["bezeichnung"], "id");


?>