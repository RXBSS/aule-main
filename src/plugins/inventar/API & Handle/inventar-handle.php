<?php require_once("01_init.php");

// 
$inventar = new Inventar();
$mitarbeiter = new Mitarbeiter();


switch($_POST['task']) {

    case 'i-submit':

        $val = intval($_POST['additional']['id']);

        if($val > 0) {

            $data = $inventar->edit($_POST['additional']['id'], $_POST['formData']);

        } else{
            $data = $inventar->new($_POST['formData']);
        }
        
        echo json_encode([
            
            'success' => $data['success'],
            'error' => $data['error']
        ]);

        break;
    case 'i-edit':

        // $data = $inventar->get($_POST['data']['1']);
        $result = $inventar->getD($_POST['data']);

        // $dataKaufperson = $mitarbeiter->get($data['kaufperson']);
        // $dataNutzer = $mitarbeiter->get($data['nutzer']);

       
        //  //
        //  $result['data']['kaufperson_id'] = $result['data']['kaufperson_id'];
        //  $result['data']['kaufperson_text'] = $result['data']['kaufpersonVorname'].' '.$result['data']['kaufpersonNachname'];
 
        //   //
        //  $result['data']['nutzer_id'] = $result['data']['nutzer_id'];
        //  $result['data']['nutzer_text'] = $result['data']['nutzerVorname'].' '.$result['data']['nutzerNachname'];
 
        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";
        // die();
 

        echo json_encode([

            "success" => true,
            'data' => [
                "kaufobjekt" => $result['data']['kaufobjekt'],
                "kaufperson_id" => [
                    "value" => $result['data']['kaufperson_id'],
                    "text" => $result['data']['kaufpersonVorname'].' '.$result['data']['kaufpersonNachname']
                ],
                "kaufdatum" => $result['data']['kaufdatum'],
                "nutzer_id" => [
                    "value" => $result['data']['nutzer_id'],
                    "text" => $result['data']['nutzerVorname'].' '.$result['data']['nutzerNachname']
                ],
                "seriennummer" => $result['data']['seriennummer'],
                "kaufpreis" => $result['data']['kaufpreis'],
                "beschreibung" => $result['data']['beschreibung'],
                "abschreibezeitraum" => $result['data']['abschreibezeitraum']
            ]

        ]);

        break;
    

    // Wenn das Inventar gelöscht werden soll
    case 'i-delete': 


        $req = new Request();

        $result = $inventar->delete($_POST['data']);

        $req->adapt($result);
        $req->echoAnswer();

        break;

    // Wenn das Formular geladen wird
    case 'load': 

        $req = new Request();

        $result = $inventar->getD($_POST['data']);

        //
        $result['data']['kaufperson_id'] = $result['data']['kaufperson_id'];
        $result['data']['kaufperson_text'] = $result['data']['kaufpersonVorname'].' '.$result['data']['kaufpersonNachname'];

         //
        $result['data']['nutzer_id'] = $result['data']['nutzer_id'];
        $result['data']['nutzer_text'] = $result['data']['nutzerVorname'].' '.$result['data']['nutzerNachname'];
 

    //    echo "<pre>";
    //    print_r($result);
    //    echo "</pre>";
    //    die();

        $req->adapt($result);
        $req->echoAnswer();

        break;

    // Dokument auf der Inventar Details Seite Hochladen 
    case 'upload-dokument': 

        // Neuen Request erstellen - Wichti
        // $req = new Request($_POST);

        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // die();

        // Uploaded Files verschieben
        // $req->moveUploadedFiles($_FILES, "inventar", [
        //     'normalize' => true
        // ]);

        //  Antwort ausgeben
        // $req->echoAnswer();

    //    echo "<pre>";
    //    print_r($_POST['additionalFileInfo']);
    //    echo "</pre>";
    //    die();

        break;

    // Modal Verleidh submit
    case 'verleihSubmit': 

        $req = new Request();

        $result = $inventar->verleihSubmit($_POST['additional']['id'], $_POST['formData']);

        $req->adapt($result);
        $req->echoAnswer();


        break;

    // Verleiht Load and Open Modal
    case 'verleih-edit': 

         // $data = $inventar->get($_POST['data']['1']);
         $result = $inventar->getD($_POST['data']);
 
        echo json_encode([
            "success" => true,
            'data' => [
                "kaufobjekt" => $result['data']['kaufobjekt'],
                "nutzungsdauer" => $result['data']['nutzungsdauer'],
                "nutzungsgrund" => $result['data']['nutzungsgrund'],
                "nutzungsstandort" => $result['data']['nutzungsstandort'],
                "nutzer_id" => [
                    "value" => $result['data']['nutzer_id'],
                    "text" => $result['data']['nutzerVorname'].' '.$result['data']['nutzerNachname']
                ]
            ]
        ]);

        break;

    // Verleih beenden
    case 'verleihBeenden':

        $req = new Request();

        $result = $inventar->verleihBeenden($_POST['data']);

        $req->adapt($result);
        $req->echoAnswer();

        break;

    // Holt alles aus den Postionen
    case 'getHistorie': 

        $req = new Request();

        $result = $inventar->getHistorie($_POST['data']);

        $req->adapt($result);
        $req->echoAnswer();

        break;

}










?>