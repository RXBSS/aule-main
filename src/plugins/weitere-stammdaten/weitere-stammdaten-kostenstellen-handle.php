<?php include('01_init.php'); 

$kostenstellen = new Kostenstellen();


if($_POST['task'] == 'ks-edit') {

    $data = $kostenstellen->get($_POST['data']['1']);


    // TODO: Bei Textarea, Select und Type number geht es nicht
    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung'],
            'verkaeufe' => $data['verkaeufe'],
            'einkaeufe' => $data['einkaeufe']
        ]
    ]); 
}


else if($_POST['task'] == 'ks-submit') {


    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $kostenstellen->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $kostenstellen->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
}



// -----------------------------------------------
else if($_POST['task'] == 'ks-delete') {
    
    $success = true;
    $error = false;

    $kostenstellen->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);

} 




?>