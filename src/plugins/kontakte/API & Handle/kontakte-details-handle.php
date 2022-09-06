<?php require_once("01_init.php");


$adressen_kontakte = new AdressenKontakte();

// Hinzufügen von neuen Kontakten --- EIGENSCHAFTEN
if($_POST['task'] == 'adressen-kontakt-submit') {

    $req = new Request(); 

    // Wenn NEW
    if($_POST['formData']['id'] > 0) {
        $result = $adressen_kontakte->edit( $_POST['formData']['id'], $_POST['formData'], $_POST['additional']['kontakte_id']);
    }

    // Wenn Edit
    else {
        $result = $adressen_kontakte->new($_POST['formData'], $_POST['additional']['kontakte_id']);
    }


    $req->adapt($result);
    $req->echoAnswer();

}

// Load And open Kontakte --- EIGENSCHAFTEN
else if($_POST['task'] == 'loadAndOpen') {

    $req = new Request();

    $result = $adressen_kontakte->get($_POST['data'][1]);

    // echo "<pre>";
    // print_r($result);
    // echo "</pre>";
    // die();

     //
    //  $result['data']['ersteller_id'] = $result['data']['ersteller_id'];
    //  $result['data']['ersteller_text'] = $dataMitarbeiter['vorname'].' '.$dataMitarbeiter['nachname'];
 

    // $result['data'][0]['adressen_id']['text'] = $result['data'][0]['name'];

    $result['data']['abteilung'] = $result['data'][0]['abteilung'];
    $result['data']['funktion'] = $result['data'][0]['funktion'];
    $result['data']['id'] = $result['data'][0]['id'];
    // $result['data']['adressen_text'] = $result['data'][0]['name'];
    // $result['data']['adressen_id'] = $result['data'][0]['adressen_id'];
  
    $result['data']['adressen_id'] = $req->mergeForList($result['data'][0]['adressen_id'], $result['data'][0]['name']);


    $req->adapt($result);
    $req->echoAnswer();
    
}

// Delete Task
else if($_POST['task'] == 'deleteKontakteAdresse') {


    $req = new Request(); 
    
    $result = $adressen_kontakte->delete($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();


}

// Kontakte Hinzufügen
else if($_POST['task'] == 'newKontakt') {

    $request = new Request();

    $result = $adressen_kontakte->newKontakt($_POST['data']); 

    $request->adapt($result);
    $request->echoAnswer();
}


// Nur Adresse hinzufügen ohne Details
else if($_POST['task'] == 'onlyAdresse') {


    $req = new Request();
    $result = $adressen_kontakte->onlyAdresse($_POST['data']); 

    $req->adapt($result);
    $req->echoAnswer();


}

?>