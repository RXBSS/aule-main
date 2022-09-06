<?php require_once("01_init.php");


$req = new Request($_POST);


if($_POST['task'] == 'create') {

    $req->success = true;


    $req->result = [
        'test' => 1
    ];

    $req->echoAnswer();

}












?>