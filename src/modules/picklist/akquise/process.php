<?php include('./../../../01_init.php');


class DtAkquise extends Dt {

    public function editCustomColumn($row, $key, $value, $default) {

        // Wenn keine Aktion dem Kunden zugeordnet wurde
        if($key == 'aktion_id') {
            if($default == null) {
                $default = "<i><strong> Keine Aktion </strong></i>";
            }
        }
        
        // 
        else if($key == 'kundentermin' || $key == 'wiedervorlage') {

            if($default == null ) {
                $default = "<i>Kein Termin</i>";
            } else if ($default !== null && $key == 'kundentermin' ) {
                $dateKundentermin = new DateTime($row['_kundentermin']);
                $default = $dateKundentermin->format("d.m.Y");

            } else if ($default !== null && $key == 'wiedervorlage' ) {

                $dateWiedervorlage = new DateTime($row['_wiedervorlage']);
                $default = $dateWiedervorlage->format("d.m.Y");

            }
        }

        // Status
        else if($key == 'status') {
            if($default == '0') {
                $default = "<i class='fa-solid fa-hourglass text-info'></i> Offen";
            } else if($default == '1') {
                $default = "<i class='fa-solid fa-thumbs-up text-primary'></i> Erfolgreich";
            } else if($default == '2') {
                $default = "<i class='fa-solid fa-thumbs-down text-danger'></i> Nicht Erfolgreich";
            } else if($default == '3') {
                $default = "<i class='fa-solid fa-trash'></i> Gelöscht";
            }
        }

        else if($key == 'kundenterminTage' || $key == 'tage') {

            if($row['_kundentermin'] == null || $row['_wiedervorlage'] == null) {
                $default = "<i style='font-weight:bold'>Kein Termin</i>";
            }
        }

        // Fügt den vollen Name vollständig an
        else if($key == 'vorname') {
            $default = $row['_vorname'].' '.$row['_nachname'];
        }
        
        if (($key == 'tage' && $row['_wiedervorlage'] != null) || ($key == 'kundenterminTage' && $row['_kundentermin'] != null)) {

            $date = "";

            if($key == 'tage') {
                $date = $row['_wiedervorlage'];
            } else if ($key == 'kundenterminTage') {
                $date = $row['_kundentermin'];
            }

            // Aktuelles Datum
            $zeitstempel = new Datetime();

            // auf die Teile des Objektes zugreifen -> nich möglich da Funktionen damit wie ->format()...
            $objToArr = (array) $zeitstempel;

            // Aufteilen und dann nur das Datum herausnehmen
            $resZeitstempel = explode(" ", $objToArr['date'])[0];

            // Wiedervorlage Datum - Gleiche wie Oben
            $wiedervorlage = new Datetime($date);
            $objToArr2 = (array) $wiedervorlage;
            $reswiedervorlage = explode(" ", $objToArr2['date'])[0];

            // Aktuell Datum Datetime wieder erstellen
            $date1 = date_create($resZeitstempel);

            // Wiedervorlage Datum Datetime wieder erstellen
            $date2 = date_create($reswiedervorlage);


            // Erstellt Objekt Differenz
            $dateDiff = date_diff($date1, $date2);

            // Gibt die Variablen der Objekts zurück    
            // $objectToArray = get_object_vars($dateDiff);

            $formatDate = $dateDiff->format('%a');

            // echo "<pre>";
            // print_r($formatDate." ");
            // print_r($dateDiff->invert);
            // echo "</pre>";
            // die();

            // die Tage sind gleich 
            // aber man muss auf das invert gehen
            // bei negativ ist invert auf 1 gesetzt und bei positive differenz ist invert 0

            // Wenn die Wiedervorlage älter ist als heute
            if($formatDate > 0 && $dateDiff->invert) {
                $default = "<strong class='text-danger'>".$dateDiff->format('+ %a')."</strong>" ;
            }

            // Wenn die Wiedervorlage heute ist
            else if ($formatDate == 0 && $dateDiff->invert == 0) {
                $default = "<strong class='text-warning'> Heute </strong>";

                // $default = "<strong class='text-primary'>".$dateDiff->format('%a')."</strong>" ;
            }

            // Wenn die Wiedervorlage noch Zeit hat
            else {
                $default = "<strong class='text-primary'>".$dateDiff->format('- %a')."</strong>" ;

            }
        }
        

        

        return $default;

    }
}


// Get Variable übergeben
$dt = new DtAkquise($_GET , "akquise");

// echo "<pre>";
// print_r($_GET['additional']);
// echo "</pre>";
// die();

// Das ist für für die Details Seite
if(isset($_GET['additional'])) {
    $dt->fixedFilter = "`akquise_aktionen`.`id` = '".$_GET['additional']."' ";

// Additional nicht auf der Hauptseite
} else {

    // Alle die !!! NICHT !!! Entwurf sind sind sichtbar ODER die Halt keine Aktion haben
    $dt->fixedFilter = "`akquise_aktionen`.`entwurf` = 1 || `akquise`.`aktion_id` IS NULL";
}


// Verarbeiten
$dt->process();

// Output
$dt->output();





?>