<?php include('01_init.php');

$_page = [
    'title' => "Example Details",
    'breadcrumbs' => ['<a href="example">Beispiel</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper loading">
        <div class="container-fluid">


            <form id="example-form">

                <div class="row">
                    <div class="col-md-4">

                        <div class="card" id="card-adresse">
                            <div class="card-body">
                                <?php include("adressen-liefer-und-rechnung-form.php"); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="card" id="card-form">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fas fa-icon"></i> Sonstige Form</h4>

                                <div class="form-group form-floating">
                                    <input type="text" name="name" class="form-control editable" placeholder="Test" autocomplete="nope">
                                    <label>Test</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Detail Status -->
                    <div class="col-md-4">
                        <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    <div>Status 1 - oben</div>
                                    <div>Status 1 - unten</div>
                                </div>
                            </div>
                        </div>
                        <div id="status-2" class="alert alert-soft-success detail-status" data-status="2">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    Status 2
                                </div>
                            </div>
                        </div>
                        <div id="status-3" class="alert alert-soft-danger detail-status" data-status="3">
                            <div class="detail-status-inner">
                                <div class="d-flex h-100 flex-column justify-content-between">
                                    Status 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col">

                        <!-- Positionen -->
                        <div class="card">
                            <div class="card-body">

                                <!-- Action Items -->
                                <div class="actions">
                                    <a class="action-item btn-pos-delete" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fa-solid fa-trash"></i></a>
                                    <a class="action-item btn-pos-shift" data-shift="up" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hoch"><i class="fa-solid fa-chevron-up"></i></a>
                                    <a class="action-item btn-pos-shift" data-shift="down" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Runter"><i class="fa-solid fa-chevron-down"></i></a>
                                    <a class="action-item btn-pos-add" href="javascript:void(0);" data-status="1" data-bs-toggle="tooltip" data-bs-placement="top" title="Neu"><i class="fa-solid fa-plus"></i></a>
                                </div>    


                                <!-- Überschrift -->
                                <h4 class="card-title"><i class="fa-solid fa-layer-group"></i> Positionen</h4>

                                <!-- Picklist -->
                                <div id="pickliste-positionen"></div>

                                <!-- Summe unten -->
                                <div class="row">
                                    <div class="col-md-8">
                                        <br>
                                        <button class="btn btn-secondary" type="button"><i class="fa-solid fa-plus"></i> Neuer Artikel</button><br>

                                        <em>Weitere Möglichkeiten</em>

                                    </div>
                                    <div class="col-md-4">
                                        <?php include("positionen-summe-anzeige.php"); ?>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">

                        <!-- Position Form 1 -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fas fa-icon"></i> Form 1</h4>
                            </div>
                        </div>

                    </div>

                    <div class="col">

                        <!-- Position Form 2 -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="fas fa-icon"></i> Form 2</h4>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

<!-- Auftrennen des JavaScripts in mehrere Dateien -->
<script src="js/pagelevel/example-details-form.js"></script>
<script src="js/pagelevel/example-details-positionen.js"></script>

<?php include('04_scripts.php'); ?>


<script>
    // Detail Helper hinzufügen
    ex = Object.assign(detailHelper, ex);

    // Weitere JavaScripts hinzufügen
    ex = Object.assign(ex, exForm);
    ex = Object.assign(ex, exPos);

    $(document).on('app:ready', function() {

        ex.init();


        // DIESER PART IST NUR ZUM STEUERN DER DEMO
        // ----------------------------------------

        // Neuen Action Button erstellen
        var exampleCtrlBtn = new Notification({
            icon: 'fas fa-bars'
        });

        var exampleCtrlBar = new Sidebar({
            name: 'example-controle',
            width: 200,
            clickToClose: false,
            actionButton: exampleCtrlBtn
        });

        var el = exampleCtrlBar.getEl();

        // Status Button hinzufügen
        el.append('<button class="btn btn-warning set-status mb-1" data-statusto="1">Status 1</button><br>');
        el.append('<button class="btn btn-success set-status mb-1" data-statusto="2">Status 2</button><br>');
        el.append('<button class="btn btn-danger set-status mb-1" data-statusto="3">Status 3</button><br>');

        el.on('click', '.set-status', function() {
            var status = parseInt($(this).data('statusto'));
            ex.changeStatus(status);
        });

    });
</script>

</html>