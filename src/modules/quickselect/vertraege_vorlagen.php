<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("status_id", 2);
$q->createComplete("vertraege_vorlagen", ["bezeichnung"], "id");

?>