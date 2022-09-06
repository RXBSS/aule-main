<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);
$q->addFilter("ist_kunde",  1);
$q->addFilter('kunde_gesperrt', 0);
$q->createComplete("adressen", ["name"], "id");

?>