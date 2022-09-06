<?php require_once("01_init.php");


// Request
$_req = new Request($_POST);

// API Verbindung herstellen
$_api = new Auftrag();

// Details Handler einfügen
include('details-handle.php');

// Positionen Handler einfügen
include('positionen-handle.php');


/*





if ($_POST['task'] == 'entwurf-erstellen') {

    // Ergebnis
    $result = $_api->new($_SESSION['user']['id']);

    // Nur wenn es erfolgreich angelegt wurde!
    if ($result['success']) {
        $_api->history->write('create', $result['data'], $_SESSION['user']['id']);
    }

    // Ergebnis
    $_req->adapt($result);
    $_req->echoAnswer();
    
} else if ($_POST['task'] == 'entwurf-validieren') {

    $result = $_api->entwurfValidieren($_req->data['data']);

    // Ergebnis
    $_req->adapt($result);
    $_req->echoAnswer();

} else if ($_POST['task'] == 'load') {

    $result = $_api->get($_req->data['data']);

    if ($result['success']) {

        $result['data']['lf_name'] = $_req->mergeForList($result['data']['lf_id'], $result['data']['lf_name']);
        $result['data']['re_name'] = $_req->mergeForList($result['data']['re_id'], $result['data']['re_name']);
        $result['data']['besteller'] = $_req->mergeForList($result['data']['besteller_id'], $result['data']['besteller_name']);
        $result['data']['kostenstelle_id'] = $_req->mergeForList($result['data']['kostenstelle_id'], $result['data']['kostenstelle_id'] . " " . $result['data']['kostenstelle_name']);
        $result['data']['zahlungsbedingung'] = $_req->mergeForList($result['data']['zahlungsbedingung_id'], $result['data']['zahlungsbedingung_bez']);
    }

    // 
    echo json_encode($result);
} else if ($_POST['task'] == 'get-adresse') {

    // 
    $adressenApi = new Adressen();

    $_req->success = true;
    $_req->result = $adressenApi->get($_req->data['data']);

    // Ergebnis
    $_req->adapt($_req->result);
    $_req->echoAnswer();

    // $_req->echoAnswer($_req->result);
} else if ($_POST['task'] == 'auftrag-erstellen') {

    // Auftrag Prozess
    $result = $_api->entwurfWirdAutrag($_req->data['data']);

    // Nur wenn es erfolgreich angelegt wurde!
    if ($result['success']) {
        $_api->history->write('process', $_req->data['data'], $_SESSION['user']['id']);
    }

    // Ergebnis
    $_req->adapt($result);
    $_req->echoAnswer();

    // Löschen
} else if ($_POST['task'] == 'entwurf-loeschen') {

    // Auftrag löschen
    echo json_encode($_api->delete($_req->data['data']));

    // Speichern
} else if ($_POST['task'] == 'entwurf-speichern') {

    $_req->data['formData']['lieferanschrift_id'] = $_req->data['formData']['lf_name']['value'];
    $_req->data['formData']['rechnungsanschrift_id'] = $_req->data['formData']['re_name']['value'];
    $_req->data['formData']['zahlungsbedingung_id'] = $_req->data['formData']['zahlungsbedingung']['value'];

    // Rückgabe
    echo json_encode($_api->edit($_req->data['additional']['id'], $_req->data['formData']));

    // Entwurf wird Auftrag
} else if ($_POST['task'] == 'entwurf-wird-auftrag') {

    $_req->success = true;
    $_req->echoAnswer();

    // Drucken
} else if ($_POST['task'] == 'print-preview') {



    // Neue Rechnung erstellen

    // $r = new RechnungDocs([
    //     'watermark' => false,
    //     'letterhead' => true,
    //     'archive' => false
    // ]);

    // $_req->result = $r->save(true);
    // $_req->success = true;
    // $_req->echoAnswer();

  


    // Historie laden
} else if ($_POST['task'] == 'load-historie') {


    // Übernehmen
    $result = $_api->history->getByReference($_req->data['data']);
    $_req->adapt($result);
    $_req->echoAnswer();



    // Verschiben
} else if ($_POST['task'] == 'positionen-shift') {

    $id = $_req->data['data']['id'];
    $colId = $_req->data['data']['colId'][0];
    $direction = $_req->data['data']['direction'];

    // Positionen
    $pos = $_api->pos->getAllById($id);
    $result = $_api->pos->shift($pos, $direction, $colId);


    $_req->success = true;
    $_req->echoAnswer();


    // Summe der Positionen errechnen
} else if ($_POST['task'] == 'positionen-summe') {

    $result = $_api->pos->getSum($_req->data['data']);
    $_req->success = $result['success'];
    $_req->result = $result['data'];
    $_req->echoAnswer();


    // Position hinzufügen
} else if ($_POST['task'] == 'positionen-add') {

    // Neue Position erstellen
    $result = $_api->setNewPositions($_req->data['data']['id'], $_req->data['data']['artikel']);
    $_req->echoAnswer($result);

    // Position laden
} else if ($_POST['task'] == 'positionen-load') {

    // Auftragspositionn auslesen
    $result = $_api->pos->getByPosId($_req->data['data']);
    echo json_encode($result);

    // Edit
} else if ($_POST['task'] == 'positionen-save') {

    // Abfangen, Multi Edit

    $result = $_api->editPosition($_req->data['formData']['id'], $_req->data['formData']);
    $_req->adapt($result);
    $_req->echoAnswer();

    // Löschen
} else if ($_POST['task'] == 'positionen-delete') {

    $result = $_api->deletePositions($_req->data['data']);
    $_req->adapt($result);
    $_req->echoAnswer();


    // Löschen
} else if ($_POST['task'] == 'get-lieferstatus') {

    $result = $_api->getLieferStatus($_req->data['data']);


    $_req->adapt($result);
    $_req->echoAnswer();

    // Löschen
} else if ($_POST['task'] == 'lieferung-neu') {

    // Den aktuellen Lieferstatus auslesen
    // TODO: Hier kann der JS Teil ggf. noch von PHP mit übernommen werden, wenn die Funktion den Lieferstatus prüft. Dies wird sowieso für eine andere Funktion benötigt.
    $result = $_api->getLieferStatus($_req->data['data']);


    // print_r($result);
    // die();

    // Zurücksetzen der alten Lieferwerte
    $_api->pos->changeColumn($_api->pos->getAllById($_req->data['data']), "liefern", 0);

    $_req->adapt($result);
    $_req->echoAnswer();
} else if ($_POST['task'] == 'lieferung-erstellen') {

    // Mit Vorschlag erstellen
    $result = $_api->Lieferungen->createWithVorschlag($_req->data['data'], $_SESSION['user']['id']);

    $_req->adapt($result);
    $_req->echoAnswer();
} else if ($_POST['task'] == 'automatisch-liefern') {

    // Ergebnis
    $result = $_api->automatischLiefern($_req->data['data']['id'], $_req->data['data']['teillieferung'] == 'true');
    $_req->adapt($result);
    $_req->echoAnswer();


} else if ($_POST['task'] == 'rechnung-erstellen') {

    // Ergebnis
    $result = $_api->rechnungErstellen($_req->data['data']);
    $_req->adapt($result);
    $_req->echoAnswer();


    // Show Document
} else if ($_POST['task'] == 'show-document') {

    // Proxy erstellen
    $proxy = new Proxy();
    $result = false;

    if ($_req->data['data']['docType'] == 'lieferschein') {

        $_req->success = true;

        $lieferschein = new LieferscheinDoc($_req->data['data']['docId']);


        $linkResult = $lieferschein->getLink();

        if ($linkResult) {
            $result = ($_req->data['data']['docLetterhead'] == 'true') ? $linkResult['data']['letterhead'] : $linkResult['data']['print'];
        } else {
            $_req->adapt($linkResult);
        }
    } else {
        $_req->error = "Unbekannter Dokumententyp";
    }

    if ($result) {

        // Ergebnis    
        $_req->result = $proxy->encode($result);
    }

    $_req->echoAnswer();
}

*/