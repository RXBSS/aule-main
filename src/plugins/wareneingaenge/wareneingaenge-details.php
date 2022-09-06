<?php include('01_init.php');

$_page = [
    'title' => "Neuer Wareneingang"
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

            <form id="form-wareneingang">

                <!-- Allgemeine Werte -->
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><i class="fa-solid fa-file-import"></i> Wareneingang</h4>

                        <div class="row">
                            <div class="col-md-4">



                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" data-qs-name="lieferanten" name="lieferant" placeholder="Lieferant" tabindex="1">
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Lieferant</label>
                                        </div>


                                    </div>
                                    <div class="col-md-6">

                                        <!-- Lieferant -->
                                        <div class="form-group form-floating">
                                            <input type="text" name="belegnummer" class="form-control editable" placeholder="Belegnummer"  tabindex="2">
                                            <label>Belegnummer</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Rechnung / Lieferschein</label>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="rechnungslieferschein" name="rechnungslieferschein" value="1" tabindex="4" />
                                                <label class="form-check-label" for="rechnungslieferschein">Rechnung als Lieferschein</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="date" name="belegdatum" class="form-control editable" placeholder="Belegdatum" tabindex="3">
                                            <label>Belegdatum</label>
                                        </div>
                                    </div>
                                </div>



                                <br>




                            </div>

                            <div class="col-md-4">


                            </div>
                            <div class="col-md-4">

                                <div style="background: #eee;border: 2px solid #ddd;">
                                    <br>
                                    <center>
                                        <i class="fa-solid fa-file-upload fa-3x" style="color: #ddd;"></i>
                                        <p style="color: #ddd;">Liefernachweis hochladen</p>
                                    </center>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>


            <div class="row">

                <!-- Pickliste -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-table"></i> Positionen</h4>
                            <div id="pickliste-lieferungen"></div>
                            <br>
                            
                            <!-- Offene Bestellungen -->
                            <button class="btn btn-secondary" id="btn-bestellung-importieren"><i class="fa-solid fa-file-import"></i> Bestellung importieren</button>
                            
                            <!-- Neue Zeile -->
                            <button class="btn btn-secondary wareneingang-manuell-hinzufuegen"><i class="fa-solid fa-plus"></i> Neue Zeile</button>
                        </div>
                    </div>
                </div>

                <!-- Seiten-Modal-->
                <div class="col-md-4">
                    <div class="card" style="display:none;">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-box"></i> <span class="form-edit-artikel-id">{{id}}</span> | <span class="form-edit-artikel-herstellernummer">{{nummer}}</span></h4>
                            <h6 class="subtext"><span class="form-edit-artikel-hersteller">{{hersteller}}</span> <span class="form-edit-artikel-bezeichnung">{{bezeichnung}}</span></h6>

                            <form id="form-edit-position">

                                <!-- Hidden Input -->
                                <input type="hidden" name="id" value="">

                                <!-- Lieferung -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Lieferung</label>
                                            <div class="form-radio mb-2">
                                                <input type="radio" class="form-check-input editable" id="lieferung-0" name="position-lieferung" value="0" />
                                                <label class="form-check-label" for="lieferung-0"><i class="fa-solid fa-circle text-danger"></i> Nicht geliefert</label>
                                            </div>
                                            <div class="form-radio mb-2">
                                                <input type="radio" class="form-check-input editable" id="lieferung-2" name="position-lieferung" value="2" />
                                                <label class="form-check-label" for="lieferung-2"><i class="fa-solid fa-circle text-success"></i> Vollständig</label>
                                            </div>
                                            <div class="form-radio mb-2">
                                                <input type="radio" class="form-check-input editable" id="lieferung-1" name="position-lieferung" value="1" />
                                                <label class="form-check-label" for="lieferung-1"><i class="fa-solid fa-circle text-warning"></i> Teillieferung</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <!-- Liefermenge -->
                                        <div class="form-group form-floating">
                                            <input type="text" name="liefermenge" class="form-control editable" placeholder="Menge" autocomplete="off" value="">
                                            <label>Menge</label>
                                        </div>

                                        <!-- Bestellnummer -->
                                        <div class="form-group form-floating">
                                            <input type="text" name="bestellung_id" class="form-control editable" placeholder="Bestellnummer" autocomplete="off" value="990005">
                                            <label>Bestellnummer</label>
                                        </div>

                                    </div>
                                </div>


                                <!-- Seriennummer Block -->
                                <div class="row" id="seriennummer-bereich"></div>

                                <div class="mt-2">
                                    <button class="btn btn-primary btn-save-and-next"><i class="fa-solid fa-check"></i> Speichern & Weiter</button>
                                    <button class="btn btn-secondary btn-save-only"><i class="fa-solid fa-check"></i> Speichern</button>
                                    <button class="btn btn-secondary btn-next-only"><i class="fa-solid fa-forward"></i> Überspringen</button>
                                </div>




                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <!-- MODAL -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Neue Position</h5>
                    <div class="actions">
                        <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Artikel Suchen"><i class="fa-solid fa-search"></i></a>
                        <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Neuen Artikel anlegen"><i class="fa-solid fa-plus"></i></a>
                    </div>
                </div>
                <div class="modal-body">
                    <form id="form-new-position">

                        <!-- Artikel -->
                        <div class="col-md-12">
                            <div class="form-group form-floating">
                                <select class="form-select init-quickselect editable" data-qs-name="artikel-suche" data-qs-only-id="true" data-qs-default-text="Schnelle Artikelsuche" name="artikel" placeholder="Suchfeld">

                                </select>
                                <label>Suchfeld</label>
                            </div>
                        </div>
                        <div class="row">

                            <!-- Menge -->
                            <div class="col-md-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="menge-1" class="form-control editable" placeholder="Liefermenge" autocomplete="off">
                                    <label>Liefermenge</label>
                                </div>
                            </div>




                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>


    <div class="fab-container">
        <button class="btn btn-primary btn-wareneingang-abschliessen"><i class="fa-solid fa-check-double"></i></button>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Wareneingang initalisieren
        w.init();
    });
</script>

</html>