<?php require_once("01_init.php");

// Neuer Request
$req = new Request($_POST);
$wareneingang = new Wareneingang();




// Bestellung importieren
if($_POST['task'] == 'neuer-wareneingang') {

    $res = $wareneingang->neu();
    $req->adapt($res);
    $req->echoAnswer();

// Wareneingang buchen
} else if($_POST['task'] == 'wareneingang-buchen') {


    $res = $wareneingang->buchen($req->data['data']);
    $req->adapt($res);
    $req->echoAnswer();


// Bestellung importieren
} else if($_POST['task'] == 'bestellung-importieren') {
    
    $lieferId = $req->data['data']['lieferungId'];
    $bestellId = $req->data['data']['bestellungId'];

    // Bestellungen Importieren
    $res = $wareneingang->importBestellung($lieferId, $bestellId);

    // Übernehmen
    $req->adapt($res);

    // 
    $req->echoAnswer();


// Position buchen
} else if($_POST['task'] == 'position-buchen') {

    // Input
    // Position ID
    // Menge

    
    $res = $wareneingang->positionBuchen($req->data['data']['id'], $req->data['data']);
    


    $req->success = true;
    $req->echoAnswer();






}









?>