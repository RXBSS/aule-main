<?php

/**
 * Klasse Rechnungen 
 * 
 * ACHTUNG! Nicht verwelchseln mit der Klasse Rechnung (Dokument)
 * 
 * // TODO: Gutschriften?
 * // TODO: 0-Rechnungen
 * 
 * 
 */
class Rechnungen {

    public $table = "rechnungen";

    public function __construct() {
        // Nothing to to
    }

    /**
     * Erstellt eine neue Rechnung
     * 
     * Wenn man nur den Netto Betrag übergibt, dann wird die MwSt. automatisch mit 19% gerechnet. 
     * Ansonsten kann man aber natürlich auch alles übergeben
     * 
     * 
     */
    public function create($data) {

        // Eine neue Rechnung erstellen
        $req = new Request($data);

        // Standard-Werte
        $req->data['datum'] = date('Y-m-d H:i:s');
        $req->data['status_id'] = 1;
        $req->data['gezahlt'] = 0;

        // Check Required
        if($req->checkRequired(['adresse_id','herkunft','referenz_id','netto'])) {

            // Prüfen, dass auch ein MwSt. Satz angegeben wurde
            $missingMwst = (isset($req->data['mwst']) && (!$req->data['mwst1_satz'] || !$req->data['mwst1_betrag'])) ? true : false;

            if(!$missingMwst) {

                // Standard MwSt. errechnen, wenn nicht mitgegeben wurde
                if(!isset($req->data['mwst']) && !isset($req->data['mwst1_satz']) && !isset($req->data['mwst1_betrag'])) {
                    $req->data['mwst1_satz'] = 19;
                    $req->data['mwst'] = $req->data['mwst1_betrag'] = $req->data['netto'] * 1.19;
                }            

                // Double Check MwSt. 
                $result = $this->doubleCheckMwst($req->data);

                if($result['success']) {

                    // verarbeiten
                    $process = [
                        ['dt','datum'],
                        ['t','adresse_id'],
                        ['t','status_id'],
                        ['t','herkunft'],
                        ['t','referenz_id'],
                        ['t','netto'],
                        ['t','mwst'],
                        ['t','mwst1_satz'],
                        ['t','mwst1_betrag'],
                        ['t','mwst2_satz'],
                        ['t','mwst2_betrag'],
                        ['t','mwst3_satz'],
                        ['t','mwst3_betrag'],
                        ['t','gezahlt']
                    ];

                    // Insert 
                    $req->insert($this->table, $process);

                } else {
                    $req->adapt($result);
                }

                // Rechnung erstellen
            } else {
                $req->error = "Es wurde ein MwSt. Betrag übergeben, aber keine Satz!";
            }
    
        // Wenn nicht alle notwendigen Felder stimmen
        } else {
            $req->error = "Es wurden nicht alle notwendigen Daten angegeben!";
        }

        // Rückgabe
        return $req->answer();

    }

    /**
     * Alle Werte noch einmal gegeneinander Rechnen
     */
    public function doubleCheckMwst($data) {
        
        $req = new Request();   
        
        if(isset($data['mwst']) && isset($data['mwst1_satz']) && isset($data['mwst1_betrag'])) {
            
            // Prüfen, dass wenn es weitere MwSt. gibt, dass der Datensatz vollständig ist
            $singleValue2 = (!isset($data['mwst2_satz']) && isset($data['mwst2_betrag'])) || (isset($data['mwst2_satz']) && !isset($data['mwst2_betrag']));
            $singleValue3 = (!isset($data['mwst3_satz']) && isset($data['mwst3_betrag'])) || (isset($data['mwst3_satz']) && !isset($data['mwst3_betrag']));

            // Prüfen auf vollständigkeit
            if(!$singleValue2 && !$singleValue3) {

                // Summe errechnen 
                $summeMwSt = $data['mwst1_betrag'] + ((isset($data['mwst2_betrag'])) ? floatval($data['mwst2_betrag']) : 0) + ((isset($data['mwst3_betrag'])) ? floatval($data['mwst3_betrag']) : 0);  
                
                if($summeMwSt === floatval($data['mwst'])) {
                    $req->success = true;
                } else {
                    $req->error = "Die Aufteilung des Mwst Satzes passt nicht zur MwSt.";
                }

            } else {
                $req->error = "Es wurde ein Satz ohne Betrag oder andersherum angegeben";
            }

        } else {
            $req->error = "Fehlender MwSt Satz";
        }
        
        // Rückgabe
        return $req->answer();
    }





}   