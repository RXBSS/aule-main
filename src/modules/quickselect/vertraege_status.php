<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);


global $db;

$array = [];


// Abfrage nur Geschäftsführer
$query = "
    SELECT *
    FROM `status` s
    WHERE s.bereich = 'vertraege_vorlagen';
";

// echo "<pre>";
// print_r($query);
// echo "</pre>";
// die();

// Datenbank Abfrage
$result = $db->query($query);

// Prüfen ob ein Ergebnis da ist
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $array[] = [
            'id' => $row['status_id'], 'text' => $row['icon']." ".$row['bezeichnung']
        ];
    }
}

// Rückgaba
$q->outputDataAsJson($array);


// $q->createComplete("mitarbeiter", ["vorname", "nachname"], "id");

?>