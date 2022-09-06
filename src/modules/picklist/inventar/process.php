<?php include('./../../../01_init.php');

class DtAkquise extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {

        // Global
        if($row['_abschreibezeitraum']) {
            // Erstellt ein neues Kaufdatum -- Datetime
            $kaufdatum = new DateTime($row['_kaufdatum']);

            // Fügt den Abschreibezeitraum hinzu
            $enddatum = $kaufdatum->add(new DateInterval("P".$row['_abschreibezeitraum']."Y"));

            // Formatiert das Datum richtig
            $enddatum = $enddatum->format('d.m.Y');
        }

        // Wenn das Feld Kaufpreis ist
        if($key == 'kaufpreis') {
            
            // Neue kaufpreis Formatieren
            $default = $default." €";
        }

        // Wenn das Feld beschreibung ist
        else if($key == 'beschreibung') {
            
            // Wenn das Feld leer ist
            $default = ((!$default) ? "<i>Keine Beschreibung</i>" : $default);

        } 


        // Wenn es keine Abschreibung gibt
        else if($key == 'abschreibedatum') {

            // Wenn das Feld leer ist
            $default = ((!$default) ? "<i>Keine Abschreibung</i>" : $default);

            // Wenn es Ein Abschreibe Zeitraum Gibt
            if($row['_abschreibezeitraum']) {
               
                // Formatiert das Datum richtig
                $default = $enddatum;

            }
        }

        // Wenn es keine Abschreibung gibt
        else if($key == 'uebrigeZeit') {

            // Wenn das Feld leer ist
            $default = ((!$default) ? "<i>Keine Abschreibung</i>" : $default);

            if($row['_abschreibezeitraum']) {

                // Enddatum
                $enddatumDateTime = new DateTime($enddatum);

                // Kaufdatum
                $kaufdatum = new DateTime($row['_kaufdatum']);

                // Differenze zwischen Kaufdatum und Enddatum
                $test = $kaufdatum->diff($enddatumDateTime);

                $default = $test->days." Tage";

            }

        }

        // Wenn es keine Abschreibung gibt
        else if($key == 'seriennummer') {

            // Wenn das Feld leer ist
            $default = ((!$default) ? "<i>Keine Seriennummer</i>" : $default);

        }

        // Fügt den vollen Name vollständig an
        else if($key == 'vorname') {
            $default = $row['_vorname'].' '.$row['_nachname'];
        }

        // Fügt den vollen Name vollständig an
        else if($key == 'vorname2') {

            // Wenn es einen Nutzer gibt
            if($default) {
                $default = $row['_vorname2'].' '.$row['_nachname2'];
            }

            // Gibt keinen Nutzer
            else {
                $default = "<b>Kein Nutzer</b>";
            }
        }

        // Wenn Nutzer Name 
        else if ($key == 'verleih') {


            // Wenn es einen Nutzer ID -- Also Verliehene Person gibt 
            if($row['_nutzer_id'] > 0) {
                $default = "<b>Nicht Verfügbar</b>";
            } 

            // Objekt wurde nicht verliehen
            else {
                $default = "<b>Verfügbar</b>";
            }

        }

        return $default;

    }

}

// Get Variable übergeben
$dt = new DtAkquise($_GET , "inventar");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>