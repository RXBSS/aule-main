<?php include('./../../../01_init.php');



// Eigene Klasse erstellen
class Positions extends Dt {

    // Die Spezialfunktion überschreiben
    public function editSpecialColumn($dbResultData, $fieldname, $config) {


        $value = "";

        // Wenn es mehrere Spezialfelder gibt, dann wird für alle die gleiche Funktion aufgerufen
        switch ($fieldname) {

                // Name des Spezialfelds
            case "netto_gesamt":

                $value = $dbResultData['netto'] * $dbResultData['menge'];
                break;

                // Name des Spezialfelds
            case "brutto_einzel":

                // Custom PHP Code
                $value = "b";
                break;

                // Name des Spezialfelds
            case "brutto_gesamt":

                // Custom PHP Code
                $value = "c";
                break;

                // Name des Spezialfelds
            case "bestand":
                $value = $this->getBestand($dbResultData, $fieldname, $config);
                break;

                // Name des Spezialfelds
            case "bestellt":
                $value = $this->getBestellt($dbResultData, $fieldname, $config);
                break;
        }

        // Rückgabe ist wichtig, sonst wird nicht angezeigt!
        return $value;
    }

    // Die Spezialfunktion überschreiben
    public function editCustomColumnAfter($row, $key, $value, $default) {  
        
        if($key == 'geliefert') {

            // Status in Liste anzeigen
            $status = ($row['_geliefert'] > 0) ? (($row['_menge'] == $row['_geliefert']) ? 2 : 1) : 0;

            $array = [
                '<i class="fa-solid fa-circle text-danger inline-icon"></i>',
                '<i class="fa-solid fa-circle text-warning inline-icon"></i>',
                '<i class="fa-solid fa-check text-success inline-icon"></i>'
            ];

    
            $default = $array[$status]." ".$default;
        }

        return $default;
    }


    // Den Bestand auslesen
    // ACHTUNG: Diese Funktion erzeugt großen Rechenlast und sollte nur mit Filter benutzt werden!
    public function getBestand($dbResultData, $fieldname, $config) {

        $artikelApi = new Artikel();

        // TODO: Ggf. noch das Lager hinterlegen
        $bestand = $artikelApi->getBestandVerfuegbar($dbResultData['_artikel_id']);

        return $bestand;
    }

    // Den Bestand auslesen
    // ACHTUNG: Diese Funktion erzeugt großen Rechenlast und sollte nur mit Filter benutzt werden!
    public function getBestellt($dbResultData, $fieldname, $config) {

        // TODO: Muss noch ausgelesen werden

        return 0;
    }



}



// Get Variable übergeben
$dt = new Positions($_GET, "auftraege_positionen");

// Add Filter;
$dt->fixedFilter = "`auftraege_positionen`.`auftrag_id` = '" . $_GET['additional'] . "'";

// Verarbeiten
$dt->process();

// Output
$dt->output();
