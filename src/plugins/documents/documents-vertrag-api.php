<?php

/**
 * 
 * 
 * 
 */
class VertragDoc extends Document {

    // Constuctor
    function __construct($id, $options = []) {

        // Lieferung Id
        $this->id = $id;

        // Parent Constuctor
        parent::__construct($options);
    }

    // Name des Ordners, wo die Dokumente gespeichert werden
    function getFolderName() {
        return 'vertraege';
    }

    // Name des Dokuments, das gespeichert wird
    function getSaveName() {
        return "vertrag";
    }


    // Daten auslesen
    function getData() {

        // Vertrag API
        $vertrag = new Vertraege();
        $vertragPos = new VertraegePos();

        // Get Klauseln
        $klauseln = $vertrag->getKlauselnWithGroups($_GET['id']);

        // Get Vertragsart/ Vorlage
        $vorlage = $vertrag->get($_GET['id']);

        // Holt Die Adressen der Verträge
        $adressen = $vertrag->getAdressen($_GET['id']);

        // Holt Alle zu den Positionen
        $positionen = $vertragPos->getPositionenWithVertragsID($_GET['id']);

        // Zaehler Pauschale
        $zaehler = $vertragPos->getZaehler($_GET['id']);

        // ggf. abfangen, wenn ein Fehler auftritt


        // Daten auslesen
        $this->data = [
            'klauseln' => $klauseln['data'],
            'positionen' => $positionen['data'],
            'vorlage' => $vorlage['data'],
            'adressen' => $adressen['data'],
            'zaehler' => $zaehler['data']
        ];

        // Vertragsbeginn direkt schon ins deutsch Format formatieren


    }

    // Build
    function build() {

        // Metadaten - Vertragsgeber, Beginn, Vertragsnummer
        $this->arrayToTable([
            'style' => ['width:60%;text-align:left;', 'width:30%;', 'width: 10%; text-align:right;'],
            [
                '<h5> Bürosystemhaus Schäfer | Haimbacher Straße 24 | 36041 Fulda </h5>',
                '<strong>Vertragsnummer</strong> <br> 
                    Vertragsbeginn',
                '<strong>' . $_GET['id'] . '</strong> <br>
                    ' . $this->germanDate($this->data['vorlage']['vertragsbeginn']) . '',
            ]
        ]);

        // Metadaten - Vertragsnehmer, Kundennummer, Druckdatum
        $this->arrayToTable([
            'style' => ['width:60%;text-align:left;', 'width:30%;', 'width: 10%; text-align:right;'],
            [
                '<h3>' . $this->data['adressen']['vn_name'] . ' <br>' . $this->data['adressen']['vn_strasse'] . '<br>' . $this->data['adressen']['vn_plz'] . ' ' . $this->data['adressen']['vn_ort'] . '<br> </h3>',
                'Kundennummer <br> 
                    Druckdatum',
                '' . $this->data['adressen']['vertragsnehmerID'] . '<br>
                    ' . $this->germanDate($this->data['vorlage']['vertragsbeginn'])
            ]
        ]);

        // Zeilenumbrüche
        $this->space(2);

        // Kopfzeile
        $this->writeHeadline($this->data['vorlage']['vertragsvorlagenBezeichnung']);
        $this->write("<em>zwischen</em>");


        $this->paragraphNo = 1;

        // Zeilenumbrüche
        $this->space(1);

        // Vertragspartner
        $this->arrayToTable([
            'style' => ['width:45%;text-align:center;', 'width:10%;text-align:center;', 'width:45%;text-align:center;'],
            [
                '<strong>Bürosystemhaus Schäfer<br>GmbH & Co. KG</strong><br>Haimbacher Straße 24<br>36041 Fulda',
                '<em>und</em>',
                '<strong>' . $this->data['adressen']['vn_name'] . '</strong><br>' . $this->data['adressen']['vn_strasse'] . '<br>' . $this->data['adressen']['vn_plz'] . ' ' . $this->data['adressen']['vn_ort'] . '<br>'
            ]
        ]);

        $this->space(2);


        // Positionen
        $this->setPositionen();

        // Laufzeit und Kosten
        $this->setLaufzeitUndKosten();

        // Paragraphen
        $this->setParagraphs();
    }

    /**
     * Schreiben eines Paragraphs
     */
    public function paragraphHeadline($text) {

        // Schreiben
        $this->write("<strong>§ " . $this->paragraphNo . " " . $text . "</strong>");
        $this->paragraphNo++;
    }


