<?php include('01_init.php');

$_page = [
    'title' => "Vertraege Vorlagen",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"><i class="fa-solid fa-file-contract"></i> Verträge </a>']

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
            

            <div id="vertraege-vorlagen-pickliste"></div>

        </div>
    </div>

    <!-- Fab Button -->
    <div class="fab-container">
         <button class="btn btn-primary btn-vertraegeArt-add"><i class="fas fa-plus"></i></button>
    </div>


    <!-- Modal Form -->
    <div class="modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus"></i> Verträge Art</h5>
                <button type="button" class="close btn-schliessen" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">

                <form id="vertraege-art-modal-form">

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope" required>
                                <label>Bezeichnung</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group form-floating">
                                <textarea class="form-control editable" name="beschreibung" placeholder="Beschreibung"></textarea>
                                <label>Beschreibung</label>
                            </div>
                        </div>
                    </div>
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
        // Do Something


        // Verträge Vorlagen
        var vervor = {


            init() {

                var me = this;

                // Init der Pickliste
                me.initPickliste();

                // Init Modal
                me.initModal();

                // EventListner
                me.addEventListener();
            },

            // Init der Pickliste
            initPickliste() {

                var me = this;

                me.list = new Picklist('#vertraege-vorlagen-pickliste', 'vertraege_vorlagen');
            },

            // init Modal
            initModal() {

                var me = this;

                me.modal = new ModalForm('#vertraege-art-modal-form');
                me.modal.initValidation();

            },

            // Add Eventlistner
            addEventListener() {

                var me = this;


                // btn-vertraegeArt-add"

                // *******************************************************************************
                // Standard Events Handler
                // *******************************************************************************
                
                // neue Vertragsart hinzufügen
                $('.btn-vertraegeArt-add').on('click', function() {
                    me.modal.open();

                    // Reset
                    me.modal.reset(1);
                });

                // *******************************************************************************
                // Form Handler
                // *******************************************************************************

                // Weiterleitung auf die Details Seite
                me.list.on('pick', function(el, data) {
                    app.redirect("vertraege-vorlagen-details?id=" + data[1]);
                });

                // Wenn Das Modal geschlossen wird Form zurück setzen
                me.modal.container.on('click', '.btn-schliessen', function() {
                    me.modal.reset(1);
                });

                // Wenn das Modal abgeschickt wird -- Submit 
                me.modal.on('submit', function() {
                    me.submit();
                });

            },

            // Submit Funktion des Modal
            submit() {

                var me = this;

                // Ajax Save Funktion 
                me.modal.save('submitVorlagen', 'vertraege-handle', 

                    // Success
                    function(response) {

                        //
                        app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                        // Liste Neu Laden
                        me.list.refresh(true);

                    },

                    // Error
                    function(response) {
                        app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                    }
                    
                )


            }

        }

        vervor.init();



    });
</script>
</html>