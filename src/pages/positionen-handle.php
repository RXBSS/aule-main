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



// Summe errechnen
if ($_POST['task'] == 'positionen-summe') {
    $result = $_api->pos->getSum($_POST['data']); 
    $_req->echoAnswer($result);

// Position/en hinzufügen
} else if ($_POST['task'] == 'positionen-add') {
    $result = $_api->pos->add($_POST['data']['id'], $_POST['data']['artikel']); 
    $_req->echoAnswer($result);

// Position/en löschen
} else if ($_POST['task'] == 'positionen-delete') {
    $result = $_api->pos->delete($_POST['data']); 
    $_req->echoAnswer($result);

// Position/en verschieben
} else if ($_POST['task'] == 'positionen-shift') {
    $_api->pos->shiftById($_POST['data']['id'], $_POST['data']['direction'], $_POST['data']['colId']);
    $_req->success = true;
    $_req->echoAnswer();

// Position/en laden
} else if ($_POST['task'] == 'positionen-load') {
    $result = $_api->pos->getByPosId($_POST['data']);
    $_req->echoAnswer($result);

// Position/en speichern
} else if ($_POST['task'] == 'positionen-save') {
    $result = $_api->pos->edit($_POST['formData']['id'], $_POST['formData']);
    $_req->echoAnswer($result);
}










?>