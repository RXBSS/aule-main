<?php require_once("01_init.php");

// Request
$req = new Request();

// API ausführen
$api = new $_POST['data']();
$api->run();

// Success
// $req->success = true;
// $req->echoAnswer();

?>