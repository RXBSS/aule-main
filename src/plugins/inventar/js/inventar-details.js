
// Alle funktionen die nur auf der Details Seite sichtbar bzw. funktionieren sollen
var id = {


    init() {

        var me = this; 

        // Globale Variable für Reset Data Form End
        me.abschreibungCheckbox = false;

        // Funktionen die auf beiden Seiten da sein sollen
        me.initBoth();

        // Die ID des Inventar um die es get (URL)
        me.id = app.getUrlId();

        // Init Form
        me.initForm();

        // Laden des Formulares der Details
        me.formLoad();

        // Init Drag and Drop
        me.initDragAndDrop();

        // Timeline Inventar Verleih
        me.timeline();
        
        // EventListener
        me.addEventListener();

    },

    // Funktion die die Form Inialisiert
    initForm() {

        var me = this; 

        me.form = new CardForm('#form-inventar');
        me.form.initValidation();

        // Verleihe Form
        me.formVerleih = new CardForm('#inventar-verleih-form');
        me.formVerleih.initValidation();

        
        
    }, 

    // Funktion die Drag and Drop Iniliasiert
    initDragAndDrop() {

        var me = this;

        // Additional ID 
        var data = {
            id: me.id,
            task: 'upload-dokument'
        };

        // Drag N Drop Klasse initalisieren
        me.dragger = new DragAndDrop('#dokumente-drag-n-drop', {
            handle: 'inventar-handle',
            task: 'upload-dokument' // TODO: nicht sinnvoll so
        });

    },

    // Quickselects
    // initQuickselect() {

    //     var me = this;

    //     me.kaufpersonQuickselect = new Quickselect('mitarbeiter', {
    //         selector: '#select-kaufperson',
    //         defaultText: 'Bitte Benutzer auswählen',
    //     });

    //     me.nutzerQuickselect = new Quickselect('mitarbeiter', {
    //         selector: '#select-nutzer',
    //         defaultText: 'Bitte Benutzer auswählen',
    //     })

    // },

    // Alle Events die auf dieser Seite geladen werden sollen
    addEventListener() {

        var me = this;


        // *******************************************************************
        // Standard Events
        // *******************************************************************
        
        // Wenn der Kaufpreis geändert wurde
        $('input[name="kaufpreis"]').on('keyup', function() {
            me.customValidierung($(this).val())
        }); 


        $('#verleih-beenden').on('click', function() {
            me.verleihBeenden(me.id, function(response) {

                me.formVerleih.reset(1);

            });
        });
    
        

        // *******************************************************************
        // Form Handler Events
        // *******************************************************************


        


        // Laden des Formulares der Details --- für den VERLEIH
        me.formVerleih.load('verleih-edit', 'inventar-handle', me.id , 
            // Success
            function(res) {

                // Globale Die Daten holen die in Verleih stehen -- Damit ein Vergleich gemacht wird und die Daten nicht abgeschicken werden können
                me.getData = me.formVerleih.getData();
            }
        );

        // Wenn die Form fertig geladen ist
        me.formVerleih.on('initComplete', function() {
           
        });


        // Wenn das Formular abgeschickt werden soll
        me.form.on('submit', function() {
            me.submit();
        });

        // Wenn das Formular abgeschickt werden soll
        me.formVerleih.on('submit', function() {
            me.verleihSubmit(me.id, me.formVerleih, function(response) {
                // Timeline Aufrufen damit es Aktuallisiert wird
                me.timeline();
            });
        });

        // Wenn die Form zurück gesetzt wird
        me.form.on('end', function() {
            if(me.abschreibungCheckbox) {
                $('input[name="abschreibung"]').prop('checked', true);
            }

            me.abschreibeEndDatum(me.kaufdatum);
        });

        // Bei erfolgreichem Upload die Liste neu laden
        me.dragger.on('upload-success', function() {
            console.log("TEST");
        });

    },

    // Wenn die Form wieder abgeschickt wird
    submit() {

        var me = this;

        // Ajax
        me.form.save('i-submit', 'inventar-handle', 
        
            // Success
            function(response) {
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            },

            // Error
            function(xhr) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }, 


            // Additional Data
            {
                id: me.id
            }
            
        )

    },

    // Nachdem die Form geladen wurde
    formLoad() {

        var me = this;

        // Laden des Formulares der Details
        me.form.load('i-edit', 'inventar-handle', me.id , 
            // Success
            function(res) {

                // Wenn die Abschreibung 0 ist
                if(res.data.abschreibezeitraum === null) {

                    $('#abschreibung').hide();
                } 

                // Ansonsten das Enddatum mit eintragen
                else {

                    $('input[name="abschreibung"]').prop('checked', true) // Abschreibung Checkbox Anhaken
                    me.abschreibungCheckbox = true;
                    
                    me.abschreibeEndDatum(res.data.kaufdatum);
                }

                // Wenn es ein kaufDatum gibt
                if(res.data.kaufdatum) {
                    me.kaufdatum = res.data.kaufdatum; // Für die Both Seite Damit beim Neuladen ohne Datum ändern ein Kaufdatum da ist
                }

                // Wenn es ein Kaufpreis gibt
                if(res.data.kaufpreis) {
                    me.customValidierung(res.data.kaufpreis)
                    me.abschreibungToggler(res.data.kaufpreis)
                }

                // GetData in eine Globale Variable Speicher
                // me.getData = me.form.getData();

            }
        );

    },

    // Validierung 
    customValidierung(val) {

        var me = this;

        // Wenn der Kaufpreis größer als 800 Euro sind dann Validieren
        if(parseInt(val) >= 800) {
            me.form.fvInstanz.enableValidator('abschreibezeitraum')
        
        // Wenn der Kaufpreis kleiner als 800 Euro sind dann Nicht Validieren
        } else {
            me.form.fvInstanz.disableValidator('abschreibezeitraum')
        }
    },


    // Timeline Inventar Historie
    timeline() {


        var me = this;

        // Ajax Befehl --  Holt alle Daten zu Inventar Positionen
        app.simpleRequest("getHistorie", "inventar-handle", me.id, 
        
            function(response) {

                console.log(response);

                // Wenn es Historie Daten gibt
                if(response.data.length > 0) {

                    // Leeres Array
                    var dataSet = [];

                    // Timeline Init
                    var timeline = new Timeline('#inventar-verleih-timeline');

                    // Schleife die durch alle Positionen geht
                    $.each(response.data, function(el, data) {

                        //  Dateset zusammensetzen
                        dataSet.push({
                            "timestamp": data.timestamp,
                            "icon": 'fa-solid fa-arrow-right',
                            'class': 'bubble-scroll-lg',
                            "content": '<b style="font-weight:bold">' + data.bearbeiterVorname  + " " + data.bearbeiterNachname + ' : </b>' + data.historieNutzungsgrund,
                            "precontent": '<i class="fa-solid fa-people-carry-box"></i> Nutzer: ' + data.NutzerVorname + " " + data.NutzerNachname,
                            // "subcontent": kundentermin
                        });
                    });

            
                    // Setzt die Daten in die Timeline
                    timeline.setData(dataSet);
            
                    // Rendert
                    timeline.render();

                }

                else {

                    // Noch keine Daten vorhanden
                    $('#inventar-verleih-timeline').html("<div class='alert alert-soft-warning'>Noch keine Historie Daten vorhanden! Erstellen Sie einen Eintrag</div>")
                }


            },

            // Error
            function(response) {

                $('#inventar-verleih-timeline').html("<div class='alert alert-soft-warning'>Historie konnte nicht geladen werden!</div>")
            },

            
        );

      


    }

}

