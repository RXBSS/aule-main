<?php include('01_init.php');

$_page = [
    'title' => "Veträge Klauseln Management",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"><i class="fa-solid fa-file-contract"></i> Verträge </a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
        .deleteFilterIcon {
            margin-top: 0.9cm;
            margin-left: 0.3cm;
            font-size: 18px;
        }   

        table.dataTable>tbody>tr.odd.selected p,
        table.dataTable>tbody>tr.even.selected p {
            color: white;
        }
    </style>

</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">
            

            <!-- ************************************************************************* -->
            <!-- Filter der Gruppen -->
            <!-- ************************************************************************* -->
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">
                        <div class="card-body">
                    
                            <form id="filterForm">

                                <div class="row">
                                    <div class="col">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">

                                                <div class="form-group form-floating">
                                                    <select class="form-select editable init-quickselect" data-qs-name="vertraege_gruppen" name="vertraegegruppen" placeholder="label">
                                                        <option value="">Bitte wählen</option>
                                                    </select>
                                                    <label>Vertraegegruppen filtern nach:</label>
                                                </div>
                                            </div>
                                            <div class="deleteFilterIcon"> 
                                                <a class="action-item" href="javascript:void(0);" id="vertraegegruppen_reset" data-select="vertraegegruppen" data-bs-toggle="tooltip" data-bs-placement="top" title="Auswahl Zurücksetzen"><i class="fa-solid fa-xmark"></i> </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <!-- VERSIONEN AUSWÄHLEN KÖNNEN -->
                                        <!-- VERSIONEN VERWALTEN -->

                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <div class="form-group form-floating">
                                                    <select class="form-select init-select2 editable" name="version" placeholder="Versionen filtern nach:">
                                                        <option value="">Bitte wählen</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <label>Versionen filtern nach:</label>
                                                </div>
                                            </div>
                                            <div class="deleteFilterIcon"> 
                                                <a class="action-item" href="javascript:void(0);" id="version_reset" data-select="version" data-bs-toggle="tooltip" data-bs-placement="top" title="Auswahl Zurücksetzen"><i class="fa-solid fa-xmark"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            </form>

                    
                        </div>
                    </div>
                    

                    
                   
                </div>
            </div>

            <div class="row">
            
                <!-- ********************************************************************* -->
                <!-- Pickliste -->
                <!-- ********************************************************************* -->
                <div class="col-lg-6">

                    <div id="vertraege-klauseln-pickliste"></div>

                </div>

                <!-- ********************************************************************* -->
                <!-- Form zur schnellen Änderung der Klausel -->
                <!-- ********************************************************************* -->
                <div class="col-lg-6 card-form" >

                    <div class="card">
                        <div class="card-body">


                            

                            <h4 class="card-title"><i class="fa-solid fa-file-contract"></i> Klauseln</h4>

                            <form id="vertraege-klauseln-form">

                                <div class="row">
                                    <div class="col">


                                        <!-- <div class="form-group form-floating">
                                            <input type="text" name="text" class="form-control editable" placeholder="Klausel" autocomplete="nope">
                                            <label>Klausel</label>
                                        </div> -->

                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" data-qs-name="vertraege_gruppen" name="gruppen_id" placeholder="label">
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Vertraegegruppen</label>
                                        </div>

                                        
                                    </div>
                                    <!-- <div class="col">
                                    
                                        <div class="form-group form-floating">
                                            <select class="form-select editable init-quickselect" data-qs-name="vertraege_art" name="vertraegeart_id" placeholder="label">
                                                <option value="">bitte wählen</option>
                                            </select>
                                            <label>Vertragsart</label>
                                        </div>

                                        <div class="form-group form-floating">
                                            <input type="text" name="titel" class="form-control editable" placeholder="Klausel Titel" autocomplete="nope">
                                            <label>Klausel Titel</label>
                                        </div>
                                    </div> -->
                                </div>


                                <br>

                                <div class="row">
                                    <div class="col">
                                        <div class="form-group form-floating">
                                            <textarea class="form-control editable" name="text" placeholder="Klausel"></textarea>
                                            <!-- <label>Klausel</label> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        
                                         <div class="form-group form-floating-check">
                                            <label class="form-label">Standard Klausel:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable" id="standard_klausel" name="standard" value="1" />
                                                <label class="form-check-label" for="standard_klausel">Standard</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col col-version">

                                        <div class="form-group form-floating">
                                            <input type="text" name="version" class="form-control" placeholder="Version" autocomplete="nope" value="1">
                                            <label>Version</label>
                                        </div>  

                                    </div>
                                    <div class="col">

                                        <div class="form-group form-floating">
                                            <input type="text" name="auschluss_klassen" class="form-control editable" placeholder="Gruppierung" autocomplete="nope">
                                            <label>Gruppierung</label>
                                        </div>

                                    </div>
                                    
                                </div>

                                <!-- Klausel Referenz ID -->
                                <div>
                                    <input type="hidden" name="klausel_referenz_id">
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>




        </div>
    </div>

    <div class="fab-container">
        <button class="btn btn-primary btn-vertraege-klauseln-add"><i class="fas fa-plus"></i></button>
    </div>

</body>

<?php include('04_scripts.php'); ?>
<script src="../js/pagelevel/vertreage-klauseln.js"></script>
<!-- <script src="js/pagelevel/vertraege-details-positionen.js"></script> -->

<script>

    // verkla = Object.assign(vPos, verkla);    
    // verkla = Object.assign(detailHelper, verkla);


    $(document).on('app:ready', function() {
        // Do Something

        verkla.init();
    });
</script>
</html>