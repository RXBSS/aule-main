<?php

/**
 * 
 * Alle Funktionen Sind identisch wie die VertragDoc nur die Klasse auf die zugegriffer wird
 * ist anders
 * Da es eine Andere Tabelle ist muss die Funktion überschrieben werden
 * 
 */
class VertragVorlagenDoc extends VertragDoc {

    // Constuctor
    function __construct($id, $options = []) {

        // Lieferung Id
        $this->id = $id;

        // Parent Constuctor
        parent::__construct($options);
    }

    // Daten auslesen
    function getData() {

        // Vertrag API
        $vertragVorlage = new VertraegeVorlagen();

        $klauseln = $vertragVorlage->getKlauselnWithGroups($_GET['id']);

        // Get Vertragsart/ Vorlage
        $vorlage = $vertragVorlage->get($_GET['id']);

        // ggf. abfangen, wenn ein Fehler auftritt

        // Daten auslesen
        $this->data = [
            'klauseln' => $klauseln['data'],
            'vorlage' => $vorlage['data'],
        ];

        // Vertragsbeginnn auf Heute für Mustervertrag
        $this->data['vorlage']['vertragsbeginn'] = date('d.m.Y');
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
                    ' . date('d.m.Y') . '',
            ]
        ]);

        $this->arrayToTable([
            'style' => ['width:60%;text-align:left;', 'width:30%;', 'width: 10%; text-align:right;'],
            [
                '<h3> Musterfirma <br> Musterstraße 123 <br> 12345 Musterstadt </h3>',
                'Kundennummer <br> 
                    Druckdatum',
                '123 <br>
                    ' . date('d.m.Y')
            ]
        ]);

        // Zeilenumbrüche
        $this->space(2);

        // Kopfzeile
        $this->writeHeadline($this->data['vorlage']['bezeichnung']);
        $this->write("<em>zwischen</em>");

        // Zeilenumbrüche
        $this->space(1);

        // Vertragspartner
        $this->arrayToTable([
            'style' => ['width:45%;text-align:center;', 'width:10%;text-align:center;', 'width:45%;text-align:center;'],
            [
                '<strong>Bürosystemhaus Schäfer<br>GmbH & Co. KG</strong><br>Haimbacher Straße 24<br>36041 Fulda',
                '<em>und</em>',
                '<strong> Musterfirma </strong><br>Musterstraße 123 <br> 12345 Musterstadt<br>'
            ]
        ]);

        // Positionen
        $this->setPositionen();

        // Abstand
        $this->space(1);

        // Laufzeit und Kosten
        $this->setLaufzeitUndKosten();

        // Abstand
        $this->space(1);

        // Paragraphen
        $this->setParagraphs();

    }

    function setPositionen() {

        $this->paragraphNo = 1;
        $this->paragraphHeadline("Vertragsgegenstände");
        $this->write("Wenn nicht anders angegeben, stehen die Geräte an der angegebenen Adresse des Vertragsnehmers. <br> Standortveränderung sind nur mit Zustimmung des Vertragsgebers zulässig");
        $this->write("<strong><em>In einem Mustervertrag gibt es keine Positionen. </em><strong>");
    }

    // function setLaufzeitUndKosten() {

    //     $this->paragraphNo = 2;
    //     $this->paragraphHeadline("Kosten und Laufzeit");
    //     $this->write("<strong><em>In einem Mustervertrag gibt es keine Kosten und Laufzeiten. </em><strong>");
    // }
}
