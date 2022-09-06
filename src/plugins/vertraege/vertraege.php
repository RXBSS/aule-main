<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-file-contract\"></i> Verträge",
    'breadcrumbs' => ['Prozesse']

];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>


</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-4">
                    <div class="card border-left-dark" id="vertraege-liste">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-file-invoice-dollar"></i> Abrechnung</h4>
                            <h6 class="subtext">Übersicht über alle Verträge und deren Abrechnung. Anlegen von Abrechnungszeiträumen.</h6>
                            <br>
                            <a class="btn btn-secondary" href="vertraege-abrechnung"><i class="fa-solid fa-file-invoice-dollar"></i> Abrechnung</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-left-dark" id="vertraege-klausel-managment">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-chart-area"></i> Controlling</h4>

                            <h6 class="subtext">
                                Hier findet man eine Übersicht zum Controlling von Verträgen und deren Reports
                            </h6>
                            <br>
                            <a class="btn btn-secondary" href="vertraege-controlling"><i class="fa-solid fa-chart-area"></i> Controlling</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-left-dark" id="vertraege-vorlagen">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-gavel"></i> Verträge Vorlagen</h4>
                            <h6 class="subtext">Alles zur Gestaltung von Verträgen. Zur Anlage und Verwaltung von Klauseln und Gruppen</h6>

                            <br>
                            <a class="btn btn-secondary" href="vertraege-vorlagen"><i class="fa-solid fa-copy"></i> Vertragsvorlagen</a>
                            <a class="btn btn-secondary" href="vertraege-klauseln"><i class="fa-solid fa-gavel"></i> Klauseln</a>
                            <a class="btn btn-secondary" href="weitere-stammdaten"><i class="fa-solid fa-gavel"></i> Gruppen</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Pickliste -->
            <div id="pickliste-vertraege"></div>

            <!-- FAB - Button -->
            <div class="fab-container">
                <button class="btn btn-primary" id="vertraege-add"><i class="fa-solid fa-plus"></i></button>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Hinzufügen</h5>
                    <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <div class="modal-body">
                    <form id="modal-vertraege">

                        <div class="row">
                            <div class="col">

                                <div class="form-group form-floating">
                                    <select class="form-select init-select2 editable init-quickselect" data-qs-name="adressen" data-qs-default-text="Bitte einen Vertragsnehmer wählen" data-qs-default-value="0" name="vn_adresse" placeholder="Vertragsnehmer" required>
                                        <option value="">bitte wählen</option>
                                    </select>
                                    <label>Vertragsnehmer</label>
                                </div>


                                <!-- <div class="form-group form-floating">
                            <select class="form-select editable" name="status_id" placeholder="Status">
                                <option value="">bitte wählen</option>
                                <option value="0">Entwurf</option>
                                <option value="1">Warten auf Authorisierung</option>
                                <option value="2">Authorisiert</option>
                                <option value="3">Gekündigt</option>
                                <option value="4">Inaktiv</option>
                            </select>
                            <label>Status</label>
                        </div> -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group form-floating">
                                    <select class="form-select editable init-quickselect" data-qs-name="vertraege_vorlagen" id="vertrags_vorlagen" name="vorlagen_id" placeholder="label">
                                        <option value="">bitte wählen</option>
                                    </select>
                                    <label>Vetragsvorlage</label>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group form-floating">
                                    <input type="date" name="vertragsbeginn" class="form-control editable" placeholder="Vertragsbeginn" autocomplete="off" required>
                                    <label>Vertragsbeginn</label>
                                </div>
                            </div>
                            <div class="col-lg-6 laufzeit-body">
                                <div class="form-group form-floating">
                                    <input type="text" name="vertragsende" class="form-control" placeholder="Vertragsende" disabled>
                                    <label>Vertragsende</label>
                                </div>
                            </div>
                        </div> -->



                        <!-- Laufzeit Befristet oder Unbefristet -->
                        <!-- <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group form-floating-check">
                                    <label class="form-label">Befristet</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input editable" id="laufzeit" name="laufzeit-trigger" />
                                        <label class="form-check-label" for="laufzeit">Befristet</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 laufzeit-body">
                                <div class="row">
                                    <div class="col-lg-8">

                                        <div class="form-group form-floating">
                                            <input type="number" name="laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off">
                                            <div id="unbefristet_laufzeit_interval" class="form-unit " style="visibility: initial; opacity:1">Monate</div>
                                            <label>Laufzeit</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group form-floating">
                                            <select class="form-select set-data-unit" data-selector-unit="unbefristet_laufzeit_interval" name="laufzeit_interval" placeholder="Interval" disabled>
                                                <option value="">bitte wählen</option>
                                                <option value="d">Tag/e</option>
                                                <option value="M" selected>Monat/e</option>
                                                <option value="Y">Jahr/e</option>
                                            </select>
                                            <label>Interval</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        
                        <!-- 
                        <div id="verlaengerung_kuendigung_ebene">

                            Automatische Verlängerung
                            <div id="automatische-verlaengerung">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Verlängerung</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input editable" id="verlaengerung" name="verlaengerung-trigger" />
                                                <label class="form-check-label" for="verlaengerung">Verlängerung</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 verlaengerung-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group form-floating">
                                                    <input type="number" name="verlaengerung_laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off">
                                                    <div id="verlaengerung_laufzeit_interval" class="form-unit " style="visibility: initial; opacity:1">Monate</div>
                                                    <label>Laufzeit</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group form-floating">
                                                    <select class="form-select set-data-unit" data-selector-unit="verlaengerung_laufzeit_interval" name="verlaengerung_laufzeit_interval" placeholder="Interval">
                                                        <option value="">bitte wählen</option>
                                                        <option value="d">Tage</option>
                                                        <option value="M" selected>Monate</option>
                                                        <option value="Y">Jahr</option>
                                                    </select>
                                                    <label>Interval</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            Kündigungsfrist
                            <div id="kuendigung_frist">
                                <div id="automatische-verlängerung">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group form-floating-check">
                                                <label class="form-label">Kündigungsfrist</label>
                                                <div class="form-check form-switch">
                                                    <input type="checkbox" class="form-check-input editable" id="kuendigungsfrist" name="kuendigungsfrist-trigger" />
                                                    <label class="form-check-label" for="kuendigungsfrist">Kündigungsfrist</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8 kuendigungsfrist-body laufzeit-body">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="form-group form-floating">
                                                        <input type="number" name="kuendigungsfrist_laufzeit" class="form-control" placeholder="Laufzeit in Monaten" autocomplete="off">
                                                        <div id="kuendigungsfrist_laufzeit_interval" class="form-unit" style="visibility: initial; opacity:1">Monate</div>
                                                        <label>Laufzeit</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group form-floating">
                                                        <select class="form-select set-data-unit" data-selector-unit="kuendigungsfrist_laufzeit_interval" name="kuendigungsfrist_laufzeit_interval" placeholder="Interval">
                                                            <option value="">bitte wählen</option>
                                                            <option value="d">Tage</option>
                                                            <option value="M" selected>Monate</option>
                                                            <option value="Y">Jahr</option>
                                                        </select>
                                                        <label>Interval</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </form>

                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</body>





<?php include('04_scripts.php'); ?>

<script>
    $(document).on('app:ready', function() {

        // Card Sizer
        new CardSizer(['#vertraege-liste', '#vertraege-klausel-managment', '#vertraege-vorlagen']);

        v.init();
    });
</script>

</html>