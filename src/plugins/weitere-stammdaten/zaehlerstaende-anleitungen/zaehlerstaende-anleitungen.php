<?php include('01_init.php');

$_page = [
    'title' => "<i class=\"fa-solid fa-book\"></i> Zählerstand Auslesen Anleitungen",
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
                <div class="col-md-6">
                    <div id="pickliste-zaehlerstaende-anleitungen"></div>


                </div>
                <div class="col-md-6">
                    <div class="card" id="card-zaehlerstand-auslesen-anleitung">
                        <div class="card-body">

                            <div class="actions">

                                <a class="action-item btn-zaehlerstaende-anleitungen-html" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Vorschau in HTML"><i class="fa-solid fa-eye"></i></a>
                                <a class="action-item btn-zaehlerstaende-anleitungen-pdf" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Anleitung als PDF"><i class="fas fa-file-pdf"></i></a>
                                <a class="action-item btn-zaehlerstaende-anleitungen-mail" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Vorschau in HTML"><i class="fa-solid fa-envelope"></i></a>
                                <a class="action-item btn-zaehlerstaende-anleitungen-loeschen" href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Löschen"><i class="fas fa-trash"></i></a>
                            </div>

                            <form id="form-zaehlerstand-auslesen-anleitung">


                                <h4 class="card-title"><i class="fas fa-book"></i> Anleitung</h4>

                                <!-- ID -->
                                <input type="hidden" name="id" value="">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-floating">
                                            <input type="text" name="bezeichnung" class="form-control editable" placeholder="Bezeichnung" autocomplete="nope">
                                            <label>Bezeichnung</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="status_id" data-qs-name="zaehlerstaende-abfrage-status" placeholder="Hersteller">
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Status</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating">
                                            <select class="form-select init-quickselect editable" name="hersteller_id" data-qs-name="hersteller" placeholder="Hersteller">
                                                <option value="">Bitte wählen</option>
                                            </select>
                                            <label>Hersteller</label>
                                        </div>
                                    </div>
                                </div>

                                <br>



                                <div class="form-group form-summernote">
                                    <textarea class="editable" name="inhalt" data-fv-notempty="true"></textarea>
                                </div>


                            </form>

                        </div>
                    </div>

                </div>
            </div>


            <div class="fab-container">
                <button class="btn btn-primary btn-zaehlerstaende-anleitungen-add"><i class="fas fa-plus"></i></button>
            </div>


        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {

        var list = new Picklist("#pickliste-zaehlerstaende-anleitungen", "zaehlerstaende-anleitungen", {
            type: 'single-picklist'
        });

        // Ausblenden
        $('#card-zaehlerstand-auslesen-anleitung').hide();


        $('textarea[name=inhalt]').summernote({
            height: 300,
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

        // Form Initalisieren
        var form = new CardForm('#form-zaehlerstand-auslesen-anleitung');

        // Form Validation aktivieren
        form.initValidation();

        list.on('selection', function(el, value) {
            if (value) {
                $('#card-zaehlerstand-auslesen-anleitung').show();

                form.load('load', 'zaehlerstaende-anleitungen-handle.php', value[1], function() {

                });
            } else {
                $('#card-zaehlerstand-auslesen-anleitung').hide();
            }
        });

        // On Submit Event Abfangen
        form.on('submit', function(e) {

            // Daten speichern
            form.save('edit', 'zaehlerstaende-anleitungen-handle.php', function(response) {
                console.log(response.data);
                list.reload();
            }, function(a,b) {
                console.log(b);
            });

        });

        // Anleitungen  
        $('.btn-zaehlerstaende-anleitungen-add').on('click', function() {

            // Einfacher Request
            app.simpleRequest("new", "zaehlerstaende-anleitungen-handle.php", null, function(response) {

                list.setFilter(new PickFilter('id', response.data));

                // Load
                form.load('load', 'zaehlerstaende-anleitungen-handle.php', response.data, function() {

                    $('#card-zaehlerstand-auslesen-anleitung').show();

                    // Enable Form
                    form.enable();

                    form.getEl('bezeichnung').focus();
                });
            });
        });


        $('.btn-zaehlerstaende-anleitungen-loeschen').on('click', function() {
            var id = form.getEl('id').val();

            // Löschbar muss noch geprüft werden?

            app.alert.delete.fire("Anleitung löschen", "Wollen Sie die Anleitung wirklich löschen? Das löschen kann nicht rückgängig gemacht werden.").then(function(result) {

                if (result.isConfirmed) {

                    // Prüfen ob es Löschbar ist
                    app.simpleRequest("delete-start", "zaehlerstaende-anleitungen-handle.php", id, function(response) {

                        // Wenn gelöscht wurde
                        if (response.data) {
                            list.reload(true);

                            // Wenn nicht gelöscht wurde
                        } else {
                            app.alert.delete.fire("Anleitung wird noch verwendet", "Die Anleitung wird noch verwendet. Wollen Sie trotzdem mit dem Löschen fortfahren?").then(function(result) {
                                app.simpleRequest("delete-force", "zaehlerstaende-anleitungen-handle.php", id, function(response) {
                                    list.reload(true);
                                });
                            });
                        }
                    });
                }
            })

        });

        $('.btn-zaehlerstaende-anleitungen-mail').on('click', function() {
            app.alert.error.fire("Noch nicht programmiert", "Hier sollte eine Auswahl nach Kontakten kommen. Aus diesen Kontakten kann man dann auswählen und die Mail verschicken!");
        });


        $('.btn-zaehlerstaende-anleitungen-html').on('click', function() {
            var id = form.getEl('id').val();
            window.open("zaehlerstaende-anleitung-preview.php?id=" + id, 'targetWindow', `toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes width=600,height=400`);
        });


        $('.btn-zaehlerstaende-anleitungen-pdf').on('click', function() {
            app.alert.error.fire("Noch nicht programmiert", "Hier sollte sich eigentlich das PDF öffnen. Diese Funktion ist aber noch nicht programmiert!");
        });

    });
</script>

</html>