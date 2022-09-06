<?php

/**
 * Lieferungen
 * 
 * 
 * 
 */
class AuftraegeLieferungen {


    function __construct() {
        $this->tableHead = 'auftraege_lieferungen';
        $this->tablePos = 'auftraege_lieferungen_positionen';
        $this->history = new History("auftraege");
    }

    // Neue Lieferung erstellen
    function create($auftragId, $userId) {

        // Neuen Request
        $req = new Request([
            'auftrag_id' => $auftragId,
            'zeitstempel' => date('Y-m-d H:i:s'),
            'status_id' => 1
        ]);

        // Verarbeiten
        $process = [
            ['t', 'auftrag_id'],
            ['dt', 'zeitstempel'],
            ['t', 'status_id']
        ];

        // Wenn das schreiben Erfolgreich war
        $req->insert($this->tableHead, $process);

        if ($req->success) {

            // Historie schreiben
            $this->history->write('neue_lieferung', [$auftragId, $req->result], $userId);
            
        }

        return $req->answer();
    }


    // Gibt alle Informationen zur Lieferung zurück
    function get($lieferungId) {
        $req = new Request();
        $req->get($this->tableHead, $lieferungId);
        return $req->answer();
    }

    /**
     * Erstellt eine Neue Lieferung und übernimmt sofort den Vorschlag
     */
    function createWithVorschlag($auftragId, $userId) {

        $req = new Request();

        // Liefervorschlag prüfen
        $checkResult = $this->checkLiefervorschlag($auftragId);

        // Wenn die Lieferung erstellt werden kann
        if ($checkResult['success']) {

            // Lieferung
            $lieferung = $this->create($auftragId, $userId);

            // Lieferung
            if ($lieferung['success']) {

                // ID der neuen Lieferung
                $lieferungId = $lieferung['data'];

                // Liefervorschlag in die neue Lieferung einfügen
                $result = $this->insertFromLieferVorschlag($lieferungId, $userId);

                // Ergebnis aus der Überfunktion übernehmen
                $req->adapt($result);
            }

            // Wenn beim Anlegen der Lieferung etwas nicht geklappt hat
            else {
                $req->adapt($lieferung);
            }
        } 
        
        // Wenn beim Prüfen des Liefervorschlags etwas schief gegangen ist
        else {
            $req->adapt($checkResult);
        }

        // Rückgabe
        return $req->answer();
    }

