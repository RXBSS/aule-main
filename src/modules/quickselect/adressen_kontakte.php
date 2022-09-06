<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 

// Ausgabe
$q = new Quickselect($_GET);

$req = new Request();



// Wenn Der Filter Gesetzt ist 
if(isset($_GET['filter']) && $_GET['filter']['name'] == 'kontakte_id_vertraege') {

    // QUery
    $query = "
        SELECT v.vn_adresse
        FROM `vertraege` v
        WHERE v.id = '".$_GET['filter']['value']."'
    ";

    // Abrfrage
    $req->getMultiQuery($query);

    // Wenn Success
    if($req->success) {

        $queryAdressenKontakte = "
            SELECT ak.kontakte_id, ak.adressen_id, k.*
            FROM `adressen_kontakte` ak
            LEFT JOIN `kontakte` k ON k.id = ak.kontakte_id
            WHERE ak.adressen_id = '".$req->result[0]['vn_adresse']."';
            
        ";

        // Datenbank Abfrage
        $result = $db->query($queryAdressenKontakte);

       
    }

}



// Prüfen ob ein Ergebnis da ist
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $array[] = [
            'id' => $row['id'], 'text' => $row['vorname']." ".$row['nachname']
        ];
    }

// Keine Daten vorhanden
} else {

    // Wenn ein Filter gesetzt ist aber einfach keine Daten vorhanden sind
    $array[] = [
        'text' => 'Keine Kontakte vorhanden'
    ];
}

// Rückgaba
$q->outputDataAsJson($array);

?>