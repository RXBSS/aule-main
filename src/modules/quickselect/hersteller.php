<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("ist_hersteller", 1);
$q->createComplete("adressen", ["hersteller_bezeichnung"], "id");

?>