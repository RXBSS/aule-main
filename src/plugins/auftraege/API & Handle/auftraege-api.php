<?php



// Auftrag API
class Auftrag {


    public $tableHead = "auftraege";
    public $tablePos = "auftraege_positionen";

    function __construct($id = false) {
        // Do Something at Construction

        // Neue Historie
        $this->history = new History("auftraege");

        // Lieferungen anfügen
        $this->Lieferungen = new AuftraegeLieferungen();

        // Positionen
        $this->pos = new AuftraegePositionen($this->tablePos, 'auftrag_id');
    }

    // Neu erstellen
    public function new($ersteller) {

        // Daten für den Auftrag
        $req = new Request([
            'status_id' => 1,
            'ersteller_id' => 1,
            'erstellt_datum' => date("Y-m-d H:i:s")
        ]);

        // Verarbeitungsarray
        $process = [
            ['t', 'status_id'],
            ['t', 'ersteller_id'],
            ['dt', 'erstellt_datum'],
        ];

        // Ergebnis
        $req->insert($this->tableHead, $process);

        // Antwort schreiben
        return $req->answer();
    }


    // Auftragsdaten holen!
    public function get($id) {

        $req = new Request();

        // Simple Get
        $query = "
            SELECT a.*, k.bezeichnung AS kostenstelle_name, z.text AS zahlungsbedingung_text, z.bezeichnung AS zahlungsbedingung_bez,
                lf.id AS lf_id, lf.name AS lf_name, lf.strasse AS lf_strasse, lf.plz AS lf_plz, lf.ort AS lf_ort, lf.land AS lf_land,
                re.id AS re_id, re.name AS re_name, re.strasse AS re_strasse, re.plz AS re_plz, re.ort AS re_ort, re.land AS re_land, 
                re.kunde_gesperrt AS re_gesperrt, re.kunde_gesperrt_grund AS re_gesperrt_grund, re.kunde_gesperrt_mitarbeiter AS re_gesperrt_mitarbeiter,
                a.besteller_id, kt.vorname, kt.nachname

            FROM " . $this->tableHead . " a 
            LEFT JOIN adressen lf ON a.lieferanschrift_id = lf.id
            LEFT JOIN adressen re ON a.rechnungsanschrift_id = re.id
            LEFT JOIN kontakte kt ON a.besteller_id = kt.id
            LEFT JOIN kostenstellen k ON a.kostenstelle_id = k.id
            LEFT JOIN zahlungsbedingungen z ON a.zahlungsbedingung_id = z.id
            WHERE a.id = '" . $id . "';
        ";


        $req->getQuery($query);

        if ($req->success) {

            // Weiteren Daten bearbeiten
            $req->result['hat_liefertermin'] = ($req->result['liefertermin']) ? true : false;
            $req->result['lf_gleich_re'] = ($req->result['lf_id'] == $req->result['re_id']) ? true : false;
            $req->result['besteller_name'] = trim($req->result['vorname'] . " " . $req->result['nachname']);
        }

        // Antwort schreiben
        return $req->answer();
    }


    // Bearbeiten
    public function edit($id, $data) {

        // Request
        $req = new Request($data);

        // Verarbeitungsarray
        $process = [
            ['t', 'lieferanschrift_id'],
            ['t', 'rechnungsanschrift_id'],
            ['t', 'herkunft'],
            ['t', 'referenz'],
            ['t', 'liefertermin'],
            ['s', 'kostenstelle_id'],
            ['s', 'besteller', 'besteller_id'],
            ['s', 'zahlungsbedingung_id'],
            ['c', 'teillieferung'],
        ];

        // Ergebnis
        $req->update($this->tableHead, $process, "WHERE `id` = '" . $id . "'");

        // Antwort schreiben
        return $req->answer();
    }


    // Löschen
    public function delete($id) {

        // Main Request
        $mainReq = new Request();

        if ($this->checkIfDeleteable($id)) {

            // Auftragskopf löschen
            $del = new Request();
            $del->delete($this->tableHead, $id);

            if ($del->success) {

                // Auftragspositionen löschen!

                $mainReq->success = true;
            }
        } else {
            $mainReq->error = "Der Auftrag ist nicht löschbar!";
        }

        // Rückgabe
        return $mainReq->answer();
    }





    // Check Löschbar
    public function checkIfDeleteable($id) {

        // Hier muss geprüft werden, ob der Auftrag gelöscht werden kann


        return true;
    }

