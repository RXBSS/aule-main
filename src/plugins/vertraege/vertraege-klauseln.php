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

            <!-- ********************************************************************* -->
            <!-- Verträgegruppen -->
            <!-- ********************************************************************* -->    
            
            <form id="klausel-status-form">
            
                <div class="row mb-lg-2">
                    <div class="col-lg-2">
                        <button class="btn btn-primary" id="vertraegegruppen-edit">Vertragsgruppen</button>
                    </div>
                    <!-- <div class="col-lg-10" style="margin-top: -5px;">

                        <div class="form-group form-floating-check">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input editable status-filter" type="checkbox" id="aktiv" name="aktiv" value="2" checked>
                                <label class="form-check-label" for="aktiv">Aktive Versionen</label>
                            </div>
                            <div class="form-check form-check-inline"> 
                                <input class="form-check-input editable status-filter" type="checkbox" id="alte" name="alte" value="3">
                                <label class="form-check-label" for="alte">Alte Versionen</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input editable status-filter" type="checkbox" id="entwurf" name="entwurf" value="1">
                                <label class="form-check-label" for="entwurf">Entwurf Versionen</label>
                            </div>
                            
                        </div>
                    </div> -->
                </div>

            </form>

            <!-- ********************************************************************* -->
            <!-- Filter -->
            <!-- ********************************************************************* -->    
            <div class="row">
                <div class="col">

                </div>
                <div class="col">

                </div>
                <div class="col">

                </div>
            </div>

            <div class="row">

                

                <!-- ********************************************************************* -->
                <!-- Pickliste -->
                <!-- ********************************************************************* -->
                <div class="col">

                    <div id="vertraege-klauseln-pickliste"></div>
                </div>
            </div>


        </div>
    </div>

    <div class="fab-container">
        <button class="btn btn-primary btn-vertraege-klauseln-add"><i class="fas fa-plus"></i></button>
    </div>

    <!-- Modal Klauseln -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-add"></i> Neue Klausel</h5>
                    <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                </div>
                <div class="modal-body">

                    <form id="vetraege-klausel-modal-form">

                        <div class="row">
                            <div class="col">

                                <div class="form-group form-floating">
                                    <select class="form-select editable init-quickselect" data-qs-name="vertraege_gruppen" name="gruppen_id" placeholder="label">
                                        <option value="">bitte wählen</option>
                                    </select>
                                    <label>Vertraegegruppen</label>
                                </div>
                            </div>
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

                            <div class="col">

                                <div class="d-flex">
                                    
                                    <div class="flex-grow-1">
                                        <div class="form-group form-floating-check">
                                            <label class="form-label">Status Aktiv:</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input editable" id="status_aktiv" name="status_aktiv" value="1" />
                                                <label class="form-check-label" for="status_aktiv">Aktiv</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="" style="margin-top: 0.3cm; margin-right: 3cm; font-size: 17px;">
                                        <a class="action-item" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Wenn Sie den Status auf Aktiv setzen">
                                            <i class="fa-solid fa-circle-question"></i>
                                        </a>
                                    </div>
                                </div>


                                
                            </div>

                            <!-- <div class="col">

                            <div class="form-group form-floating">
                                <input type="text" name="auschluss_klassen" class="form-control editable" placeholder="Gruppierung" autocomplete="nope">
                                <label>Gruppierung</label>
                            </div>

                        </div> -->

                        </div>

                    </form>


                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
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


        // Vertrag Klauseln
        var verkla_ = {

            init() {

                var me = this;

                // Modal
                me.initModal();

                // Form
                me.initForm();

                // Pickliste
                me.initPickliste();

                // Summernote
                me.initSummernote();

                // Events
                me.addEventListener();

            },

            // init Pickliste
            initPickliste() {

                var me = this;

                me.list = new Picklist('#vertraege-klauseln-pickliste', 'vertraege_klauseln', {
                    addButtons: [{
                        action: "btn-klausel-delete",
                        class: "btn-klausel-delete",
                        icon: "fa-solid fa-trash",
                        tooltip: "Löschen Klausel",
                        show: 'onSelected',
                        pos: 3,
                    }]
                });

                me.list.on('initComplete', function() {
                });
            },


            // Init Modal
            initModal() {

                var me = this;

                me.modal = new ModalForm('#vetraege-klausel-modal-form');
                me.modal.initValidation();

            },

            // Init Form
            initForm() {

                var me = this; 

                me.statusForm = new Form('#klausel-status-form'); 

            },

            // Init Summernote
            initSummernote() {

                var me = this;

                // Summernote im Editieren Block
                $('textarea[name=text]').summernote({
                    height: 100,
                    minHeight: null,
                    maxHeight: null,
                    focus: true,
                    lang: 'de-DE',

                    // Callbacks
                    callbacks: {
                        onPaste: function() {
                            app.notify.success.fire("Erfolgreich", "Erfolgreich reinkopiert");
                        }
                    },

                    // Toolbar
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline']],
                        ['font', ['strikethrough']],
                        ['para', ['ul', 'ol']],
                        ['codeview'],
                        ['Insert', ['picture', 'link']]
                    ],
                });

            },

            addEventListener() {


                var me = this;

                // ***********************************************************************
                // Standard Events 
                // ***********************************************************************


                // Wenn der Fab Button geklick wird soll das Modal sich öffnen
                $('.btn-vertraege-klauseln-add').on('click', function() {
                    me.modal.open();
                });

                // Wenn der Verträgegruppen Edit Button geklickt wird
                $('#vertraegegruppen-edit').on('click', function() {
                    document.cookie = "vg=1";
                    app.redirect("weitere-stammdaten");
                });

                // Wenn die Version geklickt wird
                // $('input[name="version"]').on('change', function() {

                //     // Setzt den Filter auf Status 1 (Entwurf) oder 2 (Aktiv)
                //     me.list.setFilter(new PickFilter('status_id_2', $(this).val() ));

                // });

                // Wenn Status Geändert wird
                // $('input.status-filter').on('change', function() {
                //     me.onChangeStatus($(this));
                // });


                // ***********************************************************************
                // Form Handler Events 
                // ***********************************************************************

                // Submit Funktion des Modals -- Neue Klausel
                me.modal.on('submit', function() {
                    me.submit();
                });

                // Wenn eine Auswahl der Liste getroffen wurde
                me.list.on('pick', function(key, data) {
                    app.redirect('vertraege-klauseln-details.php?id=' + data[1]);
                })

                // Wenn Alte Version angezeigt werden soll 
                me.list.container.on('initComplete', function() {

                    // Beim neu Laden immer status auf Aktiv setzen
                    // me.list.setFilter(new PickFilter([3, 3], ['1', '2']));
                    
                });

            },

            // Modal wird abgeschickt und neue Klausel hinzugefügt
            submit() {

                var me = this;

                // Save funktion Speichern der Daten
                me.modal.save('klausel-submit', 'vertraege-handle',

                    // Success
                    function(response) {

                        // Liste Neu Laden 
                        me.list.refresh();

                        // Erfolgsmeldung
                        app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                        // Modal Reset
                        me.modal.reset(1);

                    },

                    // Error
                    function(response) {

                        app.notify.error.fire("Fehler", 'Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!');

                    }

                )

            },

            // Funktion die den Status ändert
            onChangeStatus(selector) {

                var me = this;

                // Holt sich die Angewählten Values
                var status = me.getStatusFilterValues();

                // Mit STRG gedrückt - verhält sich wie checkbox
                if (app.keys.ctrl) {

                    // Wenn eine Auswahl getroffen wurde
                    if (status.length > 0) {

                        // Übernehmen den Filter
                        me.applyFilter();
                    } else {

                    // 
                    selector.prop('checked', true);
                }

                    // Verhält sich wie Radio
                } else {

                    // Alle werden auf False gesetzt
                    $('.status-filter').prop('checked', false);

                    // Der Aktuelle gewählte wird auf true gesetzt
                    selector.prop('checked', true);

                    // Übernehmend den Filter
                    me.applyFilter();
                }
            },

            // Nach Status Filter
            getStatusFilterValues() {

                var me = this;

                // Holt die daten
                var data = me.statusForm.getData();

                // Leeere Array
                var statusArray = [];

                // Schleife geht durch alle Statuse 
                $.each(['entwurf', 'aktiv', 'alte'], function (index, value) {

                    // Guckt wer checked ist
                    if (data[value].checked) {

                        // Setzt seine Value in das Array
                        statusArray.push(data[value].value);
                    }
                });

                // Rückgabe
                return statusArray;

            },

            // Wendet den Filter an
            applyFilter() {

                var me = this;

                // Holt die Daten aus dem Formular
                var data = me.statusForm.getData();

                // Init CompleteFilter
                var completeFilter = [];

                // 
                var statusArray = me.getStatusFilterValues();

                var status = new PickFilter(3, (statusArray.length > 0) ? statusArray : [1, 2, 3], 'IN');

                completeFilter.push(status);

                // Wenn der CompletFilter nicht leer ist
                if (completeFilter.length > 0) {

                    // Erstellt Filter
                    completeFilter = new PickFilter(completeFilter);

                    // Übernimmt es für die Pickliste
                    me.list.setFilter(completeFilter);

                    // Wenn der CompleteFilter leer ist - Filter ZURÜCKSETZEN
                } else {

                    me.list.resetFilter();
                }
                
            },

            // Filter für alle Aktuellen Versionen und Entwürfe
            // aktuelleVersion() {

            //     var me = this;

            //     console.log("FILTER AUF Neue VERSION UND ENTZWURFE");

            //     // Setzt den Filter auf Status 1 (Entwurf) oder 2 (Aktiv)
            //     me.list.setFilter(new PickFilter(['status_id', 'status_id'], ['1', '2'], null, 'OR'));

            // },

            // // Filter für alle alte Versioenn
            // alteVersionen() {

            //     var me = this;

            //     console.log("FILTER AUF ALTER VERSION");


            //     // Setzt den Filter auf Status 3 (Alte Version)
            //     me.list.setFilter(new PickFilter('status_id', '3'));

            // }

        }

        verkla_.init();

        // verkla.init();
    });
</script>

</html>