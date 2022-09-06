<?php include('01_init.php');

$_page = [
    'title' => "Artikel",
    'breadcrumbs' => ['Stammdaten']
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

            <!-- Pickliste -->
            <div id="artikel-pickliste"></div>

            <!-- FAB-->
            <div class="fab-container">
                <button class="btn btn-primary btn-artikel-new"><i class="fa-solid fa-plus"></i></button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-box"></i> Neuen Artikel</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body">

                    <!-- Form -->
                    <form id="form-artikel" autocomplete="off">

                        <!-- Wird nicht benötigt -->
                        <input type="hidden" name="artikelnummer">

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

                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

</body>

<?php include('04_scripts.php'); ?>

<!-- Artikel-Attribute -->
<script src="js/pagelevel/artikelattribute.js"></script>

</html>