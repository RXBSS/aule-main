<?php


/**
 * Dokumenten Generator
 * ********************
 * 
 * Was muss der Dokumenten Generator alles können?
 * - Als Grundbaustein für das Erstellen von Dokumenten dienen. Das heißt diese Klasse wird immer erweitert. 
 * 
 * 
 * Grundfunktionen
 * - Dokument erstellen
 * - Briefkopf hinzufügen
 * - Dokument speichern 
 * 
 * 
 * 
 * Wichtig zu wissen: 
 * - letterhead = entscheidet ob mit oder ohne Briefkopf gedruckt werden soll
 * - watermark = hinterlegt ein Wasserzeichen
 * - archive = Entscheidet ob das Dokument ins Archiv abgelegt werden soll. In das Archiv sollen nur "finale" Dokumente. Alle anderen Dokumente sollten unter temp abgelegt werden. 
 *              Hier kann man dann jederzeit den kompletten Ordner löschen.
 * 
 * 
 * // TODO: Fehlerausgabe muss noch geklärt werden! Sollen die Positionen auch alle als Request arbeiten?
 * // TODO: Jedes Dokument das gedruckt wird, sollte alle Daten noch einmal separat abspeichern um in Dokument reproduzierne zu können, auch wenn die Daten nicht mehr in der Datenbank existierten
 * 
 */
class Document {

    public $mpdf = false;


    function __construct($options = []) {

        // Default Werte
        $defaultOptions = [
            'mpdf' => [
                'margin_left' => 20,
                'margin_right' => 10,
                'margin_top' => 40,
                'margin_bottom' => 20,
                'margin_header' => 0,
                'margin_footer' => 35
            ],
            'archive' => false
        ];

        // Optionen
        $this->options = array_merge($defaultOptions, $options);

        // Daten sammeln und Pfad festlegen
        $this->getData();

        // 
        $this->getFolderName();
        $this->getSavePath();
        $this->getSaveName();

        // Dokumenten-Version
        $this->version = 1;
        $this->name = "undefined";
    }


    // Mit Briefkopf
    function addLetterhead($templateId) {

        // Muss noch in die Datenbank ausgelagert werden 
        $templates = [
            1 => "buerosystemhaus_2019.pdf",
        ];

        // Template hinzufügen
        $this->mpdf->SetDocTemplate('data/documents/templates/' . $templates[$templateId], true);
    }


    function setWatermark($text = "Vorschau!") {
        $this->mpdf->SetWatermarkText($text);
        $this->mpdf->showWatermarkText = true;
        $this->mpdf->watermark_font = 'Arial';
    }

    function start($letterhead = false, $watermark = false) {

        // MPDF Instanz erstellen
        $this->mpdf = new \Mpdf\Mpdf($this->options['mpdf']);

        // Styles für die Dokumente hinzufügen
        $this->mpdf->WriteHTML(file_get_contents('css/pagelevel/documents.css'), 1);

        // Briefkopf
        if ($letterhead) {
            $this->addLetterhead($letterhead);
        }

        // Wasserzeichen
        if ($watermark) {
            $this->setWatermark($watermark);
        }

        // Meta Daten setzen
        $this->setMetaData();
    }



    /**
     * Das Dokument wird beim erstellen immer in doppelter Ausführung erstellt
     *
     * @return void
     */
    function create() {

        // Neuen Request erstellen
        $req = new Request();

        try {

            // Pfad wo gespeichert werden soll
            $path = $this->getSavePath();
            $name = $this->getSaveName();

            // Einmal mit Briefkopf 
            $this->start(true, false);
            $this->build();
            $this->save($path, $name, true);

            // Einmal ohne Briefkopf
            $this->start(false, false);
            $this->build();
            $this->save($path, $name . "_print", true);

            // Alles erstellt!
            $req->success = true;

            // Fehler beim Erstellen
        } catch (Exception $e) {
            $req->log[] = "Fehler beim Erstellen der Dokumente";
            $req->log[] = $e->getMessage();
            $req->error = "Fehler beim Erstellen der Dokumente";
        }

        // Rückgabe
        return $req->answer();
    }

    // 
    public function build() {
        $this->write('I told my wife she was drawing her eyebrows too high... She looked surprised.');
    }

