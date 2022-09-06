<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// echo "<pre>";
// print_r($_GET);
// echo "</pre>";

// die();

// Field
// $field = ""

// Value

// Ausgabe
$q = new Quickselect($_GET);

global $db;

$array = [];

// // Wenn Kein Filter gesetzt wurde -- Fehlermeldung das eine Auswahl getroffen werden muss
// if($_GET['filter'] == 'false') {

//     $array[] = [
//         'text' => 'Treffen Sie eine Auswahl bei den Adressen'
//     ];

// }

// Wenn die Checkbox auf nicht Filter gesetzt ist dann alle Auswählen
if($_GET['filter'] == 'false' || ($_GET['filter']['name'] == 'checkbox' && $_GET['filter']['value'] == 'false')) {

    // Query
    $query = "
        SELECT id, vorname, nachname, geschlecht
        FROM `kontakte`
    ";

    // Datenbank Abfrage
    $result = $db->query($query);


} else {

    // Query
    $query = "

        SELECT k.id as id , k.vorname as vorname, k.nachname as nachname, k.geschlecht as geschlecht
        FROM `adressen_kontakte` ak
        LEFT JOIN `kontakte` k ON k.id = ak.kontakte_id

        ".( ($_GET['filter']['value']) ? "WHERE ak.".$_GET['filter']['name']." = '".$_GET['filter']['value']."'" : "" ).";
        

    "; 


    // Datenbank Abfrage
    $result = $db->query($query);
}




$text = "";

/**
 * RESULT DB HIER ---- WENN ES EINE DATENBANK ABFRAGE GAB
 */

// Wenn es kein Ergebnis gibt
if(isset($result->num_rows) && $result->num_rows == 0){

    $array = [];

    // Wenn ein Filter gesetzt ist aber einfach keine Daten vorhanden sind
    $array[] = [
        'text' => 'Keine Kontakte vorhanden'
    ];
    
}

// Wenn es ein Ergebnis gibt
else if(isset($result->num_rows) && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

        if(!$row['vorname']) {
            if($row['geschlecht'] == 'H') {
                $text = "Herr ".$row['nachname'];
            } else if ($row['geschlecht'] == 'F') {
                $text = "Frau ".$row['nachname'];
            }
        } else {
            $text = $row['vorname']." ".$row['nachname'];
        }

        $array[] = [
            'id' => $row['id'], 
            'text' => $text
        ];
    }
}


$q->outputDataAsJson($array);
