
// Alle Funktion die in der Veträge Klausern gebraucht werden
var verkla = {

    init() {

        var me = this;

        // Editiren Global
        me.edit = false;

        // Standardmäßig Hide
        $('.card-form').hide();

        // Init Pickliste
        me.initPickliste();

        // init Form
        me.initForm();

        // Filter Pickliste 
        // me.initFilter();

        // init Summernote
        me.initSummernote();

        me.addEventListener();

    },

    // Init Pickliste
    initPickliste() {

        var me = this;

        // 
        me.list = new Picklist('#vertraege-klauseln-pickliste', 'vertraege_klauseln', {
            type: 'single-picklist',
            select: "multi",
            addButtons: [
                {
                    action: "btn-klausel-delete",             
                    class: "btn-klausel-delete",
                    icon: "fa-solid fa-trash",           
                    tooltip: "Löschen Klausel",     
                    show: 'onSelected',
                    pos: 3                         
                }
            ]
        });

         // Wenn vollständig initalisiert ist
         me.list.on('initComplete', function () {
            // Handle Funktionen die zum Start geladen werden sollen
            // me.handlePositionSelection();

            // me.initFilter();
        });

        // Selection
        me.list.on('selection', function () {
            me.handlePositionSelection();
        });

    },

    // Init Form
    initForm() {

        var me = this;

        // Form zum Editieren der Klauseln
        me.form = new CardForm('#vertraege-klauseln-form');
        me.form.initValidation();


        // Filter Form für die Vertragsgruppen
        me.filterForm = new Form('#filterForm');

    },

    // 
    initSummernote() {

        var me = this;

        // Summernote im Editieren Block
        $('textarea[name=text]').summernote({
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

    },

    // TODO: MULTI SELECT ?????????????
    // Filter der Pickliste
    setFilter() {

        var me = this;

        // Init CompleteFilter
        var completeFilter = [];


        // Get Data from Form
        var formData = me.filterForm.getData();

        // ***************************************************************
        // FILTER 1  - Verträgegruppen
        // ***************************************************************

        // Nur wenn Select nicht leer ist
        if(formData['vertraegegruppen']['value']) {

            // Filter Setzen -- Verträgegruppen Filter
            vertraegegruppen = new PickFilter(2, formData['vertraegegruppen']['text'], "=");

            // Pusht in den CompleteFilter den Filter vertraegegruppen
            completeFilter.push(vertraegegruppen);

        }


        // ***************************************************************
        // FILTER 2  - Version
        // ***************************************************************

        if(formData['version']['value']) {

            // Filter Setzen -- Version Filter
            version = new PickFilter(5, formData['version']['value'], '=');

            // Pusht in den CompleteFilter den Filter version
            completeFilter.push(version);

        }

        // ***************************************************************
        // ZUSAMMENBAUEN
        // ***************************************************************

        // Wenn der CompletFilter nicht leer ist
        if (completeFilter.length > 0) {

            // Erstellt Filter mit Complete FIlter
            completeFilter = new PickFilter(completeFilter);

            // Filter setzen
            me.list.setFilter(completeFilter);

        // Wenn der CompleteFilter leer ist - Filter ZURÜCKSETZEN
        } else {
            me.list.resetFilter();
        }



    },

    
    handlePositionSelection() {

        var me = this;

        var id = me.list.getSelectedSingle()[1];

        // Wenn es eine ID gibt
        if(id > 0) {

            // Karte wieder anzeigen
            $('.card-form').show();

            // Versionen Editierbar machen
            $('input[name="version"]').removeClass('editable').attr('disabled', true);

            // Ajax Befehl die Daten holen
            me.form.load("load-klauseln", "vertraege-handle", id, 

                // Success
                function(response) {
                    // console.log(response);

                    // Form direkt Bearbeitbar
                    me.form.enable();

                    // Klausel anzeigen
                    $('.col-version').show();

                    // Editieren ist True
                    me.edit = true;


                    // Vertragsart und Paragraph sollen beim Editieren nicht Bearbeitbar sein
                    // $('select[name="vertraegegruppen_id"], select[name="vertraegeart_id"]').removeClass('editable').attr('disabled', true);


                    // TODO: Muss raus macht so kein Sinn
                    // $('input[name="paragraph"]').val(response.data.paragraph)
                    // $('input[name="titel"]').val(response.data.titel)
                    // $('input[name="version"]').val(response.data.version)
                    // $('input[name="gruppierung"]').val(response.data.gruppierung)
                    // $('textarea[name="text"]').summernote("code", response.data.text)
                }
                
            );

        } else {

            // Karte wieder anzeigen
            $('.card-form').hide();

        }


    },

    // AddEventlistener
    addEventListener() {


        var me = this; 


        // ******************************************************
        // Standard Events
        // ******************************************************

        $('.btn-vertraege-klauseln-add').on('click', function() {
            me.neueKlausel();
        });

        // Wenn beim Select (Veträgegruppen und Version) eine Auswahl getroffen wurde
        $('select[name="vertraegegruppen"], select[name="version"]').on('change', function() {
            me.setFilter();
        });

        // Zurücksetzen des Filters
        $('.deleteFilterIcon').on('click', function() {
        
            // me.filterForm.reset(1);
            
            // me.list.resetFilter();
        });


        // Zurücksetzen der Filter (Verträgegruppen und Vesion)
        $('#version_reset, #vertraegegruppen_reset').on('click', function() {
            $('select[name="' + $(this).data('select') + '"]').val(null).trigger('change');
        }); 


        // ******************************************************
        // Form Handler Events
        // ******************************************************

        // Wenn die Form abgeschickt wird
        me.form.on('submit', function() {
            me.submit();
        });

        // Wenn die Form Aktiviert wird 
        me.form.on('enable', function() {
        });

        // Wenn die Form abgebrochen werden soll 
        me.form.on('end', function() {
            $('.card-form').hide(); // Form Ausblenden
            me.form.reset(1); // Forn zurücksetzen
            me.list.refresh(true); // liste Neuladen
        });

        // Wenn eine Klausel Gelöscht werden soll
        me.list.container.on('click', '.btn-klausel-delete', function() {
            new simpleDeleteTask(me.list, 'deleteKlausel', 'vertraege-handle');
        });


    },

    // Save Funktion -- Weil Mehrfach genutzt
    submitSave() {

        var me = this;

        // Save funktion Speichern der Daten
        me.form.save('klausel-submit', 'vertraege-handle', 
                        
            // Success
            function(response) {

                // Liste Neu Laden 
                me.list.refresh();

                // Card Hide
                $('.card-form').hide();

                // Callback Zurück schicken 
                // callback(response);

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

            },

            // Error
            function(response) {

                // Meldung
                var fehlerMeldung = ""

                // Wenn eine Fehlermeldung aus der API kommtm
                if(response.error) {
                    fehlerMeldung = response.error;
                }

                // Stanard Fehlermeldung
                else {

                    fehlerMeldung = "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!";

                }

                app.notify.error.fire("Fehler", fehlerMeldung);

            },

            // Additional
            {
                id: me.list.getSelectedSingle()[1]
            }

        )


    },

    // Formular Klausel abschicken
    submit() {

        var me = this;

        // Wenn Editieren ist True
        if(me.edit) {

            // Dialog
            app.alert.question.fire("Version","Wenn Sie die Form Senden wird eine neue Version dieser Klausel erstellt!")
                .then((result) => {

                    // Wenn gesendet werden soll dann abschicken ansonsten passiert nichts
                    if(result.isConfirmed) {

                        // Save
                        me.submitSave();

                    }

                });

        } else {

            // Save
            me.submitSave();

        }

        

    },


    // Funktion die neue Klausel hinzufügt und Standardeinstellungen trifft bevor die Card geöffnet wird
    neueKlausel() {

        var me = this;

        // 
        me.list.refresh(true);

        // Timeout 1 Sekunde
        setTimeout(() => {
            
            // Card anzeigen
            $('.card-form').show();

            // Versionen Editierbar machen
            $('input[name="version"]').addClass('editable').removeAttr('disabled');

            // Klausel verschwindet
            $('.col-version').hide();

            // Editieren ist False
            me.edit = false;

            // 
            $('select[name="gruppen_id"], select[name="vertraegeart_id"]').addClass('editable').removeAttr('disabled');

            // Enable Form
            me.form.enable();

            // Card zurücksetuen
            me.form.reset(1);

            // Auswahl in Pargapah
            me.form.container.find('input[name=bezeichnung]').focus();

        }, 50);

       
    },

    // Zählt alle Klauseln
    countKlausel(callback) {

        var me = this;

        // Count der Einträge
        app.simpleRequest("countKlausel", "vertraege-handle", false, 
                                
            function(response) {
                callback(response);
            }
            
        );

    }

}