<?php


/**
 * Ticket Klasse
 */
class Ticket {


    public $table = "tickets";

    // Ticket erstellen
    function create($data) {

        $req = new Request($data);
        
        // Aktuelles Datum und Uhrzeit erstellen
        $date = new DateTime();
        $req->data['erstellt'] = $date->format('Y-m-d H:i:s');
        $req->data['ersteller_id'] = $_SESSION['user']['id'];

        // Process Array
        $process = [
            ['t', 'titel'],
            ['s', 'status_id'],
            ['t', 'erstellt'],
            ['t', 'ersteller_id']
        ];

        // Insert Query
        $req->insert($this->table, $process);

        // Rückgabe
        return $req->answer();
    }

    // Ticket Infos auslesen
    function get($id) {

        $req = new Request();

        $query = "
            SELECT t.*, s.*, m.vorname AS erstellerVorname, m.nachname AS erstellerNachname
            FROM `tickets` t
            LEFT JOIN `status` s ON `s`.`status_id` = `t`.`status_id` AND `s`.`bereich` = 'tickets'
            LEFT JOIN `mitarbeiter` m ON `m`.`id` = `t`.`ersteller_id`
            WHERE `t`.`id` = '".$id."';
        ";

        // Get Query
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Ticket ändern
    function change() {

    }

    // Neuer Kontakte zum Ticket hinzufügen
    function newKontakt($data) {

        $req = new Request($data);

        // Ticket ID
        $req->data['ticket_id'] = $data[0];

        // Schleife geht durch alle Kontakte
        foreach($data[1] as $key => $value) {

            // Kontakte ID ständig überschriebe
            $req->data['kontakte_id'] = $value[1];

            // Process Array
            $process = [
                ['t', 'ticket_id'],
                ['s', 'kontakte_id']
            ];

            // Insert Query
            $req->insert('tickets_kontakte', $process);

        }

        // Rückgabe
        return $req->answer();


    }

    // Holt alle Kontakte die zu dem aktuellen Ticket gehören 
    function getKontakt($id) {

        // 
        $req = new Request();

        // Query
        $query = "

            SELECT tk.*, k.intern AS interExtern, k.vorname as kontaktVorname, k.nachname as kontaktNachname, t.*
            FROM tickets_kontakte tk
            LEFT JOIN kontakte k ON k.id = tk.kontakte_id
            LEFT JOIN tickets t ON t.id = tk.ticket_id
            WHERE tk.ticket_id = '".$id."';

        "; 

        // Get Query
        $req->getMultiQuery($query, true);

        // Rückgabe
        return $req->answer();
    }

    // Lädt Timeline und alle dazugehöruigen Daten
    function getTimeline($id) {

        $req = new Request(); 

        // Query
        $query = "
        
            SELECT tv.*, m.vorname as mitarbeiterVorname, m.nachname as mitarbeiterNachname, t.*
            FROM `tickets_verlauf` tv
            LEFT JOIN tickets t ON t.id = tv.ticket_id
            LEFT JOIN mitarbeiter m ON m.id = tv.person_id
            WHERE tv.ticket_id = '".$id."';
        
        ";

        // Get Query 
        $req->getMultiQuery($query, true); 

        // Rückgabe
        return $req->answer();

    }


    // Erstell einen neuen Timeline Eintrag
    function submitTimeline($data) {

        $req = new Request($data['formData']);

        // Aktuelles Datum und Uhrzeit erstellen
        $date = new DateTime();
        $req->data['zeitstempel'] = $date->format('Y-m-d H:i:s');

        // Aktuelle Ticket ID
        $req->data['ticket_id'] = $data['additional']['id'];;

        // Person ID
        $req->data['person_id'] = $_SESSION['user']['id'];

        // Event
        $req->data['event'] = 'erstellt';


        // Process Array
        $process = [
            ['t', 'text'],
            ['t', 'ticket_id'],
            ['t', 'zeitstempel'],
            ['t', 'person_id'],
            ['t', 'event']
        ];

        // Insert Query
        $req->insert('tickets_verlauf', $process);

        // Rückgabe
        return $req->answer();


    }

    // Hinzufügen von neuen Dokument an das Formular
    function submitTicketFile($data) {

        $req = new Request($data['formData']);

        // Aktuelle Ticket ID
        $req->data['ticket_id'] = $data['additional']['id'];


        // [dirname] => C:\\fakepath
        // [basename] => Ferienwohnung_rheinberg9.jpg
        // [extension] => jpg
        // [filename] => Ferienwohnung_rheinberg9

        
        // 
        $test = urldecode($req->data['dokument']);

        $path_parts = pathinfo($test);


       

        // Process Array
        $process = [
            ['t', 'text'],
            ['t', 'ticket_id'],
            ['t', 'file']
        ];

        // Insert Query
        $req->insert('tickets_dokument', $process);

        // Rückgabe
        return $req->answer();
    }





}

?>