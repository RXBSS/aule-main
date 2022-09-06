<?php

/**
 * Das ist eine Vorlage, die als Erklärung diesen soll um ein eigenes Dokument zu erstellen
 * 
 * Zum Aufrufen wie folgt vorgehen:
 * 
 *      $doc = new TemplateDoc();
 *      $doc->start(true);
 *      $doc->build();
 *      $doc->open();
 * 
 */
class TemplateDoc extends Document {

    // Name des Ordners, wo die Dokumente gespeichert werden
    function getFolderName() {
        return 'template';
    }

    // Name des Dokuments, das gespeichert wird
    function getSaveName() {
        return "template";
    }

    // Titel des Dokuments
    function getTitle() {
        return "Template";
    }

    // Build
    function build() {

        // Adresse kann als Array oder als ID übergeben werden
        $address = [
            'name' => 'Max Mustermann',
            'strasse' => 'Musterstraße',
            'land' => 'DE',
            'plz' => '36041',
            'ort' => 'Fulda'
        ];

        // Standard Kopf-Zeile
        $this->standardHead(1, $address, [['Links', 'Rechts'], ['A', 'B']], "DOKNUMMER123");

        // Etwas in HTML Schreiben
        $this->write("Something");

        // Etwas großeses schreibens
        $this->writeHeadline('Something Big');

        // Zeilenumbrüche
        $this->space(3);

        // Array to Table
        $this->arrayToTable([

            // Kopf, Fuß und Style Zeile
            'header' => ['Kopf 1', 'Kopf 2', 'Kopf 3'],
            'style' => ['width:15%;text-align:left;', 'width:40%;text-align:left;', 'text-align:right;color:red;'],
            'footer' => ['Fuß 1', 'Fuß 2', 'Fuß 3'],

            // Anderen Zeilen werdnen als Daten interpretiert
            ['Daten A', 'Daten B', 'Daten C'],
            ['Daten D', 'Daten E', 'Daten F'],
        ]);

        // Weitere Funktionen siehe documents-00-api.php
    }
}
