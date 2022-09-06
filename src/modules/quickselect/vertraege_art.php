<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->createComplete("vertraege_art", ["bezeichnung"], "id");

?>