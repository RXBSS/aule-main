<?php include('01_init.php'); 

$lager = new Lagerverwaltung();


if($_POST['task'] == 'lg-edit') {


    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    $data = $lager->get($_POST['data']['1']);


    // TODO: Bei Textarea, Select und Type number geht es nicht
    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung'],
            'kommission' =>  $data['kommission']
        ]
    ]); 
} else if($_POST['task'] == 'lg-submit') {


    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $lager->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $lager->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
}



// -----------------------------------------------
else if($_POST['task'] == 'lg-delete') {
    
    $success = true;
    $error = false;

    $lager->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);

} 




?>