    /**
     * Prüft ob aus dem Entwurf ein Auftrag gemacht werden darf!
     */
    public function entwurfValidieren($id) {

        $req = new Request();

        // Prüfen ob der Kunde gesperrt ist!
        // Sollte aber vorher schon in der GUI sichtbar sein

        $auftrag = $this->get($id);

        // Wenn der Auftrag nicht gefunden werden konnte
        if ($auftrag['success']) {

            if ($auftrag['data']['re_gesperrt'] != '1') {

                // Prüfen ob Positionen vorhanden sind
                $pos = $this->pos->getAllById($id);

                if ($pos['success']) {

                    // Request
                    $req->success = true;

                    // Zero Position
                    $hasZeroNumber = false;

                    // Loop durch alle Positionen durchführen
                    foreach ($pos['data'] as $key => $value) {

                        // Prüfen ob es eine Menge gibt
                        if ($value['menge'] == 0) {
                            $hasZeroNumber = true;
                        }
                    }

                    // 
                    if (!$hasZeroNumber) {

                        // Wenn alles erfolgreich war
                        $req->success = true;
                    } else {
                        $req->error = "Mindestens eine Position hat keine Menge";
                    }
                } else {
                    $req->error = "Keine Positionen im Auftrag hinterlegt!";
                }
            } else {
                $req->error = "Der Kunde ist gesperrt. Der Kunde muss zunächst entsperrt werden, bevor er wieder bedient werden kann!";
            }
        }

        // Rückgabe
        return $req->answer();
    }


