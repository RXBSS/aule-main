<?php include('./../../../01_init.php');





// Eigene Klasse erstellen
class DtArtikel extends Dt {

    // Die Spezialfunktion überschreiben
    public function editCustomColumn($row, $key, $value, $default) {

        if (in_array($key, ['bestand', 'bestellt', 'kommission'])) {
            
            // 0 Wert ausblenden
            $default = (!$default || $default == 0) ? "" : $default;

            // Kommission Blau darstellen
            if($key == 'kommission') {
                $default = '<span class="text-info">'.$default.'</span>';
            }

        } else if($key == 'status') {
            $default = $default;
        }

        return $default;
    }
}

// Get Variable übergeben
$dt = new DtArtikel($_GET , "artikel");

// Verarbeiten
$dt->process();

// Output
$dt->output();

?>