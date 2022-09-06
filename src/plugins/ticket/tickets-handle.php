<?php require_once("01_init.php");

// APIs
$ticket = new Ticket();


// Create Ticket
if($_POST['task'] == 'createTicket') {

    $request = new Request();

    $result = $ticket->create( $_POST['formData']);

    $request->adapt($result);
    $request->echoAnswer();

}

// Load Form Funktion
else if($_POST['task'] == 'loadForm') {

    $request = new Request();

    $result = $ticket->get( $_POST['data']);

    $result['data'] = $result['data'][0];

    // Ersteller Name Erstellt
    $result['data']['ersteller_name'] = $result['data']['erstellerVorname']." ".$result['data']['erstellerNachname'];

    // Ersteller Datum Erstellen
    $date = new DateTime($result['data']['erstellt']);
    $result['data']['erstellt'] = $date->format('d.m.Y H:i');


    $request->adapt($result);
    $request->echoAnswer();
}

// Ein neuer Kontakt wird zum Ticket hinzugefügt
else if($_POST['task'] == 'kontakteTicket') {

    $request = new Request();

    $result = $ticket->newKontakt( $_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();
}

// Lädt alle Personen/ Kontakte die zu dem Ticket gehören
else if($_POST['task'] == 'loadPersonen') {

    $request = new Request();

    $result = $ticket->getKontakt( $_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

}

// Lädt die Timeline und alle dazugehörigen Daten
else if ($_POST['task'] == 'loadTimeline') {

    $request = new Request();

    $result = $ticket->getTimeline( $_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

}

// eine neuer Timeline Eintrag wird erstellt
else if($_POST['task'] == 'submitTimeline') {

    $request = new Request();

    $result = $ticket->submitTimeline($_POST);

    $request->adapt($result);
    $request->echoAnswer();

}

// Hinzufügen von einem neuen Dokument zu einem Ticket
else if($_POST['task'] == 'submitTicketFile') {

   //

    // $request = new Request();

    // $result = $ticket->submitTicketFile($_POST);

    // $request->adapt($result);
    // $request->echoAnswer();

}













?>