    public function entwurfWirdAutrag($id) {

        $req = new Request([
            'status_id' => 2
        ]);

        // Prüfen, dass der Auftrag verarbeitet werden kann
        $result = $this->entwurfValidieren($id);

        // Wenn der Auftrag verarbeitet werden kann
        if ($result['success']) {

            $process = [
                ['t', 'status_id']
            ];

            // Update durchführen
            $req->update($this->tableHead, $process, "WHERE `id` = '" . $id . "'");
        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }

    // Positionsbezogenes AUSLAGERN


    // Edit Positions
    public function editPosition($pos_id, $data) {

        // Daten
        $req = new Request($data);

        // Verarbeitungsarray
        $process = [
            ['t', 'menge'],
            ['t', 'ek'],
            ['t', 'vk'],
            ['t', 'steuer'],
            ['t', 'rabatt_betrag'],
            ['t', 'rabatt_prozent']
        ];

        // Ergebnis
        $req->update($this->tablePos, $process, "WHERE `id` = '" . $pos_id . "'");

        // Antwort schreiben
        return $req->answer();
    }


    // Position ID
    public function deletePosition($pos_id, $reihenfolge = true) {

        // Zeile löschen
        $del = new Request();

        // Auftrag ID 
        $auftrag = $this->pos->getRefByPosId($pos_id);

        // Prüfen ob der Auftrag aus der Positionsnummer gelesen werden konnte
        if ($auftrag['success']) {

            // Auftrags ID auslesen
            $auftrag_id = $auftrag['data']['auftrag_id'];

            // Delelte Query ausführen
            $del->delete($this->tablePos, $pos_id);

            // Prüfen ob die Zeilen neu sortiert werden müssen
            if ($reihenfolge) {
                $this->pos->reorder($this->pos->getAllById($auftrag_id));
            }
        } else {
            $del->error = "Fehler beim lesen der Positionsdaten";
        }

        // Antwort geben
        return $del->answer();
    }

    public function deletePositions($pos_ids) {

        $pos_ids = (is_array($pos_ids)) ? $pos_ids : [$pos_ids];

        // Request
        $del = new Request();
        $del->success = true;

        // Schleife durch alle Positionen
        foreach ($pos_ids as $key => $value) {

            // Einzelne Zeile löschen!
            $delResult = $this->deletePosition($value, false);

            // Bei einem Fehler abbrechen!
            if (!$delResult['success']) {

                // Fehlermeldung ausgeben
                $del->success = false;
                $del->error = "Fehler beim Löschen einer Position";

                break;
            }
        }

        // Rückgabe
        return $del->answer();
    }

    /**
     * Löscht alle Positionen
     * 
     * 
     */
    public function deleteAllPositions($auftrag_id) {

        // Request
        $del = new Request();

        // Positionsdaten
        $pos = $this->pos->getAllById($auftrag_id);

        // Prüfen ob die Positionsdaten existieren
        if ($pos['success']) {

            // Schleife durch alle Positionen
            foreach ($pos['data'] as $key => $value) {

                // Einzelne Zeile löschen!
                $delResult = $this->deletePosition($value['id'], false);

                // Bei einem Fehler abbrechen!
                if (!$delResult['success']) {

                    // Fehlermeldung ausgeben
                    $del->error = "Fehler beim Löschen einer Position";

                    break;
                }
            }

            // Wenn keine Positionsdaten gefunden wurden!
        } else {
            $del->error = $pos['error'];
        }

        // Rückgabe
        return $del->answer();
    }


    /**
     * Gibt an, ob ein Auftrag beliefert werden kann.
     * Dabei bezieht sich die Funktion immer auf die noch nicht gelieferte Ware
     * 
     * Status: 0 = keine, 1 = teilweise, 2 = vollständig
     * 
     * // TODO: Auf ein Lager beschränken?
     * 
     */
    public function getLieferStatus($auftrag_id, $withLager = false) {

        // Neuer Request
        $req = new Request();

        // Auf ein bestimmtes Lager beschränken
        if ($withLager !== false) {
            $withLager = (is_array($withLager)) ? $withLager : [$withLager];
        }

        $auftrag = $this->get($auftrag_id);

        if ($auftrag['success']) {

            // Status der Lieferung
            $pos = $this->pos->getAllById($auftrag_id);

            // Wenn die Positionen ausgelesen werden konnte
            if ($pos['success']) {

                // Artikel API
                $artikelApi = new Artikel();

                // Initalisieren
                $req->result = [
                    'status' => 0,
                    'status_detail' => [
                        'prozent' => [
                            'anzahl' => 0,
                            'warenwert' => 0
                        ],
                        'gesamt' => [
                            'bedarf' => 0,
                            'verfuegbar' => 0,
                            'geliefert' => 0,
                            'menge' => 0
                        ],
                        'artikel' => [
                            '0' => [],
                            '1' => [],
                            '2' => []
                        ],
                        'pos' => [
                            '0' => [],
                            '1' => [],
                            '2' => []
                        ],
                    ],
                    'pos' => $pos['data'],
                    'auftrag' => $auftrag['data'],
                    'artikel' => [],
                ];

                // Artikel und Menge Extrahieren
                $artikel = [];

                // Schleife durch alle Positionen
                // ******************************                
                foreach ($pos['data'] as $key => $value) {

                    // Wenn der Artikel zum ersten Mal auftaucht
                    if (!isset($req->result['artikel'][$value['artikel_id']])) {

                        // Setzen
                        $req->result['artikel'][$value['artikel_id']] = [
                            'verfuegbar' => 0,
                            'gesamt' => 0,
                            'bedarf' => 0,
                            'rest' => 0,
                            'differenz' => 0,
                            'lieferstatus' => 0,
                            'pos' => []
                        ];
                    }

                    // Gesamt errechnen
                    $req->result['artikel'][$value['artikel_id']]['gesamt'] = $req->result['artikel'][$value['artikel_id']]['gesamt'] + $value['menge'];
                    $req->result['artikel'][$value['artikel_id']]['bedarf'] = $req->result['artikel'][$value['artikel_id']]['bedarf'] + $value['bedarf'];

                    $req->result['artikel'][$value['artikel_id']]['pos'][$key] = [
                        'verfuegbar' => 0,
                        'menge' => $value['menge'],
                        'lieferstatus' => 0
                    ];
                }


                // Schleife durch alle Artikel 
                // ***************************

                // Mengen prüfen
                foreach ($req->result['artikel'] as $artikelId => $a) {

                    // Artikel Info
                    $a['verfuegbar'] = $artikelApi->getBestandVerfuegbar($artikelId);
                    $a['differenz'] = $a['verfuegbar'] - $a['bedarf'];

                    // Wenn etwas verfübar ist
                    if ($a['verfuegbar'] > 0) {

                        // Lieferstatus setzen
                        $a['lieferstatus'] = ($a['verfuegbar'] >= $a['bedarf']) ? 2 : 1;

                        $laufendeZaehler = $a['verfuegbar'];

                        // Auf Positionsebene durchgehen
                        // Positionen werden dabei von Oben nach unten gefüllt!
                        foreach ($a['pos'] as $posId => $posVal) {

                            if ($laufendeZaehler > 0) {
                                $a['pos'][$posId]['lieferstatus'] = ($laufendeZaehler >= $posVal['menge']) ? 2 : 1;
                                $a['pos'][$posId]['verfuegbar'] = ($laufendeZaehler >= $posVal['menge']) ? $posVal['menge'] : $laufendeZaehler;
                                $laufendeZaehler = ($laufendeZaehler >= $posVal['menge']) ? $laufendeZaehler - $posVal['menge'] : 0;
                            }
                        }
                    } else {
                        $laufendeZaehler = 0;
                    }

                    $a['rest'] = $laufendeZaehler;

                    // Positionsinfos aus dem Artikel entfernen und zu den Positionen hinzufügen
                    foreach ($a['pos'] as $posId => $posVal) {
                        $req->result['pos'][$posId] = array_merge($req->result['pos'][$posId], $posVal);
                        $req->result['status_detail']['pos'][$posVal['lieferstatus']][] = $posId;
                    }

                    // Aus dem Artikel löschen
                    unset($a['pos']);

                    $req->result['status_detail']['artikel'][$a['lieferstatus']][] = $artikelId;
                    $req->result['artikel'][$artikelId] = $a;
                }

                // Prozentuales Verhältnis ausrechnen
                foreach ($req->result['pos'] as $posId => $posVal) {
                    $req->result['status_detail']['gesamt']['menge'] = $req->result['status_detail']['gesamt']['menge'] + $posVal['menge'];
                    $req->result['status_detail']['gesamt']['bedarf'] = $req->result['status_detail']['gesamt']['bedarf'] + $posVal['bedarf'];
                    $req->result['status_detail']['gesamt']['geliefert'] = $req->result['status_detail']['gesamt']['geliefert'] + $posVal['geliefert'];
                    $req->result['status_detail']['gesamt']['verfuegbar'] = $req->result['status_detail']['gesamt']['verfuegbar'] + $posVal['verfuegbar'];
                }


                // Prüfen ob überhaupt ein Bedarf da ist
                if ($req->result['status_detail']['gesamt']['bedarf'] > 0) {

                    // Wenn alle Artikel vollständig lieferbar sind
                    if (count($req->result['status_detail']['artikel'][0]) == 0 && count($req->result['status_detail']['artikel'][1]) == 0) {
                        $req->result['status'] = 2;
                        $req->result['status_detail']['prozent']['anzahl'] = 100;


                        // Wenn Teilweise oder vollständig zumindest einen Artikel hat
                    } else if (count($req->result['status_detail']['artikel'][1]) > 0 || count($req->result['status_detail']['artikel'][2]) > 0) {
                        $req->result['status'] = 1;

                        // Prozent errechnen
                        $req->result['status_detail']['prozent']['anzahl'] = ($req->result['status_detail']['gesamt']['verfuegbar'] / $req->result['status_detail']['gesamt']['bedarf']) * 100;
                    }

                    // 
                    $req->result['auftrag']['soll_status'] = 2;

                    // Wenn kein Bedarf da ist
                } else {
                    $req->result['status'] = 3;
                    $req->result['status_detail']['prozent']['anzahl'] = 100;
                    $req->result['auftrag']['soll_status'] = 3;
                }

                // Auf Success setzen
                $req->success = true;
            } else {
                $req->adapt($pos);
            }
        } else {
            $req->adapt($auftrag);
        }

        // Rückgabe
        return $req->answer();
    }

    /**
     * Prüft den aktuellen Lieferstatus und setz diesen ggf. neu
     * 
     * // TODO: Ggf. kann man hier in Zukunft unterscheiden zwischen es ist bereits etwas bestellt, etc. Momentan werden Sie einfach erstmal als offen markiert
     * 
     */
    public function setLieferstatus($auftragId) {

        // Neuen Request
        $req = new Request();

        $result = $this->getLieferStatus($auftragId);

        // Den Lieferstatus
        if ($result['success']) {

            // Status vorher
            $statusVorher = $result['data']['auftrag']['status_id'];

            // Wenn es ein offener Status ist
            if (in_array($statusVorher, [2, 3]) && $result['data']['auftrag']['soll_status'] != $statusVorher) {

                // Request
                $subReq = new Request([
                    'status_id' => $result['data']['auftrag']['soll_status']
                ]);

                $process = [
                    ['t', 'status_id']
                ];

                // Update durchführen
                $subReq->updateById($this->tableHead, $process, $auftragId);

                $req->log[] = "Der Status wurde angepasst";

                // SubRequest übernehmen
                $req->adapt($subReq);

                // Durchführen
                $req->result = [
                    'status_id' => $result['data']['auftrag']['soll_status']
                ];

                // Historie
                $auftrag = new Auftrag();


                // Wenn der Status beliefert gesetzt wurde
                if ($statusVorher == 2 && $result['data']['auftrag']['soll_status'] == 3) {
                    $auftrag->history->write('status_beliefert', $result['data']['auftrag']['id']);
                }
            } else {
                $req->log[] = "Der Status ist bereits der richtige";
                $req->success = true;

                // Durchführen
                $req->result = [
                    'status_id' => $statusVorher
                ];
            }
        } else {
            $req->adapt($result);
        }

        // Rückgabe
        return $req->answer();
    }



    /**
     * Automatisch Liefern
     */
    public function automatischLiefern($id, $teilweise = false) {

        $req = new Request();

        // Lieferstatus
        $result = $this->getLieferStatus($id);

        if ($result['success']) {

            $data = $result['data'];


            if (($teilweise === false && $data['status'] === 2) || ($teilweise === true && $data['status'] == 1)) {

                // Daten in die Datenbank schreiben
                foreach ($data['pos'] as $key => $value) {

                    // Neuen Sub Request
                    $subreq = new Request([
                        'liefern' => $value['verfuegbar']
                    ]);

                    // Verarbeiten
                    $process = [
                        ['t', 'liefern']
                    ];

                    $subreq->update($this->tablePos, $process, "WHERE `id` = '" . $value['id'] . "'");
                }

                // TODO: Fehler noch abfangen!
                $req->success = true;
            } else {
                $req->error = "Der Lieferstatus hat sich geändert und spricht nicht mit dem angeforderte überein";
            }
        } else {
            $req->adapt($result);
        }

        return $req->answer();
    }


    /**
     * Rechnung
     * -- 
     * Prüfen, dass der Auftrag vollständig beliefert wurde
     * 
     *  
     */
    public function rechnungErstellen($auftragId) {

        // APIs
        $Rechnung = new Rechnungen();

        // Request
        $req = new Request();

        // Lieferresult
        $reResult = $this->checkRechnungMoeglich($auftragId);

        // Wenn es passt
        if ($reResult['success']) {

            // Summe der Positionen auslesen
            $posResult = $this->pos->getSum($auftragId);

            // Ergebnis der Positionen
            if ($posResult['success']) {

                // Mwst
                $mwst = [
                    'mwst1_satz' => false,
                    'mwst1_betrag' => false,
                    'mwst2_satz' => false,
                    'mwst2_betrag' => false,
                    'mwst3_satz' => false,
                    'mwst3_betrag' => false
                ];

                // 
                $i = 1;

                // Alle MwSt Sätze durchgehen
                foreach ($posResult['data']['mwst_saetze'] as $satz => $wert) {

                    // Mwst setzen
                    $mwst['mwst' . $i . '_satz'] = $satz;
                    $mwst['mwst' . $i . '_betrag'] = $wert;

                    $i++;
                }

                // Array zur Übergabe erstellen
                $arrayZurUebergabe = array_merge([
                    'adresse_id' => $reResult['data']['auftrag']['rechnungsanschrift_id'],
                    'herkunft' => 'auftrag',
                    'referenz_id' => $auftragId,
                    'netto' => $posResult['data']['netto'],
                    'mwst' => $posResult['data']['mwst'],
                ], $mwst);

                // Rechnung erstellen
                $docResult = $Rechnung->create($arrayZurUebergabe);

                // Wenn alles geklappt
                if ($docResult['success']) {


                    // Status ändern
                    $subReq = new Request([
                        'status_id' => 4
                    ]);

                    // Update durchführen
                    $subReq->updateById($this->tableHead, [['t', 'status_id']], $auftragId);

                    // SubRequest übernehmen
                    if ($subReq->success) {

                        // Wenn alles geklappt hat
                        $req->success = true;

                        // Historie schreiben
                        $this->history->write('status_rechnung', [$auftragId, $docResult['data']]);
                    } else {
                        $req->adapt($subReq);
                    }
                } else {
                    $req->adapt($posResult);
                }
            } else {
                $req->adapt($posResult);
            }
        } else {
            $req->adapt($reResult);
        }

        // Rückgabe
        return $req->answer();
    }


    public function checkRechnungMoeglich($auftragId) {
        // Request
        $req = new Request();

        // Lieferresult
        $lieferResult = $this->getLieferStatus($auftragId);

        // Lieferstatus konnte erfolgreich abgefragt werden
        if ($lieferResult['success']) {

            // Wenn der Status 3 ist
            if ($lieferResult['data']['status'] == 3) {

                // Nur offene Aufträge 
                if ($lieferResult['data']['auftrag']['status_id'] == 3) {
                
                    // TODO: Noch prüfen ob die Rechnungsnummer schon in der Datenbank ist?? Würde aber nicht mit Gutschriften funktionieren, weil sich diese ja auf die gleichen Daten beziehen!
                    // Maybe more Magic??

                    // 
                    $req->adapt($lieferResult);

                } else {
                    $req->error = "Es handelt sich nicht um einen offenen Auftrag";
                }
            } else {
                $req->error = "Der Auftrag wurde noch nicht vollständig beliefert!";
            }
        } else {
            $req->adapt($lieferResult);
        }

        // Zurückgeben
        return $req->answer();
    }
}
