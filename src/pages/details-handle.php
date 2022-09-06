<?php

/**
 * Diese Datei kann in die Handle von Detail-Seiten eingefügt werden
 * Darüber muss nur die Variable $_api und die $_req deklariert werden
 * 
 */

if(!$_api) {
    throw new Exception("Die Variable _api wurde nicht deklariert. Bitte prüfen und die Dokumentation lesen", 1);
}

if(!$_req) {
    throw new Exception("Die Variable _req wurde nicht deklariert. Bitte prüfen und die Dokumentation lesen", 1);
}


// Standard Get Funktion
if ($_POST['task'] == 'get') {
    $result = $_api->get($_POST['data']); 
    $_req->echoAnswer($result);

// Entwurf speichern
} else if ($_POST['task'] == 'entwurf-speichern') {
    
    $result = $_api->entwurfSpeichern($_POST['additional']['id'], $_POST['formData']); 
    $_req->echoAnswer($result);
}





?>