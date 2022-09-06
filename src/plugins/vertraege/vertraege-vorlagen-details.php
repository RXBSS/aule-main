<?php include('01_init.php');

$_page = [
    'title' => "Veträge Vorlage Details",
    'breadcrumbs' => ['Prozesse', '<a href="vertraege"> Verträge </a>', '<a href="vertraege-vorlagen"> Verträge Vorlagen</a>']
];

?>
<!doctype html>

<head>
    <?php include('02_header.php'); ?>

    <style>
    table.dataTable>tbody>tr.odd.selected p,
    table.dataTable>tbody>tr.even.selected p {
        color: white;
    }

    .dataTables_scrollBody.disabled {
        pointer-events: none;
    }
    </style>
</head>

<body>
    <?php include('03_navigation.php'); ?>
    <div class="wrapper">
        <div class="container-fluid">


            <form id="vertraege-vorlagen-form">

                <div class="row">

                    <!-- ***************************************************************** -->
                    <!-- Stammdaten Verträge -->
                    <!-- ***************************************************************** -->
                    <div class="col-lg-6">


                        <!-- ********************************************************* -->
                        <!-- Vertrag Stammdaten -->
                        <div class="row">
                            <div class="col">
                                <div class="card" id="vertrag-stammdaten">
                                    <div class="card-body">

                                        <div class="actions">
                                            <a class="action-item btn-show-document" href="javascript:void(0);"
                                                data-document="vtv" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Vorschau Erstellen"><i class="fa-solid fa-file-pdf"></i></a>
                                        </div>

                                        <h4 class="card-title"><i class="fa-solid fa-file-signature"></i> Vetrag
                                            Stammdaten</h4>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group form-floating">
                                                    <input type="text" name="bezeichnung" class="form-control editable"
                                                        placeholder="Bezeichnung" autocomplete="nope">
                                                    <label>Bezeichnung</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group form-floating">
                                                    <textarea class="form-control editable" name="beschreibung"
                                                        placeholder="Beschreibung"></textarea>
                                                    <label>Beschreibung</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <?php include("./vertraege-laufzeiten.php") ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- **************************************************************** -->
                        <!-- Vertrags Klauseln Vorlagen Pickliste -->
                        <!-- ***************************************************************** -->
                        <div class="row">
                            <div class="col">

                                <div class="card" id="card-vorlagen-pickliste">
                                    <div class="card-body">
                                        <div id="vorlagen-klausen-pickliste"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ***************************************************************** -->
                    <!-- Vorschau PDF -->
                    <!-- ***************************************************************** -->
                    <div class="col-lg-6">

                        <div class="row">
                            <div class="col-lg-12">

                                <!-- ************************************************* -->
                                <!-- Vertrag Vorlagen Status -->
                                <!-- ************************************************* -->

                                <!-- Status 1 - Entwurf -->
                                <div id="status-1" class="alert alert-soft-warning detail-status" data-status="1">
                                    <div class="detail-status-inner">
                                        <div class="d-flex h-100 flex-column justify-content-between">
                                            <div>
                                                <h4 class="alert-header status-header"> </h4>
                                                <ul class="status-unorder-list">

                                                </ul>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-dark btn-vertrag-aktiviern"><i
                                                        class="fa-solid fa-check"></i> Vertrag aktiviern</button>
                                                <button type="button" class="btn btn-dark btn-entwurf-speichern"><i
                                                        class="fa-solid fa-save"></i> Entwurf speichern</button>
                                                <button type="button" class="btn btn-danger btn-entwurf-loeschen"><i
                                                        class="fa-solid fa-trash"></i> Entwurf löschen</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Status 2 - Aktiver Vertrag -->
                                <div id="status-2-0" class="alert alert-soft-secondary detail-status" data-status="2"
                                    data-substatus="0">
                                    <div class="detail-status-inner">
                                        <div class="d-flex h-100 flex-column justify-content-between">
                                            <div>
                                                <h4 class="alert-header status-header"> </h4>

                                                <!-- <a href=""><i class="fa-solid fa-file-pdf"></i> Auftragsbestätigung</a> - 26.01.2022<br> -->

                                            </div>
                                            <div>
                                                <button class="btn btn-primary btn-vertrag-neue-version"
                                                    type="button"><i class="fa-solid fa-code-branch"></i> Neue
                                                    Version</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">

                                <div class="card" id="card-klauseln">
                                    <div class="card-body">

                                        <!-- ********************************************************************** -->
                                        <!-- Paragraphen und Klauseln -->
                                        <!-- ********************************************************************** -->
                                        <div class="row">
                                            <div id="paragraphen-klauseln"></div>
                                        </div>

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

