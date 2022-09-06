<?php include('01_init.php'); 

$artikelAttribute = new artikelAttribute();


if($_POST['task'] == 'aga-edit') {

    $data = $artikelAttribute->get($_POST['data']['1']);

    // TODO: Bei Textarea, Select und Type number geht es nicht
    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung'],
            'beschreibung' => $data['beschreibung'],
            'pflichtfeld' => ($data['pflichtfeld'] >= 0 && $data['pflichtfeld'] != NULL) ? $data['pflichtfeld'] : '- Bitte Wähle -',
            'datentyp' => ($data['datentyp']) ? $data['datentyp'] : '- Bitte Wähle -',
            'reihenfolge' => ($data['reihenfolge']) ? $data['reihenfolge'] : ''
        ]
    ]); 
}


else if($_POST['task'] == 'aga-submit') {


    $val = intval($_POST['additional']['id']['1']);

    
    if($val > 0) {
        $data = $artikelAttribute->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $artikelAttribute->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
}



// -----------------------------------------------
else if($_POST['task'] == 'aga-delete') {
    
    $success = true;
    $error = false;

    $artikelAttribute->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);

} 




?>