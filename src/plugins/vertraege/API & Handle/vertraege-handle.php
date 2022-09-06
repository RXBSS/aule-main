<?php require_once("01_init.php");

// 

$vertraege = new Vertraege();
$vertraegePos = new VertraegePos(); // TODO AUSLAGGERN
$vertraegeKlauseln = new VertraegeKlauseln();
$vertraegeVorlagen = new VertraegeVorlagen();
$vertraegeAbrechnung = new VertraegeAbrechnung();
$vertraegeKosten = new VertraegeKosten();
$vertraegeGruppen = new VertraegeGruppen();


$adresse = new Adressen();




$adressen = new Adressen();


/**
 * ********************************************************************
 * Stammseite
 * ********************************************************************
 * 
 */
if($_POST['task'] == 'v-submit') {


    $req = new Request($_POST);

    // echo "<pre>",
    // print_r($req);
    // echo "</pre>";

    // die();

    // if($req->data['formData']['id']) {
    //     $data = $vertraege->edit($_POST['formData']['id'], $_POST['formData']);
    // } else {
        $data = $vertraege->new($_POST['formData']);
    // }


    $req->adapt($data);
    $req->echoAnswer();


/**
 * ********************************************************************
 * DETAILS
 * ********************************************************************
 * 
 */

} else if($_POST['task'] == 'positionen-load') {


    $req = new Request();

    $data = $vertraegePos->get($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();


} else if($_POST['task'] == 'positionen-delete') {


    $req = new Request();

    $data = $vertraegePos->delete($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();

    

} else if($_POST['task'] == 'positionen-editieren') {

    $req = new Request();

    $data = $vertraegePos->edit($_POST['data']['id'], $_POST['data']['data']);

    $req->adapt($data);
    $req->echoAnswer();


} else if($_POST['task'] == 'entwurf-speichern') {
  
    $req = new Request();

    $data = $vertraege->edit($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($data);
    $req->echoAnswer();


} else if($_POST['task'] == 'vertragErstellen') {
  
    $req = new Request();

    $data = $vertraege->aktivStellen($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($data);
    $req->echoAnswer();


} else if($_POST['task'] == 'load') {


//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
//    die();

    $req = new Request();

    $result = $vertraege->get($_POST['data']);


    if ($result['success']) {

        // wenn es Ein Land gibt
        // if($result['data']['vertragsnehmerLand']) {
        //     $resLand = $adresse->getDE($result['data']['vertragsnehmerLand']);
        // }

        // $result['data']['lf_name'] = $req->mergeForList($result['data']['lf_id'], $result['data']['lf_name']);
        // $result['data']['re_name'] = $req->mergeForList($result['data']['re_id'], $result['data']['re_name']);
        $result['data']['vn_adresse'] = $req->mergeForList($result['data']['vertragsnehmerID'], $result['data']['name']);
        $result['data']['authorisierer_id'] = $req->mergeForList($result['data']['idGeschaeftsfuehrer'], $result['data']['vornameGeschaeftsfuehrer']." ".$result['data']['nachnameGeschaeftsfuehrer']);
        $result['data']['sachbearbeiterkunde_id'] = $req->mergeForList($result['data']['idKunde'], $result['data']['vornameKunde']." ".$result['data']['nachnameKunde']);
        $result['data']['vorlagen_id'] = $req->mergeForList($result['data']['vertragsvorlagenID'], $result['data']['vertragsvorlagenBezeichnung']);

        $result['data']['sachbearbeiter_id'] = $result['data']['sachbearbeiterVorname']." ".$result['data']['nachnameSachbearbeiter'];
        
    }


    $req->adapt($result);
    $req->echoAnswer();

    // $dataAdresse = $adressen->onlyGetName($data['vn_adresse']);


    // if($data['vn_adresse'] >= 1) {
    //     $dataAdresse = $adressen->onlyGetName($data['vn_adresse']);
    // } else {
    //     $data['vn_adresse'] = false;
    //     $dataAdresse['name'] = false;
    // }

    // $sampleData = [
    //     'id' => $data['id'],
    //     'status_id' => [
    //         "value" => $data['status_id'],
    //     ],
    //     'laufzeit' => $data['laufzeit'],
    //     'vertragsbeginn' => $data['vertragsbeginn'],
    //     'vertragsende' => $data['vertragsende'],
    //     'gekuendigt_am' => $data['gekuendigt_am'],
    //     'vn_adresse' => [
    //         "value" => $data['vn_adresse'],
    //         "text" => $dataAdresse['name']
    //     ],
    //     'version' => $data['version'],
    // ];

    // $success = true;

    // echo json_encode([
    //     'success' => $success,
    //     'data' => $sampleData
    // ]);
}

// Vertrag Entwurf loeschen
else if($_POST['task'] == 'entwurf-loeschen') {

    $req = new Request();

    $vertraege->deleteKlausel($_POST['data']);
    $data = $vertraege->delete($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();

}

// Wenn die VertragsPositionn Ausgelesen werden soll
else if ($_POST['task'] == 'getPos') {

    // $req = new Request();

    // $data = $vertraegePos->get($_POST['data'][0]);

    // $req->adapt($data);
    // $req->echoAnswer();

}

// Wenn eine Auswahl getroffen wurde auf eine neue Adresse
else if($_POST['task'] == 'getAdresseData') {

    // $req = new Request();

    // $success = $error = false;

    // $data = $adressen->get($_POST['data']);

    // // Holt das Land ausgeschrieben
    // $resultLand = $adressen->getDE($data['data']['land']);

    // // $data['data']['laender'] = $resultLand['data'][0]['de'];

    // // Wenn es Daten gibt
    // if($data['data']) {

    //     $success = true;

    //     $sampleData = [
    //         'id' => $data['data']['id'],
    //         'kunde' => [
    //             "value" => $data['data']['id'],
    //             "text" => $data['data']['name'],
    //         ],
    //         'land' => [
    //             "value" => $data['data']['land'],
    //             "text" => $resultLand['data'][0]['de'],
    //         ],
    //         'strasse' => $data['data']['strasse'],
    //         'plz' => $data['data']['plz'],
    //         'ort' => $data['data']['ort']
    //     ];


    // } else {

    //     $error = true;
    // }

    // // Rückgabe
    // echo json_encode([
    //     'success' => $success,
    //     'error' => $error,
    //     'data' => $sampleData
    // ]);

  

    // $req->adapt($sampleData);
    // $req->echoAnswer();

}

// Holt die Adresse nach einer Auswahl
if ($_POST['task'] == 'get-adresse') {

    // 
    $adressenApi = new Adressen();

    $req = new Request($_POST);

    if(isset($req->data['data'])) {

        $req->success = true;
        $req->result = $adressenApi->getAdressenLand($req->data['data']);

        $req->result['vn_adresse'] = $req->mergeForList($req->result['data']['id'], $req->result['data']['name']);

        // Ergebnis
        $req->adapt($req->result);
        $req->echoAnswer();

    }

    return true;


}

// Holt Alle Daten der Vertragsklausen
else if($_POST['task'] == 'load-klauseln') {

    $req = new Request();


    $result = $vertraegeKlauseln->get($_POST['data']);

//    echo "<pre>";
//    print_r($result);
//    echo "</pre>";

    $result['data'] = $result['data'][0];

    if ($result['success']) {

        // $result['data']['vertraegeart_id'] = $req->mergeForList($result['data']['vertraegeart_id'], $result['data']['vertragsArtBezeichnung']);
        $result['data']['gruppen_id'] = $req->mergeForList($result['data']['gruppen_id'], $result['data']['vertragsgruppenParagraph']);
    }


    // $req->adapt($result);
    $req->echoAnswer($result);

}


// Submit Funktion der Klause
else if ($_POST['task'] == 'klausel-submit') {

    $req = new Request();
    
    //

    // Wenn es eine ID gibt dann Edit
    if(isset($_POST['additional']['id']) && $_POST['additional']['id'] > 0 ) {

        // Wie Edit aber Insert neue Version
        $data = $vertraegeKlauseln->editKlausel($_POST['additional']['id'], $_POST['formData']);
    
    }

    // Wenn es keine ID gibt dann submit
    else {

        $data = $vertraegeKlauseln->newKlausel($_POST['formData']);

    }

    $req->adapt($data);
    $req->echoAnswer();

}

// Klausel Entwurf Loeschen
else if($_POST['task'] == 'entwurfLoeschen') {

    $req = new Request();

    $data = $vertraegeKlauseln->entwurfLoeschen($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();

}

// Wenn die Klausel Aktiviert wird 
else if ($_POST['task'] == 'klauselAktivieren') {

    $req = new Request();

    $data = $vertraegeKlauseln->klauselAktivieren($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();

}

// neue Version der Klausel Veröffentlichen
else if ($_POST['task'] == 'klauselVersionNeu') {

    $req = new Request();

    $data = $vertraegeKlauseln->klauselVersionNeu($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();


}

// Lädt die Verträge Stammdaten 
else if($_POST['task'] == 'load-vorlagen-details') {

    $req = new Request();

    $result = $vertraegeVorlagen->getVertraegeArt($_POST['data']);

//    echo "<pre>";
//    print_r($result);
//    echo "</pre>";
//    die();


    // $req->adapt($result);
    $req->echoAnswer($result);
}

// Vorlagen Submit
else if ($_POST['task'] == 'vorlagen-submit') {

    $req = new Request();

    $result = $vertraegeVorlagen->new($_POST['data']);

//    echo "<pre>";
//    print_r($result);
//    echo "</pre>";
//    die();


    // $req->adapt($result);
    $req->echoAnswer($result);

}

// Holt die Klauseln der Verträge
else if ($_POST['task'] == 'getKlauselnVertraege') {

    $req = new Request();

    $success = $error = false;

    $result = $vertraege->getKlauselnVertraege($_POST['data']);

    $req->echoAnswer($result);

}

// Holt die Klauseln
else if ($_POST['task'] == 'getKlauseln') {

    $req = new Request();

    $success = $error = false;

    $result = $vertraegeKlauseln->getKlauseln($_POST['data']);

//     $arr = [
//         'Inhalte der Mietpauschale',
//         'Inhalte der Wartung',
//         'Ausnahmen der Wartung',
//         'Pflichten des Kunden',
//         'Sondervereinbarungen',
//         'Sichere Außerbetriebnahme von Druckern, Kopierern und Multifunktionsgeräte',
//         'Zahlungsverzug',
//         'Gerichtsstand',
//     ];

//     // Geht durch die Schleife und sucht die Gruppen
//     foreach($result as $key => $value) {



//     }

//    echo "<pre>";
//    print_r($result);
//    echo "</pre>";
//    die();

    $req->echoAnswer($result);

}


// Löschen einer Klausel
else if ($_POST['task'] == 'deleteKlausel') {

    $req = new Request();

    $result = $vertraegeKlauseln->deleteKlausel($_POST['data']);

    $req->echoAnswer($result);

}

// Löschen einer Klausel
else if ($_POST['task'] == 'deleteKlauselVorlage') {

    $req = new Request();

    $result = $vertraegeVorlagen->deleteKlausel($_POST['data']);

    $req->echoAnswer($result);

}

// Stammdaten Submit Funktion
else if($_POST['task'] == 'submitVorlagen') {
    
    $req = new Request();

    // Wenn es Additional ID gibt dann Edit
    if(isset($_POST['additional']['id']) && $_POST['additional']['id'] > 0 ) {
        $result = $vertraegeVorlagen->editVorlagen($_POST['additional']['id'], $_POST['formData']);
    }

    // Wenn es keine Addtional ID gibt dann Insert New
    else {
        $result = $vertraegeVorlagen->newVertraegeVorlage($_POST['formData']);
    }


    $req->echoAnswer($result);


}

// Löscht die Vorlage 
else if($_POST['task'] == 'entwurfLoeschenVorlage') {


    $req = new Request();

    $data = $vertraegeVorlagen->entwurfLoeschen($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();


}

// Vertrags Vorlage auf Aktiv stellen
else if($_POST['task'] == 'vorlageAktivieren') {
    
    $req = new Request();

    $data = $vertraegeVorlagen->vorlageAktivieren($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();


}

// eine neue Version erstellen für einen Vertrag
else if ($_POST['task'] == 'vertragVorlagenVersionNeu') {

    $req = new Request();

    $data = $vertraegeVorlagen->vertragVorlagenVersionNeu($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();
}


// Zählt alle Klauseln
else if($_POST['task'] == 'countKlausel') {

    $req = new Request();

    $result = $vertraegeKlauseln->countKlausel();

    $req->echoAnswer($result);

}

// Veträgegruppen Create
else if($_POST['task'] == 'vertraegegruppen-submit') {

    $vertraegeGruppen = new VertraegeGruppen();

    $val = intval($_POST['additional']['id']['1']);
    
    if($val > 0) {
        $data = $vertraegeGruppen->edit($_POST['additional']['id']['1'], $_POST['formData']);
    } else {
        $data = $vertraegeGruppen->new($_POST['formData']);
    }

    echo json_encode([
        'success' => $data['success'],
        'error' => $data['error']
    ]);

}


// Vertrgegruppen Edit
else if($_POST['task'] == 'editVertaegegruppen') {
    
    $vertraegeGruppen = new VertraegeGruppen();

    $result = $vertraegeGruppen->get($_POST['data']['1']);

    echo json_encode([
        'success' => true,
        'data' => [
            'bezeichnung' => $result['data']['bezeichnung']
        ]
    ]); 
}

// Verträgegruppen Delete
else if($_POST['task'] == 'deleteVertaegegruppen') {

    $vertraegeGruppen = new VertraegeGruppen();

    $success = true;
    $error = false;

    $vertraegeGruppen->delete($_POST['data']);

    echo json_encode([
        'success' => $success,
        'error' => $error
    ]);
}


// Lädt die Timeline der Klauseln 
else if($_POST['task'] == 'loadTimeline') {

    $success = $error = false;

    $req = new Request();

    $result = $vertraegeKlauseln->loadTimeline($_POST['data']);

    if($result['success']) {
        $success = true;
    } else {
        $error = true;
    }

    echo json_encode([
        'success' => $success,
        'error' => $error,
        'data' => $result['data']['data'],
    ]);

}

// Neue Version von einem Vertrag
else if($_POST['task'] == 'vertragVersionNeu') {

    
    $req = new Request();

    $data = $vertraege->vertragVersionNeu($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();

}

// Wenn der vertrag Gekündigt wird
else if ($_POST['task'] == 'submitKuendigen') {

    $req = new Request();

    $data = $vertraege->submitKuendigen($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($data);
    $req->echoAnswer();
}

// Wenn der vertrag Gekündigt wird
else if ($_POST['task'] == 'klauselVerwendetIn') {

    $req = new Request();

    $data = $vertraegeKlauseln->klauselVerwendetIn($_POST['data']);

    $req->adapt($data);
    $req->echoAnswer();
}

// Wenn der vertrag Gekündigt wird
else if ($_POST['task'] == 'addKlauselnVertraege') {

    $req = new Request();

    $result = $vertraege->addKlauselnVertraege($_POST['data']);

    // $req->adapt($result);
    $req->echoAnswer($result);

}

// Eine Klausel aus einem Vertrag löschen
else if($_POST['task'] == 'deleteVertragKlausel') {

    $req = new Request();

    $result = $vertraege->delete($_POST['data']);

    // $req->adapt($result);
    $req->echoAnswer($result);
}

else if($_POST['task'] == 'submitPositionen') {

    $req = new Request();

    // Wenn die Positionen ID größ als 0 ist dann soll die vorhandene Editiert werden
    if(isset($_POST['additional']['positionenID']) && intval($_POST['additional']['positionenID']) > 0) {

        $result = $vertraegePos->edit(intval($_POST['additional']['positionenID']), $_POST['formData']);

    // Neue Positionen Erstellen
    } else {
        // $result = $vertraegePos->new($_POST['additional']['id'], $_POST['formData']);
    }


    // $req->adapt($result);
    $req->echoAnswer($result);
    
} else if($_POST['task'] == 'editPositionen') {

    $req = new Request();

    $result = $vertraegePos->get($_POST['data']);

    // $req->adapt($result);
    $req->echoAnswer($result);
}

else if($_POST['task'] == 'deletePositionen') {

    $req = new Request();

    $result = $vertraegePos->delete($_POST['data']);

    // $req->adapt($result);
    $req->echoAnswer($result);
}

// Abrechnung Abschicken
else if($_POST['task'] == 'abrechnungSubmit') {


    $req = new Request();

    // Wenn es eine vertrags ID gibt die größer als 0 ist -- Dann Edit
    if($_POST['additional']['abrechnungID'] > 0) {

        $result = $vertraegeAbrechnung->edit($_POST['additional']['abrechnungID'], $_POST['formData']);

    // Neue Abrechnung Erstellen
    } else {
        $result = $vertraegeAbrechnung->new($_POST['additional']['id'], $_POST['formData']);
    }


    // $req->adapt($result);
    $req->echoAnswer($result);

    
}

// Holt alle Abrechnungspositionen
else if($_POST['task'] == 'loadAbrechnungTable') {

    $req = new Request();

    $result = $vertraegeAbrechnung->getByVertragsID($_POST['data']);

    // $req->adapt($result);
    $req->echoAnswer($result);
}



// ******************************************************************
// Verträge Details --- Neu
// ******************************************************************

// ******************************************************************
// Verträge Details Adressen --- Neu

// Verträge Adressen Submit
else if($_POST['task'] == 'vertraegeAdressenSubmit') {

    $req = new Request();

    $data = $vertraege->editAdressen($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($data);
    $req->echoAnswer();
}


// Load Verträge Adressen
else if($_POST['task'] == 'loadAdressen') {

    $req = new Request();

    $data = $vertraege->getAdressen($_POST['data']);

    // Wenn die Abfrage erfolgreich war -- Setzt es das Select der Adresse
    if ($data['success']) {
        
        $data['data']['vn_adresse'] = $req->mergeForList($data['data']['vertragsnehmerID'], $data['data']['vn_name']);
        $data['data']['lf_adresse'] = $req->mergeForList($data['data']['lieferadresseID'], $data['data']['lf_name']);
    }

    $req->adapt($data);
    $req->echoAnswer();
}

// ******************************************************************
// Verträge Details Stammdaten --- Neu

else if($_POST['task'] == 'loadStammdaten') {

    $req = new Request();

    $result = $vertraege->getStammdaten($_POST['data']);

    // Wenn die Abfrage erfolgreich war -- Setzt es das Select der Adresse
    if ($result['success']) {

        $result['data']['sachbearbeiter_id'] = $result['data']['sachbearbeiterVorname']." ".$result['data']['sachbearbeiterNachname'];
        $result['data']['authorisierer_id'] = $req->mergeForList($result['data']['geschaeftsfuehrerID'], $result['data']['geschaeftsfuehrerVorname']." ".$result['data']['geschaeftsfuehrerNachname']);
        $result['data']['sachbearbeiterkunde_id'] = $req->mergeForList($result['data']['sachbearbeiterKundeID'], $result['data']['sachbearbeiterKundeVorname']." ".$result['data']['sachbearbeiterKundeNachname']);
        $result['data']['vorlagen_id'] = $req->mergeForList($result['data']['vorlagenID'], $result['data']['vorlagenBezeichnung']);

    }

    $req->adapt($result);
    $req->echoAnswer();
}

else if($_POST['task'] == 'submitStammdaten') {

    $req = new Request();

    $result = $vertraege->editStammdaten($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($result);
    $req->echoAnswer();
}

else if($_POST['task'] == 'changeVorlage') {

    $req = new Request();

    $result = $vertraege->changeVorlage($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();
}

// Wenn die Laufzeiten abgeschickt werden
else if($_POST['task'] == 'submitLaufzeiten') {

    $req = new Request();

    $result = $vertraege->editLaufzeiten($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($result);
    $req->echoAnswer();
}

// Wenn die Kosten abgeschickt werden
else if($_POST['task'] == 'submitKosten') {

    $req = new Request();

    $result = $vertraege->editKosten($_POST['additional']['id'], $_POST['formData']);

    $req->adapt($result);
    $req->echoAnswer();

}

// Lädt die Klauseln mit den Gruppen
else if ($_POST['task'] == 'loadKlauselnWithGroups') {

    $req = new Request();

    $result = $vertraege->klauselPreview($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();

}

// Lädt die Klauseln mit den Gruppen
else if ($_POST['task'] == 'loadKlauselnWithGroupsVorlagen') {

    $req = new Request();

    $result = $vertraegeVorlagen->klauselPreview($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();

}

// Gruppen Reihnefolge ändern
else if($_POST['task'] == 'positionen-shift') {

    //
    $success = $error = false;

    $request = new Request();

    $result = $vertraegeGruppen->posShift($_POST);
    
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

}

// eine Neue Position wird zu dem vertrag hinzugefügt 
else if($_POST['task'] == 'submitPositionenIdent') {

    $req = new Request();

    $result = $vertraegePos->newIdentPos($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();

}

// Wenn eine Positon gelöscht werden soll
else if($_POST['task'] == 'deletePositionen') {

    $req = new Request();

    $result = $vertraegePos->delete($_POST['data']);

    $req->adapt($result);
    $req->echoAnswer();

}

// Lädt alle Daten zu einer Position
else if($_POST['task'] == 'getPositionen') {

    $req = new Request();

    $result = $vertraegePos->getPositionen($_POST['data']);

    // $result['data'] = $result['data'][0];

    $req->echoAnswer($result);

}

// Wenn eine Position editiert wird
else if($_POST['task'] == 'submitPositionenForm') {

    $req = new Request();

    // Wenn es eine ID gibt
    if(isset($_POST['additional']['id']) && $_POST['additional']['id'] > 0) {
        $result = $vertraegePos->edit($_POST['additional']['id'], $_POST['formData']);
    }

    $req->echoAnswer($result);

}

// Vertrag auf Aktiv setzen
else if($_POST['task'] == 'vertragAktivieren') {

    $req = new Request();

    $result = $vertraege->vertragAktivieren($_POST['additional']['id'], $_POST['formData']);

    $req->echoAnswer($result);

}

else if($_POST['task'] == 'kundenUnterschrift') {

    $req = new Request();

    $result = $vertraege->kundenUnterschrift($_POST['data']);

    $req->echoAnswer($result);

}

// Lädt Alle Zähler die es in den Positionen gibt
else if($_POST['task'] == 'loadZaehler') {

    $req = new Request();

    $result = $vertraegePos->getZaehler($_POST['data']);

    $req->echoAnswer($result);

}




































?>