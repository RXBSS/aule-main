<?php include('01_init.php');

$_page = [
    'title' => "Veträge Klauseln Details",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"> Verträge </a>', '<a href="vertraege-klauseln"> Verträge Klauseln</a>']
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

            <!-- Eine Einzige Form -->
            <form id="vertraege-klauseln-form">


                <div class="row">

                    <!-- Bearbeiten der Stammdaten der Klausel -->
                    <div class="col-lg-6">

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fas fa-edit"></i> Verträge Klauseln</h4>

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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- ************************************************* -->
                        <!-- Verwendet in -->
                        <!-- ************************************************* -->

                        <div class="row">
                            <div class="col">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title"><i class="fa-solid fa-circle-info"></i> Verwendet In</h4>
                                
                                        <h6 class="subtext">Hier Werden alle Vertragsarten aufgelistet, in den die Klausel verwendet wird: </h6>
                                        
                                        <div id="verwendet-in">
                                            <ul></ul>
                                        </div>
                                
                                
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>

                    <!-- Status der Klausel auf Entwurf oder Aktiv mit Version -->
                    <div class="col-lg-6">


                        <div class="row">
                            <div class="col">

                                <!-- ************************************************* -->
                                <!-- Vertrag Vorlagen Status -->
                                <!-- ************************************************* -->

                                <!-- Status 1 - Entwurf -->
                                <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1" style="min-height: 200px;">
                                    <div class="detail-status-inner">
                                        <div class="d-flex h-100 flex-column justify-content-between">
                                            <div>
                                                <h4 class="alert-header status-header"> </h4>
                                                <ul class="status-unorder-list">
                                                    <!-- <li>Der Kunde hat noch keine Einsicht im Kundenportal</li> -->
                                                    <!-- <li>Vorschau <a href="javascript:void(0);" data-document="ag" class="btn-print-preview">Vertrag</a></li> -->
                                                </ul>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-dark btn-klausel-aktivieren"><i class="fa-solid fa-check"></i> Klausel Aktivieren</button>
                                                <button type="button" class="btn btn-dark btn-entwurf-speichern"><i class="fa-solid fa-save"></i> Entwurf speichern</button>
                                                <button type="button" class="btn btn-danger btn-entwurf-loeschen"><i class="fa-solid fa-trash"></i> Entwurf löschen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Status 2 - Aktiver Vertrag -->
                                <div id="status-2-0" class="alert alert-soft-secondary detail-status" data-status="2" data-substatus="0" style="min-height: 200px;">
                                    <div class="detail-status-inner">
                                        <div class="d-flex h-100 flex-column justify-content-between">
                                            <div>
                                                <h4 class="alert-header status-header"></h4>

                                                <ul class="status-unorder-list">

                                                </ul>


                                                <!-- <a href=""><i class="fa-solid fa-file-pdf"></i> Auftragsbestätigung</a> - 26.01.2022<br> -->

                                            </div>
                                            <div>
                                                <button class="btn btn-primary btn-klausel-neue-version" type="button"><i class="fa-solid fa-code-branch"></i> Neue Version</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Timeline -->
                                <div class="row">
                                    <div class="col">
                                        <div id="vertraege-klauseln-timeline"></div>
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>

                </div>





            </form>

        </div>
    </div>
</body>

<?php include('04_scripts.php'); ?>
<script>
    $(document).on('app:ready', function() {
        // Do Something

        // Verträge Klauseln Details
        var verkla_d = {

            init() {

                var me = this;

                // ID
                me.id = app.getUrlId();

                // Summernote
                me.initSummernote();

                // Form
                me.initForm();

                // Events
                me.addEventListener();


                // Wenn es eine ID gibt
                if (me.id) {

                    // Beide Card Ausblenden
                    $('#status-1, #status-2-0').hide();

                    // Holt die Daten der Form
                    me.loadForm();

                    // loadTimeline Alte Versionen
                    me.loadTimeline();

                    // Lädt alle Vertragsarten in den die Klausel vorkommt
                    me.klauselVerwendetIn()

                }

            },

            // Init Summernote
            initSummernote() {

                var me = this;

                // Summernote im Editieren Block
                $('textarea[name=text]').summernote({
                    height: 120,
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

            // init Form
            initForm() {

                var me = this;

                me.form = new Form('#vertraege-klauseln-form');
                me.form.initValidation();

            },

            // Events
            addEventListener() {

                var me = this;

                // *****************************************************************************
                // Standard Events
                // *****************************************************************************

                

                // *****************************************************************************
                // Form Handle Events
                // *****************************************************************************

                // Wenn die Klausel aktiviert werden soll
                me.form.container.on('click', '.btn-klausel-aktivieren', function() {
                    me.klauselAktivieren();
                });

                // Wenn die Klausel Entwurf gespeichert werden soll
                me.form.container.on('click', '.btn-entwurf-speichern', function() {
                    me.entwurfSpeichern();
                });

                // Wenn die Klauseln gelöscht werden soll
                me.form.container.on('click', '.btn-entwurf-loeschen', function() {
                    me.entwurfLoeschen();
                });

                // Wenn eine neue Version der Klausel erstellt werden soll
                me.form.container.on('click', '.btn-klausel-neue-version', function() {
                    me.klauselVersionNeu();
                });


            },

            // Klausel verwendet in
            klauselVerwendetIn() {

                var me = this;

                // AJax Abfrage
                app.simpleRequest("klauselVerwendetIn", "vertraege-handle", me.id, 
                
                    // Success
                    function(response) {
                        console.log(response);

                        // Wenn es Daten gibt die Größer als 0 sind
                        if(response.data.length > 0) {

                            // Schleife geht alle durch
                            $.each(response.data, function(key, value) {

                                // Fügt die Bezeichnung als Liste Hinzu
                                $('#verwendet-in ul').append('<h5><li>' + value['bezeichnung'] +'</li></h5>')

                            });

                        }

                        // Es wurde noch in keinem Vertrag genutz
                        else {

                            // Fügt die Bezeichnung als Liste Hinzu
                            $('#verwendet-in').append('<div class="alert alert-soft-warning"> Diese Klausel wurde bis jetzt in keinem Vertrag genutzt. </div>')

                        }

                    },

                    // Error
                    function(response) {
                        console.log(response);
                    },
                    
                );


            },

            // Timeline 
            loadTimeline() {

                var me = this;

                // TODO: Backend mit Req hinkriegen
                // Holt alle Versionen einer Klausel
                app.simpleRequest("loadTimeline", "vertraege-handle", me.id, 
                
                    function(response) {
                        console.log(response);

                        // Dom Element Leeren
                        $('#vertraege-klauseln-timeline').html("");

                        // Wenn es Klauseln gibt
                        if(response.data.length > 1) {

                            // leere Data Array
                            var dataSet = [];

                            // Schleife geht durch alle Element durch 
                            $.each(response.data, function(key, value) {

                                dataSet.push({
                                    'timestamp': value['timestamp'],
                                    'icon': 'fa fa-arrow-right',
                                    'precontent': "<i class='fa-solid fa-user'></i> Ersteller: " + value['mitarbeiterVorname']  + " " + value['mitarbeiterNachname'],
                                    'content': "Klausel: " + value['text'].replace(/(<([^>]+)>)/ig,""), // RegEx lösch alle HTML Tags
                                    'subcontent': "Version: " + value['version']
                                });


                            });


                            // Erstellen
                            var timeline = new Timeline('#vertraege-klauseln-timeline');

                            // Daten setzen
                            timeline.setData(dataSet);

                            // Write Data
                            timeline.render();

                        }

                        // Wenn es keine Klauseln gibt
                        else {

                            $('#vertraege-klauseln-timeline').html("<div class='alert alert-soft-warning'>Es sind noch keine alten Versionen vorhanden!</div>")


                        }

                    },

                    // Error
                    function(response) {
                        app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                    }
                     
                );

                

            },

            // Holt die Daten der Form
            loadForm() {

                var me = this;

                // Form Daten Laden
                me.form.load('load-klauseln', "vertraege-handle", me.id,

                    // Erfolgsmeldung
                    function(response) {

                        me.handleForm(response)

                        // Aktuelle Form Abspeichern
                        me.getDataForm = me.form.getData();

                    },

                    // Error
                    function(response) {

                    }

                )

            },

            // Bearbeiten der Form und Manipulieren
            handleForm(response) {

                var me = this;

                // 
                var status = "";

                // Icon 
                var icon = ""

                // Wenn der Status 1 -- also Entwurf ist
                if (response.data.status_id == '1') {
                    
                    // Status Anzeigen
                    $('#status-1').show();

                    // Ausblenden
                    $('#status-2-0').hide();

                    // Status ist Entwurf
                    status = " ein Entwurf";

                    // Icon ist Entwurf
                    icon = '<i class="fa-solid fa-edit"></i>';
                   
                }

                // Wenn der Status 2 -- aslo Aktiv ist
                else if (response.data.status_id == '2') {
                    $('#status-2-0').show();

                    // Status Anzeigen
                    $('#status-1').hide();


                    // Status ist Aktiv
                    status = " Aktiv";

                    // Icon ist Aktiv
                    icon = '<i class="fa-regular fa-hourglass"></i>',

                    // Alles auf Disabled/ Readonly setzen wenn der Status Aktiv ist
                    me.form.setReadonly(true)
                }

                // HTML DOM Elemente Leeren
                $('.status-header, .status-unorder-list').html("");

                // Klausel Status in Header setzen
                $('.status-header').html(icon + ' Klausel "' + response.data.vertragsgruppenParagraph + '" ist' + status)

                // Version reinsetzen
                $('.status-unorder-list').html('<li>Das ist die ' + response.data.version + '. Version der Klausel</li>')

            },


            // Entwurf der Klauseln Speichern
            entwurfSpeichern() {

                var me = this;

                // Save funktion Speichern der Daten
                me.form.save('klausel-submit', 'vertraege-handle', 
                        
                    // Success
                    function(response) {
        
                        // Erfolgsmeldung
                        app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
        
                        // Form Neuladen
                        me.loadForm();
                    },
        
                    // Error
                    function(response) {
        
                        // Meldung
                        app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
        
                    },
        
                    // Additional
                    {
                        id: me.id
                    }
        
                )

            },

            // Wenn der Entwurf gelöscht werden soll
            entwurfLoeschen() {

                var me = this;

                // Dialog ob Wirklich gelöscht werden will
                app.alert.question.fire("Entwurf Löschen?","Wollen Sie den Entwurf wirklich Löschen? Diesen Vorgang kann man nicht mehr Rückgängig machen.")
                    .then((result)  => {

                        // Wenn Bestäigt wird
                        if(result.isConfirmed) {

                            // Via Ajax die Form Abschicken und Entwurf Loeschen
                            app.simpleRequest("entwurfLoeschen", "vertraege-handle", me.id, 
                                
                                // Success
                                function(response) {

                                    // Erfolgsmeldung
                                    app.alert.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet").then(function () {
                                        app.redirect("vertraege-klauseln");
                                    });

                                },

                                // Error
                                function(response) {

                                    // Meldung
                                    app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

                                }
                            );
                        }

                });


                

            },

            // Wenn die Klausel aktiviert werden soll
            klauselAktivieren() {

                var me = this;

                var getData = me.form.getData();

                // Wenn Nicht geändert Wurde
                if(JSON.stringify(getData) == JSON.stringify(me.getDataForm)) {

                    // Dialog ob Wirklich gelöscht werden will
                    app.alert.question.fire("Klausel Aktivieren","Wollen Sie die Klausel auf Aktiv stellen? Danach können Sie die Klausel nicht mehr bearbeiten")
                        .then((result)  => {

                            // Wenn Bestäigt wird
                            if(result.isConfirmed) {

                                // via Ajax die Form abschicken und den Status auf 2 Setzen
                                app.simpleRequest("klauselAktivieren", "vertraege-handle", me.id, 
                                
                                    // Success
                                    function(response) {

                                        // Su
                                        app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                                        // Form Neuladen
                                        me.loadForm();

                                    },

                                    // Error
                                    function() {

                                        // Meldung
                                        app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                                    }
                                );
                            }
                    });

                // Meldung aufzeigen das etwas geändert wurde und die Form erst gespeichert werden muss
                } else {
                    app.notify.warning.fire("Änderung","Sie haben die Form verändert. Bitte speichern Sie zunächst den Entwurf bevor Sie fortfahren!");
                }

            },

            // Eine Neue Version der Klausel veröffentlichen
            klauselVersionNeu() {

                var me = this;

                // Dialog ob Wirklich gelöscht werden will
                app.alert.question.fire("Neue Version","Wollen Sie eine neue Version dieser Klausel veröffentlichen?")
                    .then((result)  => {
                        
                        // Wenn Bestäigt wird
                        if(result.isConfirmed) {

                        // Via Ajax verschicken und neue Version aktivieren
                        app.simpleRequest("klauselVersionNeu", "vertraege-handle", me.id, 
                        
                            // Success
                            function(response) {
                                console.log(response);

                                app.alert.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet").then(function () {
                                    app.redirect("vertraege-klauseln-details.php?id=" + response.data);
                                });

                            },

                            // Error 
                            function(response) {

                                // Meldung
                                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

                            }
                            
                        );

                    }

                });

            }

        }

        verkla_d.init();

    });
</script>

</html>