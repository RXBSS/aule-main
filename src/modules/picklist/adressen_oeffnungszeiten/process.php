<?php include('./../../../01_init.php');


// Eigene Klasse erstellen
class OeffnungszeitenPicklist extends Picklist {

    // Die Spezialfunktion überschreiben
    public function editSpecialColumn($row, $field, $defs) {
        
        // Standard definieren, falls nichts zutrifft
        $result = "";

        switch ($field) {

            // Tage als Mo, Di, ... Ausgeben
            case "tag2":
                // $tage = [null, "Mo", "Di", "Mi", "Do", "Fr", "Sa", "So"];
                $tage = [null, 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag','Freitag','Samstag','Sonntag'];
                $result = $tage[$row['_tag']];
                break;

            // Kombination aus Von1 und Bis1 anzeigen oder geschlossen
            case "zeit1":
                if ($row['_offen'] == 1) {
                    $result = substr($row['_von1'], 0, 5) . " - " . substr($row['_bis1'], 0, 5);

                    // Wenn zweite Öffnungszeiten vorhanden sind
                    if ($row['_von2']) {
                        $result .= " | ".substr($row['_von2'], 0, 5) . " - " . substr($row['_bis2'], 0, 5). " Uhr";
                    }

                    if(!$row['_von2']) {
                        $result .= " Uhr";
                    }
                } else {
                    $result = "Geschlossen";
                }
                break;
        }

        // Den aktuellen Tag in Fett-Buchstaben ausgeben
        return ($result && date('N') == $row['_tag']) ? "<strong>".$result."</strong>" : $result;
        
    }
}


// Get Variable übergeben
$dt = new OeffnungszeitenPicklist($_GET , "adressen_oeffnungszeiten");

// Add Filter
$dt->fixedFilter = "`adressen_oeffnungszeiten`.`adressen_id` = '".$_GET['additional']."'";

// Verarbeiten
$dt->process();

// Output
$dt->output();


?>