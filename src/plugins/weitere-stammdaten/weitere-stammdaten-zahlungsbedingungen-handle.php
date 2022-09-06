<?php include('01_init.php'); 

$zahlungsbedingungen = new Zahlungsbedingungen();


if($_POST['task'] == 'zb-edit') {


    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $data = $zahlungsbedingungen->get($_POST['data']['1']);


    // TODO: Bei Textarea, Select und Type number geht es nicht
    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung'],
            'text' =>  $data['text'],
            'abbuchung' =>  $data['abbuchung'],
            'tage' =>  $data['tage'],
            'skonto_prozent' =>  $data['skonto_prozent'],
            'skonto_tage' =>  $data['skonto_tage']
        ]
    ]); 
} else if($_POST['task'] == 'zb-submit') {


    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $zahlungsbedingungen->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $zahlungsbedingungen->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
}



// -----------------------------------------------
else if($_POST['task'] == 'zb-delete') {
    
    $success = true;
    $error = false;

    $zahlungsbedingungen->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);

} 




?>