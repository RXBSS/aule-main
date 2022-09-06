<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("bereich", "zaehlerstaende_anleitungen");
$q->createComplete("status", ["bezeichnung"], "status_id");

?>