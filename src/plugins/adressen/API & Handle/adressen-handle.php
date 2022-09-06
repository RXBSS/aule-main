<?php require_once("01_init.php");

// 
$adressen = new Adressen();
$kontakte = new Kontakte();

$req = new Request($_POST);

/**
 * ******************************************************************************************
 * 
 * ADRESSEN HANDLER
 * ******************************************************************************************
 * 
*/
if ($_POST['task'] == 'adr-submit') {


    $val = intval($_POST['additional']['id']);
    // $boolval = boolval($_POST['formData']['oeffnungszeiten-uebernehmen']['checked']);


    $oeffnungszeitenGoogle = new OeffnungszeitenGoogle();


    if ($val > 0) {
        $data = $adressen->edit($_POST['additional']['id'], $_POST['formData']);
    } else {
        $data = $adressen->new($_POST['formData']);

        if ($data['success'] && $_POST['formData']['oeffnungszeiten-uebernehmen']['checked'] === "true")  $data = $oeffnungszeitenGoogle->new($_POST['additional']['oeffnungszeiten'], $data['data']);
    }


    echo json_encode([
        'data' => $data,
        'success' => $data['success'],
        'error' => $data['error']
    ]);


/**
 * ******************************************************************************************
 * 
 * ADRESSEN DETAILS HANDLER
 * ******************************************************************************************
 * 
*/
} else if ($_POST['task'] == 'adr_d-submit') {

    $val;

    if (isset($_POST['formData']['id'])) {
        $val = intval($_POST['formData']['id']);
    } else {
        $val = intval($_POST['additional']['id']);
    }

    if ($val > 0) {

        $data = $adressen->edit($val, $_POST['formData']);

        if ($data['success'] && isset($_POST['formData']['oeffnungszeiten-uebernehmen']['checked']) && $_POST['formData']['oeffnungszeiten-uebernehmen']['checked'] === "true") {
            $req = new Request($_POST);

            if (isset($req->data['additional']['oeffnungszeiten'])) {
                $oeffnungszeitenGoogle = new OeffnungszeitenGoogle();

                $formData = $req->data['additional']['oeffnungszeiten'];
                $adressId = $req->data['additional']['id'];

                $dataOef = $oeffnungszeitenGoogle->new($formData, $adressId);
            }
        }
    } else {
        $data = $adressen->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
} else if ($_POST['task'] == 'getLand') {

    $request = new Request($_POST);
    
    // GEt Land
    $result = $adressen->getCode($_POST['data']);

    $request->adapt($result);  
    $request->echoAnswer();
} 

else if ($_POST['task'] == 'load') {

    $request = new Request($_POST);
    
    $result = $adressen->get($_POST['data']);

    
    // GEt Land
    $dataLaender = $adressen->getLaender($result['data']['land']);

    $result['data']['land_text'] = $dataLaender['de'];


    $request->adapt($result);  
    $request->echoAnswer();


    // $sampleData = [
    //     "auslieferungsart" => [
    //         "value" => $data['auslieferungsart']
    //     ],
    //     "id" => $data['id'],
    //     "place_id" => $data['place_id'],
    //     "name" => $data['name'],
    //     "namenszusatz" => $data['namenszusatz'],
    //     "laender" => [
    //         "value" => $data['land'],
    //         "text" => $dataLaender['de']
    //     ] ,
    //     "strasse" => $data['strasse'],
    //     "plz" => $data['plz'],
    //     "ort" => $data['ort'],
    //     "telefon" => $data['telefon'],
    //     "telefax" => $data['telefax'],
    //     "email" => $data['email'],
    //     "website" => $data['website'],
    //     "steuernummer" => $data['steuernummer'],
    //     "umsatzsetuer_id" => $data['umsatzsetuer_id']
    // ];

    // $success = true;

    // echo json_encode([
    //     'success' => $success,
    //     'data' => $sampleData,
    //     'restData' => $data
    // ]);
} else if ($_POST['task'] == 'getAdressen') {

    $data = $adressen->getAdressen($_POST['data']['strasse'], $_POST['data']['plz']);

    echo json_encode([
        'success' => true,
        'data' => $data
    ]);


/**
 * ******************************************************************************************
 * 
 * OEFFNUNGSZEITEN HANDLER
 * ******************************************************************************************
 * 
*/
} else if ($_POST['task'] == 'oeffnungszeiten-submit') {

    // 
    $req = new Request($_POST);

    $o = new Oeffnungszeiten();



    $formData = $req->data['formData'];
    $adressId = $req->data['additional']['id'];


    $res = $o->writeToDatabase($adressId, $formData);

    $req->adapt($res);
    $req->echoAnswer();
} else if ($_POST['task'] == 'oeffnungszeiten-delete') {


    $o = new Oeffnungszeiten();

    $success = true;
    $error = false;

    $o->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
} else if ($_POST['task'] == 'getGoogleData') {

    $success = $error = false;

    $req = new Request($_POST);

    $data = $req->proxy($_POST['data']);

    (($data) ? $success = true :  $error = true);

    echo json_encode([
        'data' => $data,
        'success' => $success,
        'error' => $error
    ]);
} else if ($_POST['task'] == 'oeffnungszeiten-google') {


    $success = $error = false;

    $oeffnungszeitenGoogle = new OeffnungszeitenGoogle();

    if ($_POST['formData']['oeffnungszeitenGoogle'] == 'set') {

        $data = $oeffnungszeitenGoogle->new($_POST['additional']['oeffnungszeiten'], $_POST['additional']['id']);

        (($data) ? $success = true :  $error = true);
    }

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
} else if ($_POST['task'] == 'oeffnungszeiten-vorhanden') {

    $success = $error = false;

    $oeffnungszeitenGoogle = new OeffnungszeitenGoogle();


    $data = $oeffnungszeitenGoogle->get($_POST['data']);

    (($data['data']) ? $success = true :  $error = true);

    echo json_encode([
        'data' => $data,
        'success' => $success,
        'error' => $error
    ]);


/**
 * 
 * ******************************************************************************************
 * KUNDE HANDLER
 * ******************************************************************************************
*/
} else if ($_POST['task'] == 'kunde-load') {


    // Ergebnis
    $result = $adressen->getData($req->data['data']);

    // Anpassungen der Daten
    $result['data']['kunde_email_rechnung_benutzerdefiniert'] = ($result['data']['kunde_email_rechnung_adresse']) ? 1 : 0;

    // Wenn es ein Betreiber ist
    if($result['data']['ist_betreiber']) {
        $result['data']['rechnungsempfaenger_id'] = $req->mergeForList($result['data']['rechnungsempfaenger_id'], $result['data']['rechnungsempfaenger_name']);
    } else {
        $result['data']['rechnungsempfaenger_id'] = false;
    }

    // Nur wenn eine Kundensperre existiert
    if($result['data']['kunde_gesperrt_mitarbeiter']) {
        // 
        $mitarbeiter = new Mitarbeiter();

        // GET Mitarbeiter Data
        $dataMitarbeiter = $mitarbeiter->get($result['data']['kunde_gesperrt_mitarbeiter']);

        // Fügt den Mitarbeiter zum Select
        $result['data']['kunde_gesperrt_mitarbeiter'] = $req->mergeForList($result['data']['kunde_gesperrt_mitarbeiter'], $dataMitarbeiter['vorname']." ".$dataMitarbeiter['nachname']);

    }


    // Wenn das Feld leer ist soll das Feld gefüllt werden mit EMail von Stammdaten
    if(!$result['data']['kunde_email_rechnung_adresse']) {
        $result['data']['kunde_email_rechnung_adresse'] = $result['data']['email'];
    }


    if($result['data']['branche']) {

        $dataBranche = $adressen->getBranche($result['data']['branche']);

        // Fügt den Mitarbeiter zum Select
        $result['data']['branche'] = $req->mergeForList($result['data']['branche'], $dataBranche['branche']);

    }

    $req->adapt($result);  
    $req->echoAnswer();


// Kunde Speichern
} else if ($_POST['task'] == 'kunde-save') {


    $result = $adressen->editKunde($req->data['additional']['id'], $req->data['formData'], $req->data['additional']['email']);    
    $req->adapt($result);
    $req->echoAnswer();

/**
 * ******************************************************************************************
 * LIEFERANTEN HANDLE 
 * ******************************************************************************************
 * 
*/
} else if ($_POST['task'] == 'load-lieferanten') {


    $result = $adressen->getData($req->data['data']);
    $req->echoAnswer($result);

/**
 * 
 * ******************************************************************************************
 * 
 * HERSTELLER HANDLE 
 * ******************************************************************************************
 * 
 */
} else if($_POST['task'] == 'lieferant-save') {

    $result = $adressen->editLieferant($req->data['additional']['id'], $req->data['formData']);
    $req->adapt($result);
    $req->echoAnswer();


} else if($_POST['task'] == 'hersteller-save') {


    $result = $adressen->editHersteller($req->data['additional']['id'], $req->data['formData']);
    $req->adapt($result);
    $req->echoAnswer();


} else if ($_POST['task'] == 'load-hersteller') {

    $success = $error = false;

    $sampleData = "";

    $data = $adressen->getData($req->data['data']);

    if($data['success'] == 1) {

        $sampleData = [
            "ist_hersteller" => $data['data']['ist_hersteller'],
            "hersteller_nummer" => $data['data']['hersteller_nummer'],
            "hersteller_bezeichnung" => $data['data']['hersteller_bezeichnung']
        ];

        $success = true;
    } else {
        $error = "Die Daten konnten nicht geladen werden";
    }


    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $sampleData
    ]);

} else if ($_POST['task'] == 'getCurrentTime') {

    $success = $error = false;

    $request = new Request();

    $adressen_oeffnungszeiten = new OeffnungszeitenGoogle();

    $result = $adressen_oeffnungszeiten->get($_POST['data']);
    
    // Success
    if($result['data']) {
        $success = true;

    // Keine Daten
    } else if (!$result['data'] && $result['result']->num_rows == '0') {
        $success = true;
    
    // Error
    } else {
        $error = true;
    }

    // Result
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $result['data']
    ]);

} 



// OpenDialog Akquise Callback
else if($_POST['task'] == 'neueAdresse') {

    $request = new Request();

    $result = $adressen->neueAdresse($_POST['formData']);
    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'get') {

    $request = new Request();

    $result = $adressen->get($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();
} 

// CardView ansicht in der Personen Tab auf der Adressen Details Seite
else if($_POST['task'] == 'cardView') {

    $request = new Request();

    $kontakte = new Kontakte();

    $result = $kontakte->getCardView($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();

}

// Visitenkarten Ansicht Kontakt löschen
else if($_POST['task'] == 'deleteVisitenkarte') {

    $request = new Request();

    $result = $adressen->deleteVisitenkarte($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();
}

// -----------------------------------------
// Neue Adressen Kontakt Hinzufügen für die N:N verbindung

else if($_POST['task'] == 'submitAdressenKontakt') {


    $request = new Request();

    $adressen_kontakte = new AdressenKontakte();

    $result = $adressen_kontakte->submitAdressenKontakt($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();

}

// Adressen über die Positionen API UPDATE
else if ($_POST['task'] == 'adrSubmit') {

    $request = new Request();

    $adressen = new Adressen();

    $result = $adressen->adressenPos($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();

}