    /**
     * Erstellt einen Lieferung 
     * 
     * 
     * 
     * 
     *
     * @param [type] $lieferungId
     * @param [type] $userId
     * @return void
     */
    function insertFromLieferVorschlag($lieferungId, $userId) {

        $req = new Request();

        // Request
        $req = new Request();

        // Auftrag auslesen
        $lieferResult = $this->get($lieferungId);

        // Prüfen ob die Informationen aus der Lieferung ausgelesen werden konnte
        if ($lieferResult['success']) {

            // Liefervorschlag prüfen
            $checkResult = $this->checkLiefervorschlag($lieferResult['data']['auftrag_id']);

            // Wenn der Liefervorschlag in Ordnung ist
            if ($checkResult['success']) {

                // Alle Positionen löschen
                $delResult = $this->deleteAllPos($lieferungId);

                // Wenn alles gelöscht wurde
                if ($delResult['success']) {

                    // Artikel API
                    $artikel = new Artikel();

                    // TODO: Die LagerId muss ggf. noch aus den Positionen gezogen werden
                    $lagerId = 1;

                    // TODO: Hier muss ggf. geprüft werden, dass alles geklappt hat. Falls nichts, muss alles rückgängig gemacht werden
                    $resetArray = [];

                    // Variable zum prüfen, dass alles Fehlerfrei durch die Schleife läuft
                    $running = true;

                    // Kürzen der Variable
                    $d = $checkResult;


                    // Schliefe
                    foreach ($d['data']['pos'] as $key => $value) {

                        if ($running) {

                            // Bewegung hinzufügen     
                            $resBewegung = $artikel->changeBestand($value['artikel_id'], $lagerId, - ($value['liefern']), "lf", [
                                'ref1' => $lieferResult['data']['id'],
                                'ref2' =>  $lieferResult['data']['auftrag_id'],
                                'ref3' =>  $d['data']['auftrag']['lieferanschrift_id'],
                                'user_id' => $userId
                            ]);

                            // Prüfen, ob die Bestandsänderung in die Datenbank eingetragen wurde
                            if ($resBewegung['success']) {

                                // TODO: Reset Informationen speichern, falls es im Laufe noch zu einem Fehler kommt!
                                $reset[] = ['some' => 'Info für ChangeBestand Rückgängig machen'];

                                // Dann die Position in die Lieferung schreiben
                                $resPos = $this->insertPos($lieferResult['data']['id'], $value['id'], $value['liefern']);

                                // Wenn das einfügen der Position erfolgreich war
                                if ($resPos['success']) {

                                    // TODO: Reset Informationen speichern, falls es im Laufe noch zu einem Fehler kommt!
                                    $reset[] = ['some' => 'Info für Insert Pos Rückgängig machen'];

                                    // Wenn etwas schief geht
                                } else {
                                    $req->adapt($resPos);
                                    $running = false;
                                }

                                // Wenn etwas schief geht
                            } else {
                                $req->adapt($resBewegung);
                                $running = false;
                            }
                        }
                    }

                    // Wenn alles geklappt hat
                    if ($running) {

                        // Auftrag API
                        $auftrag = new Auftrag();

                        // Zurücksetzen der Spalte
                        $auftrag->pos->changeColumn($auftrag->pos->getAllById($lieferResult['data']['auftrag_id']), "liefern", 0);

                        // Lieferschein drucken
                        $doc = new LieferscheinDoc($lieferungId);

                        // Dokument erstellen
                        $createResult = $doc->create();

                        // Lieferstatus überarbeiten
                        if($createResult['success']) {

                            // Lieferstatus setzen
                            $lieferStatusResult = $auftrag->setLieferstatus($lieferResult['data']['auftrag_id']);

                            // Übernehmen
                            $req->adapt($lieferStatusResult);
                            


                        // Else Abfrage
                        } else {

                            // Daten übernehmen
                            $req->adapt($createResult);

                        }

                    
                        /// Test
                    } else {
                        // TODO: Rückabwicklung!
                        $req->log[] = "Hier müsste die Rückabwicklung stattfinden";
                    }

                    // Löschung der Positionen ist fehlgeschlagen
                } else {
                    $req->adapt($delResult);
                }

                // Prüfung ist fehlgeschlagen
            } else {
                $req->adapt($checkResult);
            }

            // Lieferung exisitiert nicht
        } else {
            $req->adapt($lieferResult);
        }

        // Antworten
        return $req->answer();
    }



    /**
     * Prüft ob der Vorschlag belieferbar ist
     * 
     * // TODO: Kann Theoretisch noch in die getLieferStatus Funktion gemergt werden und wird damit überflüssig
     * 
     * 
     */
    function checkLiefervorschlag($auftragId) {

        $req = new Request();

        // Auftrag
        $auftrag = new Auftrag();

        // Positionen auslesen
        $positions = $auftrag->getLieferStatus($auftragId);

        // Wenn alles gelöscht wurde
        if ($positions['success']) {

            // Prüfen der Artikel
            $alleLieferBar = true;
            $keinLieferVorschlag = true;

            // Schliefe durch alle Positionen
            foreach ($positions['data']['pos'] as $key => $value) {

                // Prüfen ob Lieferbar
                if ($value['liefern'] > 0) {

                    // Mindestens 1 Artikel ist nicht mehr Lieferbar
                    if ($value['verfuegbar'] < $value['liefern']) {
                        $alleLieferBar = false;
                    }

                    // Wenn mindestens kein Artikel eine Liefermenge hat
                    $keinLieferVorschlag = false;
                }
            }

            // Mindestens ein Artikel zur Lieferung ausgewählt 
            if (!$keinLieferVorschlag) {

                // Wenn nicht alle Positionen eines Vorschlags lieferbar sind
                if (!$alleLieferBar) {
                    $req->error = "Es sind nicht alle Positionen verfügbar";

                    // Wenn alles ok ist, dann übernehmen
                } else {
                    $req->adapt($positions);
                }

                // Keine Artikel zur Lieferung ausgewählt
            } else {
                $req->error = "Es sind keine Artikel zur Lieferung ausgewählt";
            }

            // Wenn keine Positionen ausgegeben werden konnte
        } else {
            $req->adapt($positions);
        }

        // Ausgabe
        return $req->answer();
    }


