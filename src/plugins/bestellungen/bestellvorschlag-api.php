<?php

class Bestellvorschlag {

    function __construct() {

    }

    /**
     * Bestellvorschlag erstellen
     * 
     * Optionen 
     * - mit Auftragsbestand
     * - mit Minimal und Maximal Beständen
     * - nur Hauptlager
     * 
     */
    function create($opts = []) {


        // Optionen abgleichen

        // 
        $artikel = $this->getArtikelBestaende();

        // 
        $auftrag = $this->getAuftragsBestaende();


    }

    // Artikelbestände
    function getArtikelBestaende() {

        global $db;

        // Select Query
        $query = "SELECT a.id, a.bezeichnung, a.auto_bestand_aktiv, a.auto_bestand_min, a.auto_bestand_max, ab.bestand, ab.kommission, ab.bestellt 
            FROM `artikel` a
            LEFT JOIN `artikel_bestand` ab ON a.id = ab.artikel_id AND ab.lager_id = 1
            WHERE `a`.`bestandsfuehrung` = '1' ";
        
   
        // Datenbank Abfrage
        $result = $db->query($query);


        // Alle mit Bedarf
        $bedarfArtikel = [];


        // Prüfen ob ein Ergebnis da ist
        if($result->num_rows > 0) {
            
            // Ergebnis
            while($row = $result->fetch_assoc()) {
        
                // Bedarf initalsiieren
                $row['bedarf'] = 0;

                // Normalisieren, falls kein Datenbank-Eintrag gefunden wurde
                $row['bestand'] = (!$row['bestand']) ? 0 : $row['bestand'];
                $row['kommission'] = (!$row['kommission']) ? 0 : $row['kommission'];
                $row['bestellt'] = (!$row['bestellt']) ? 0 : $row['bestellt'];

                // Automatischer Bestand
                if($row['auto_bestand_aktiv'] == 1 && intval($row['auto_bestand_min']) > 0 && $row['bestand'] < $row['auto_bestand_min']) {
                    
                    // Wenn ein Maximalbestand gefüllt ist
                    $max =(!$row['auto_bestand_max']) ? $row['auto_bestand_min'] : $row['auto_bestand_max'];

                    // Neuen Bedarf
                    $row['bedarf'] = $max - $row['bestand'];
                }

                if($row['bedarf'] > 0) {
                    $bedarfArtikel[] = $row;
                }
            }


        }

        // Bedarf Artikel zurückgeben
        return $bedarfArtikel;
    }

    function getAuftragsBestaende() {

        global $db;

        // Select Query
        $query = "
        SELECT p.*
            FROM `positionen` p
            LEFT JOIN `auftraege` a ON p.auftrag_id = a.id
            WHERE a.status_id = 2;            
        ";

        echo $query;

        // Datenbank Abfrage
        $result = $db->query($query);

        // Prüfen ob ein Ergebnis da ist
        if($result->num_rows > 0) {
            
            // Ergebnis
            while($row = $result->fetch_assoc()) {


                print_r($row);

            }

        }
    }
}
?>