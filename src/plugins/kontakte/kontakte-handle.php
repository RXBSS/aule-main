<?php require_once("01_init.php");

$kontakte = new Kontakte();
$adressen = new Adressen();

if($_POST['task'] == 'k-submit') {

    $val = 0;

    if(isset($_POST['additional']['id']))  {
        $val = intval($_POST['additional']['id']);
    } else if (isset($_POST['formData']['kontakte-id'])) {
        $val = intval($_POST['formData']['kontakte-id']);
    }

    // echo "<pre>";
    // print_r($val);
    // echo "</pre>";

    // die();

    if($val > 0) {
        $data = $kontakte->edit($val, $_POST['formData']);
    } else {
        $data = $kontakte->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error'],
        'data' => $data
    ]);

} else if($_POST['task'] == 'loadKontakte') {

    $request = new Request($_POST);

    if(is_array($_POST['data'])) {
        $_POST['data'] = $_POST['data']['1'];
    } else {
        $_POST['data'] = $_POST['data'];
    }
    
    $id = $_POST['data'];

    // Holt die Akquise Daten
    $result = $kontakte->get($id);

    $request->echoAnswer($result);

} else if ($_POST['task'] == 'load') {

//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
//    die();

    $request = new Request($_POST);

    if(is_array($_POST['data'])) {
        $_POST['data'] = $_POST['data']['1'];
    } else {
        $_POST['data'] = $_POST['data'];
    }
    
    $id = $_POST['data'];
    

    // Holt die Akquise Daten
    $result = $kontakte->getKontakteAdresse($id);

    // Wenn es einen Adresse gibt
    // if($result['data']['adressen_id']) {

    //     // Holt den Aktuellen Adressen
    //     $resultAdresse = $adressen->get($result['data']['adressen_id']);

    //     // Schreibt den Name in das Vorgesehene Feld
    //     $result['data']['unternehmen'] = $resultAdresse['data']['name'];

    // }

    

    $request->adapt($result);  
    $request->echoAnswer();

  

    // $sampleData = [
    //     "kontakte-id" => $data['id'],
    //     "vorname" => $data['vorname'],
    //     "nachname" => $data['nachname'],
    //     "adressen_id" => $data['adressen_id'],
    //     "abteilung" => $data['abteilung'],
    //     "funktion" => $data['funktion'],
    //     "email" => $data['email'],
    //     "telefon" => $data['telefon'],
    //     "mobil" => $data['mobil'],
    //     "geschlecht" => [
    //         "value" => $data['geschlecht']
    //     ],
    //     "kontosperre_grund" => [
    //         "value" => $data['kontosperre_grund']
    //     ],
    //     "titel" => [
    //         "value" => $data['titel']
    //     ],
    //     "geburtstag" => [
    //         "value" => $data['geburtstag']
    //     ],
    //     "telefax" => $data['telefax']

    // ];

    // $success = true;

    // echo json_encode([
    //     'success' => $success,
    //     'data' => $sampleData
    // ]);
} else if($_POST['task'] == 'k-edit') {
    $data = $adressenbank->get($_POST['data']['1']);

    echo json_encode([
        'success' => true,
        'data' => [
            'adressen_id' => $data['adressen_id'],
            'iban' => $data['iban'],
            'bic' => $data['bic'],
            'bank' => $data['bank']
        ]
    ]); 

} else if($_POST['task'] == 'k-delete') {

    $success = true;
    $error = false;

    $kontakte->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
    
} else if($_POST['task'] == 'neuerKontakt') {


    $request = new Request();

    $result = $kontakte->newKontakt($_POST['formData']);

    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'get') {

    $request = new Request();

    $result = $kontakte->get($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} 

// Holt den Kontake der in der Akquise neu anlegt wurde
else if ($_POST['task'] == 'getAdressenKontakt') {

    $request = new Request();

    $result = $kontakte->getAdressenKontakt($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} 

else if ($_POST['task'] == 'deleteAdressenKontakte') {


    $request = new Request();

    $adressen_kontakte = new AdressenKontakte();

    $result = $adressen_kontakte->deleteAdressenKontakte($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();
}















?>