    /**
     * Alle Positionen auslesen
     * 
     * @param integer 
     */
    function getAllPositions($lieferungId) {

        $req = new Request();

        // Mehrere Daten auslesen
        $req->getMultiByKey($this->tablePos, "lieferung_id", $lieferungId);

        // Wenn Die Daten ausgelesen wurden
        if ($req->success) {

            // Auftrag auslesen
            $auftrag = new Auftrag();

            // Schliefe durch alle Positionen
            foreach ($req->result as $key => $value) {

                $posResult = $auftrag->pos->getByPosId($value['pos_id']);

                // Wenn Ergebnisse aus dem Auftrag da sind
                if ($posResult['success']) {

                    // Auftragsposition hinzufügen
                    $req->result[$key] = $posResult['data'];
                    $req->result[$key]['lieferung_id'] = $value['lieferung_id'];
                    $req->result[$key]['lieferung_pos_id'] = $value['id'];
                    $req->result[$key]['lieferung_menge'] = floatval($value['menge']);
                } else {
                    $req->error = "Es konnten nicht alle Positionen ausgelesen werden!";
                    $req->succes = false;
                    break;
                }
            }

            // Fehler ausgeben
        } else {
            $req->error = "Fehler beim Abfragen der Positionen";
        }

        // Rückgabe
        return $req->answer();
    }


    // Ersetzt die Positionen einer Lieferung
    function replacePos($lieferungId, $lfPosData) {

        // Request
        $req = new Request();

        // Alle löschen
        $result = $this->deleteAllPos($lieferungId);

        // Wenn alles gelöscht wurde
        if ($result['success']) {

            // Auftrag auslesen
            $lieferInfo = $this->get($lieferungId);

            if ($lieferInfo['success']) {

                // Auftrag
                $auftrag = new Auftrag();

                // Schleife durch alle Daten die hinzugefügt werden sollen
                foreach ($lfPosData as $lfPos) {

                    // Positionsinfo
                    $posId = $lfPos[0];

                    // Infos der Position auslesen
                    $posInfo = $auftrag->pos->getByPosId($posId);

                    // Wenn die Menge kleiner = ist
                    // TODO: Was ist bei Negativ?
                    if ($posInfo['success']) {

                        // Menge die beliefert werden soll
                        $menge = ($lfPos[1] <= $posInfo['data']['menge']) ? $lfPos[0] : $posInfo['data']['menge'];


                        // Prüfen, dass die Menge beliefert werden kann

                        // Einfügen der Position
                        $insertResult = $this->insertPos($lieferungId, $posId, $menge);

                        if ($insertResult['success']) {
                        } else {
                            // Schleife beenden
                            $req->adapt($lieferInfo);
                            break;
                        }

                        // Was im Fehlerfall tun?
                    } else {
                        // Ignorieren der Zeile
                    }
                }
            } else {
                $req->adapt($lieferInfo);
            }

            // Wenn es einen Fehler gab
        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }

    /**
     * Alle Positionen löschen
     */
    function deleteAllPos($lieferungId) {
        $req = new Request();
        $query = "DELETE FROM `" . $this->tablePos . "` WHERE `lieferung_id` = '" . $lieferungId . "';";
        $req->deleteQuery($query);
        return $req->answer();
    }



    // Position einfügen    
    function insertPos($lieferungId, $posId, $menge) {

        // Neuen Request
        $req = new Request([
            'lieferung_id' => $lieferungId,
            'pos_id' => $posId,
            'menge' => $menge
        ]);

        // Verarbeiten
        $process = [
            ['t', 'lieferung_id'],
            ['t', 'pos_id'],
            ['t', 'menge']
        ];

        $req->insert($this->tablePos, $process);

        // Wenn das einfügen geklappt hat
        if ($req->success) {

            $auftrag = new Auftrag();

            // Prüfen
            $result = $auftrag->pos->getByPosIdosId($posId);

            if ($result['success']) {

                // Bedarf prüfen
                if ($menge <= $result['data']['bedarf']) {

                    // Neuer Lieferwert                    
                    $neuGeliefertWert = $result['data']['geliefert'] + $menge;

                    // Neuen Request
                    $subReq = new Request([
                        'geliefert' => $neuGeliefertWert
                    ]);

                    // Verarbeiten
                    $process = [
                        ['t', 'geliefert']
                    ];

                    // Update durchführen
                    $subReq->update($auftrag->tablePos, $process, "WHERE `id` = '" . $posId . "'");

                    // Ergebnis übernehmen
                    $req->adapt($subReq);

                    // Rückabwicklung durchführen
                    if (!$subReq->success) {
                        $req->reset();
                    }
                } else {
                    $req->reset();
                    $req->error = "Es soll mehr beliefert werden, als Bedarf da ist";
                }
            } else {
                $req->adapt($result);
            }
        }

        // Rückgabe
        return $req->answer();
    }
}
