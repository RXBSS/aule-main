/**
 * Alle Funktionen die für die Tickets Seite Details geladen werden müssen
 */

var ticket_details = {


    init() {

        var me = this;

        // Aktive ID aus der URL
        me.id = app.getUrlId();

        // Hide Standardmäßg die Karte
        $('.card-timeline-eintrag').hide();

        // Init Form
        me.initForm();

        // Init Pickliste
        me.initPickliste();

        // Init Modal Dokument
        me.initModalForm();

        // Lädt die Kontakte/ Personen zum Ticket
        me.loadPersonen();

        // lädt die Timeline bei init
        me.loadTimeline();

        // Init Summernote
        me.initSummernote();

        // Add Eventlistener beim Init
        me.addEventListener();

    },

    // Modal Form
    initModalForm() {

        var me = this;

        // Modal zum hinzufügen von Dokumenten
        me.modalFile = new ModalForm('#ticket-neues-dokument');
        me.modalFile.initValidation();

    },

    // Initialisiert die Form beim Laden
    initForm() {

        var me = this;

        // Ticket Informationen Form
        me.form = new CardForm('#form-ticket-infos');
        me.form.initValidation(); 


        // Neuer Eintrage Erfassen Timeline Form
        me.timelineForm = new Form('#timeline-eintrag-form');
        me.timelineForm.initValidation();

    },
    
    // Pickliste die auf der Details Seite geladen werden
    initPickliste() {

        var me = this; 

        me.kontakteList = new PicklistModal('kontakte', {
            type: "multi-picklist",
            autoDeselect: false 
        });

    },


    // Summernote Initialisieren
    initSummernote() {

        var me = this;

        $('.summernote').summernote({
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

    // Alle Events hier rein
    addEventListener() {

        var me = this;

        // Normale Events
        // **********************************************************

        // Open Picklise Modal
        $('#add-ticket-kontakte').on('click', function() {
            me.kontakteList.open();
        });

        // Wenn die Service Planung geklickt wird
        $('#service-planung-ticket').on('click', function() {

            app.notify.info.fire("Wird noch Progammiert","");

        });

        // Neue Dateien hinzufügen
        $('#add-file-ticket').on('click', function() {
            app.notify.info.fire("Wird noch Progammiert","");

            // me.modalFile.open();
        });

        // Wenn ein neuer Timeine Eintrag erstellt werden soll
        $('.neue-antwort').on('click', function() {

            // Card Anzeigen
            $('.card-timeline-eintrag').show();

            // Controller Ausblenden
            $('#controller').hide();
        });




        // Form Handler Events
        // **********************************************************
        
        // Laden der Informationen der Tickets
        me.form.load('loadForm', 'tickets-handle', me.id, 
        
            // Success
            function(response) {

                // Lädt die Form und fügt die nötigen Daten hinzu
                me.loadForm(response);

            }
        );

        // Wenn ein neuer Kontakt zum Ticket hinzugefügt werden soll
        me.kontakteList.on('pick', function(el, data) {
            me.submitKontakteTicket(el, data);
        });

        // Summernote Formular wird abgesendent
        me.timelineForm.on('submit', function() {
            me.submitTimeline();
        });

        // Wenn der Eintrag doch nicht erstellt weredn soll ---- Abbruch
        me.timelineForm.container.on('click', '.abbruch-eintrag', function() {

            // Card Ausblenden
            $('.card-timeline-eintrag').hide();

            // Controller Anzeigen
            $('#controller').show();
        })

        // Abschicken des Formulares hinzufügen von Dateien an das Ticket
        // me.modalFile.on('submit', function() {
        //     me.submitTicketFile();
        // });

    },

    // Lädt die Timeline und alle dazugehörigen Daten
    loadTimeline() {

        var me = this;

        // Ajax
        app.simpleRequest("loadTimeline", "tickets-handle", me.id, 
        
            // Success
            function(response) {

                // Wenn es Datensätze gibt
                if(response.data.length > 0) {

                    // 
                    var timeline = new Timeline('#ticket-timeline');

                    var dataSet = [];

                    $.each(response.data, function(key, value) {
                        
                        dataSet.push({
                            "timestamp": value.zeitstempel,
                            "icon": 'fa fa-comment',
                            'content': value.text,
                            "precontent": '<i class="fa-solid fa-user"></i> ' + value.mitarbeiterVorname + " " + value.mitarbeiterNachname
                        });

                    });

                    // Setzt die Daten in die Timeline
                    timeline.setData(dataSet.reverse());

                    // Rendert
                    timeline.render();
                }

                // Wenn es keinen Datensatz gibt
                else {

                    // Warning Meldung
                    $('#ticket-timeline').append('<div class="mt-lg-2 alert alert-soft-grey">Noch keine Kontakte/ Personen hinterlegt</div> ');
                    

                }


            }, 

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
            
        );

    },

    // Lädt Alle Daten die zur Form gehören Inklusive RECHTS (Service, Personen, Dateien, Status)
    loadForm(response) {

        var me = this;

        // TODO: Muss doch von selbst reinladen oder?

        // 
        var data = response.data;

        // Ticket Status
        $('#status-ticket').html(data['bezeichnung']);

        // Letzte Aktivität --- ToDo: Aktuelle Ticket ersteller Zeit
        $('#letzte-aktivitaet').html(data['erstellt']);

    },

    // Lädt alle Personen die zu dem Ticket gehören
    // TODO: on klick auf Person --> Dialog: löschen, bearbeiten, Kontak anzeigen (weiterleitung auf kontakte details)
    loadPersonen() {

        var me = this;

        // Ajax
        app.simpleRequest("loadPersonen", "tickets-handle", me.id, 
        
            // Success
            function(response) {

                // HTML vorher leeren
                $('#ticket-personen').html('');

                // Wenn es Kontakte gibt
                if(response.data.length > 0) {

                    var setData = "";

                    // Geht durch alle Kontakte durch
                    $.each(response.data, function(key, value) {

                        var internPill = ""

                        // Wenn es eine Extern/ Öffentliche Person ist
                        if(value.interExtern == '0') {
                            internPill = ''
                            
                                + '<span><i class="fa-solid fa-circle-user text-warning"></i> ' + value.kontaktVorname + " " + value.kontaktNachname +  '</span>'
                                + '<span><span class="badge bg-primary rounded-pill">OP</span></span>'
                            '';
                        
                        // Wenn die Person Intern ist
                        } else {

                            internPill = ''
                            
                                + '<span><i class="fa-solid fa-circle-user text-primary"></i> ' + value.kontaktVorname + " " + value.kontaktNachname +  ' </span>'
                                + '<span><span class="badge bg-primary rounded-pill"><i class="fa-solid fa-bell"></i></span></span>'
                            '';

                        }

                        setData += ''
                        
                            + '<ul class="list-group">'
                            + '<li class="list-group-item d-flex justify-content-between align-items-center">'
                            + internPill
                            + '</li>'
                        
                        '';

                    });

                    // Append Data
                    $('#ticket-personen').append(setData);
                }

                // Wenn es keine Kontakte gibt
                else {

                    // Warning Meldung
                    $('#ticket-personen').append('<div class="mt-lg-2 alert alert-soft-grey">Noch keine Kontakte/ Personen hinterlegt</div> ');
                    
                }

                
            },

            // Error
            function(xhr) {

            }
            
        );

    },

    // Neuer Ticket eintrag soll erstellt werden
    neueAntwortTicket() {

        // $('#antwort').show();

        $('.card-timeline-eintrag').show();

        $('#controller').hide();
    },

    // Fügt neue Kontakte zum Ticket hinzu
    submitKontakteTicket(el, data) {

        var me = this;

        // Addionale Data das mitgegeben wird
        var additionalData = [
            id = me.id,
            data = data
        ];

        // Ajx
        app.simpleRequest("kontakteTicket", "tickets-handle", additionalData, 
        
            // Success
            function(response) {

                // Kontakte Neue laden
                me.loadPersonen();

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            },

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
            
        );
    },


    // Wenn ein neuer Timeline Eintrag erstelt wurde
    submitTimeline() {

        var me = this;

        me.timelineForm.save('submitTimeline', 'tickets-handle', 
        
            // Success
            function(response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // Timeline Neuladen
                me.loadTimeline();

                // Formular zurücksetzen
                me.timelineForm.reset(1);

                // Wieder Ausblenden Summernote
                $('.card-timeline-eintrag').hide();

                // Controlle wieder einblenden
                $('#controller').show();

            },

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },

            // Additional
            {
                id: me.id
            }
            
        )

    },

    // Wenn man neues Dokument zum Ticket hinzufügt
    submitTicketFile() {

        var me = this;

        // Ajax
        me.modalFile.save('submitTicketFile', 'tickets-handle', 
        
            // Success
            function(response) {

                console.log(response);

            },

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Additional
            {
                id: me.id
            }
            
        )

    }

}