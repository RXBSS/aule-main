<?php include('01_init.php');

$_page = [
    'title' => "<i class='fa-solid fa-laptop-house'></i> Ident Details",
    'breadcrumbs' => ['Stammdaten', "<a href='ident'><i class='fa-solid fa-laptop-house'></i> Ident</a>"]
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        #haupt-id-warnung {
            display: none;
        }

        #image-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            text-align: right;
            border: 1px solid #eee;
            min-height: 116px;
            box-shadow: inset 0 0 0.5em #eee;
            padding-right: calc(var(--bs-gutter-x) * 0.5);
            padding-left: calc(var(--bs-gutter-x) * 0.5);
        }

        #image-container img {
            max-height: 116px;
            max-width: 100%;
        }
    </style>

</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <form id="ident-form">
            <div class="container-fluid">




                <!--
                <div id="haupt-id-warnung" class="alert alert-warning">
                    <i class="fa-solid fa-triangle-exclamation"></i> Diese ID ist mit einer anderen ID verknüpft. Die marktierten Elemente können nur in der Haupt-ID geändert werden.<br>
                    <a class="alert-link" href=""><i class="fa-solid fa-arrow-up-right-from-square"></i> Zur Haupt-ID</a> | <a class="alert-link" href=""><i class="fa-solid fa-xmark"></i> Warnung ausblenden</a>
                </div>-->

                <div class="row">
                    <div class="col-md-4">
                        <div id="card-stammdaten" class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fa-solid fa-database"></i> Stammdaten</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="id" class="form-control" placeholder="Identnummer (ID)" autocomplete="off" readonly>
                                            <label>Identnummer (ID)</label>
                                        </div>
                                        <div class="form-group form-floating">
                                            <input type="text" name="seriennummer" class="form-control" placeholder="Seriennummer" autocomplete="off" readonly>
                                            <label>Seriennummer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="image-container">

                                            <div>
                                                <em>Kein Bild verfügbar</em>
                                                <!--<img src="https://www.actiware.de/fileadmin/actiware/produkte/ELOprofessional-ECM.png">-->
                                                <!--<img src="https://printego.de/media/image/product/160826/lg/develop-ineo-258.jpg">-->
                                            </div>
                                        </div>






                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="artikel_hersteller" class="form-control" placeholder="Hersteller" autocomplete="off" disabled>
                                            <label>Hersteller</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect" name="artikel" data-qs-name="artikel" placeholder="Artikel" disabled>
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Artikel</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="date" name="installationsdatum" class="form-control editable" placeholder="Inbetriebnahme" autocomplete="off" disabled>
                                            <label>Installation</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="date" name="lieferdatum" class="form-control editable" placeholder="Lieferung" autocomplete="off" disabled>
                                            <label>Lieferung</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Kunden Daten -->
                    <div class="col-md-4">
                        <div id="card-kundendaten" class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fa-solid fa-user-group"></i> Kundendaten</h4>

                                <!-- Warnmeldungen bei Sub IDNR -->
                                <h6 id="haupt-id-warnung" class="card-subtitle">Diese Daten werden von der Haupt-ID verwaltet</h6>

                                <div class="form-group form-floating">
                                    <select class="form-select init-quickselect" name="be_name" data-qs-name="adresse" placeholder="Betreiber" disabled>
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Betreiber</label>
                                </div>
                                <div class="form-group form-floating">
                                    <select class="form-select init-quickselect" name="re_name" data-qs-name="adresse" placeholder="Rechnungsempfänger" disabled>
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Rechnungsempfänger</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <div class="form-group form-floating">
                                                <input type="text" name="kunden_referenz" class="form-control editable" placeholder="Kunden Referenz" autocomplete="off">
                                                <label>Kunden Referenz</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <div class="form-group form-floating">
                                                <input type="text" name="kunden_kostenstelle" class="form-control editable" placeholder="Kunden Kostenstelle" autocomplete="off">
                                                <label>Kunden Kostenstelle</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-floating">
                                    <div class="form-group form-floating">
                                        <input type="text" name="standort" class="form-control editable" placeholder="Kunden Kostenstelle" autocomplete="off">
                                        <label>Standort</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kunden Daten -->
                    <div class="col-md-4">
                        <div class="card" id="card-verknuepfung">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fa-solid fa-paperclip"></i> Verknüpfungen</h4>
                                <div id="ident-verlinkung-container"></div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="actions">
                                    <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Neues Ticket erstellen"><i class="fa-solid fa-plus"></i></a>
                                </div>

                                <h4 class="card-title"><i class="fa-solid fa-ticket"></i> Tickets</h4>
        



                                <em>Hier kommen dann noch die Tickets hin!</em><br>
                                > Nur bei Haupt ID Nummern?


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="actions">
                                    <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Neues Ticket erstellen"><i class="fa-solid fa-plus"></i></a>
                                </div>

                                <h4 class="card-title"><i class="fa-solid fa-truck-loading"></i> Warenlieferungen</h4>



                                <em>Hier kommen dann noch die Warenlieferungen hin!</em><br>
                                > Nur bei Haupt ID Nummern?


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fab-container" id="locked-form">
                <button class="btn btn-primary btn-form-unlock"><i class="fa-solid fa-lock"></i></button>
            </div>

            <div class="fab-container fab-row" id="unlocked-form" style="display:none;">
                <button class="fab-text btn btn-danger btn-form-discard"><i class="fa-solid fa-trash"></i> Verwerfen</button>
                <button class="fab-text btn btn-primary btn-form-save"><i class="fa-solid fa-save"></i> Speichern</button>
            </div>






        </form>
    </div>


</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        // Initaliieren
        idet.init();


    });
</script>

</html>