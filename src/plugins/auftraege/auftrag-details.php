<?php include('01_init.php');

// Id
$id = (isset($_GET['id'])) ? " - " . $_GET['id'] : "";

$_page = [
    'title' => "<i class=\"fa-solid fa-layer-group\"></i> Auftrag Details " . $id,
    'breadcrumbs' => ['<i class="fa-solid fa-cogs"></i> Prozesse', '<a href="auftraege"><i class="fa-solid fa-layer-group"></i> Aufträge</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

</head>

<body data-page="auftraege">
    <?php include('03_navigation.php'); ?>
    <div class="wrapper loading">
        
        <!-- Loading muss noch eingesetzt werden "loading" -->
        <div class="container-fluid">

            <form id="form-auftrag">

                <div class="row">
                    <div class="col-md-4">
                       <!-- Adressen -->
                       <?php include('rechnungs-lieferadresse-card.php'); ?>
                    </div>

                    <div class="col-md-4">
                        <div class="card" id="card-form">
                            <div class="card-body">

                                <div class="form-group form-floating-radio">
                                    <label class="form-label">Auftrag Herkunft</label><br>
                                    <div class="form-radio form-check-inline">
                                        <input class="form-check-input editable" type="radio" id="auftrag-herkunft-1" name="herkunft" value="Telefon" required>
                                        <label class="form-check-label" for="auftrag-herkunft-1">Telefon</label>
                                    </div>
                                    <div class="form-radio form-check-inline">
                                        <input class="form-check-input editable" type="radio" id="auftrag-herkunft-2" name="herkunft" value="E-Mail" required>
                                        <label class="form-check-label" for="auftrag-herkunft-2">E-Mail</label>
                                    </div>
                                    <div class="form-radio form-check-inline">
                                        <input class="form-check-input editable" type="radio" id="auftrag-herkunft-3" name="herkunft" value="Website" required>
                                        <label class="form-check-label" for="auftrag-herkunft-3">Website</label>
                                    </div>
                                    <div class="form-radio form-check-inline">
                                        <input class="form-check-input editable" type="radio" id="auftrag-herkunft-4" name="herkunft" value="Andere" required>
                                        <label class="form-check-label" for="auftrag-herkunft-4">Andere</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="referenz" class="form-control editable" placeholder="Kundenreferenz" autocomplete="off">
                                            <label>Kundenreferenz</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!--<div class="form-group form-floating">
                                            <input type="date" name="liefertermin" class="form-control editable" placeholder="Liefertermin" autocomplete="off">
                                            <label>Liefertermin</label>
                                        </div>-->

                               
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="kostenstelle_id" data-qs-name="kostenstellen" placeholder="Kostenstelle" required>
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Interne Kostenstelle</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="besteller" data-qs-name="kontakte" placeholder="Besteller">
                                            </select>
                                            <label>Besteller</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-select2 editable" name="auslieferungs" placeholder="Auslieferung">
                                                <option value="">Standard</option>
                                                <option value="abholung">Abholung</option>
                                                <option value="techniker">Techniker</option>
                                                <option value="versand">Versand</option>
                                            </select>
                                            <label>Auslieferung</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Teillieferung</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="auftrag-teillieferung-1" name="teillieferung" value="1" required>
                                                <label class="form-check-label" for="auftrag-teillieferung-1">Ja</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="auftrag-teillieferung-2" name="teillieferung" value="0" checked required>
                                                <label class="form-check-label" for="auftrag-teillieferung-2">Nein</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">


                        <!-- Status 1 - Entwurf -->
                        <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-edit"></i> Auftrag ist ein Entwurf</h4>
                                        <ul>
                                            <li>Der Kunde hat noch keine Einsicht im Kundenportal</li>
                                            <li>Die Bestände werde noch nicht geändert</li>
                                            <li>Es wird nich kein Bestellvorschlag erstellt</li>
                                            <li>Vorschau <a href="javascript:void(0);" data-document="ab" class="btn-show-document">Auftragbestätigung</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-dark btn-auftrag-erstellen"><i class="fa-solid fa-check"></i> Auftrag erstellen</button>
                                        <button type="button" class="btn btn-dark btn-entwurf-speichern"><i class="fa-solid fa-save"></i> Entwurf speichern</button>
                                        <button type="button" class="btn btn-danger btn-entwurf-loeschen"><i class="fa-solid fa-trash"></i> Entwurf löschen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status 2 - Offener Auftrag -->
                        <div id="status-2-0" class="alert alert-soft-secondary detail-status" data-status="2" data-substatus="0">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-regular fa-hourglass"></i> Offener Auftrag</h4>

                                        <a href=""><i class="fa-solid fa-file-pdf"></i> Auftragsbestätigung</a> - 26.01.2022<br>

                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-lieferung-neu" type="button"><i class="fa-solid fa-database"></i> Auftrag beliefern</button>
                                        <button class="btn btn-primary btn-bestellung-neu" type="button"><i class="fa-solid fa-shopping-cart"></i> Bestellung Erstellen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status 2 - Liefern -->
                        <div id="status-2-1" class="alert alert-soft-secondary detail-status" data-status="2" data-substatus="1">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-database"></i> Lieferung Erstellen</h4>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-lieferung-erstellen" type="button"><i class="fa-solid fa-check"></i> Erstellen</button>
                                        <button class="btn btn-danger btn-lieferung-abbrechen" type="button"><i class="fa-solid fa-times"></i> Abbrechen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status 2 - Bestellen -->
                        <div id="status-2-2" class="alert alert-soft-secondary detail-status" data-status="2" data-substatus="2">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-database"></i> Bestellung Erstellen</h4>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-bestellung-erstellen" type="button"><i class="fa-solid fa-check"></i> Erstellen</button>
                                        <button class="btn btn-danger btn-bestellung-abbrechen" type="button"><i class="fa-solid fa-times"></i> Abbrechen</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Status Lieferung Vollständig -->
                        <div id="status-3" class="alert alert-soft-secondary detail-status" data-status="3">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-check"></i> Warenlieferung vollständig</h4>

                                        Der Auftrag wurde erstellt. Der Kunde kann den Auftrag über das Kundenportal einsehen.
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-rechnung-erstellen" type="button"><i class="fa-solid fa-file-invoice-dollar"></i> Rechnung erstellen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Lieferung Vollständig -->
                        <div id="status-4" class="alert alert-soft-success detail-status" data-status="4">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-check-double"></i> Vollständig berechnet</h4>
                                        <div class="documents"></div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- 
                    Positionen 
                    ####################################

                -->
                <div class="row">
                    <div class="col-selector">

                        <!-- Position Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="actions">
                                    <a class="action-item btn-pos-delete" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fa-solid fa-trash"></i></a>
                                    <a class="action-item btn-pos-shift" data-shift="up" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hoch"><i class="fa-solid fa-chevron-up"></i></a>
                                    <a class="action-item btn-pos-shift" data-shift="down" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Runter"><i class="fa-solid fa-chevron-down"></i></a>
                                    <a class="action-item btn-pos-add" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Neu"><i class="fa-solid fa-plus"></i></a>
                                </div>

                                <h4 class="card-title"><i class="fa-solid fa-layer-group"></i> Positionen</h4>



                                <div id="pickliste-positionen"></div>


                                <div class="mt-3">
                                    <div class="row">
                                        <div class="col-md-9">


                                            <button type="button" class="btn btn-dark btn-pos-add" data-status="1"><i class="fa-solid fa-plus"></i> Artikel hinzufügen</button>
                                            <button type="button" class="btn btn-dark btn-pos-neu-vertragsgegenstand" data-status="1"><i class="fa-solid fa-search"></i> Artikel über Gerät</button><br>


                                            <!-- Zahlungsbedingung -->
                                            <div class="form-group form-floating">
                                                <select class="form-select init-quickselect" name="zahlungsbedingung" data-qs-name="zahlungsbedingungen" placeholder="Zahlungsbedingung">
                                                    <option value="">bitte wählen</option>
                                                    <option value="asdf">Someone</option>
                                                </select>
                                                <label>Zahlungsbedingung</label>
                                            </div>

                                        </div>
                                        <div class="col-md-3">
                                            <div id="positionen-gesamtsumme">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Netto</strong><br>
                                                        <span>MwSt.</span><br>
                                                        <span>Brutto</span>
                                                    </div>
                                                    <div class="col-md-6" style="text-align:right;">
                                                        <strong class="pos-total pos-total-netto">...</strong><br>
                                                        <span class="pos-total pos-total-mwst">...</span><br>
                                                        <span class="pos-total pos-total-brutto">...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Position Form -->
                    <div class="col-selector">
                        <?php include('auftrag-details-position-form.php'); ?>
                    </div>

                    <!-- Lieferung Form -->
                    <div class="col-selector">
                        <?php include('auftrag-details-lieferung-form.php'); ?>
                    </div>

                    <!-- Bestellung Form -->
                    <div class="col-selector">
                        <?php include('auftrag-details-bestellung-form.php'); ?>
                    </div>

                    <!-- Rechnung Form -->
                    <div class="col-selector">
                        <?php include('auftrag-details-rechnung-form.php'); ?>
                    </div>
                </div>

                <div class="row">

                    <!-- Lieferung -->
                    <div class="col-md-6">
                        <div id="lieferungen">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fa-solid fa-database"></i> Lieferungen</h4>
                                    <h6 class="subtext">Lieferungen des Auftrags an den Kunden</h6>


                                    <div id="lieferungen-liste"></div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Bestellungen -->
                    <div class="col-md-6">
                        <div id="bestellungen">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fa-solid fa-shopping-cart"></i> Bestellungen</h4>
                                    <h6 class="subtext">Bestellungen an den Lieferanten</h6>

                                    <div id="bestellung-liste"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Status 1 -->
                <div class="fab-container detail-status" data-status="1">
                    <button type="button" class="btn btn-danger btn-sm fab-children btn-entwurf-loeschen" data-label="Entwurf Löschen"><i class="fa-solid fa-trash"></i></button>
                    <button type="button" class="btn btn-primary btn-sm fab-children btn-entwurf-speichern" data-label="Entwurf Speichern"><i class="fa-solid fa-save"></i></button>
                    <button type="button" class="btn btn-primary btn-sm fab-children btn-auftrag-erstellen" data-label="Auftrag erstellen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

                <!-- Status 2 - Offen -->
                <div class="fab-container detail-status" data-status="2" data-substatus="0">
                    <button type="button" class="btn btn-primary btn-bestellung-neu btn-sm fab-children" data-label="Bestellung erstellen"><i class="fa-solid fa-shopping-cart"></i></button>
                    <button type="button" class="btn btn-primary btn-lieferung-neu btn-sm fab-children" data-label="Lieferung erstellen"><i class="fa-solid fa-database"></i></button>
                    <button type="button" id="btn-auftrag-stornieren" class="btn btn-danger btn-sm fab-children" data-label="Auftrag stornieren"><i class="fa-solid fa-times"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

                <!-- Status 2 - Liefern -->
                <div class="fab-container detail-status" data-status="2" data-substatus="1">
                    <button type="button" class="btn btn-primary btn-lieferung-erstellen btn-sm fab-children" data-label="Lieferung Durchführen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-danger btn-lieferung-abbrechen btn-sm fab-children" data-label="Lieferung abbrechen"><i class="fa-solid fa-times"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

                <!-- Status 2 - Bestellen -->
                <div class="fab-container detail-status" data-status="2" data-substatus="2">
                    <button type="button" class="btn btn-primary btn-bestellung-erstellen btn-sm fab-children" data-label="Bestellung Durchführen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-danger btn-bestellung-abbrechen btn-sm fab-children" data-label="Bestellung abbrechen"><i class="fa-solid fa-times"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

                <!-- Status 3 - Alles geliefert -->
                <div class="fab-container detail-status" data-status="3">
                    <button type="button" class="btn btn-primary btn-rechnung-erstellen btn-sm fab-children" data-label="Rechnung erstellen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

                <!-- Status 4 - Vollständig berechnet -->
                <div class="fab-container detail-status" data-status="4">
                    <button type="button" class="btn btn-danger btn-gutschrift-erstellen btn-sm fab-children" data-label="Gutschrift erstellen"><i class="fa-solid fa-times"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>




            </form>

        </div>
    </div>
</body>



<script src="js/pagelevel/auftrag-details-positionen.js"></script>
<script src="js/pagelevel/auftrag-details-beliefern.js"></script>

<?php include('04_scripts.php'); ?>

<script src="js/pagelevel/auftrag-details-historie.js"></script>

<script>


au = Object.assign(detailHelper, au);
au = Object.assign(au, auPos);




$(document).on('app:ready', function () {

    // Initalisieren
    au.init();

});


</script>

</html>