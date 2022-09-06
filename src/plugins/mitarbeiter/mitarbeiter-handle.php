<?php require_once("01_init.php");


// 
$mitarbeiter = new Mitarbeiter();
$adressen = new Adressen();

// Bearbeiten ? 


if($_POST['task'] == 'mtr-submit') {

    $val = intval($_POST['additional']['id']);

    // $val = (intval($_POST['additional']['id']) ? intval($_POST['additional']['id']) : ($_POST['formData']['id'] ? $_POST['formData']['id'] : false) );

    if($val > 0) {
        $data = $mitarbeiter->edit($_POST['additional']['id'], $_POST['formData']);
    } else {
        $data = $mitarbeiter->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);

// Mitarbeiter Details Seite 
} else if($_POST['task'] == 'mtr_d-submit') {

    $val = intval($_POST['formData']['mitarbeiter-id']);

   

    if($val > 0) {
        $data = $mitarbeiter->edit($_POST['formData']['mitarbeiter-id'], $_POST['formData']);
    } else {
        $data = $mitarbeiter->new($_POST['formData']);
    }


    echo json_encode([
        'log' => $data['log'],
        'success' => $data['success'],
        'error' => $data['error']
    ]);
} else if($_POST['task'] == 'load') {

    $success = $error = false;

    // 
    $data = $mitarbeiter->get($_POST['data']);

    // get Lander
    $laender = $adressen->getLaender($data['land']);

    // Wenn Kein Land angegeben ist dann auf false setzen damit keine Fehlermeldung entsteht
    if(!$data['land']) {
        $data['land'] = false;
        $laender['de'] = false;
    }

    if($data) {
        $sampleData = [
            "mitarbeiter-id" => $data['id'],
            "nummer" => $data['nummer'],
            "vorname" => $data['vorname'],
            "nachname" => $data['nachname'],
            "strasse" => $data['strasse'],
            "laender" => [
                "value" => $data['land'],
                "text" => $laender['de']
            ],
            "plz" => $data['plz'],
            "ort" => $data['ort'],
            "telefon" => $data['telefon'],
            "mobiltelefon" => $data['mobiltelefon'],
            "email" => $data['email'],
            "email_geschaeftlich" => $data['email_geschaeftlich'],
            "geburtstag" => $data['geburtstag'],
            "eintrittsdatum" => $data['eintrittsdatum'],
            "austrittsdatum" => $data['austrittsdatum'],
            "aktiv" => $data['aktiv'],
            "auszubildender" => $data['auszubildender'],
            "geschlecht" => [
                "value" => $data['geschlecht']
            ],
        ];
        
        $success = true; 
    } else {
        $error = true; 
    }

    echo json_encode([
        "success" => $success,
        "error" => $error,
        "data" => $sampleData
    ]);

} else if($_POST['task'] == 'getMitarbeiter') {

    $data = $mitarbeiter->getMitarbeiter($_POST['data']['vorname'], $_POST['data']['nachname']);

    echo json_encode([
        'success' => true,
        'data' => $data
    ]); 

} else if($_POST['task'] == 'getMitarbeiterName') {

    $data = $mitarbeiter->get($_POST['data']);

    echo json_encode([
        'success' => true,
        'data' => $data
    ]); 
}
















?>