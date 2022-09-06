<?php require_once("01_init.php");

// Request
$req = new Request($_POST);


// Hinzufügen
if($req->task == 'positionen-add') {
    $req->success = true;
    $req->echoAnswer();

// Löschen
} else if($req->task == 'positionen-delete') {
    $req->success = true;
    $req->echoAnswer();

// Verschieben
} else if($req->task == 'positionen-shift') {
    $req->success = true;
    $req->echoAnswer();

// Verschieben
} else if($req->task == 'positionen-summe') {

    $req->success = true;

    // Rückgabe
    $req->result = [
        'netto' => 100,
        'mwst' => [
            ['satz' => 19, 'betrag' => 23.2],
            ['satz' => 7, 'betrag' => 9.23]
        ],
        'brutto' => 119
    ];



    $req->echoAnswer();
}









?>