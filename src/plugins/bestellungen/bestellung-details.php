<?php include('01_init.php');

$_page = [
    'title' => "Bestellungen Details",
    'breadcrumbs' => ['<i class="fa-solid fa-cogs"></i> Prozesse', '<a href="bestellungen"><i class="fa-solid fa-shopping-cart"></i> Bestellungen</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>


    <style>
        #timeline-container {
            margin-right: -370px;
        }

        #timeline-container.open {
            margin-right: 0;
        }
    </style>

</head>

<body>
    <?php include('03_navigation.php'); ?>


    <div class="wrapper loading">

        <form id="form-bestellung">

            <div class="container-fluid">





                <div class="row">

                    <!-- ## ADRESSES -->

                    <div class="col-md-4">
                        <div class="card" id="card-lieferant">
                            <div class="card-body">
                                <div class="actions">
                                    <!-- TODO: Adresse suchen über Pickliste

                                    <a class="action-item" id="adresse-suchen" data-status="1" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Adresse Suchen"><i class="fa-solid fa-search"></i></a>-->
                                </div>

                                <nav>
                                    <div class="nav nav-tabs" id="tab-name">
                                        <button class="nav-link active" id="tab-btn-adresse-1" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-1" type="button"><i class="fa-solid fa-shopping-cart"></i> Lieferant</button>
                                        <button class="nav-link" id="tab-btn-adresse-2" data-bs-toggle="tab" data-bs-target="#tab-content-adresse-2" type="button"><i class="fa-solid fa-truck-loading"></i> Empfänger</button>
                                    </div>
                                </nav>

                                <div class="tab-content" id="tab-content-adresse">

                                    <!-- LIEFERANT -->
                                    <div class="tab-pane show active" id="tab-content-adresse-1" data-type="re">

                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="lieferant" data-qs-name="lieferanten" placeholder="Lieferant" required>
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Lieferant</label>
                                        </div>

                                        <div class="form-group form-floating">
                                            <input type="text" name="lieferant_name" class="form-control" placeholder="Name" readonly>
                                            <label>Name</label>
                                        </div>

                                        <div class="form-group form-floating">
                                            <input type="text" name="lieferant_strasse" class="form-control" placeholder="Straße" readonly>
                                            <label>Straße</label>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferant_land" class="form-control" placeholder="Land" readonly>
                                                    <label>Land</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferant_plz" class="form-control" placeholder="PLZ" readonly>
                                                    <label>PLZ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="lieferant_ort" class="form-control" placeholder="Ort" readonly>
                                                    <label>Ort</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- LIEFERADRESSE -->
                                    <div class="tab-pane" id="tab-content-adresse-2" data-type="re">
                                        <div class="tab-pane show active" id="tab-content-adresse-1" data-type="re">


                                            <div class="form-group form-floating">
                                                <input type="text" name="empfaenger_name" class="form-control" placeholder="Empfänger" readonly>
                                                <label>Empfänger</label>
                                            </div>

                                            <div class="form-group form-floating">
                                                <input type="text" name="empfaenger_strasse" class="form-control" placeholder="Straße" readonly>
                                                <label>Straße</label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="empfaenger_land" class="form-control" placeholder="Land" readonly>
                                                        <label>Land</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="empfaenger_plz" class="form-control" placeholder="PLZ" readonly>
                                                        <label>PLZ</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="form-group form-floating">
                                                        <input type="text" name="empfaenger_ort" class="form-control" placeholder="Ort" readonly>
                                                        <label>Ort</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ## MISC -->

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="activation-input-container">
                                            <div class="form-group form-floating-check">
                                                <label class="form-label"></label>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="hat_liefertermin" name="hat_liefertermin" value="1">
                                                    <label class="form-check-label" for="hat_liefertermin"></label>
                                                </div>
                                            </div>
                                            <div class="form-group form-floating">
                                                <input type="date" name="liefertermin" class="form-control editable" placeholder="Liefertermin" autocomplete="off" required>
                                                <label>Liefertermin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Direktlieferung</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="direktlieferung" name="direktlieferung" value="1" disabled />
                                                <label class="form-check-label" for="direktlieferung">Ja</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-floating">
                                    <textarea class="form-control editable" name="text" placeholder="Bestelltext"></textarea>
                                    <label>Bestelltext</label>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group form-floating-check">
                                            <label class="form-label">Ohne Preise versenden</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input editable" id="keine_preise" name="keine_preise" value="1" />
                                                <label class="form-check-label" for="keine_preise">Aktiviert</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 

                                    </div>
                                </div>




                            </div>
                        </div>
                    </div>

                    <!-- ## STATUS -->

                    <div class="col-md-4">


                        <!-- Status 1 - Entwurf -->
                        <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-edit"></i> Bestellung ist Entwurf</h4>
                                        <ul>
                                            <li>Die Bestellung wurde noch nicht versendet</li>
                                            <li>Die Bestellung wird nicht im Bestellvorschlag berücksichtigt</li>
                                            <li><a href="javascript: void(0);" class="btn-entwurf-preview" data-bs-toggle="tooltip" data-bs-placement="top" title="Halten Sie STRG gedrücken und klicken um die Druck-Version ohne Briefkopf zu erhalten!">Vorschau Dokument anzeigen</a></li>
        
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-dark btn-bestellung-abschicken"><i class="fa-solid fa-check"></i> Erstellen</button>
                                        <button type="button" class="btn btn-dark btn-entwurf-speichern"><i class="fa-solid fa-save"></i> Entwurf speichern</button>
                                        <button type="button" class="btn btn-danger btn-entwurf-loeschen"><i class="fa-solid fa-trash"></i> Entwurf löschen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status 1 - Entwurf -->
                        <div id="status-2" class="alert alert-soft-secondary detail-status" data-status="2">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-edit"></i> Bestellung ist Offen</h4>
                                        <ul>
                                            <li>Die Bestellung wurde versendet</li>
                                            <li>Die Bestellung wird im Bestellvorschlag berücksichtig</li>
                                            <li>Es ist noch keine Warenlieferung eingetroffen</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-secondary btn-anzeigen"><i class="fa-solid fa-file-pdf"></i> Anzeigen</button>
                                        <button type="button" class="btn btn-secondary btn-wareneingang"><i class="fa-solid fa-truck-loading"></i> Wareneingang</button>
                                        <button type="button" class="btn btn-danger btn-stornieren"><i class="fa-solid fa-reply"></i> Stornieren</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <!-- ############################## Middle -->
                <br>

                <div class="row" style="display:none;">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">

                        <!-- Navigation -->
                        <nav>
                            <div class="nav nav-tabs" id="tab-nav-name">
                                <button class="nav-link active" id="tab-nav-name-1" data-bs-toggle="tab" data-bs-target="#tab-content-name-1" type="button">Bereits geliefert</button>
                                <button class="nav-link" id="tab-nav-name-2" data-bs-toggle="tab" data-bs-target="#tab-content-name-2" type="button">Offene Posten</button>
                            </div>
                        </nav>
                        <br>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Action Items -->
                                <div class="actions">
                                    <a class="action-item btn-pos-delete" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fa-solid fa-trash"></i></a>
                                    <a class="action-item btn-pos-edit" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Bearbeiten"><i class="fa-solid fa-edit"></i></a>
                                    <a class="action-item btn-pos-up" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Hoch"><i class="fa-solid fa-arrow-up"></i></a>
                                    <a class="action-item btn-pos-down" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Runter"><i class="fa-solid fa-arrow-down"></i></a>
                                    <a class="action-item btn-pos-neu" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Neu"><i class="fa-solid fa-plus"></i></a>
                                </div>


                                <h4 class="card-title"><i class="fa-solid fa-layer-group"></i> Bestellpositionen</h4>
                                <div id="pickliste-positionen"></div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6" style="display:none;">

                        <!-- Offene Positionen -->
                        <div class="tab-content" id="tab-content-name">

                            <!-- Lieferungen -->
                            <div class="tab-pane fade show active" id="tab-content-name-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fa-solid fa-truck-loading"></i> Lieferungen</h4>
                                        <div id="pickliste-lieferungen"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Offene Posten -->
                            <div class="tab-pane fade" id="tab-content-name-2">
                                <em>Liste folgt nocht</em>
                                <br>
                                <br>
                                <button type="button" class="btn btn-primary">Liefermahnung</button>
                            </div>
                        </div>


                    </div>
                </div>




                <!-- Status 1 -->
                <div class="fab-container detail-status" data-status="1">
                    <button type="button" class="btn btn-danger btn-entwurf-loeschen btn-sm fab-children" data-label="Entwurf Löschen"><i class="fa-solid fa-trash"></i></button>
                    <button type="button" class="btn btn-primary btn-entwurf-speichern btn-sm fab-children" data-label="Entwurf Speichern"><i class="fa-solid fa-save"></i></button>
                    <button type="button" class="btn btn-primary btn-bestellung-abschicken btn-sm fab-children" data-label="Bestellung Erstellen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>





            </div>
        </form>

        <div class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-paper-plane"></i> Bestellung Abschicken</h5>
                        <div class="actions">
                            <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="left" title="PDF-Vorschau"><i class="fa-solid fa-file-pdf"></i></a>
                        </div>
                    </div>
                    <div class="modal-body pt-0">
                        <form id="form-bestellung-abschicken">
                            <div class="form-group form-floating-radio">
                                <label class="form-label">Übermittlung zum Lieferanten</label>

                                <div class="form-radio mb-1">
                                    <input type="radio" class="form-check-input editable" id="bestellung-abschicken-1" name="methode" value="1" />
                                    <label class="form-check-label" for="bestellung-abschicken-1"><i class="fa-solid fa-times text-danger inline-icon"></i> Manuelle Bestellung / Bereits erfolgt</label>
                                </div>
                                <div class="form-radio mb-1">
                                    <input type="radio" class="form-check-input editable" id="bestellung-abschicken-2" name="methode" value="2" />
                                    <label class="form-check-label" for="bestellung-abschicken-2"><i class="fa-solid fa-print inline-icon"></i> Bestellung drucken</label>
                                </div>
                                <div class="form-radio mb-1">
                                    <input type="radio" class="form-check-input editable" id="bestellung-abschicken-3" name="methode" value="3" />
                                    <label class="form-check-label" for="bestellung-abschicken-3"><i class="fa-solid fa-envelope-open-text inline-icon"></i> Bestellung per Mail versenden</label>
                                </div>
                                <div class="form-radio mb-1">
                                    <input type="radio" class="form-check-input editable" id="bestellung-abschicken-4" name="methode" value="4" />
                                    <label class="form-check-label" for="bestellung-abschicken-4"><i class="fab fa-usb inline-icon"></i> Übertragung per Schnittstelle</label>
                                </div>
                            </div>

                            <div class="form-group form-floating">
                                <input type="text" name="email" class="form-control editable" placeholder="E-Mail Adresse" autocomplete="off" value="bestellung@lieferant.de" required>
                                <label>E-Mail Adresse</label>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

    </div>

    <aside id="timeline-container" class="sidebar card" style="width: 370px;position:fixed;right: 0px;background: #fff;justify-content:flex-end;padding: 10px;">
        <div id="timeline"></div>
    </aside>

</body>

<!-- Skript für Positionen -->
<script src="js/pagelevel/bestellung-details-positionen.js"></script>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        
        b.init();

    });
</script>

</html>