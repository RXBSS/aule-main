<?php include('./../../../01_init.php');




// Eigene Klasse erstellen
class DtAuftraegeLieferungen extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {



        if ($key == 'status_name') {
            $default = $row['_status_icon'] . " " . $default;
        } else if ($key == 'show_document') {
            $default = "<a class='btn-lieferschein-anzeigen' data-id='" . $row['_id'] . "' href='javascript:void(0);'><i class='fa-solid fa-file-pdf'></i> Lieferschein</a>";
        }

        return $default;
    }
}


// Get Variable übergeben
$dt = new DtAuftraegeLieferungen($_GET, "auftraege_lieferungen");

// Verarbeiten
$dt->process();

// Output
$dt->output();
