<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-code-branch\"></i> Software",
    'breadcrumbs' => ['Stammdaten', '<a href="weitere-stammdaten">Weitere Stammdatan</a>']
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
                <div class="offset-6 col-6">
                    <nav>
                        <div class="nav nav-tabs" id="tab-nav-name">
                            <button class="nav-link active" id="tab-nav-name-1" data-bs-toggle="tab" data-bs-target="#tab-content-name-1" type="button">Versionen</button>
                            <button class="nav-link" id="tab-nav-name-2" data-bs-toggle="tab" data-bs-target="#tab-content-name-2" type="button">Artikel</button>
                        </div>
                    </nav>
                    <br>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div id="picklist-software"></div>
                </div>
                <div class="col-md-6">



                    <div class="tab-content" id="tab-content-name">
                        <div class="tab-pane fade show active" id="tab-content-name-1">
                            <div id="picklist-software-versionen"></div>
                        </div>
                        <div class="tab-pane fade" id="tab-content-name-2">
                            <em>TODO</em>
                        </div>
                    </div>


                </div>
            </div>
        </div>


        <div class="fab-container">
            <button class="btn btn-primary btn-sm fab-children" data-label="Neue Software"><i class="fa-solid fa-code"></i></button>
            <button class="btn btn-primary btn-sm fab-children" data-label="Neue Version"><i class="fa-solid fa-code-branch"></i></button>
            <button class="btn btn-primary fab-parent fab-rotate"><i class="fa-solid fa-angle-up"></i></button>
        </div>


    </div>


    <!-- Modal für Version -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa-solid fa-code-branch"></i> Software Version</h5>
                    <div class="actions"></div>
                </div>
                <div class="modal-body pt-0">
                    <form id="form-software-version">

                        <!-- Software -->
                        <div class="form-group form-floating">
                            <select class="form-select init-select2 editable" name="software" placeholder="Software">
                                <option value="">Bitte wählen</option>
                            </select>
                            <label>Software</label>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-floating">
                                    <input type="text" name="versionsnummer" class="form-control editable" placeholder="Versionsnummer" autocomplete="off">
                                    <label>Versionsnummer</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-floating">
                                    <input type="date" name="releasedatum" class="form-control editable" placeholder="Releasedatum" autocomplete="off">
                                    <label>Releasedatum</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-floating-check">
                                    <label class="form-label">Minor / Major</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input editable" id="major-release" name="major" value="1" />
                                        <label class="form-check-label" for="major-release">Ist Major Release</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-floating">
                                    <select class="form-select init-select2 editable" name="art" placeholder="Art">
                                        <option value="">Bitte wählen</option>
                                    </select>
                                    <label>Art</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-floating-check">
                            <label class="form-label">Sperre</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input color-danger editable" id="sperre" name="sperre" value="1" />
                                <label class="form-check-label" for="sperre">Sperre für diese Version aktivieren</label>
                            </div>
                        </div>

                        <div class="form-group form-floating">
                            <textarea class="form-control editable" placeholder="Anmerkungen"></textarea>
                            <label>Anmerkungen</label>
                        </div>

                        <div class="form-group form-floating">
                            <textarea class="form-control editable" placeholder="Releasenotes" style="max-height: 200px;"></textarea>
                            <label>Releasenotes</label>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>




</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        var softwareList = new Picklist("#picklist-software", "software", {
            type: 'single-picklist',
            addHandleButtons: true,
            addButtons: [{
                action: "create-report",
                icon: "fa-solid fa-chart-area",
                tooltip: "Neues Chart erstellen",
                show: 'onSingleSelected',
                pos: 4
            }]
        });

        var versionList = new Picklist("#picklist-software-versionen", "software-versionen", {
            // type: 'multi-picklist'
            pageLength: 15,
            addHandleButtons: true
        });


        softwareList.on('selection', function(el, data) {
            // Daten
            if (data) {

                // Set Filter
                versionList.setFilter(new PickFilter('software_id', data[1]));

            } else {
                versionList.resetFilter();
            }
        });


        softwareList.on('action', function(el, event) {

            if (event == 'create-report') {
                // 
                var data = softwareList.getSelectedSingle();

                // Redirect
                app.redirect('software-report?id=' + data[1]);
            }




           
        });




        // Form ohne FormValidation
        var form = new ModalForm('#form-software-version', true);

        // Open
        versionList.on('pick', function(el, data) {
            form.open();
        });
    });
</script>

</html>