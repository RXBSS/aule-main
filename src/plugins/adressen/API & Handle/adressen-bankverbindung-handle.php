<?php

use Mpdf\Tag\Address;

require_once("01_init.php");

// 
$adressenbank = new AdressenBank();

// Bearbeiten ? 


if($_POST['task'] == 'bv-submit') {

  

    $request = new Request();

    $val = 0;

    if(isset($_POST['additional']['id'])) {
        $val = intval($_POST['additional']['id']);
    }


    // $val = (intval($_POST['additional']['id']) ? intval($_POST['additional']['id']) : ($_POST['formData']['id'] ? $_POST['formData']['id'] : false) );

    
    if($val > 0) {
        $data = $adressenbank->edit($_POST['additional']['id'], $_POST['formData']);
    } else {
        $data = $adressenbank->new($_POST['formData']);
    }


    $request->adapt($data);
    $request->echoAnswer();
//    echo "<pre>";
//    print_r($data);
//    echo "</pre>";
//    die();


    // echo json_encode([
    //     'success' => $data['success'],
    //     'error' => $data['error']
    // ]);

// Adressen Details Seiter
} else if($_POST['task'] == 'load') {

    // echo "<pre>";
    // print_r($_POST['data']);
    // echo "</pre>";

    // die();

    $data = $adressenbank->get($_POST['data']);

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";

    // die();

    $sampleData = [
        "id" => $data['id'],
        "adressen_id" => $data['adressen_id'],
        "iban" => $data['iban'],
        "bic" => $data['bic'],
        "bank" => $data['bank']
    ];

    $success = true;

    echo json_encode([
        'success' => $success,
        'data' => $sampleData
    ]);
} else if($_POST['task'] == 'bv-delete') {

    $success = true;
    $error = false;

    $adressenbank->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
} else if($_POST['task'] == 'getIbanData') {

    $success = $error = false;

    $req = new Request($_POST);

    // echo "<pre>";
    // print_r();
    // echo "</pre>";

    // die();

    $data = $req->proxy($_POST['data']);

    (($data) ? $success = true :  $error = true);

    echo json_encode([
        'data' => $data,
        'success' => $success,
        'error' => $error
    ]);
}












?>