    /**
     * Suche nach den Dokumenten 
     */
    public function exists() {

        // Pfad wo gespeichert werden soll
        $path = $this->getSavePath();
        $name = $this->getSaveName();

        // Prüfen ob die Dateien schon exsitieren
        return (is_file($path . "/" . $name . ".pdf") && is_file($path . "/" . $name . "_print.pdf")) ? true : false;
    }


    public function print($noLetterhead = false) {

        // Print
        $req = new Request();

        // Wenn es existiert
        if ($this->exists()) {

            // 
            $req->success = true;

            // Send to printer
            // --- Somehow

        } else {
            $req->error = "Die Dokument wurden noch nicht erstellt.";
        }

        return $req->answer();
    }

    public function getLinks($proxy = true) {

        // Print
        $req = new Request();

        // Wenn es existiert
        if ($this->exists()) {

            // 
            $req->success = true;

            // Daten sammeln
            $path = $this->getSavePath();
            $name = $this->getSaveName();

            // Rückgabe
            $req->result = [
                'letterhead' => $path . "/" . $name . ".pdf",
                'print' => $path . "/" . $name . "_print.pdf",
            ];

            // Wenn es mit Proxy ist
            if ($proxy) {

                // Proxy
                $proxyApi = new Proxy();

                // Encode
                $req->result = [
                    'letterhead' => $proxyApi->encode($req->result['letterhead']),
                    'print' => $proxyApi->encode($req->result['print']),
                ];
            }
        } else {
            $req->error = "Die Dokument wurden noch nicht erstellt.";
        }

        return $req->answer();
    }

    // 
    function getLink($type = 'letterhead', $proxy = true) {

        // Mit Proyx
        $links = $this->getLinks($proxy);

        if (!$links['success']) {
            return false;
        }

        // Rückgabe
        return $links['data'][$type];
    }

    function getLetterheadLink($proxy = true) {
        return $this->getLink('letterhead', $proxy);
    }

    function getPrintLink($proxy = true) {
        return $this->getLink('print', $proxy);
    }

    // Sender ermitteln!
    function getSenderById($id) {

        // TODO: Hier muss noch aus der Datenbank geholt werden!

        $tempSender = [

            // Bürosystemhaus Schäfer 
            1 => [
                'name' => 'Bürosystemhaus Schäfer GmbH & Co. KG',
                'strasse' => 'Haimbacher Straße 24',
                'plz' => '36041',
                'ort' => 'Fulda',
                'land' => 'Deutschland'
            ],

            // Schäfer Projekt Gbr
            2 => [
                'name' => 'Schäfer Projekt GbR',
                'strasse' => 'Haimbacher Straße 24',
                'plz' => '36041',
                'ort' => 'Fulda',
                'land' => 'Deutschland'
            ],
        ];


        // Sender!
        if (!isset($tempSender[$id])) {
            throw new Exception("Der Sender wurde nicht gefunden!", 1);
        }

        // Standard Anschrift zurückgeben!
        return $tempSender[$id];
    }

    // Empfänger ermitteln
    function getEmpfeaengerById($id) {

        // Adress API ansprechen
        $addresse = new Adressen();

        // Adressedaten
        $data = $addresse->get($id);

        if (!$data && !$data['success']) {
            throw new Exception("Der Empfänger wurde nicht gefunden!", 1);
        }

        // Rückgabe        
        return $data['data'];
    }


    // Funktion zum Überschreiben
    function getData() {
        $this->data = [];
    }

    function getFolderName() {
        return 'misc';
    }

    // Funktion zum Überschreiben
    function getSavePath() {
        return "data/documents/archive/" . $this->getFolderName();
    }

    function getTempPath() {
        return "data/documents/temp/" . $this->getFolderName();
    }

    // Name des Dokuments
    function getSaveName() {
        return "document";
    }

    // Name des Dokuments
    function getTitle() {
        return "document";
    }



