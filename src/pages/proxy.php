<?php

/**
 * PROXY
 * 
 * Der Proxy soll zum aufrufen verschiedene Dateien dienen
 * Wenn zum Beispiel eine Download eines Dokuments stattfinden soll, wird zunächst der Proxy angesprochen.
 * 
 * Dieser prüft dann ob der Benutzer angemeldet ist und die entsprechende Berechtigung auf das Dokument hat
 * Ist das der Fall, dann erhält er Zugriff auf dieses Dokument.
 * 
 * 
 */

 // $file = $_GET['file'];

$file = "data/documents/archive/lieferscheine/lieferschein_300000.pdf";

// Prüfen ob GET FILE definiert ist
if(isset($file) && $file) {

    // 
    $url = $file;
    $path_parts = pathinfo($url);
    
    // print_r($path_parts);


    $ext = $path_parts['extension'];
    $filename = $path_parts['basename'];

    header("Content-type: application/pdf");
    header("Content-Disposition: inline; filename=".$path_parts['basename']);
    @readfile($file);

    /*

    header("Content-type: application/$ext");
    header("Content-Disposition: attachment; filename=$filename");
    
    echo file_get_contents($url);

    */

} else {
    echo "ERROR: Es wurde keine Datei angegeben!";
}