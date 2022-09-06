<?php include($_SERVER["DOCUMENT_ROOT"].'/01_init.php'); 




/**
 * Klasse für die Kontakte Quickselect
 */
class KontakteQuickselect extends Quickselect {

    // Text rendern
    public function renderText($fields, $row, $schema, $primary) {
        $pieces = [];

        // Geschlecht
        if($row['geschlecht'] && ($row['geschlecht'] == 'F' || $row['geschlecht'] == 'M')) {
            $geschlecht = ['F' => 'Frau', 'M' => 'Herr'];
            $pieces[] = $geschlecht[$row['geschlecht']];
        }

        // Titel, wie Dr. Prof. usw
        if($row['titel']) {
            $pieces[] = $row['titel'];
        }

        // Vor- und Nachname
        $pieces[] = ($row['vorname']) ? $row['vorname']." ".$row['nachname'] : $row['nachname'];

        // Icons
        $pieces[] = "<span style='float:right;padding-right: 10px;opacity:0.5'>";
        $pieces[] = "<i class=\"fa-solid fa-envelope ".(($row['email']) ? 'text-success' : 'text-danger')."\"></i>";
        $pieces[] = ($row['telefon']) ? "<i class=\"fa-solid fa-phone-flip text-success\"></i>" : "<i class=\"fa-solid fa-phone-slash text-danger\"></i>" ;
        $pieces[] = "</span>";

        return implode(" ",$pieces);   
    }
}


// Ausgabe
$q = new KontakteQuickselect($_GET);

$q->createComplete("kontakte", ["geschlecht", "vorname", "nachname", "titel", "telefon", "email"], "id");

?>