    function standardHead($sender, $empfaenger, $list = [], $barcode = false) {

        // Wenn Sender kein Array ist, dann ist eine ID angegeben!
        if (!is_array($sender)) {
            $sender = $this->getSenderById($sender);
        }

        // 
        if (!is_array($empfaenger)) {
            $empfaenger = $this->getEmpfeaengerById($empfaenger);
        }

        $div = "";

        // Wenn es einen Barcode gibt
        if ($barcode) {
            $div .= "

            <div class='barcode-container' style='position: fixed; right: -20; rotate: -90;'>
                <barcode code='" . $barcode . "' type='C128A' text='0' size='0.7' />
            </div>";
        }


        // 
        $div .= "
            <table class='top'>
            <tr>
                <td style='width:100mm;line-height:1.6'>
                    <p style='font-size:6pt;margin-bottom:5mm;'>
                        " . $this->simpleFormatAdresse($sender, 'line') . "
                    </p>
                    <p style='line-height:1.8;'>
                        " . $this->simpleFormatAdresse($empfaenger) . "
                    </p>
                </td>
                <td>";


        // Wenn es eine Liste gibt
        if (count($list) > 0) {

            $div .= "<table class='metadaten'>";

            foreach ($list as $row) {
                $div .= "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";
            }

            $div .= "</table>";
        }


        $div .= "
                </td>
            </tr>
        </table>";


        $this->mpdf->WriteHTML($div);
    }

    // Zum einfachen formatieren von Adressen
    function simpleFormatAdresse($data, $mode = 'break') {

        // Formatieren als Break
        if ($mode == 'break') {

            $string =
                $data['name'] . "
                <br>
                " . ((isset($data['zusatz'])) ? $data['zusatz'] . "<br>"  : "") . "
                " . $data['strasse'] . "
                <br>
                " . $data['land'] . " " . $data['plz'] . " " . $data['ort'];

            // Formatieren als Line
        } else if ($mode == 'line') {

            // Formatieren der Adresse
            $string = $data['name'] . ", " . $data['strasse'] . ", " . $data['plz'] . " " . $data['ort'];
        }

        return $string;
    }

    function setMetaData() {
        $this->mpdf->SetTitle($this->getTitle());
        $this->mpdf->SetAuthor("Bürosystemhaus Schfäer GmbH & Co. KG");
        $this->mpdf->SetCreator("Bürosystemhaus Schfäer GmbH & Co. KG");
    }


    function writeHeadline($headline) {
        $this->mpdf->writeHTML("<h2>" . $headline . "</h2>");
    }

    // Simple Write 
    function write($html) {
        $this->mpdf->writeHTML($html);
    }

    // German Date Format
    function germanDate($date) {
        
        if ($date) {
            $germanDate = new DateTime($date);
            $germanDate = $germanDate->format('d.m.Y');

            return $germanDate;
        }
    }


    // Tabelle
    function arrayToTable($array, $footer = false) {

        $table = "<table>";


        // Wenn es einen Header gibt
        if (isset($array['header'])) {
            $table .= "<tr>";
            foreach ($array['header'] as $colKey => $cols) {
                $table .= "<th " . ((isset($array['style'][$colKey])) ? "style='" . $array['style'][$colKey] . "'" : "") . ">" . $cols . "</th>";
            }
            $table .= "</tr>";

            // Unterstrich hinzufügen
            $table .= "<tr><td colspan='" . count($array['header']) . "'><hr></td></tr>";
        }

        // Array ohne Keys durchgehen
        foreach ($array as $rowKey => $rows) {

            if (!in_array($rowKey, ['header', 'footer', 'style'])) {

                $table .= "<tr>";

                foreach ($rows as $colKey => $cols) {
                    $table .= "<td " . ((isset($array['style'][$colKey])) ? "style='" . $array['style'][$colKey] . "'" : "") . ">" . $cols . "</td>";
                }

                $table .= "</tr>";
            }
        }

        // Wenn es einen Header gibt
        if (isset($array['footer'])) {

            // Unterstrich hinzufügen
            $table .= "<tr><td colspan='" . count($array['footer']) . "'><hr></td></tr>";

            $table .= "<tr>";
            foreach ($array['footer'] as $colKey => $cols) {
                $table .= "<th " . ((isset($array['style'][$colKey])) ? "style='" . $array['style'][$colKey] . "'" : "") . ">" . $cols . "</th>";
            }
            $table .= "</tr>";
        }

        $table .= "</table>";


        if ($footer) {
            $this->mpdf->SetHTMLFooter($table);
        } else {
            $this->mpdf->WriteHTML($table);
        }
    }


    function multiLineText($input) {
        return str_replace("\\n", "<br>", $input);
    }

