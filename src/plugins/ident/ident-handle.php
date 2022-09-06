<?php require_once("01_init.php");

// Request
$req = new Request($_POST);
$ident = new Ident();


if($_POST['task'] == 'load') {
    $result = $ident->get($req->data['data']);

    // 
    $result['data']['be_name'] = $req->mergeForList($result['data']['betreiber_id'], $result['data']['be_name']);
    $result['data']['re_name'] = $req->mergeForList($result['data']['rechnungsempfaenger_id'], $result['data']['re_name']);
    $result['data']['artikel'] = $req->mergeForList($result['data']['artikel_id'], $result['data']['artikel_bezeichnung']);

    $req->adapt($result);
    $req->echoAnswer();
} else if($_POST['task'] == 'get-link') {
    $result = $ident->getLink($req->data['data']);
    $req->adapt($result);
    $req->echoAnswer();
}











?>