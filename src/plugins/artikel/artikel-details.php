<?php include('01_init.php');

$_page = [
    'title' => "Artikel Details",
    'breadcrumbs' => ['Stammdaten', '<a href="artikel">Artikel</a>']
];

$artikel = new Artikel();


?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
    <style>
        .label-info {
            position: relative;
        }

        .label-info:after {
            position: absolute;
            content: " ";
            width: 100%;
            left: 0px;
            bottom: 0px;
            border-bottom: 1px dashed #7AB929;
        }


        .card-img-top {
            border-top-left-radius: 2px;
            border-top-right-radius: 2px;
            box-shadow: 0 1px 2px rgb(0 0 0 / 8%);
        }

        .btn-artikel-filter-verknuepfung.disabled .alert {
            opacity: 0.5;
        }
    </style>
</head>

<body>
    <?php include('03_navigation.php'); ?>

    <div class="wrapper">
        <div class="container-fluid">

            <!-- Warnung für Inaktive Artikel -->
            <div class="alert alert-warning alert-status" data-values="2"><i class="fa-solid fa-xmark"></i> <strong>Artikel ist inaktiv</strong></div>
            
            <!-- Warnung für Gesperre Artikel -->
            <div class="alert alert-danger alert-status" data-values="3"><i class="fa-solid fa-ban"></i> <strong>Artikel ist gesperrt</strong></div>

            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><i class="fa-solid fa-box"></i> Artikel Stammdaten</h4>

                            <!-- Form -->
                            <form id="form-artikel">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group form-floating">
                                            <input type="text" name="id" class="form-control" placeholder="Artikel Id" disabled>
                                            <label>Artikel Id</label>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group form-floating-radio">
                                            <label class="form-label">Status</label><br>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="status-1" name="status_id" value="1">
                                                <label class="form-check-label" for="status-1">Aktiv</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="status-2" name="status_id" value="2">
                                                <label class="form-check-label label-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Artikel kann noch verwendet werden, es öffnet sich aber immer ein Informationsdialog" for="status-2">Inaktiv</label>
                                            </div>
                                            <div class="form-radio form-check-inline">
                                                <input class="form-check-input editable" type="radio" id="status-3" name="status_id" value="3">
                                                <label class="form-check-label label-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Artikel kann nicht mehr verwendet werden" for="status-3"> Gesperrt</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="herstellernummer" class="form-control editable" placeholder="Bezeichnung">
                                            <label>Herstellernummer</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <input type="text" name="ean" class="form-control editable" placeholder="EAN">
                                            <label>EAN</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-floating">
                                    <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" required>
                                    <label>Bezeichnung</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" name="hersteller" placeholder="Hersteller" required>
                                            </select>
                                            <label>Hersteller</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" name="zuordnung" data-qs-name="artikel_zuordnung" placeholder="Zuordnung" required>
                                            </select>
                                            <label>Zuordnung</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" name="artikelgruppe" data-qs-name="artikel_gruppen" placeholder="Artikelgruppe" required>
                                            </select>
                                            <label>Artikelgruppe</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attribute -->
                                <div id="artikel-attribute"></div>

                                <!-- Langtext -->
                                <div class="form-group form-floating">
                                    <textarea class="form-control editable" name="langtext" placeholder="Floating Textarea"></textarea>
                                    <label>Langtext</label>
                                </div>

                                <!-- Notizen -->
                                <div class="form-group form-floating">
                                    <textarea class="form-control editable" name="notiz" placeholder="Floating Textarea"></textarea>
                                    <label>Notiz</label>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8">

                    <!-- Tab Navigation -->
                    <nav>
                        <div class="nav nav-tabs justify-content-between" id="tab-nav-artikel">
                            <button class="nav-link active" id="tab-nav-artikel-1" data-bs-toggle="tab" data-bs-target="#tab-content-artikel-1" type="button"><i class="fa-solid fa-box"></i> Lager / Preise</button>
                            <button class="nav-link identartikel" id="tab-nav-artikel-2" data-bs-toggle="tab" data-bs-target="#tab-content-artikel-2" type="button"><i class="fa-solid fa-lightbulb"></i> Ident</button>
                            <button class="nav-link " id="tab-nav-artikel-4" data-bs-toggle="tab" data-bs-target="#tab-content-artikel-4" type="button"><i class="fa-solid fa-diagram-project"></i> Verknüpfungen</button>
                            <button class="nav-link" id="tab-nav-artikel-5" data-bs-toggle="tab" data-bs-target="#tab-content-artikel-5" type="button"><i class="fa-solid fa-book"></i> Dokumente</button>
                            <button class="nav-link" id="tab-nav-artikel-6" data-bs-toggle="tab" data-bs-target="#tab-content-artikel-6" type="button"><i class="fa-regular fa-image"></i> Bilder</button>
                        </div>
                    </nav>

                    <br>


                    <!-- ############## TAB CONTENT -->
                    <div class="tab-content" id="tab-content-artikel">

                        <!-- Lager und Preise -->
                        <div class="tab-pane active show" id="tab-content-artikel-1">
                            <?php include("artikel-details-lager-preise.php"); ?>
                        </div>

                        <!-- Identartikel -->
                        <div class="tab-pane" id="tab-content-artikel-2">
                            <?php include("artikel-details-ident.php"); ?>
                        </div>

                        <!-- Verknüpfungen -->
                        <div class="tab-pane " id="tab-content-artikel-4">
                            <?php include("artikel-details-verknuepfungen.php"); ?>
                        </div>

                        <!-- Dokumente -->
                        <div class="tab-pane" id="tab-content-artikel-5">
                            <?php include("artikel-details-dokumente.php"); ?>
                        </div>

                        <!-- Bilder -->
                        <div class="tab-pane" id="tab-content-artikel-6">
                            <?php include("artikel-details-bilder.php"); ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAB Buttons -->
    <div class="fab-container">
        <button class="btn btn-primary btn-sm fab-children btn-artikel-nachfolger" data-label="Artikel Nachfolger"><i class="fa-solid fa-file-import"></i></button>
        <button class="btn btn-primary btn-sm fab-children btn-artikel-kopieren" data-label="Artikel Kopieren"><i class="fa-solid fa-copy"></i></button>
        <button class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
    </div>

</body>





<?php include('04_scripts.php'); ?>

<!-- Artikel-Attribute -->
<script src="js/pagelevel/artikel-details-01-lager-und-preise.js"></script>
<script src="js/pagelevel/artikel-details-02-ident.js"></script>
<script src="js/pagelevel/artikel-details-03-verknuepfungen.js"></script>
<script src="js/pagelevel/artikel-details-04-dokumente.js"></script>
<script src="js/pagelevel/artikel-details-05-bilder.js"></script>
<script src="js/pagelevel/artikelattribute.js"></script>
<script src="js/pagelevel/artikel-details-historie.js"></script>

<script>
    $(document).on('app:ready', function() {

        // Objekte hinzufügen
        artikel = Object.assign(artikel, artikelLagerUndPreise);
        artikel = Object.assign(artikel, artikelIdent);
        artikel = Object.assign(artikel, artikelVerknuepfungen);
        artikel = Object.assign(artikel, artikelDokumente);
        artikel = Object.assign(artikel, artikelBilder);

        // Init
        artikel.init();
    });
</script>



</html>