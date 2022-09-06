<?php include('01_init.php'); 

$_req = new Request($_POST);
$_api = new ZaehlerstaendeAnleitungen();



// Neu
if($_POST['task'] == 'new') {
    
    $result = $_api->new();
    
    $_req->echoAnswer($result);

// Load
} else if($_POST['task'] == 'load') {

    $result = $_api->get($_req->data['data']);
    $result['data']['hersteller_id'] = $_req->mergeForList($result['data']['hersteller_id'], $result['data']['hersteller_bezeichnung']);
    $result['data']['status_id'] = $_req->mergeForList($result['data']['status_id'], $result['data']['status_bezeichnung']);
    

    $_req->echoAnswer($result);

// 
} else if($_POST['task'] == 'edit') {
    
    $result = $_api->edit($_POST['formData']['id'],$_POST['formData']);
    $_req->echoAnswer($result);

} else if($_POST['task'] == 'delete-start') {

    $result = $_api->delete($_req->data['data']);
    $_req->echoAnswer($result);
    
} else if($_POST['task'] == 'delete-force') {
    $result = $_api->delete($_req->data['data'], true);
    $_req->echoAnswer($result);
}





?>