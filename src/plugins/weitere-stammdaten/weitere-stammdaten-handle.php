<?php include('01_init.php'); 

$artikelgruppen = new Artikelgruppen();
$request = new Request();


// Bearbeiten
if($_POST['task'] == 'ag-edit') {

    $data = $artikelgruppen->get($_POST['data']['1']);
    

    

    if($data['zuordnung_id']) {
        $dataZuordnung = $artikelgruppen->getArtikelZuordnung($data['zuordnung_id']);
       
    } else {
        $data['zuordnung_id'] = false;
        $dataZuordnung['bezeichnung'] = false;
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $data['bezeichnung'],
            'artikel_zuordnung' => [
                "value" => $data['zuordnung_id'],
                "text" => $dataZuordnung['bezeichnung']
            ],
        ]
    ]); 
} 

else if($_POST['task'] == 'ag-submit') {


    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $artikelgruppen->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $artikelgruppen->new($_POST['formData']);
    }


    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);
}


else if($_POST['task'] == 'ag-delete') {
    
    $success = true;
    $error = false;

    $artikelgruppen->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);


} 




?>