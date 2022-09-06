<?php require_once("01_init.php");


// Reuqe
$req = new Request($_POST);

$bes = new Bestellung();

// 
if($_POST['task'] == 'create') {

    // Bestellungen aufgeben
    $req->data['formData']['ersteller_id'] = $_SESSION['user']['id'];


    $result = $bes->create($req->data['formData']);

    $req->echoAnswer($result);

// 
} else if($_POST['task'] == 'load') {

    $req->success = true;

    $result = $bes->get($req->data['data']);

    $result['data']['lieferant'] = $req->mergeForList($result['data']['lieferant_id'], $result['data']['lieferant_bezeichnung']);

    $req->echoAnswer($result);

// Entwurf speichern
} else if($_POST['task'] == 'entwurf-speichern') {

    $req->success = true;

    $result = $bes->edit($req->data['additional']['id'], $req->data['formData']);

    $req->echoAnswer($result);

// Entwurf löschen
} else if($_POST['task'] == 'entwurf-loeschen') {

    $result = $bes->delete($req->data['data']);
    $req->echoAnswer($result);

// Verarbeiten
} else if($_POST['task'] == 'prepare') {

    $result = $bes->prepare($req->data['data']);
    $req->echoAnswer($result);

// Verarbeiten
} else if($_POST['task'] == 'abschicken') {

    // User Id hinzufügen
    $req->data['formData']['besteller_id'] = $_SESSION['user']['id'];
    $result = $bes->process($req->data['additional']['id'], $req->data['formData']);
    $req->echoAnswer($result);

// Bestellposition hinzufügen
} else if($_POST['task'] == 'bestellposition-hinzufuegen') {

    // Positionen hinzufügen
    $result = $bes->simpleAddPositions($req->data['data']['bestellung'],$req->data['data']['artikel']);

    $req->echoAnswer($result);

// Bestellposition hinzufügen
} else if($_POST['task'] == 'bestellposition-loeschen') {
    
    // Positionen hinzufügen
    $result = $bes->deletePositions($req->data['data']);

    $req->echoAnswer($result);

// Bestellposition hinzufügen
} else if($_POST['task'] == 'bestellposition-menge') {
    
    // Positionen hinzufügen
    $result = $bes->changePositionAmount($req->data['data']['lineId'], $req->data['data']['to']);

    $req->echoAnswer($result);

}




