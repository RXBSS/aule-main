<?php require_once("01_init.php");

// Request
$_req = new Request($_POST);

// API Verbindung herstellen
$_api = new Angebote();

// Details Handler einfügen
include('details-handle.php');

// Positionen Handler einfügen
include('positionen-handle.php');

// Dokument erstellen
if($_POST['task'] == 'create') {

    $result = $_api->create($_SESSION['user']['id']);
    $_req->echoAnswer($result);   

// Entwurf validieren
} else if($_POST['task'] == 'entwurfValidieren') {

    $result = $_api->entwurfValidieren($_POST['data']);
    $_req->echoAnswer($result);   

// Dokument erstellen
} else if($_POST['task'] == 'documentErstellen') {
   
    $result = $_api->createDocument($_POST['data']);   
    $_req->echoAnswer($result);   

//     
} else if($_POST['task'] == 'angebot-erstellen') {

    $result = $_api->entwurfWirdAngebot($_POST['additional']['id']);   
    $_req->echoAnswer();   
}













?>