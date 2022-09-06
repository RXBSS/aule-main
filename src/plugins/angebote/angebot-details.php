<?php include('01_init.php');

$_page = [
    'title' => '<i class="fa-solid fa-star"></i> Angebote Details',
    'breadcrumbs' => ['<i class="fa-solid fa-cogs"></i> Prozesse', '<a href="angebote"><i class="fa-solid fa-star"></i> Angebote</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body data-page="angebote">
    <?php include('03_navigation.php'); ?>

    <div class="wrapper">
        <div class="container-fluid">

            <form id="angebot-form">
                <div class="row">
                    <div class="col-md-4">

                        <!-- Adressen -->
                        <?php include('rechnungs-lieferadresse-card.php'); ?>

                    </div>
                    <div class="col-md-4">
                        <div class="card" id="card-form">
                            <div class="card-body">

                                <!-- Kontakte -->
                                <div class="qs-buttons d-flex justify-content-between">

                                    <div class="form-group form-floating form-select2-multi-column flex-grow-1">
                                        <select class="form-select init-quickselect editable" name="empfaenger" data-qs-name="kontakte2" placeholder="Empfänger" multiple>
                                            <option value="">Bitte wählen</option>
                                        </select>
                                        <label>Empfänger</label>
                                    </div>

                                    <div class="btn-group align-self-start pt-4 ps-2">
                                        <button type="button" class="btn btn-primary" data-action="link"><i class="fa-solid fa-link"></i></button>
                                        <button type="button" class="btn btn-primary" data-action="edit" data-validate="single"><i class="fa-solid fa-edit"></i></button>
                                        <button type="button" class="btn btn-primary" data-action="add"><i class="fa-solid fa-add"></i></button>
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
                                            <select class="form-select init-quickselect editable" name="bearbeiter_id" data-qs-name="mitarbeiter" placeholder="label">
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Sachbearbeiter</label>
                                        </div>
                                    </div>
                                </div>


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
                                            <div class="form-group form-floating">
                                                <input type="text" name="liefertermin_dummy" class="form-control" placeholder="Liefertermin" autocomplete="off" value="Kein Termin" disabled>
                                                <label>Liefertermin</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>
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
                                        <h4 class="alert-header"><i class="fa-solid fa-edit text-warning"></i> Angebot ist ein Entwurf</h4>
                                        <ul>
                                            <li>Der Kunde hat noch keine Einsicht im Kundenportal</li>
                                            <li>Vorschau <a href="javascript:void(0);" class="btn-show-document" data-document="ag">Angebot</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-dark btn-angebot-erstellen"><i class="fa-solid fa-check"></i> Angebot erstellen</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status 2 - Entwurf -->
                        <div id="status-2" class="alert alert-soft-secondary detail-status" data-status="2">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>
                                        <h4 class="alert-header"><i class="fa-solid fa-user-pen"></i> Angebot ist beim Kunden</h4>
                                        <ul>
                                            <li>Der Kunde hat Einsicht im Kundenportal</li>
                                            <li>Anzeige <a href="javascript:void(0);" data-document="ag" class="btn-show-document">Angebot</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-dark btn-angebot-rueckmeldung"><i class="fa-solid fa-check"></i> Rückmeldung</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>



                <!-- Positionen -->
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

                                            <!-- Zahlungsbedingung -->
                                            <div class="form-group form-floating">
                                                <select class="form-select init-quickselect" name="zahlungsbedingung_id" data-qs-name="zahlungsbedingungen" placeholder="Zahlungsbedingung">
                                                    <option value="">bitte wählen</option>
                                                    <option value="asdf">Someone</option>
                                                </select>
                                                <label>Zahlungsbedingung</label>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <!-- Summe der Positionen -->
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
                        <?php include('angebot-details-position-form.php'); ?>
                    </div>

                </div>

                <!-- Status 1 -->
                <div class="fab-container detail-status" data-status="1">
                    <button type="button" class="btn btn-danger btn-sm fab-children btn-entwurf-loeschen" data-label="Entwurf Löschen"><i class="fa-solid fa-trash"></i></button>
                    <button type="button" class="btn btn-primary btn-sm fab-children btn-speichern" data-label="Entwurf Speichern"><i class="fa-solid fa-save"></i></button>
                    <button type="button" class="btn btn-primary btn-sm fab-children btn-angebot-erstellen" data-label="Angebot erstellen"><i class="fa-solid fa-check"></i></button>
                    <button type="button" class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
                </div>

            </form>

        </div>
    </div>

    <!-- Modal zum Erstellen -->
    <div class="modal" id="angebot-erstellen-modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="angebot-erstellen-form">


                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-cat"></i> Angebot Erstellen & Verschicken</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body pt-0">


                        <!-- Auswahl der Versandart -->
                        <div class="form-group form-floating-radio">
                            <label class="form-label">Versenden an den Kunden</label>
                            <div class="form-radio">
                                <input type="radio" class="form-check-input editable" value="email" id="angebot-versandart-1" name="angebot-versandart" value="1" checked />
                                <label class="form-check-label" for="angebot-versandart-1"><i class="fa-solid fa-envelope"></i> Per E-Mail verschicken</label>
                            </div>
                            <div class="form-radio">
                                <input type="radio" class="form-check-input editable" value="print" id="angebot-versandart-2" name="angebot-versandart" value="1" />
                                <label class="form-check-label" for="angebot-versandart-2"><i class="fa-solid fa-print"></i> Ausdrucken</label>
                            </div>
                        </div>


                        <!-- Nur bei E-Mail -->
                        <div class="angebot-erstellen-versandart" data-values="email">
                            <div class="form-group form-floating">
                                <input type="text" name="empfaenger" class="form-control editable" value="t.pitzer@buerosystemhaus.de" placeholder="Absender" autocomplete="nope">
                                <label>Absender</label>
                            </div>

                            <div class="form-group form-floating">
                                <input type="text" name="empfaenger" class="form-control editable" value="empfaenger@buerosystemhaus.de" placeholder="Empfänger" autocomplete="nope">
                                <label>Empfänger</label>
                            </div>
                        </div>





                        <!-- <div class="angebot-erstellen-versandart" data-values="print">
                            Ich werde nur beim Drucken angezeigt!
                        </div> -->



                        <div class="form-group form-floating-check">
                            <label class="form-label">Prüfen</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input editable" id="angebote-erstellen-geprueft" name="angebote-erstellen-geprueft" value="1" required />
                                <label class="form-check-label" for="angebote-erstellen-geprueft">Auf Fehler geprüft</label>
                            </div>
                        </div>

                        <div class="form-group form-floating-check angebot-erstellen-versandart" data-values="print">
                            <label class="form-label">Prüfen</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input editable" id="angebote-erstellen-gedruckt" name="angebote-erstellen-gedruckt" value="1" required />
                                <label class="form-check-label" for="angebote-erstellen-gedruckt">Gedruckt und an Kunden versendet</label>
                            </div>
                        </div>

                        <!-- Vorschau Dokument -->
                        <a href="javascript:void(0);" class="btn btn-primary mt-3 angebot-erstellen-versandart btn-show-document" data-document="ag" data-show="true" data-print="false" data-values="email"><i class="fa-solid fa-file-pdf"></i> Vorschau Dokument</a>
                        <a href="javascript:void(0);" class="btn btn-primary mt-3 angebot-erstellen-versandart btn-show-document" data-document="ag" data-show="true" data-print="true" data-values="print"><i class="fa-solid fa-file-pdf"></i> Vorschau Dokument</a>


                    </div>
                    <div class="modal-footer">
                       
                    </div>

                </form>
            </div>
        </div>
    </div>


    <?php include('./adressen-neu-modal.php');  ?>
    <?php include("./rechnungs-lieferadresse-modal.php"); ?>
    <?php include('./kontakte-details-modal.php') ?>
</body>


<!-- Angebot Positionen-->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcz5vCR6GMcbQtHfK_ImcU3yQwgmAVfa8&libraries=places&v=weekly&channel=2&"></script>
<script src="js/pagelevel/adressen-neu.js"></script>
<script src="js/pagelevel/angebot-details-positionen.js"></script>
<script src="js/pagelevel/angebot-details-erstellen.js"></script>

<?php include('04_scripts.php'); ?>

<script>
    // Angebote 
    ag = Object.assign(detailHelper, ag);
    ag = Object.assign(adressen_neu, ag);
    ag = Object.assign(ag, agPos);
    ag = Object.assign(ag, agErst);

    // On Document Ready
    $(document).on('app:ready', function() {

        // Initalisieren
        ag.init();

    });
</script>

</html>