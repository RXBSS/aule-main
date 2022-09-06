<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);


global $db;



// 
$array = [];

// Select Query
$query = "
    SELECT id, herstellernummer, bezeichnung 
    FROM `artikel` ".$q->getWhereQuery(['id', 'herstellernummer', 'bezeichnung']);


// Datenbank Abfrage
$result = $db->query($query);

// Prüfen ob ein Ergebnis da ist
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $array[] = [
            'id' => $row['id'], 'text' => $row['id']." | ".$row['herstellernummer']." | ".$row['bezeichnung']
        ];
    }
}

// Select Query
$query = "
    SELECT l.nummer, l.artikel_id, a.lieferant_bezeichnung, aa.herstellernummer, aa.bezeichnung
    FROM `artikel_lieferantennummern` l
    LEFT JOIN `adressen` a ON l.lieferant_id = a.id
    LEFT JOIN `artikel` aa ON l.artikel_id = aa.id

    ".$q->getWhereQuery(['nummer']);


// Datenbank Abfrage
$result = $db->query($query);

// Prüfen ob ein Ergebnis da ist
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $array[] = [
            'id' => $row['artikel_id'], 'text' => $row['lieferant_bezeichnung'].": ".$row['nummer']." | ".$row['herstellernummer']." | ".$row['bezeichnung']
        ];
    }
}

$q->outputDataAsJson($array);


?>