    /**
     * Schreibt die Summen-Tabelle
     * 
     */
    function summen($data) {

        $f = new Formatter();

        // Zusammenstellen der Beträge

        $array = [];

        // Standard Netto
        $array[] = ["Netto", $f->betrag($this->data['positionen_summe']['netto_rabatt']) . " €"];

        // Schleife durch alle Steuersätze
        foreach ($this->data['positionen_summe']['steuer_saetze'] as $steuer => $betrag) {
            $array[] = [$steuer . "% MwSt.", $f->betrag($betrag) . " €"];
        }

        $array[] = ["Brutto", $f->betrag($this->data['positionen_summe']['brutto']) . " €"];

        // -------------------------

        // Initalisieren der Paare
        $bezeichnungen = [];
        $betraege = [];

        // Schliefe durch alle Paare
        foreach ($array as $pairs) {
            $bezeichnungen[] = $pairs[0];
            $betraege[] = $pairs[1];
        }

        $withRabatt = [];

        // Wenn es Positionen mit Rabatt gibt
        if ($this->data['positionen_summe']['hasRabatt']) {
            $withRabatt[] = ["", "", "Gesamtpreis", $f->betrag($this->data['positionen_summe']['netto']) . " €"];
            $withRabatt[] = ["", "", "Rabatt", "-" . $f->betrag($this->data['positionen_summe']['rabatt']) . " €"];
        }

        // Array to Table
        $this->arrayToTable(array_merge($withRabatt, [
            'footer' => [
                "Zahlungsbedingungen TODO",
                "",
                implode("<br>", $bezeichnungen),
                implode("<br>", $betraege),
            ],
            'style' => ['width:65%;text-align:left;', 'width:5%;text-align:left;', 'width:15%;text-align:left;', 'width:15%;text-align:right;'],
        ]));
    }


    /**
     * Generiert einen Zeilenumbruch
     */
    function space($no = 1) {

        $i = 0;
        $a = [];

        while ($i < $no) {
            $a[] = "<br>";
            $i++;
        }

        // Breaks schreiben
        $this->write(implode("", $a));
    }



    // ZugFerd Rechnung erstellen?
    // Vielleicht doch eher nur in Rechnung?
    function mkZugferd() {
    }


    // Öffnen
    function open($letterhead = true, $watermark = "VORSCHAU") {

        $success = true;


        // Dazu bringen, dass PHP Warnungen als Excepations ausgibt
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (0 === error_reporting()) {
                return false;
            }

            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            try {
                $this->start($letterhead, $watermark);
                $this->build();
            } catch (Exception $ex) {
                $success = false;
            }
        } catch (Error $ex) {

            $success = false;
        }

        // Backup
        restore_error_handler();

        if ($success) {

            // Output a PDF file directly to the browser
            $this->mpdf->Output();

            return "no_error";
        } else {
            return "\"" . $ex->getMessage() . "\" Zeile: " . $ex->getLine();
        }
    }

    /** 
     * Funktion zum Speichern
     *
     * @param string $path Der Pfad in den das Dokument gespeichert werden soll
     * @param string $name Der Name, den das Dokument erhalten soll
     * @param boolean $overwrite Ob das Dokument überschrieben werden soll
     */
    function save($path, $name, $overwrite = false) {

        // Ordner anlegen, falls er noch nicht exisitiert!
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Neuen Namen festlegen
        $newName = $name;

        // Wenn das Dokument überschrieben werden soll
        if (!$overwrite) {

            // Dokumenten-Nummer ermitteln:
            if (is_file($newName . ".pdf")) {

                $i = 1;

                // Schleife initiieren
                while ($i < 99999) {

                    if (!is_file($newName . "_" . $i . ".pdf")) {
                        $newName = $newName . "_" . $i;
                        break;
                    }

                    $i++;
                }
            }
        }

        // Vollständiger Name
        $completeName = $path . "/" . $newName;

        // Datieiname
        $this->saveData($completeName);

        // Save Document
        $this->mpdf->Output($completeName . ".pdf", \Mpdf\Output\Destination::FILE);

        // Rückgabe
        return [
            'file' => $newName,
            'directory' => $path,
            'complete' => $completeName . ".pdf",
            'json' => $completeName . ".json",
            'extension' => ".pdf"
        ];
    }

    function saveData($filename) {

        // JSON erstellen
        $json = json_encode([
            'version' => $this->version,
            'name' => $this->name,
            'data' => $this->data
        ], JSON_PRETTY_PRINT);

        // Daten schreiben
        file_put_contents($filename . ".json", $json);
    }

    // Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {
        // Die Berechtigung muss in der jeweiligen Dokumenteklasse geprüft werden
        return false;
    }
}
