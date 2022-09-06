<?php require_once("01_init.php");

$akquiseAktion = new AkquiseAktionen();
$mitarbeiter = new Mitarbeiter();
$akquise = new Akquise();
$akquisePositionen = new AkquisePosition();
$akquiseAbo = new AkquiseAbo();
$akquiseMeilenstein = new AkquiseMeilenstein();


if($_POST['task'] == 'ak-submit') {

    $request = new Request();

    // Wenn es ID gibt dann EDIT
    if(isset($_POST['additional']['id']) && $_POST['additional']['id'] !== 'false') {

        $id = $_POST['additional']['id'];

        $result = $akquiseAktion->edit($id, $_POST['formData']); 

    // Wenn es keine ID gibt dann NEW
    } else {

        

        $result = $akquiseAktion->new($_POST['formData']); 
    }

    $request->adapt($result);
    $request->echoAnswer();


} else if($_POST['task'] == 'getKundenName') {


    $request = new Request();

    $result = $akquise->getKundeName($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();


}



else if($_POST['task'] == 'getCount') {

    $success = $error = false;

    // Zählt alle Akquise Aktionen zusammen
    $data = $akquiseAktion->getAkquiseAktionen();
    
    // Success
    if($data['success'] == '1') {
        $success = true;
    } else {
        $error = "Es ist ein Fehler aufgetreten!";
    }
    
    // Rückgabe
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $data
    ]);

} else if($_POST['task'] == 'load') {

    $success = $error = false;

    $request = new Request($_POST);


    // Holt die Akquise Daten
    $result = $akquiseAktion->get($_POST['data']);

    // Holt die Mitarbeiter Daten der Akquise erstellt hat
    $dataMitarbeiter = $mitarbeiter->get($result['data']['ersteller_id']);

    // $sampleData = [

    // ]

//    echo "<pre>";
//    print_r($result);
//    echo "</pre>";
//    die();

    $result['data']['standard_meilensteine'] = $result['data']['standard_meilensteine'];

    //
    $result['data']['ersteller_id'] = $result['data']['ersteller_id'];
    $result['data']['ersteller_text'] = $dataMitarbeiter['vorname'].' '.$dataMitarbeiter['nachname'];


    $result['data']['zeitstempel'] = new DateTime($result['data']['zeitstempel']);
    $result['data']['zeitstempel'] = $result['data']['zeitstempel']->format('Y-m-d');

    $request->adapt($result);  
    $request->echoAnswer();

} else if($_POST['task'] == 'loadTimelineForm') {


    $request = new Request($_POST);

    $result = $akquise->loadTimelineForm($_POST['data']);

    echo json_encode([
        "success" => true,
        "result" => $result,
        "data" => [
            "aktuelle_bearbeiter" => $result['data'][0]['vorname'].' '.$result['data'][0]['nachname']
        ]

    ]);


} else if($_POST['task'] == 'neuerKunde') {

    $request = new Request();

    $res = $akquiseAktion->get($_POST['data'][0]);

    if($res['success'] == '1') {

        $data = [
            'res' => $res,
            'post' => $_POST
        ];

        $result = $akquise->new($data); 

    }

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'deleteKunden') {

    $request = new Request();

    $result = $akquise->delete($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'newKundeAkquise') {

    $request = new Request();

    $result = $akquise->newKunde($_POST['formData']);
    $request->adapt($result);
    $request->echoAnswer();


} else if($_POST['task'] == 'loadTimeline') {

    $success = $error = $successData = false;

    // 
    $request = new Request();

    // Alle Daten aus der Akquise Positionen Seite mit der Aktive ID
    $resultPos = $akquise->getAkquisePositionen($_POST['data']);

    $request->adapt($resultPos);
    $request->echoAnswer();

    // // Holt den Aktuellen Status der Akquise für den Text
    // $resultState = $akquise->getState($_POST['data']);

    // // Holt den Ablehnungsgrund mit dieser Akquise
    // $resultAkquise = $akquise->get($_POST['data']);

    // // Array der Meilensteine Vorbereiten

    // // result
    // $res = [];
    // $resIcon = [];
    // $resMitarbeiter = [];
    // $resZustaendigkeit = [];
    // $resultMeilensteine = [];
    // $resultAblehnung = [];
    // $resultAkquiseAblehnungsgrund = "";

    // $test = [];

    // // Wenn es einen Ablehnungsgrund gibt
    // // if($resultAkquise['data']['ablehnungsgrund']) {

    //     // Holt den Ablehnungsgrund aus der akquise_ablehnungsgrund Tabelle
    //     // $resultAkquiseAblehnungsgrund = $akquise->getAkquiseAblehnungsgrund($resultAkquise['data']['ablehnungsgrund']);
    // // }


    // // Wenn etwas zurück Kommt
    // if(is_array($resultPos)) {

    //     // Es gibt Daten
    //     if($resultPos) {

    //         // Es gibt Daten
    //         $successData = true;

    //         // Nur die Daten die gebraucth werden werden zusammen gebastelt in Arrays und dann an das Frontend übergeben
    //         foreach($resultPos as $key => $value) {

    //             // Holt die Daten zum Mitarbeiter der der Akquise zugeordnet wurde
    //             $dataMitarbeiter = $mitarbeiter->get($value['bearbeiter_id']);

    //             $resMitarbeiter[] = $dataMitarbeiter['vorname']." ".$dataMitarbeiter['nachname'];

    //             // Wenn die Zuständigkeit gemeinsam mit dem Text geändert wurde
    //             if($value['bearbeiter_wechsel']) {
    //                 $dataZuständigkeit = $mitarbeiter->get($value['bearbeiter_wechsel']);
    //                 $resZustaendigkeit[] = $dataZuständigkeit['vorname']." ".$dataZuständigkeit['nachname'];
                
    //             // An die Stellen wo kein Mitarbeiterwechsel stattgefunden hat soll eine leere Stelle kommen damit man durch die Schleife richtig loopen kann 
    //             } else {
    //                 $resZustaendigkeit[] = "";
    //             }

    //             // Nur wenn es ein Meilenstein ist
    //             if($value['meilenstein']) {

    //                 // Holt den Text von Meilensteine zu einer Position
    //                 $resultMeilensteine[] = $akquiseMeilenstein->getMeilensteineText($resultAkquise['data']['aktion_id'], $value['text']);

    //             } else {
    //                 $resultMeilensteine[] = "";
    //             }

    //             // Wenn es einen Ablehungsgrund gibt dann den richtigen -- zwei verschieden Positionen können verschiedene Ablehnungsgründe haben
    //             if($value['ablehnungsgrund']) {
    //                 $resultAblehnung[] = $akquise->getAkquiseAblehnungsgrund($value['ablehnungsgrund']);
    //             } else {
    //                 $resultAblehnung[] = "";
    //             }


    //             // Wenn Kein Icon dann Leer
    //             $iconValue = "";

    //             // Alle Daten mit dem Icon
    //             $resultIcon = $akquise->getAkquiseIcon();

    //             // Geht durch alle Icons die für diese Akquise sind
    //             foreach($resultIcon['data'] as $key2 => $value2) {

    //                 // IconValue wird überschrieben jedesmal und richtig ersetz
    //                 if($value['art'] == $value2['status_id']) {
    //                     $iconValue = $value2['icon'];
    //                 }

    //             }

    //             // Res nur was ich brauche an Akquise Position
    //             $res[] = $value;

    //             // Res nur Icons die ich brauchen
    //             $resIcon[] = $iconValue;
                
    //             // array_push($res, $timeline);
                
    //         }

    //     }

    //     // Erfolg
    //     $success = true;
    // } else {

    //     // Error
    //     $error = true; 
    // }

    // Rückgabe
    // echo json_encode([
    //     'success' => $success,
    //     'error' => $error,
    //     'resultPos' => $res,
    //     'resultIcon' => $resIcon,
    //     'resultMitarbeiter' => $resMitarbeiter,
    //     'resultState' => $resultState,
    //     'resultZustaendigkeit' => $resZustaendigkeit,
    //     'resultAkquise' => $resultAkquise['data'],
    //     'resultMeilensteine' => $resultMeilensteine,
    //     'resultAblehnung' => $resultAblehnung,
    //     'successData' => $successData
    // ]);
    
    // Wenn etwas zurückkommt
    // if($result) {

    //     // 
    //     $akquiseIcon = $akquise->getAkquiseIcon();

    //     // result
    //     $res = [];

    //     // 
    //     foreach($result as $key => $value) {

    //         // Holt die Daten zum Mitarbeiter der der Akquise zugeordnet wurde
    //         $dataMitarbeiter = $mitarbeiter->get($value['bearbeiter_id']);

    //         // Wenn Kein Icon dann Leer
    //         $iconValue = "";

    //         // Geht durch alle Icons die für diese Akquise sind
    //         foreach($akquiseIcon['data'] as $key2 => $value2) {

    //             // IconValue wird überschrieben jedesmal und richtig ersetz
    //             if($value['art'] == $value2['status_id']) {
    //                 $iconValue = $value2['icon'];
    //             }

    //         }


    //         $wiedervorlageData = '';
    //         if($value['wiedervorlage'] != null) {
    //             // Trennen von Datum und Uhrzeit
    //             $wiedervorlage = timeFormat($value['wiedervorlage']);

    //             if(!($wiedervorlage[0] == '30.11.-1')) {
    //                 $wiedervorlageData = '<a href="javascript:void(0);" style="color: #aaa"> <i class="fa-solid fa-bell"></i> '.$wiedervorlage[0].' um '.$wiedervorlage[1].' </a>';
    //             }
    //         }

    //         // SubContent wird Erstellt
    //         $subContent = "";

    //         // Wenn es einen Kundetermin gibt 
    //         if($value['kundentermin'] != null) {

    //             // Datum und Uhrzeit werden getrennt
    //             $kundeTermin = timeFormat($value['kundentermin']);
                
    //             // SubContent wird zusammengesetzt
    //             $subContent = '<a href="javascript:void(0);" style="color: #aaa"> <i class="fa-solid fa-calendar-days"></i> Kundentermin auf '.$kundeTermin[0].' um '.$kundeTermin[1].' gelegt </a>';
            
    //         // Wenn es keinen Kundentermin gibt
    //         } else {
    //             $subContent = "";

    //         }

    //         // Status Text
    //         if($value['text'] == 'status_0') {
    //             $value['text'] = "Der Status wurde auf offen geändert";
    //         } else if ($value['text'] == 'status_1') {
    //             $value['text'] = "Der Status wurde auf erfolgreich geändert";
    //         } else if ($value['text'] == 'status_2') {
    //             $value['text'] = "Der Status wurde auf nicht erfolgreich geändert";
    //         } else if ($value['text'] == 'status_3') {
    //             $value['text'] = "Der Status wurde auf gelöscht geändert";
    //         }

    //         // Dynamische die TimeLine dataSet erstellt
    //         $timeline = [
    //             'timestamp' => $value['zeitstempel'],
    //             'icon' => $iconValue,
    //             'content' => '<b style="font-weight:bold">'.$dataMitarbeiter['vorname'].' '.$dataMitarbeiter['nachname'].': </b>'.$value['text'],
    //             'precontent' => $wiedervorlageData,
    //             'subcontent' =>  $subContent
    //         ];  

    //         // Timeline wird immer wieder neu Überladen
    //         $res[] = $timeline;
            
    //         // array_push($res, $timeline);
            
    //         $succes = true;
            

    //     }
    // } else {

    //     $error = true;
    //     $res = false;
    // }

    
    


    // $request->adapt($result);
    // $request->echoAnswer();

} else if ($_POST['task'] == 'submitTimeline') {

    $dataMitarbeiter;



    // if($_POST['formData']['bearbeiter_id']['value']) {
    //     $dataMitarbeiter = $_POST['formData']['bearbeiter_id'];
    // } else {
    //     $dataMitarbeiter = $_POST['additional']['bearbeiter_id'];
    // }
   

    // Custom Data
    $post = [
        'post' => $_POST,
        // 'mitarbeiterID' => $dataMitarbeiter
    ];

    $request = new Request();

    $result = $akquisePositionen->new($post);

    // Rückgabe
    echo json_encode([
        'success' => $result['success'],
        'error' => $result['error'], 
        'result' => $result
    ]);

} else if($_POST['task'] == 'getAllData') {

    $request = new Request();

    $result = $akquisePositionen->new($post);

} else if($_POST['task'] == 'getAkquise') {

    $request = new Request();

    $result = $akquise->get($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'getAllAdressen') {

    $request = new Request();

    $result = $akquise->getAllAdressen($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'getKundentermin') {

    $request = new Request();

    $result = $akquise->getKundentermin($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();
    
        
} else if($_POST['task'] == 'getBearbeiter') {

    $success = $error = false;

    $request = new Request();

    $result = $akquise->getBearbeiter($_POST['data']);

    // Holt die Daten zum Mitarbeiter der der Akquise zugeordnet wurde
    $dataMitarbeiter = $mitarbeiter->get($result['data'][0]['bearbeiter_id']);

    $resMitarbeiter = $dataMitarbeiter['vorname']." ".$dataMitarbeiter['nachname'];
  
    if($resMitarbeiter) {
        $success = true;
    } else {
        $error = false;
    }

    // Rückgabe
    echo json_encode([
        'success' => $success,
        'error' => $error, 
        'result' => $resMitarbeiter
    ]);


    $request->result = $resMitarbeiter;

//    echo "<pre>";
//    print_r($dataMitarbeiter);
//    echo "</pre>";
//    die();

//     $request->adapt($request);
//     $request->echoAnswer();

// ------------------------------------------------------------------------
// Status Akquise
// ------------------------------------------------------------------------
} else if ($_POST['task'] == 'notErfolgreich') {

    $request = new Request();

    $result = $akquise->statusNotErfolgreich($_POST['additional']['id'], $_POST['formData']);
    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'akquiseErfolgreichOrOffen') {

    $request = new Request();

    $result = $akquise->statusErfolgreichOrOffen($_POST['data'], );
    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'statusDelete') {

    $request = new Request();

    $result = $akquise->statusGeloescht($_POST['data']);
    $request->adapt($result);
    $request->echoAnswer();




} else if($_POST['task'] == 'statusAkquiseDelete') {

    $request = new Request();

    $result = $akquise->statusAkquiseGeloescht($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'getStatusOffen') {

    $request = new Request();

    $result = $akquise->getStatusOffen($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'getStatusForStatistic') {

    $success = $error = false;

    $request = new Request();

    // TODO: PERFORMANCE FÜRN AR****
    $result = $akquise->getStatusForStatistic($_POST['data']);
    // $resultErfolgreich = $akquise->getStatusForStatisticERF($_POST['data']);
    // $resultNichtErfolgreich = $akquise->getStatusForStatisticNOT($_POST['data']);
  
    // Erfolgreich
    // if($resultOffen && $resultErfolgreich && $resultNichtErfolgreich) {
        // $success = true;
    // } else {
        // $error = true;
    // }

    $request->adapt($result);
    $request->echoAnswer();

    // Rückgabe
    // echo json_encode([
    //     'success' => $success,
    //     'error' => $error, 
    //     'resultOffen' => $resultOffen['data'],
    //     'resultErfolgreich' => $resultErfolgreich['data'],
    //     'resultNichtErfolgreich' => $resultNichtErfolgreich['data']
    // ]);


    // $request->adapt($result);
    // $request->echoAnswer();
    
    
// ------------------------------------------------------------------------
// Kontakt Ansprechpartner
// ------------------------------------------------------------------------

} else if($_POST['task'] == 'neuerKontakt') {

    $request = new Request();

    $result = $akquise->newKontakt($_POST['data']); 

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'deleteKontakte') {

    $request = new Request();

    $result = $akquise->deleteKontakt($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if ($_POST['task'] == 'getKontakte')  {

    $request = new Request();

    $kontakte = new Kontakte();

    $result = $kontakte->getKontakteAkquise($_POST['data']);


    $request->adapt($result);
    $request->echoAnswer();

}

// ---------------------------------------------------------------------------
// Akquise Abonnenten
// -------------------------------------------------------------------------- 

else if ($_POST['task'] == 'getAkquiseAbo') {

    $request = new Request();

    // TODO: Falsche Weil Multiple muss es sein
    // Wenn Akquise id und Mitarbeiter Session id dann
    $result = $akquiseAbo->getAkquiseAboMultiple($_POST);

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'akquiseAbo') {


    $request = new Request();

    $result = $akquiseAbo->setAbo($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

}   else if($_POST['task'] == 'getCurrentUser') {

    $success = $error = false;

    // Data
    $sampleData = [
        "bearbeiter_id" => [
            "value" => $_SESSION['user']['id'],
            "text" => $_SESSION['user']['vorname']. ' '. $_SESSION['user']['nachname']
        ]
    ];

    // Success
    if($_SESSION['user']['id'] && $_SESSION['user']['vorname']) {
        $success = true;

    // Error
    } else {
        $error = true;
    }

    // Result
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $sampleData
    ]);

    
} else if($_POST['task'] == 'submitMeilenstein') {

    $success = $error = false;
    
    $request = new Request();

    $akquiseMeilenstein  = new AkquiseMeilenstein();

    // TODO: Falsche Weil Multiple muss es sein
    // Wenn Akquise id und Mitarbeiter Session id dann
    $result = $akquiseMeilenstein->new($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'getMeilenstein') {
    
    $success = $error = false; 

    $request = new Request();

    $akquiseMeilenstein  = new AkquiseMeilenstein(); 

    // Res
    $result;

    // Holt Erstmal Alles über die Akquise
    $resultAkquise = $akquise->get($_POST['data']);

    // Wenn Es überhaupt eine Aktion gibt
    if($resultAkquise['data']['aktion_id']) {

        // Holt Alles über die Aktion ID
        $resultAktion = $akquiseAktion->get($resultAkquise['data']['aktion_id']);

      

        // Wenn Die Standard Meilensteine Erlaubt sind
        if($resultAktion['data']['standard_meilensteine']) {
            $result = $akquiseMeilenstein->getMeilensteine($_POST['data'], true);
        } 

        // Wenn es eine Aktion gibt aber die Standard Meilensteine nicht erlaubt sind
        else {
            $result = $akquiseMeilenstein->getMeilensteine($_POST['data'], false);
        }

    }

    // Wenn es Keine Aktion nicht gibt
    else {

        // Alle Meilensteine die es gibt holen
        $result = $akquiseMeilenstein->getMeilensteine($_POST['data'], true);

    }

    $resultTest = $akquiseMeilenstein->getMeilensteinMitarbeiter($_POST['data']);

    if($result['success'] == 1 && $resultTest['success'] == 1) {
        $success = true;
    } else {
        $error = false;
    }

    // Result
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'resultTest' => $resultTest,
        'result' => $result
    ]);


    // if($getAkquise['success'] && $getMeilensteine['success']) {
    //     $success = true; 
    // } else {
    //     $error = false;
    // }

    // // Result
    // echo json_encode([
    //     'success' => $success,
    //     'error' => $error,
    //     'getMeilensteine' => $getMeilensteine,
    //     'getPositionMeilensteine' => $getPositionMeilensteine,
    //     'getAkquise' => $getAkquise
    // ]);


    // $success = $error = $successSQL = false;

    // $request = new Request();

    // $akquiseMeilenstein  = new AkquiseMeilenstein();
  
    // $resultAkquise = $akquise->get($_POST['data']);   

    // // TODO: Falsche Weil Multiple muss es sein
    // // Wenn Akquise id und Mitarbeiter Session id dann
    // $result = $akquiseMeilenstein->getAll($_POST['data']);
 
    // $resultPos = false;

    // if($resultAkquise['data']['aktion_id'] != '') {
    //     $resultPos = $akquiseMeilenstein->getPos($result['data']);
    //     $success = true;

    // // Keine Daten aber SQL Abfrage war erfolgreich
    // } else if($result['error'] == 'Der gewünschte Datensatz wurde nicht gefunden') {
    //     $successSQL = true;
    //     $success = true;

    // // Akquise hat keine Aktion
    // } else if ($result['success']) {
    //     $success = true;

    // // Fehler
    // } else {
    //     $error = true;
    // }

    // // Result
    // echo json_encode([
    //     'success' => $success,
    //     'successSQL' => $successSQL,
    //     'error' => $error,
    //     'resultPos' => $resultPos,
    //     'result' => $result
    // ]);
} else if($_POST['task'] == 'createMeilenstein') {

    $request = new Request();
    $akquiseMeilenstein  = new AkquiseMeilenstein();

    // Geht Aktuelle Nummer

    // Wenn es eine ID gibt ---- Update
    if($_POST['formData']['id'] > 0) {

        // Update des Meilensteins
        $result = $akquiseMeilenstein->update($_POST);

    } 

    // Wenn es keine ID gibt ---- New
    else {

        // Wenn Akquise id und Mitarbeiter Session id dann
        $result = $akquiseMeilenstein->create($_POST);

    }

    // TODO: Falsche Weil Multiple muss es sein

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'getMeilensteinSet') {

    $request = new Request();

    $akquiseMeilenstein  = new AkquiseMeilenstein();

    // TODO: Falsche Weil Multiple muss es sein
    // Wenn Akquise id und Mitarbeiter Session id dann
    $result = $akquiseMeilenstein->getEdit($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();


} else if($_POST['task'] == 'editMeilenstein') {

    $request = new Request();

    $id = "";

    // Bei den Weiteren Stammdaten wird ein Array mitgegeben und kein String
    if(is_array($_POST['data'])) {
        $id = $_POST['data'][1];
    
    // Else Ist Pst an der stelle Data ein String dann den übergeben
    } else {
        $id = $_POST['data'];
    }

    $akquiseMeilenstein  = new AkquiseMeilenstein();

    // TODO: Falsche Weil Multiple muss es sein
    // Wenn Akquise id und Mitarbeiter Session id dann
    $result = $akquiseMeilenstein->get($id);

    $request->adapt($result);
    $request->echoAnswer();


} else if($_POST['task'] == 'deleteMeilensteine') {

    $request = new Request();

    $akquiseMeilenstein  = new AkquiseMeilenstein();

    // TODO: Falsche Weil Multiple muss es sein
    // Wenn Akquise id und Mitarbeiter Session id dann
    $result = $akquiseMeilenstein->delete($_POST['data']);

    $request->adapt($result);
    $request->echoAnswer();

} else if($_POST['task'] == 'getHistoryAkquise') {

    $request = new Request();

    $result = $akquisePositionen->getHistory();

    $request->adapt($result);
    $request->echoAnswer();

}

// Positionen der Meilensteine Verschieben
else if($_POST['task'] == 'positionen-shift') {

    //
    $success = $error = false;

    $request = new Request();

    $result = $akquiseMeilenstein->posShift($_POST);
    
    // Wenn Erfolgreich
    if($result['success']) {

        $success = true;

    } else {

        $error = true;
    }

    // Rückgabe
    echo json_encode([
        'success' => $success,
        'error' => $error,
        'result' => $result
    ]);

    // $request->adapt($result);
    // $request->echoAnswer();

}

// Holt die Aktion des Meilenstein
else if($_POST['task'] == 'getMeilensteineAktion') {


    $request = new Request();

    $result = $akquiseMeilenstein->getMeilensteineAktion($_POST['data'][0]);

    $request->adapt($result);
    $request->echoAnswer();
} 







function timeFormat($date) {

    $dateExplode = explode(" ", $date);

    // neues Datum Wiedervorlage
    $newDate = new DateTime($dateExplode[0]);
    $newDate = $newDate->format("d.m.y");

    // neue Uhrzeit Wiedervorlage
    $newTime = new DateTime($dateExplode[1]);
    $newTime = $newTime->format("H:i");

    $arr = [$newDate, $newTime];

    return $arr;
} 

?>