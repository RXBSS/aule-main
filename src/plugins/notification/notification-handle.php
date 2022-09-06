<?php require_once("01_init.php");

$notification = new Notification();
$mitarbeiter = new Mitarbeiter();

// 
if($_POST['task'] == 'load') {

    $success = $error = $successSQL = $resultKeinAbo = $result = false;

    $req = new Request();

    // Akquise Abo
    $akquiseAbo = new AkquiseAbo();

    // Get Data
    $result = $notification->get();
  
    $resMitarbeiter = [];   
   
    // Wenn es Daten gibt
    if(isset($result['success']) && $result['success']) {

        // Geht alle Rückgaben durch
        foreach($result['data'] as $key => $value) {

            // Mitarbeiter
            // $dataMitarbeiter = $mitarbeiter->get($value['user_id']);
            $dataMitarbeiter = $mitarbeiter->get($result['data'][$key]['user_id']);

            $resMitarbeiter[] = $dataMitarbeiter['vorname']." ".$dataMitarbeiter['nachname'];
                
        }

    }


    // Wenn Erfolgreich und es Daten gibt
    if( isset($result['success']) && $result['success'] || $resultKeinAbo) {
        $success = true; 

    // Wenn es keine Daten gibt // TODO: Request API weitere Variable
    } else if(($result['error']) == 'Der gewünschte Datensatz wurde nicht gefunden') {
    
        $successSQL = true;
        $success = true; 

    // In allen Anderen fällen
    } else {
        $error = true;

    }

    // Result
    echo json_encode([
        'success' => $success,
        'successSQL' => $successSQL,
        'error' => $error,
        'result' => $result,
        'resultMitarbeiter' => $resMitarbeiter
    ]);
    

} else if ($_POST['task'] == 'redirect-notification') {

    $request = new Request();

    $result = $notification->notificationGelesen($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();



} else if ($_POST['task'] == 'load-notification') {

    $request = new Request();

    $result = $notification->getNotification();

    $request->adapt($result);
    $request->echoAnswer();

}













?>