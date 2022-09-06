<?php include('01_init.php');


$zaehler = new Zaehler();


if($_POST['task'] == 'zaehler-submit') {

    
    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $zaehler->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $zaehler->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);

} else if($_POST['task'] == 'zaehler-edit') {

    $data = $zaehler->get($_POST['data']['1']);

    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung']
        ]
    ]); 
} else if($_POST['task'] == 'zaehler-delete') {

    $success = true;
    $error = false;

    $zaehler->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
}

?>