    /**
     * Laufzeit und Kosten
     */
    public function setLaufzeitUndKosten() {

        $this->paragraphHeadline("Kosten und Laufzeit");
        // $this->write("- Hier kommt alles zu Kosten");

        // 
        $interval = [
            ['d', 'Tagen', 'Tag', 'täglich'],
            ['M', 'Monaten', 'Monat', 'monatlich'],
            ['Q', '', '', 'quartalsmäßig', ''],
            ['Y', 'Jahren', 'Jahr', 'jährlich']
        ];

        // Zaehler Bezeichnung
        $zaehler = [
            [1, 'schwarz-weiß Seite'],
            [2, 'Farbseite']
        ];

        foreach ($interval as $value) {

            // Checkt Welches der Werte Laufzeit Interval ist (d, M, Y)
            if ($value[0] == $this->data['vorlage']['laufzeit_interval']) {

                // Checkt ob Größer als 1 ist
                $this->data['vorlage']['laufzeit_interval'] = (($this->data['vorlage']['laufzeit'] > 1) ? $value[1] : $value[2]);
            }

            // Checkt die Vertrags Verlängerung und Kündigungsfrist
            if ($value[0] == $this->data['vorlage']['verlaengerung_laufzeit_interval']) {
                $this->data['vorlage']['verlaengerung_laufzeit_interval'] = (($this->data['vorlage']['verlaengerung_laufzeit'] > 1) ? $value[1] : $value[2]);
            }

            // Checkt die Vertrags Verlängerung und Kündigungsfrist
            if ($value[0] == $this->data['vorlage']['kuendigungsfrist_laufzeit_interval']) {
                $this->data['vorlage']['kuendigungsfrist_laufzeit_interval'] = (($this->data['vorlage']['kuendigungsfrist_laufzeit'] > 1) ? $value[1] : $value[2]);
            }

            // Checkt Welche Bereitsstellungsinterval
            if (isset($this->data['vorlage']['pauschale_abrechnung_interval']) && $value[0] == $this->data['vorlage']['pauschale_abrechnung_interval']) {
                $this->data['vorlage']['pauschale_abrechnung_interval'] = $value[3];
            }

            // Check den Intervall Der Bereitstellung
            if (isset($this->data['vorlage']['kosten_interval']) && $value[0] == $this->data['vorlage']['kosten_interval']) {
                $this->data['vorlage']['kosten_interval'] = $value[3] . "e";
            }
        }

        // Wenn es Gesamtpauschale einen Preis gibt -- Preis der Bereitstellung
        if (isset($this->data['vorlage']['gesamtpauschale_preis']) &&  $this->data['vorlage']['gesamtpauschale_preis']) {
            $this->write("- Der " . $this->data['vorlage']['kosten_interval'] . " Preis der Bereitsstellung beträgt <b>" . $this->data['vorlage']['gesamtpauschale_preis'] . " € </b>.");
        } else {
            $this->write("- Der Gesamtpreis beträgt ".$this->gesamtPreisPos." €. Der Preis ergibt sich aus den einzelnen Positionen.");
        }

        $zaehlerText = "- Die Wartung wird zum Preis von";

        // Schleife geht durch die ZaehlerPreis
        foreach($this->data['zaehler'] as $valueZ) {
            
            // Wenn es Einheitlich Preise gibt
            if(isset($this->data['vorlage']['zaehler_einheitlich']) && $this->data['vorlage']['zaehler_einheitlich'] == '1') {
                $zaehlerText .= " <strong>".$valueZ['pauschale']." je ".$valueZ['bezeichnung']."</strong> ";
            }
        }

        $zaehlerText .= " in Rechnung gestellt.";

        // Zaehler
        $this->write($zaehlerText);


        // Wenn es einen Vertragsbeginn gibt -- Vertrags Laufzeit
        if (isset($this->data['vorlage']['vertragsbeginn']) &&  $this->data['vorlage']['vertragsbeginn']) {
            $this->write("- Der Vertrag beginnt am <b>" . $this->germanDate($this->data['vorlage']['vertragsbeginn']) . "</b> mit einer Laufzeit von <b>" . $this->data['vorlage']['laufzeit'] . " " . $this->data['vorlage']['laufzeit_interval'] . "</b> ");
        }

        // Wenn es einen Intervall der Abrechnugn gibt -- Abrechnung
        if (isset($this->data['vorlage']['pauschale_abrechnung_interval']) && $this->data['vorlage']['pauschale_abrechnung_interval']) {
            $this->write("- Die Abrechnung erfolgt " . $this->data['vorlage']['pauschale_abrechnung_interval'] . "");
        }

  

        // Allgemeine 
        $this->write("- Die vorgenannten Preise verstehen sich zuzüglich Mehrwertsteuer.");

        // Verlängerung und Kündigungsfrist
        if ($this->data['vorlage']['verlaengerung_laufzeit'] && $this->data['vorlage']['kuendigungsfrist_laufzeit']) {
            $this->write("- Der Vertrag verlängert sich stillschweigend um " . $this->data['vorlage']['verlaengerung_laufzeit'] . " " . $this->data['vorlage']['verlaengerung_laufzeit_interval'] . ", 
            wenn er nicht spätestens " . $this->data['vorlage']['kuendigungsfrist_laufzeit'] . " " . $this->data['vorlage']['kuendigungsfrist_laufzeit_interval'] . " vor Ablauf von einem der beiden Vetragspartner schriftlich gekündigt wird.");
        }

        $this->space();
    }


    /**
     * Positionen
     */
    public function setPositionen() {

        $this->paragraphHeadline("Vertragsgegenstände");
        $this->write("Wenn nicht anders angegeben, stehen die Geräte an der angegebenen Adresse des Vertragsnehmers. <br> Standortveränderung sind nur mit Zustimmung des Vertragsgebers zulässig");

        $this->space();
        $this->write("<hr style='color: black'>");

        $this->gesamtPreisPos = 0;
        
        // Schleife geht alle Positionen durch
        foreach ($this->data['positionen'] as $key => $value) {

            // Wenn es einen Pauschalen Preis pro Position gibt
            $pauschale = ($value['pauschale']) ? " - <strong> Preis </strong> : ".$value['pauschale']." €" : "";
           
            // Gesamtpreis aus allen Positionen
            $this->gesamtPreisPos = intval($value['pauschale']) + intval($value['pauschale']);

            // Nur an der ersten Stellen Überschrift Ident hinzufügen
            if ($key == 0) {

                $this->arrayToTable([
                    'style' => ['width: 25%', '', 'width: 35%'],
                    [
                        '<custom> Identnummer </custom>',
                        '<custom>' . $value['id'] . " " . $value['bezeichnung'] . " ". $pauschale. '</custom>',
                    ]
                ]);
            } else {

                $this->arrayToTable([
                    'style' => ['width: 25%;', '', 'width: 35%; '],
                    [
                        '',
                        '<custom style="margin-top: 2cm;">' . $value['id'] . " " . $value['bezeichnung'] . " ". $pauschale.'</custom>',
                    ]
                ]);
            }



            // $arrayPos[1][1] = $value['id'];
        };

        $standortPos = "";

        // Wenn die Lieferadresse eine Andere ist wie der Vertragsnehmer
        if ($this->data['adressen']['vertragsnehmerID'] != $this->data['adressen']['lieferadresseID']) {
            '<custom> ' . $this->data['adressen']['lf_name'] . ', ' . $this->data['adressen']['lf_strasse'] . ', ' . $this->data['adressen']['lf_plz'] . ' ' . $this->data['adressen']['lf_ort'] . ' </custom>';
        } else {
            $standortPos = "Gerät steht an der angegebenen Adresse des Vertragsnehmers.";
        }

        $this->arrayToTable([
            'style' => ['width: 25%;', '', 'width: 35%'],
            [
                '<custom> Standort </custom>',
                $standortPos
            ]
        ]);


        $this->write("<hr style='color: black'>");
        $this->space();

        $this->write("- Vertragsgegenstand 2");
        $this->space();
    }

    /**
     * Paragraphen Auslesen
     */
    public function setParagraphs() {

        // Alle Paragraphen durchgehen
        foreach ($this->data['klauseln'] as $pKey => $pValue) {

            // Paragraph schreiben
            $this->paragraphHeadline($pValue['bezeichnung']);

            // Klauseln durchgehen
            foreach ($this->data['klauseln'][$pKey]['klauseln'] as $kKey => $kValue) {
                $this->write("- " . substr(substr(trim($kValue['text']), 3), 0, -4));
            }

            // Leerzeichen einfügen
            $this->space();
        }
    }

    // TODO: Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {
        return true;
    }
}