<script src="../js/pagelevel/vetraege-laufzeiten.js"></script>
<script src="../js/pagelevel/vertraege-laufzeiten-validierung.js"></script>
<?php include('04_scripts.php'); ?>
<script>




$(document).on('app:ready', function() {


    var vervor_d = {


        init() {

            var me = this;

            // Url ID
            me.id = app.getUrlId();

            // Init der Vorlagen
            me.fields = me.initLaufzeitValidierung();

            // Init der Form
            me.initForm();

            //   init Pickliste
            me.initPickliste()

            // Laufzeiten nur Vorlagen Init
            me.initVorlagen();

            // Wenn es eine ID gibt
            if (me.id) {

                // Erstmal beide Ausblenden
                $('#status-1, #status-2-0').hide();

                // Holt die Daten der Form
                me.loadForm();

                new CardSizer(['#status-1', '#vertrag-stammdaten', '#status-2-0']);
                new CardSizer(['#card-vorlagen-pickliste', '#card-klauseln']);



            }

            // Actitavtion Checkboxen
            me.initActivation();

            // Events
            me.addEventListener();

        },

        // Init Aktivation Checkboxen
        initActivation() {

            var me = this;

            // ************************************************************
            // Kündigungsfrist Aktivation
            // ************************************************************
            me.kuendigungsfrist = new ActivationCheckbox('#kuendigungsfrist',
                [{
                        el: '.kuendigungsfrist-body'
                    },
                    {
                        el: '.kuendigungsfrist-body'
                    }
                ], me.form);

            // ************************************************************
            // Verlängerung Aktivation
            // ************************************************************
            me.verlaengerung = new ActivationCheckbox('#verlaengerung',
                [{
                        el: '.verlaengerung-body'
                    },
                    {
                        el: '.verlaengerung-body'
                    },
                    {
                        el: '#kuendigung_frist',
                        child: me.kuendigungsfrist
                    }
                ], me.form);


            // // ************************************************************
            // // Laufzeit Aktivation
            // // ************************************************************
            me.laufzeit = new ActivationCheckbox('#laufzeit',
                [{
                        el: '.laufzeit-body'
                    },
                    {
                        el: '.laufzeit-body'
                    },
                    {
                        el: '#verlaengerung_kuendigung_ebene',
                        child: me.verlaengerung
                    }
                ], me.form);

        },

        // Init der Klauseln Pickliste
        initPickliste() {

            var me = this;

            // Vorlagen Pickliste der Klausen
            me.list = new Picklist('#vorlagen-klausen-pickliste', 'vertraege_klauseln_vorlagen', {
                type: "multi-picklist",
                autoDeselect: false,
                pagination: false,
                card: false,
                addButtons: [{
                        action: "add",
                        class: "add",
                        icon: "fa-solid fa-plus",
                        id: "add",
                        tooltip: "Gruppen Hinzufügen",
                        pos: 2
                    },
                    {
                        action: "btn-klausel-delete",
                        class: "btn-klausel-delete",
                        icon: "fa-solid fa-trash",
                        tooltip: "Löschen Klausel",
                        show: 'onSelected',
                        pos: 3
                    }
                ],
                data: me.id
            });

            // Klauseln Hinzufügen
            me.paragraphenList = new PicklistModal('vertraege_klauseln', {
                type: "multi-picklist",
                config: {
                    file: 'config-overwrite.json',
                },
                autoDeselect: false,
                disabled: {
                    query: {
                        table: 'vertraege_klauseln_vorlagen',
                        field: 'klausel_id',
                        filter: {
                            vorlagen_id: me.id
                        }
                    },
                    icon: '<i class="fa-solid fa-check-double text-primary"></i>'
                },
                data: 'only_aktiv'
            });

        },

        // init der Form
        initForm() {

            var me = this;

            me.form = new Form('#vertraege-vorlagen-form');

            me.form.initValidation(me.fields);

        },

        // Holt die Daten der Form
        loadForm() {

            var me = this;

            // Load Stammdaten
            me.form.load('load-vorlagen-details', 'vertraege-handle', me.id,
                // Success
                function(response) {
                    // $('.vertragsart').html(response.data.bezeichnung);

                    me.handleForm(response)

                    // Aktuelle Form Abspeichern
                    me.getDataForm = me.form.getData();

                }

            )

        },


        // Form Bearbeiten und Manipulieren
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
                me.list.setReadonly(true);

                //
                me.form.container.find('input').attr('disabled', true);

                // Liste Icons auch auf ReadOnly setzen
                me.list.container.find('.dataTables__top').css('pointer-events', 'none');

            }

            // HTML DOM Elemente Leeren
            $('.status-header, .status-unorder-list').html("");

            // Klausel Status in Header setzen
            $('.status-header').html(icon + ' Vorlage "' + response.data.bezeichnung + '" ist' + status)

            // Version reinsetzen
            $('.status-unorder-list').html('<li>Das ist die ' + response.data.version +
                '. Version des Vertrages</li>')

            // var activationValue = {
            //     'laufzeit-trigger': [response.data.laufzeit, 'laufzeit-body'],
            //     'verlaengerung-trigger': [response.data.verlaengerung_laufzeit, 'verlaengerung-body'],
            //     'kuendigungsfrist-trigger': [response.data.kuendigungsfrist_laufzeit, 'kuendigungsfrist-body', ]
            // };

            // // Schleife geht durch das Objekt durch
            // $.each(activationValue, function(key, value) {

            //     // Wenn das Input oder der Select einen Wert hat -> dann soll die Checkbox gesetzt sein
            //     if (value[0]) {

            //         // Setzt den Inhalt auf True damit er Angezeigt wird
            //         me.form.setData({
            //             key: true
            //         });

            //         // Setzt das Feld Auf True -- Key
            //         me.form.setFieldData(key, true);

            //     } else {

            //         me.form.setFieldData(key, false);

            //         me.form.setData({
            //             key: false
            //         });

            //     }
            // });

            // var activationValue = {
            //     'laufzeit-trigger': [response.data.laufzeit, 'laufzeit-body'],
            //     'verlaengerung-trigger': [response.data.verlaengerung_laufzeit, 'verlaengerung-body'],
            //     'kuendigungsfrist-trigger': [response.data.kuendigungsfrist_laufzeit, 'kuendigungsfrist-body', ]
            // };


            // Wenn die Werte vorhanden sind dann Activation Aktivieren
            if (response.data.laufzeit != null) {
                me.form.setData({
                    'laufzeit-trigger': true
                });
            }
            if (response.data.verlaengerung_laufzeit != null) {
                me.form.setData({
                    'verlaengerung-trigger': true
                });
            }
            if (response.data.kuendigungsfrist_laufzeit != null) {
                me.form.setData({
                    'kuendigungsfrist-trigger': true
                });
            }



        },


        // Add EventListener
        addEventListener() {

            var me = this;


            // *********************************************************************
            // Form Handler Events
            // *********************************************************************

            // Abschicken der Stammdaten Form
            // me.form.on('submit', function() {
            //     me.submitVorlagenStammdaten();
            // });

            // Wenn die Pickliste fertig geladen ist
            me.list.on('initComplete', function(el, data) {
                me.loadKlauselnWithGroups();
            });

            // Wenn Die Liste fertig geladen ist -- Wählt alle Felder der Liste aus
            // me.list.on('loading', function(el, data) {
            //     // me.selectAllList();
            // });

            // Wenn ADD button in der Pickliste gedrückt wird
            me.list.container.on('click', '.dt-action[data-action="add"]', function() {
                me.paragraphenList.open();
            });

            // Wenn neue Paragraphen hinzugefügt werden sollen
            me.paragraphenList.on('pick', function(el, data) {
                me.vorlagenSubmit(data);
            });

            // Wenn ein Anwahl getroffen wird
            me.list.on('selection', function(key, value) {
                me.markKlausel(value);
            });

            // Wenn Delete Funktion ausgeführt wird
            me.list.container.on('click', '.btn-klausel-delete', function() {
                me.deleteKlausel();
            });


            // Wenn die Klausel aktiviert werden soll
            me.form.container.on('click', '.btn-vertrag-aktiviern', function() {
                me.vorlageAktivieren();
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
            me.form.container.on('click', '.btn-vertrag-neue-version', function() {
                me.vertragVorlagenVersionNeu();
            });

        },

        // Vertrags eine neue Version mit Entwurf erstellen
        vertragVorlagenVersionNeu() {

            var me = this;

            // Dialog ob Wirklich gelöscht werden will
            app.alert.question.fire("Neue Version",
                    "Wollen Sie eine neue Version dieses Vertrages veröffentlichen?")
                .then((result) => {

                    // Wenn Bestäigt wird
                    if (result.isConfirmed) {

                        // Via Ajax verschicken und neue Version aktivieren
                        app.simpleRequest("vertragVorlagenVersionNeu", "vertraege-handle", me
                            .id,

                            // Success
                            function(response) {
                                console.log(response);

                                app.alert.success.fire("Erfolgreich",
                                    "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet"
                                ).then(function() {
                                    app.redirect(
                                        "vertraege-vorlagen-details.php?id=" +
                                        response.data);
                                });

                            },

                            // Error 
                            function(response) {

                                // Meldung
                                app.notify.error.fire("Fehler",
                                    "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!"
                                );

                            }

                        );

                    }

                });

        },

        // Wenn der Vertrag Aktiviert werden sol
        vorlageAktivieren() {

            var me = this;

            var getData = me.form.getData();

            // Wenn Nicht geändert Wurde
            if (JSON.stringify(getData) == JSON.stringify(me.getDataForm)) {

                // Dialog ob Wirklich gelöscht werden will
                app.alert.question.fire("Vertrag Aktivieren",
                        "Wollen Sie den Vertrag auf Aktiv stellen? Danach können Sie den Vertrag nicht mehr bearbeiten"
                    )
                    .then((result) => {

                        // Wenn Bestäigt wird
                        if (result.isConfirmed) {

                            // via Ajax die Form abschicken und den Status auf 2 Setzen
                            app.simpleRequest("vorlageAktivieren", "vertraege-handle", me.id,

                                // Success
                                function(response) {

                                    // Su
                                    app.notify.success.fire("Erfolgreich",
                                        "Ihre Aktion wurde erfolgreich angepasst");

                                    // Form Neuladen
                                    me.loadForm();

                                },

                                // Error
                                function() {
                                    // Meldung
                                    app.notify.error.fire("Fehler",
                                        "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!"
                                    );
                                }
                            );
                        }
                    });

                // Meldung aufzeigen das etwas geändert wurde und die Form erst gespeichert werden muss
            } else {
                app.notify.warning.fire("Änderung",
                    "Sie haben die Form verändert. Bitte speichern Sie zunächst den Entwurf bevor Sie fortfahren!"
                );
            }

        },

        // Wenn Der Entwurf gelöscht werden soll
        entwurfLoeschen() {

            var me = this;

            // Dialog ob Wirklich gelöscht werden will
            app.alert.question.fire("Entwurf Löschen?",
                    "Wollen Sie den Entwurf wirklich Löschen? Diesen Vorgang kann man nicht mehr Rückgängig machen."
                )
                .then((result) => {

                    // Wenn Bestäigt wird
                    if (result.isConfirmed) {

                        // Via Ajax die Form Abschicken und Entwurf Loeschen
                        app.simpleRequest("entwurfLoeschenVorlage", "vertraege-handle", me.id,

                            // Success
                            function(response) {

                                // Erfolgsmeldung
                                app.alert.success.fire("Erfolgreich",
                                    "Ihre Aktion wurde erfolgreich angepasst. Sie werden weitergeleitet"
                                ).then(function() {
                                    app.redirect("vertraege-vorlagen");
                                });

                            },

                            // Error
                            function(response) {

                                // Meldung
                                app.notify.error.fire("Fehler",
                                    "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!"
                                );

                            }
                        );
                    }

                });


        },

        // Wenn der entwurf gepseichert werden soll
        entwurfSpeichern() {

            var me = this;

            me.form.fvInstanz.validate().then(function(status) {
                if (status == 'Valid') {

                    // Ajax Save Funktion 
                    me.form.save('submitVorlagen', 'vertraege-handle',

                        // Success
                        function(response) {

                            //
                            app.notify.success.fire("Erfolgreich",
                                "Ihre Aktion wurde erfolgreich angepasst");

                            // Form Neuladen
                            me.loadForm();

                        },

                        // Error
                        false,

                        {
                            id: me.id
                        }
                    )
                }
            });

        },

        // Klausel als gelöscht Markieren
        deleteKlausel() {

            var me = this;

            // Wenn es eine Auswahl gibt
            if (me.list.getSelectedLength() > 0) {

                // Abfrage was alles gemacht werden soll
                app.alert.question.fire('Wollen Sie wirklich löschen?',
                        'Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                    .then((result) => {

                        // Wenn der Nutzer zustimmt
                        if (result.value) {

                            // Alle angewählten Ids auslesen
                            var ids = me.list.getSelectedColumn(1);

                            // Simple Request
                            app.simpleRequest('deleteKlausel', 'vertraege-handle', ids,
                                function() {

                                    // PickListe wird automatisch neu geladen
                                    me.list.refresh(true);

                                    // ParagraphenListe auch neu Laden
                                    me.paragraphenList.refresh(true);

                                    // PDF Neu Laden
                                    me.loadKlauselnWithGroups();

                                    app.notify.success.fire("Erfolgreich",
                                        "Ihre Aktion wurde erfolgreich angepasst");
                                });
                        }
                    });

            } else {
                app.notify.error.fire("Auswahl Treffen", "Es wurden keine Auswahl getroffen");
            }

        },

        // Submit der Stammdaten
        submitVorlagenStammdaten() {

            var me = this;

            // Ajax Save Funktion 
            me.form.save('submitVorlagenStammdaten', 'vertraege-handle',

                // Success
                function(response) {

                    //
                    app.notify.success.fire("Erfolgreich",
                        "Ihre Aktion wurde erfolgreich angepasst");
                },

                // Error
                function(response) {
                    app.notify.error.fire("Fehler",
                        "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!"
                    );
                },

                {
                    id: me.id
                }

            )

        },

        // Paragraphen zu der Vorlage hinzufügen
        vorlagenSubmit(data) {

            var me = this;

            // Daten die mitgehen
            var additional = {
                'data': data,
                'id': me.id
            }

            // mit Ajax Formular abschicken
            app.simpleRequest("vorlagen-submit", "vertraege-handle", additional,

                // Success
                function(response) {

                    // Liste Neu Laden
                    me.list.refresh(true);

                    me.paragraphenList.refresh(true);

                    app.notify.success.fire("Erfolgreich",
                        "Ihre Aktion wurde erfolgreich angepasst");

                    // PDF Neu Laden
                    me.loadKlauselnWithGroups();
                },

                // Error
                function() {
                    app.notify.error.fire("Fehler",
                        "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!"
                    );
                }

            );


        },

        // Wenn eine Auswahl getroffen wurde soll dieser angemarkt werden
        markKlausel(data) {

            var me = this;

            // Alle li erstmal Normalisieren
            $('#paragraphen-klauseln').find('li').css('font-weight', 'normal')

            // Schleife geht durch die Values der Pickliste Selection 
            $.each(data, function(key, value) {

                // Alle ausgewählten Klauseln bekommen bold Style
                $('#paragraphen-klauseln').find('li[data-klausel="' + value[4] + '"]').css(
                    'font-weight', 'bold')

            });

        },

        // Lädt alle Klauseln mit den dazugehörigen Gruppen
        loadKlauselnWithGroups() {

            var me = this;

            // Ajax
            app.simpleRequest("loadKlauselnWithGroupsVorlagen", "vertraege-handle", me.id,

                function(response) {

                    console.log("ERFOLG");

                    // DOM Element Erstmal leeren
                    $('#paragraphen-klauseln').html("");

                    $('#paragraphen-klauseln').append(response.data);

                }
            );

        },


        // Wenn ein Paragraph zu der Vorlage hinzugefügt wird
        loadVorlagePDF() {

            var me = this;

            // Später soll in den Klauseln geguckt werden

            /**
             * z.B. 
             * Vertragsart: Mietvertrag - ID 4
             * Paragaph: Inhalte der War. - ID 6
             * Wenn in Klauseln DB =  ID 4 und ID 6 ist dann soll in dem PDF der gesonderte TEXT stehen
             * 
             */


            // Wenn das Objekt nicht leer ist
            if (me.id > 0) {

                // Daten die mitgegeben werden zum auslesen
                var additional = {
                    vertraegeart_id: me.id,
                    // vertraegeVorlage: me.list.getSelectedColumn(1)
                }

                // Ajax Abfrage über die Vertragsart_id (me.id) und Vertragsgruppen_id (in data) in der Klauseln DB
                app.simpleRequest("getKlauseln", "vertraege-handle", me.id,

                    // Success
                    function(response) {

                        // Wenn eine Rückgabe zurück kommen
                        if (response.data.length) {

                            // HTML DOM erstmal Löschen
                            $('#paragraphen-klauseln').html("");

                            // // Leere Gruppen Objekt
                            var gruppen = {}

                            var count = 1;

                            // Geht Die Schleife durch alle Objekte Durch
                            $.each(response.data, function(el, value) {

                                // Wenn das Element größer als 1 ist -- weil 1 - 1 = 0 und Position 0 gibt es nicht (Fehlermeldung sonst)
                                if (el >= 1) {

                                    // Wenn das Objekt an der Aktuellen Stelle die selbe Gruppe ist wie der vorgänger
                                    if (value['bezeichnung'] == response.data[el - 1][
                                            'bezeichnung'
                                        ]) {

                                    }

                                    // Ansonten schreibe es in ein Neues Objekt
                                    else {
                                        gruppen[el] = value['bezeichnung'].replace(/ /g,
                                            "_").replace(",", "").toLowerCase();
                                        // 
                                        $('#paragraphen-klauseln').append(
                                            "<div class='" + value['bezeichnung']
                                            .replace(/ /g, "-").replace(",", "")
                                            .toLowerCase() + "'> <b> § " + count +
                                            " " + value['bezeichnung'] +
                                            " </b> <ul class='unorder-list'></ul> </div>"
                                        )

                                        // Counter Hochzählen
                                        count++;
                                    }

                                }

                                // Für alle Werte die Kleiner als 1 sind
                                else {
                                    gruppen[el] = value['bezeichnung'].replace(/ /g, "_")
                                        .replace(",", "").toLowerCase();

                                    // 
                                    $('#paragraphen-klauseln').append("<div class='" +
                                        value['bezeichnung'].replace(/ /g, "-")
                                        .replace(",", "").toLowerCase() +
                                        "'> <b> § " + count + " " + value[
                                            'bezeichnung'] +
                                        " </b> <ul class='unorder-list'></ul> </div>"
                                    )

                                    // Counter Hochzählen
                                    count++;
                                }

                            });

                            // Vertrage Klausel GRUPPEN
                            var myValues = {
                                ausnahmen_der_wartung: "Ausnahmen der Wartung",
                                gerichtsstand: "Gerichtsstand",
                                inhalte_der_mietpauschale: "Inhalte der Mietpauschale",
                                inhalte_der_wartung: "Inhalte der Wartung",
                                pflichten_des_kunden: "Pflichten des Kunden",
                                sichere_außerbetriebnahme_von_druckern_kopierern_und_multifunktionsgeräte: "Sichere Außerbetriebnahme von Druckern, Kopierern und Multifunktionsgeräte",
                                sondervereinbarungen: "Sondervereinbarungen",
                                zahlungsverzug: "Zahlungsverzug",
                            }

                            // Schleife geht durch alle Daten durch
                            $.each(response.data, function(key, value) {

                                // Sucht die Paragraphen aus den MyValues
                                if (myValues[value['paragbezeichnungraph'].replace(/ /g, "_")
                                        .replace(",", "").toLowerCase()]) {

                                    // Sucht das DOM Element und fügt den Text der Unordered list hinzu
                                    $('#paragraphen-klauseln').find("div." + value[
                                            'bezeichnung'].replace(/ /g, "-").replace(
                                            ",", "").toLowerCase() +
                                        " .unorder-list").append(
                                        "<li data-klausel='" + value[
                                            'klausel_id'] + "'>" + value[
                                            'text'] + "</li>")

                                }

                            });

                        }

                    },

                    // Error
                    function(response) {

                        // Wenn es keine Daten gibt
                        // if(!response.data[0]) {

                        //     app.notify.info.fire("Info","Für die ausgewählte Gruppe, wurde im Vertrag, noch keine Klausel angelegt!");

                        // // Keine Auswahl
                        // } else {
                        app.notify.warning.fire("Warnung", "Es wurde keine Auswahl getroffen!");
                        // }


                    }

                );

                // Keine Auswahl getroffen
            } else {

                // HTML DOM erstmal Löschen
                $('#paragraphen-klauseln').html("");

                app.notify.warning.fire("Warnung", "Es wurde keine Auswahl getroffen!");

            }

        }

    }

    vervor_d = Object.assign(l_validierung, vervor_d);
    vervor_d = Object.assign(detailHelper, vervor_d);
    vervor_d = Object.assign(v_laufzeiten, vervor_d);

    vervor_d.init();

});
</script>

</html>