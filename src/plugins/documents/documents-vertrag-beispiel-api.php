<?php

/**
 * Vertrag Beispiel Doc
 * 
 */
class VertragExampleDoc extends VertragDoc {

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
        $api = new VertraegeVorlagen();

        // TODO: Beispiel Daten noch vom Standard-Werten auslesen lassen
        $this->data['laufzeit'] = [
            'laufzeit' => 60,
            'laufzeit_interval' => 'm',
            'verlaengerung_laufzeit' => 12,
            'verlaengerung_laufzeit_interval' => 'm',
            'kuendigungsfrist_laufzeit' => 6,
            'kuendigungsfrist_laufzeit_interval' => 'm',
        ];

        // Beispiel Daten erstellen
        $this->data['positionen'] = [
            ['some','data'],
            ['somemore','data'],
        ];

        // Alle Klauseln der Gruppe auslesen
        $klauseln = $api->getKlauselnWithGroups(1);

        // Daten auslesen
        $this->data['klauseln'] = $klauseln['data'];
    }

    // TODO: Berechtigung prüfen
    function checkPermission($dokId, $userId, $userTable) {
        return true;
    }
}
