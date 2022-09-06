<?php include("01_init.php");

$artikel = new Artikel();
$request = new Request();
$post = $request->sanitize($_POST);

// Neuere Versoin
$req = new Request($_POST);


if ($_POST['task'] == 'new') {


    // Attribute
    $attribute = $artikel->getAttributesFromForm($post['formData']);

    // Eintragung
    $result = $artikel->new($post['formData'], $attribute);

    echo json_encode($result);

} else if ($_POST['task'] == 'load') {

    $data = $artikel->get($post['data']);

    // Mergen für Liste
    $data['data']['hersteller'] = $request->mergeForList($data['data']['hersteller_id'], $data['data']['hersteller']);
    $data['data']['zuordnung'] = $request->mergeForList($data['data']['zuordnung_id'], $data['data']['zuordnung']);
    $data['data']['artikelgruppe'] = $request->mergeForList($data['data']['artikel_gruppe_id'], $data['data']['artikel_gruppe']);
   
    echo json_encode($data);


} else if ($_POST['task'] == 'get-by-hersteller') {

    // 
    $data = $artikel->get($req->data['data'], true);

    echo json_encode($data);


} else if ($_POST['task'] == 'edit') {

    // Attribute
    $attribute = $artikel->getAttributesFromForm($post['formData']);

    // Artikel bearbeiten
    $data = $artikel->edit($post['formData']['id'], $post['formData'], $attribute);

    echo json_encode($data);


// Dubletten-Prüfung
} else if ($_POST['task'] == 'pre-duplicate-check') {

    // Request
    $req->checkDuplicate("Herstellernummer", "artikel", "herstellernummer", $req->data['data']);
    $req->echoAnswer();

} else if ($_POST['task'] == 'lager-set') {

    // Artikel bearbeiten
    $data = $artikel->setLager($post['formData']['id'], $post['formData']);

    echo json_encode($data);


} else if ($_POST['task'] == 'lager-chart') {


    // Artikel und Bestanddaten aus der Datenbank auslesen
    $bestaende = $artikel->getBestand($post['data']['id']);

    // Artikel
    $artikel = $artikel->get($post['data']['id']);


    // Return Data 
    $data = [
        'hauptlager' => 0,
        'nebenlager' => 0,
        'personen' => 0,
        'auftraege' => 0,
        'kommission' => 0,
        'bestellt' => 0
    ];


    // 
    foreach ($bestaende as $bestand) {

        // Hauptlager Bestand
        if ($bestand['hauptlager']) {
            $data['hauptlager'] = $data['hauptlager'] + $bestand['bestand'];
            $data['kommission'] = $data['kommission'] + $bestand['kommission'];
            $data['bestellt'] = $data['bestellt'] + $bestand['bestellt'];

            // TODO: Muss noch gemacht werden!
        } else {
        }
    }


    echo json_encode([
        'success' => true,
        'data' => $data
    ]);


    // Preise Laden 
} else if ($_POST['task'] == 'preise-load') {


    // Artikel bearbeiten
    $data = $artikel->getPreise($post['formData']['id']);

    echo json_encode($data);

    // Preise speichern
} else if ($_POST['task'] == 'preise-set') {

    // Artikel bearbeiten
    $data = $artikel->setPreise($post['formData']['id'], $post['formData']);

    echo json_encode($data);

    // Get Attributes
} else if ($_POST['task'] == 'get-attributes') {

    $success = true;
    $error = false;
    $log = $post;

    if (isset($post['data'])) {
        $data = $artikel->getAttributes($post['data']);
    } else {
        $data = [];
    }

    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $data,
        'log' => $log
    ]);

    // #########################
    // Ident
    // 


    // Zähler hinzufügen
} else if ($_POST['task'] == 'add-zaehler') {

    // Hinzufügen
    $result = $artikel->addZaehler($req->data['data']['id'], $req->data['data']['zaehler']);

    $req->echoAnswer($result);

    // Zähler hinzufügen
} else if ($_POST['task'] == 'remove-zaehler') {

    // Hinzufügen
    $result = $artikel->removeZaehler($req->data['data']['zaehler']);


    $req->echoAnswer($result);

    // Zähler hinzufügen
} else if ($_POST['task'] == 'get-verknuepfung') {

    // Hinzufügen
    $result = $artikel->getLinks($req->data['data'], false);

    $req->echoAnswer($result);

} else if ($_POST['task'] == 'add-verknuepfung') {

    // Hinzufügen
    $result = $artikel->createLinks($req->data['data']['artikelId'],$req->data['data']['linkTo'], $req->data['data']['art']);

    $req->echoAnswer($result);

} else if ($_POST['task'] == 'delete-verknuepfung') {

    // Hinzufügen
    $result = $artikel->removeLink($req->data['data']);

    $req->echoAnswer($result);

} else if ($_POST['task'] == 'ident-load') {




    $result = $artikel->get($post['data']);

    $req->echoAnswer($result);

} else if ($_POST['task'] == 'ident-save') {

    // Hinzufügen    
    $result = $artikel->identEdit($req->data['additional']['id'], $req->data['formData']);

    $req->echoAnswer($result);


} else if ($_POST['task'] == 'load-historie') {

    // TODO: Hier muss noch die Artikel-Historie generiert werden

    // Übernehmen
    // $result = $artikel->history->getByReference($req->data['data']);

    $req = new Request();

    $req->success = true;

    $req->result = [
        [
            'data' => 'test'
        ],
        [
            'data' => 'test2'
        ]
    ];

    $req->echoAnswer();
 
 
}