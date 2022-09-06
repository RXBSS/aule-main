<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("aktiv", 1);
$q->createComplete("mitarbeiter", ["vorname", "nachname"], "id");

?>