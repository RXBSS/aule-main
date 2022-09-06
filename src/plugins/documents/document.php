<?php include('01_init.php');

/**
 * Dokumente
 *
 * Dieser Proxy ist nur dazu da Dokumente anzuzeigen. Dazu muss man den entsprechenden Link aufrufen. 
 * Dieser wiederrum öffnet dann die dazugehörige Klasse. Für jedes Dokument gibt es eine Abkürzung (siehe $classes Array)
 * 
 * Je nach dem was man mit `action` ansteuert öffnet die Klasse das bereits gespeicherte Dokument oder generiert eine Vorschau und öffnet diese temporär.
 * Dabei werden auch Fehler abgefangen wie "Dokument nicht gefunden" und "Berechtigung fehlt"
 * 
 * 
 * ### Link
 * document?doctype=<doctype>&id=<id>&action=<action(show|preview)>&print=<Boolean>
 * 
 * 
 * ### doctype
 * Dokumentenart (Siehe $classes Array). Die Klasse wird initalisiert. 
 * Es ist wichtig, dass diese Klasse entsprechende Standard-Funktionen beinhaltet wie: 
 * `checkPermission` zum prüfen der Berechtigung
 * `getPrintLink` zum Abrufen des Links des Druck-Dokuments (In der Documents API vorhanden)
 * `getLetterheadLink` zum Abrufen des Links des Briefkopf-Dokuments (In der Documents API vorhanden)
 * `open` zum Öffnen des Dokuments (In der Documents API vorhanden)
 * 
 * 
 * ### id
 * Die ID des Dokuments, die an die Klasse übergeben wird
 * 
 * #### action
 * Die Aktion die durchgeführt werden soll:
 * `show` Zeigt das Dokument an, was bereits erzeugt wurde. Das Dokument liegt dann bereits in data/archive 
 * `preview` Generiert ein Dokument und zeigt die entsprechende Vorschau an
 * 
 * ### print
 * Mit Print `true` oder `false` kann man entscheiden, ob ein Briefkopf auf das Dokument gedruckt werden soll. 
 * Print true heißt, kein Briefkopf, da man das Dokument auf einen Drucker schicken will, in dem dann ein Briefpapier vorhanden ist
 * Print false heißt, mit Briefkopf, da man das Dokument speichern und per E-Mail oder sonst wie verschicken will.
 * 
 * 
 * ---
 * Zur Vereinfachung gibt es eine Funktion das ganze in einem Link einzubetten. 
 * Dabei wird immer automatisch die ID aus der URL gezogen.
 * 
 * Die Werte data-action und data-print sind optional.
 * Bei data-action wird standardmäßig "preview" gewählt. 
 * Wenn man data-print mitgibt, dann wir diese Einstellung erzwungen. 
 * Ansonsten hat der Benutzer über `Shift` die Möglichkeit zu entscheiden, ob er mit oder ohne Briefkopf haben will.
 * 
 * 
 * Einfacher Aufruf per Link
 * <a href="javascript:void(0);" data-document="ag" class="btn-show-document">
 * 
 * Alle Optionen mitgeben
 * <a href="javascript:void(0);" data-document="ag" data-action="show" data-print="false" class="btn-show-document">
 * 
 */

 
$error = false;
$result = false;

// Benötigten Daten prüfen
if (isset($_GET['doctype']) && isset($_GET['id'])) {

    // Dokumententyp
    $doctype = $_GET['doctype'];

    // Klassen
    $classes = [        
        'ab' => 'Auftragsbestaetigung',
        'ag' => 'AngebotDoc',
        'be' => 'BestellungDoc',
        'lf' => 'Lieferschein',
        'vt' => 'VertragDoc',
        'vtv' => 'VertragVorlagenDoc',
        'vte' => 'VertragExampleDoc'
    ];
    
    // Prüfen das der Dokumenten-Typ überhaupt existiert
    if(isset($classes[$_GET['doctype']])) {

        // Abfagen, falls in der Klasse ein Fehler ensteht
        try {

            // API
            $api = new $classes[$_GET['doctype']]($_GET['id']);

            // Berechtigung prüfen
            if ($api->checkPermission(1, 2, 3)) {

                // Action
                $action = (isset($_GET['action'])) ? $_GET['action'] : 'show';
                $print = (isset($_GET['print']) && $_GET['print'] == 'true') ? true : false;

                // Standard anzeige, dazu muss das Dokument existieren
                if ($action == 'show') {

                    // Pfad
                    $path = ($print) ? $api->getPrintLink(false) : $api->getLetterheadLink(false);

                    // Wenn die Datei existiert
                    if ($path && is_file($path)) {
                        
                        // Pfad-Info
                        $path_parts = pathinfo($path);

                        // Header Informationen setzen
                        header("Content-type: application/pdf");
                        header("Content-Disposition: inline; filename=" . $path_parts['basename']);

                        // Datei einlesen
                        @readfile($path);

                        die();

                        // Wenn es das Dokument nicht gefunden wird
                    } else {
                        $error = "document_not_found";
                    }

                    // Standard Preview, dazu muss das Dokument nicht existieren
                } else if ($action == 'preview') {

                    $result = $api->open(!$print, "VORSCHAU");

                    if($result != 'no_error') {
                        $error = "exception";
                    } else {
                        die();
                    }
                }

                // Wenn es keine Berechtigung gibts
            } else {
                $error = "no_permission";
            }


        // Wenn ein Fehler auftritt
        } catch (Exception $e) {
            $error = "exception";
            $result = $e->getMessage();
        }
    
    } else {
        $error = "missing_class";
    }

    // Error Handling
} else {
    $error = "required_data_missing";
}





// Wenn es einen Fehler gibt
if ($error) {

    $array = [
        'document_not_found' => ['Dokument nicht gefunden!', 'Das angefordete Dokument konnte nicht gefunden werden!'],
        'no_permission' => ['Keine Berechtigung!', 'Sie besitzen keine Berechtigung um auf das angeforderte Dokument zuzugreifen'],
        'missing_class' => ['Fehlende Dokumentenklasse!', 'Es wurde versucht eine unbekannte Dokumenteklasse aufzurufen!'],
        'required_data_missing' => ['Fehlerhafte Daten!', 'Die von Ihnen übergebenen Daten sind Fehlerhaft'],
        'exception' => ['Dokument hat einen Fehler!', 'Bitte teilen Sie den Entwicklern den folgenden Fehler mit: <pre>'.$result.'</pre>']
    ];

    $_page = [
        'title' => $array[$error][0]
    ];
?>
    <!doctype html>

    <head>
        <?php include('02_header.php'); ?>
    </head>

    <body>
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div style="margin-top: -20vh;">
                <h1><i class="fa-solid fa-exclamation-triangle text-danger"></i> <?php echo $array[$error][0]; ?></h1>
                <p><?php echo $array[$error][1]; ?></p>
                <button id="btn-bug-report" class="btn btn-secondary"><i class="fa-solid fa-bug"></i> Fehler melden</button>
                <button id="btn-close-page" class="btn btn-secondary"><i class="fa-solid fa-xmark"></i> Seite schließen</button>
            </div>
        </div>
    </body>
    <?php include('04_scripts.php'); ?>
    <script>
        $(document).on('app:ready', function() {
            $('#btn-bug-report').on('click', function() {
                
            });

            $('#btn-close-page').on('click', function() {
                window.close();

                app.redirect('/');
            });

        });
    </script>

    </html>
<?php
}
