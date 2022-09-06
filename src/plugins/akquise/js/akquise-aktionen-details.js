/**
 * Dieses Objekt behinhaltet nur Funktionen die auf der Details Seite sichtbar sein sollen
 */

var akquise_details = {


    init() {

        var me = this;

        // ID der URL
        me.id = app.getUrlId();

        // Chart Js
        me.chart;

        // Global Wiedervorlage Nach
        me.wiedervorlage_nach;

        // Init die auf beiden Seiten gelten soll
        me.initBoth();

        // Init Pickliste
        me.initPickliste();

        // Details zur Aktion
        me.initCardForm();

        // Modal des Meilenstein
        me.initModalMeilenstein();

        // Details zur Aktion - Card Load
        me.aktionLoad();

        // Activation Input
        me.initActivationInput();

        // Load Pie Chart
        me.loadChart();

        // EventListener
        me.addEventListener();
    },

    // Pickliste der Aquisen
    initPickliste() {

        var me = this;

        // TODO: BUG HIER
        me.list = new Picklist('#akquise-kunden-pickliste', 'akquise', {
            type: 'multi-picklist',
            card: false,
            data: me.id,
            addButtons: [
                {
                    action: "btn-akquise-timeline",             
                    class: "btn-akquise-timeline",              
                    icon: "fa-solid fa-timeline",           
                    tooltip: "Timeline Kunden",   
                    show: 'onSingleSelected',
                    pos: 1                    
                },
                {
                    action: "btn-akquise-kunde-add",             
                    class: "btn-akquise-kunde-add",              
                    icon: "fa-solid fa-plus",           
                    tooltip: "Hinzufügen Kunden",         
                    pos: 2                        
                },
                {
                    action: "btn-akquise-delete",             
                    class: "btn-akquise-delete",
                    icon: "fa-solid fa-trash",           
                    tooltip: "Löschen Kunden",     
                    show: 'onSelected',
                    pos: 3                         
                }
            ]
        });

        // Adressen zur Aktion Hinzufügen
        me.listAdressen = new PicklistModal('adressen', {
            type: 'multi-picklist',
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'akquise',
                    field: 'adressen_id',
                    filter: {
                        aktion_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            }
        });

       


    },

    // Pickliste Meilensteine
    initPicklisteMeilensteine(meilenstein) {
      
        var me = this;

        // Meilensteine Pickliste
        me.listMeilensteine = new Picklist('#pickliste-meilensteine', 'akquise_meilenstein', {
            type: 'multi-picklist',
            data: {
                'aktion_id': me.id,
                'setMeilenStein': meilenstein
            },
            card: false,
            // search: false,
            pagination: false,
            description: false, 
            lengthMenu: false,
            buttons: false,
            addButtons: [
                {
                    action: "btn-meilenstein-edit",             
                    class: "btn-meilenstein-edit",              
                    icon: "fa-solid fa-edit",           
                    tooltip: "Timeline Kunden",   
                    show: 'onSingleSelected',
                    pos: 2                 
                },
                {
                    action: "btn-meilenstein-add",             
                    class: "btn-meilenstein-add",              
                    icon: "fa-solid fa-plus",           
                    tooltip: "Hinzufügen Kunden",         
                    pos: 1                        
                },
                {
                    action: "btn-meilenstein-delete",             
                    class: "btn-meilenstein-delete",
                    icon: "fa-solid fa-trash",           
                    tooltip: "Löschen Kunden",     
                    show: 'onSelected',
                    pos: 3                         
                },
                {
                    action: "up",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-up",           
                    tooltip: "Hoch",     
                    show: 'onSingleSelected',
                    pos: 4                         
                },
                {
                    action: "down",             
                    class: "btn-pos-shift",
                    icon: "fa-solid fa-chevron-down",           
                    tooltip: "Runter",     
                    show: 'onSingleSelected',
                    pos: 5                        
                }

            ],
            autoDeselect: false
        });

        // EventListener der Meilensteine Pickliste
        me.addEventListenerMeilensteine();
    },

    // Details zur Aktion hier geladen
    initCardForm() {

        var me = this;

        // Details zur Aktion
        me.form = new CardForm('#form-akquise-details');

    },

    // Modal Form des Meilenstein 
    initModalMeilenstein() {

        var me = this;

        // Meilenstein Modal Form
        me.meilensteinModalForm = new ModalForm('#form-meilenstein');
        me.meilensteinModalForm.initValidation();

    },

    // Activation Checkbox Benutzer Definiert Wiedervorlage Nach
    initActivationInput() {

        var me = this;

        me.wiedervorlageActivate = new ActivationInput('#cb-aktivieren', [{
            selector: 'input[name=wiedervorlage_nach]',
            text: '10'
        }], me.form)

    },

    // Nur EventListener der Meilensteine -- Dieser werden erst Geladen wenn die Form fertig ist (Sonst Henne und Ei)
    addEventListenerMeilensteine() {

        var me = this;

        // Wenn die Pickliste fertig geladen ist
        me.listMeilensteine.on('initComplete', function() {
            // console.log("LISTE FETIG Geladen");
        })

        // Wenn etwas aus der Meilenstein List angeklickt wurde
        me.listMeilensteine.on('pick', function(el, data) {

            // Informationen
            app.alert.info.fire(data[2], ''
                 + 'Der Meilenstein <strong>"' + data[2] + '"</strong> kann für jede Akquise separat gesetzt werden. Über das <strong> "Timeline-Modal" </strong> kann der Meilenstein eingesehen werden.'
                 + ' <br> Zusätzlich ist es sichtbar ob, wann und von wem der Meilenstein gesetzt worden ist.');

        });

        // Wenn ein Meilenstein edditiert werden soll
        me.listMeilensteine.container.on('click', '.dt-action[data-action="btn-meilenstein-edit"]', function() {

            // Helper Funktion Editieren von Meilenstein
            me.editMeilenStein(me.listMeilensteine, me.meilensteinModalForm);

        });

        // Wenn ein Meilenstein neu hinzugefügt werden soll
        me.listMeilensteine.container.on('click',  '.dt-action[data-action="btn-meilenstein-add"]', function() {

            // Modal Meilenstein öffnen
            me.meilensteinModalForm.open();
        })

        // Wenn ein Meilenstein gelöscht werden soll
        me.listMeilensteine.container.on('click', '.dt-action[data-action="btn-meilenstein-delete"]', function() {

            // Helper Funktion zum Löschen der Meilensteine
            me.deleteMeilenstein(me.listMeilensteine);
        });

        // Wenn ein Meilenstein die Position verschoben werden soll
        me.listMeilensteine.container.on('click', '.btn-pos-shift', function() {
            var direction = $(this).data('action');

            me.posShiftByList(direction);

        });



         /**
         * *******************************************************************************************
         * Custom Script
         * *******************************************************************************************
         */


    },

    addEventListener() {

        var me = this;

        // **********************************************************************************
        // Standard Events
        // ***********************************************************************************

        // Wenn der Statistik Tab Sichtbar ist
        $('#tab-nav-statistik').on('show.bs.tab', function(){
          
        });


        // Wenn das Akquise Timeline Modal geschlossen wird
        $('#akquise-timeline-modal').on('click', '.btn-schliessen', function() {
            me.listMeilensteine.refresh(true); // Damit falls Meilensteine geändert wurden es sichtbar wird
        });

        // Wenn der Tab Statistik getriggert wurde
        $('button#tab-nav-statistik').on('shown.bs.tab', function() {
            me.loadChart();
        });

        // Wenn ein neuer Meilenstein hinzugefügt werden soll
        $('.btn-add-meilenstein').on('click', function() {
            me.meilensteinModalForm.open();
        });

        // TODO: GGF CALLBACK DEs ACTIVATIONINPUT
        // Wenn die Wiedervorlage Tage der Aktion geändert werden soll
        $('input[name="cb-aktivieren"]').on('change', function (a,b,c) {

            // Wenn Es gecheckt wird also wenn eine Benutzerdefinierte Wiedervorlage Geschrieben werden soll
            if($(this).is(':checked')) {
                $('input[name="wiedervorlage_nach"]').val('');
                $('input[name="wiedervorlage_nach"]').focus();

            // Wieder 10 Tage reinschreiben
            } else {
                $('input[name="wiedervorlage_nach"]').val('10');
            }
        });

        // *****************************************************************
        // Form Handler
        // *****************************************************************

        // Open Timline
        me.list.container.on('click', '.btn-akquise-timeline', function() {
            me.openModal(me.list.getSelectedColumn('id')[0]);
        });

        // Add Kunde
        me.list.container.on('click', '.btn-akquise-kunde-add', function() {
            me.listAdressen.open();
        });

        // Neue Kunden Hinzufügen
        me.listAdressen.on('pick', function(el, data) {
            me.submitAktionKunden(el, data);
        });

        // Kunden aus der Akquise Rauslöschen oder Status auf gelöscht setzen
        me.list.container.on('click', '.btn-akquise-delete', function() {
            me.submitDelete();
        });

        // Wennn ein Auswahl Getroffen wird
        // me.list.on('selection', function() {
        //     me.offenAnzeige();
        // });

        // Bei Discard soll die Wiedervorlage Nach wiedr auf Standard zurück
        me.form.container.on('click', '.btn-form-discard', function() {
            $('input[name="wiedervorlage_nach"]').val(me.wiedervorlage_nach);
        });

        // Form Aktion Details Abschicken
        me.form.on('submit', function() {
            me.submitAktionDetails();
        });

        // Wenn die Form fertig geladen ist
        me.form.on('initComplete', function() {
            // console.log("FERTIG GELADEN");

        });       

        // Wenn der Meilenstein Modal Bearbeiter wurde und abgeschickt wird
        me.meilensteinModalForm.on('submit', function() {
            me.submitCreateMeilenstein();
        });

        // Wenn das Modal Meilensteine geschlossen wird
        me.meilensteinModalForm.container.on('click', '.btn-schliessen', function() {
            me.meilensteinModalForm.clearForm();
        });
       
    },

    // Wenn der Meilenstein Bearbeitet wurde und abgeschickt werden soll
    submitCreateMeilenstein() {

        var me = this; 

        // ID des Meilensteins
        // var id = me.meilensteinModalForm.container.find('input[name="id"]');

        // TODO:  SAVE Funktion gibt Fehler

        // Save Funktion
        me.meilensteinModalForm.defaultSave('createMeilenstein', 'akquise-handle', 
        
            function(data) {

                /* Callback Success */
                me.listMeilensteine.refresh(true);

                // Alle Input-Felder werden gesäubert
                me.meilensteinModalForm.clearForm(); 

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
                
                // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
                // me.listMeilensteine.refresh(true);

            },

            /* Callback Error ist nicht vorhanden */
            function(xhr) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },
            
            /* Additional */
            {

                // Additional Data - falls es Edit werden soll
                'aktion_id': me.id,
            }
        );

    },

    // Details Aktion Überarbeiter
    submitAktionDetails() {

        var me = this;

        // Bei der Wiedervorlage das Tage wieder entfernen
        var wiedervorlageSplit = $('input[name="wiedervorlage_nach"]').val().split(' ');
        var wiedervorlage = "";

        // Wenn die Erste Stelle eine Zahl ist
        if($.isNumeric(wiedervorlageSplit[0])) {
            $('input[name="wiedervorlage_nach"]').val(wiedervorlageSplit[0]);
            wiedervorlage = wiedervorlageSplit[0];

        // Ein Tag wurde selber Hinzugefügt
        } else {
            $('input[name="wiedervorlage_nach"]').val(wiedervorlageSplit[1]);
            wiedervorlage = wiedervorlageSplit[1];
        }

        // Ajax Submit
        me.form.save('ak-submit', 'akquise-handle', 
            
            // Success
            function(res) {

                // Erfolg
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // "Wiedervorlage_nach" Tage wieder hinzufügen
                $('input[name="wiedervorlage_nach"]').val(wiedervorlage);

            // Error
            }, function(a,b,c) {

                // Fehler
                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten!");
            },

            // Additional
            {
                id: me.id
            }
        );
    },

    // Kunden aus der Aktion rauslöschen oder Status auf Gelöscht setzen
    submitDelete() {

        var me = this; 

        app.alert.question.fire({
            title: 'Löschen',
            text: 'Akquise Dauerhaft löschen oder Status auf gelöscht setzen?',
            confirmButtonText: 'Akquise Löschen',
            cancelButtonText: 'Abbrechen',
            showCancelButton: true,
            denyButtonText: "Löschen",
            showDenyButton: true,
            customClass: {
                denyButton: 'btn btn-danger',
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary'
            },
        }).then((result) => { 

            // Status auf Gelöscht setzen
            if(result.isConfirmed) {

                app.alert.question.fire({
                    title: 'Löschen',
                    text: 'Sie können den Status auf gelöscht setzen, wobei die Akquise in der Aktion erhalten bleibt oder Sie können die Akquise dauerhaft aus der Aktion löschen!',
                    confirmButtonText: 'Status auf gelöscht',
                    cancelButtonText: 'Abbrechen',
                    showCancelButton: true,
                    denyButtonText: "Akquise aus Aktion entfernen",
                    showDenyButton: true,
                    customClass: {
                        denyButton: 'btn btn-danger ml-lg-3',
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-secondary mr-lg-3',
                        popup: 'swal-wide'
                    },
                }).then((result) => { 

                    // Status auf gelöscht setzen
                    if(result.isConfirmed) {

                        me.helperDelete('statusDelete');

                    } 
                    
                    // Akquise aus der Aktion löschen und Status auf gelöscht setzen
                    else if (result.isDenied) {

                        me.helperDelete('aktionDelete');

                    }
                });
                

            // Dauerhaft löschen
            } else if(result.isDenied) {

                // Dauerhaft Löschen Funktion
                me.helperDeleteDauerhaft();

            // Abbruch
            } else {

            }
        });

    },

    // Neuer Kunden werden zur Akquise Aktion hinzugefügt
    submitAktionKunden(el, data) {

        var me = this; 

        // Data
        var newData = [
            id = me.id,
            data =  data
        ];

        // Ajax
        app.simpleRequest("neuerKunde", "akquise-handle", newData, 
            
            // Erfolg
            function(res) {

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // Reset Funktion
                me.reset();

            // Fehler
            }, function(a,b,c) {

            }
        );
    },

    // Positionen Veschieben AJAX
    posShift(direction) {

        var me = this;

        // Ajax
        app.simpleRequest("positionen-shift", "akquise-handle", 
        
            // Additonnal
            {

                id: me.id, 
                colID: me.colID, 
                direction: direction

            }, 
            
            // Erfolg
            function(response) {
                me.listMeilensteine.refresh();

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

            },

            // Fehler
            function(a,b,c) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }

            
            
        );

    },

    // Verschiebt die Positionen der Liste
    posShiftByList(direction) {

        var me = this;

        // Die ID der Spalte auslesen -- Global immer überschrieben
        me.colID = me.listMeilensteine.getSelectedColumn(1);

        // Holt die Aktion des Meilensteins
        // var resultAktion = me.getMeilensteineAktion(me.colID);

        // Erstmal Abfragen ob das ein Standard Meilenstein ist oder nicht
        app.simpleRequest("getMeilensteineAktion", "akquise-handle", me.colID, 
        
            // Success
            function(response) {

                // Wenn es Überhaupt zu einer Aktion gehört
                if(response.data[0]['aktion_id'] > 0) {

                    // Wenn die Reihenfolge bereits Null ist kann man nicht noch mehr verschieben
                    // if(response.data[0]['reihenfolge'] >= 1 || (response.data[0]['reihenfolge'] == '0' && direction == 'down')) {

                        // Übersetztung
                        var richtungGerman = (direction == 'up') ? 'Oben' : 'Unten';

                        // Dialog 
                        // app.alert.question.fire("Positionen ändern","Soll die Position wirklich nach <strong>" + richtungGerman + "</strong> verschoben werden?")
                        
                            // .then(result => {

                                // Wenn Gespeichert werden soll
                                // if(result.isConfirmed) {
                                    
                                    // Positionen Verschieben
                                    me.posShift(direction);
                                // }

                                // // Wenn Nicht gespeichert werden soll 
                                // else {

                                // }

                            // }
                        // );

                    // }

                    // else {

                        // app.notify.info.fire("Info","Sie können die Position des Meilensteins nicht weiter nach oben Verschieben!");
                    // }
                    

                }

                // Wenn es zu keiner Aktion gehört
                else {

                    app.notify.info.fire("Info","Sie können die Position des Meilensteins nicht ändern. Dieser ist keiner Aktion zu geordnet. Die Positon der Meilensteine ohne Aktion können Sie unter 'weitere Stammdaten' verändern!");

                }

            }
            
        );

    },

    // Details zu der Aktion werden geladen
    aktionLoad() {

        var me = this;

        // Load Funktion
        me.form.load('load', 'akquise-handle', me.id, 
        
            function(res) { 

                // Wenn es größer als 10 ist wurde es benutzerdefiniert
                if(res.data['wiedervorlage_nach'] > 10) {
                    $('input[name="cb-aktivieren"]').prop('checked', true);
                } else {
                    $('input[name="cb-aktivieren"]').prop('checked', false);
                }

                me.wiedervorlage_nach = res.data.wiedervorlage_nach;

                // Fügt der "Wiedervorlage_nach" hinten dran Tage hinzu
                $('input[name="wiedervorlage_nach"]').val(res.data.wiedervorlage_nach );

                // Meilensteine Aktion Name
                $('#name_aktion').append('<strong>"' + res.data.name + '"</strong>')

                // Pickliste Meilensteine
                me.initPicklisteMeilensteine(res.data.standard_meilensteine);

                // Fügt den Name der Aktion in den Titel der Navigation
                $('.akquise-title').html(res.data['name'] + " - Aktion Details");
            }

        );

    },

    // Wenn die Akquise Dauerhaft entfernt werden soll
    helperDeleteDauerhaft() {

        var me = this;

        // Wenn es eine Auswahl gibt
        if(me.list.getSelectedLength() > 0) {

            // Abfrage was alles gemacht werden soll
            app.alert.question.fire('Wollen Sie wirklich löschen?','Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                .then((result) => { 	        

                    // Wenn der Nutzer zustimmt
                    if(result.value) {

                        // Alle angewählten Ids auslesen
                        var ids = me.list.getSelectedColumn(1);

                        // Simple Request
                        app.simpleRequest('deleteKunden', 'akquise-handle.php', ids, function() {                                
                            
                            // Reset Funktion 
                            me.reset();

                            //
                            return true;
                        });
                    }
            });

        // Wenn keine Auswahl getroffen wurde
        } else {
            app.notify.error.fire("Auswahl Treffen","Es wurden keine Auswahl getroffen");
        }
    },


    // Wenn der Status auf Gelöscht gesetzt werden soll oder wenn der Kunde aus der Aktion gelöscht werden soll
    helperDelete(deleteStatus) {

        var me = this;

        var task = "";

        // Status wird auf gelöscht gesetzt
        if(deleteStatus == 'statusDelete') {
            task = 'statusDelete';

        // Kunde wird aus der Aktion entfernt
        } else {
            task = 'statusAkquiseDelete';
        }

        // Ajax
        app.simpleRequest(task, "akquise-handle", me.list.getSelectedColumn(1), 
                        
            // Success
            function(response) {

                // Wenn nur der Status auf gelöscht gesetzt werden soll
                if(deleteStatus == 'statusDelete') {
                    me.hideStatus('3')
                }

                // Reset Funktion
                me.reset();

                // Erfolg
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            },

            // Error
            function(a,b,c) {
                app.notify.error.fire("Nicht Erfolgreich","Es ist ein Fehler aufgetreten. Bitte melden Sie sich beim Admin!");
            }
        );
    },

    // Löschen von Meilensteine
    deleteMeilenstein(list) {

        var me = this;

        // Zählt alle Meilensteien die schon gesetzt worden sind
        me.countMeilensteinPos(list, 
        
            // Callback von der Funktion Count MeilensteinPost
            function(response) {

                // Wenn noch die Meilensteine noch nicht gesetzt worden sind dann kann es gelöscht werden
                if(response.data[0].anzahlMeilenstein < 1) {

                    // Wenn es eine Auswahl gibt
                    if(list.getSelectedLength() > 0) {

                        // Abfrage was alles gemacht werden soll
                        app.alert.question.fire('Wollen Sie wirklich löschen?','Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                            .then((result) => { 	        

                                // Wenn der Nutzer zustimmt
                                if(result.value) {

                                    // Alle angewählten Ids auslesen
                                    var ids = list.getSelectedColumn(1);

                                    // Simple Request
                                    app.simpleRequest('deleteMeilensteine', 'akquise-handle', ids, 
                                    
                                        // Success
                                        function() {                                
                                        
                                            // Erfolgsmeldung
                                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                                            // PickListe wird automatisch neu geladen
                                            list.refresh(true);

                                        }, 

                                        // Error
                                        function(xhr) {
                                            app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                                        }
                                        
                                    );
                                }
                        });

                    // Wenn keine Auswahl getroffen wurde
                    } else {
                        app.notify.error.fire("Auswahl Treffen","Es wurden keine Auswahl getroffen");
                    }

                // Wenn eine der Meilensteine schon gesetzt ist dann Fehlermeldung
                } else {

                    app.notify.info.fire("Löschen nicht möglich","Eine der von Ihnen ausgewählten Meilensteine wurde schon gesetzt, weshalb er nicht mehr gelöscht werden kann!");

                }

            },
            'delete'
            
        )

    },

    // Editieren zum Meilenstein
    editMeilenStein(list, modal) {

        var me = this;

        // Zählt alle Meilensteine die schon gesetzt sind
        me.countMeilensteinPos(list, 
        
            // Callback von der Funktion Count MeilensteinPost
            function(response) {

                // Wenn der Meilenstein noch nicht gesetzt wurde
                if(response.data[0].anzahlMeilenstein < 1) {

                    var id = list.getSelectedSingle()[1];

                    // Modal Öffnen und Laden
                    modal.loadAndOpen('editMeilenstein', 'akquise-handle', id, function() {

                    })

                }

                // Fehlermeldung bringen das der Meilenstein nicht mehr geändert werden kann weil er schon vergeben wurde
                else {
    
                    app.notify.info.fire("Bearbeiten nicht möglich","Dieser Meilenstein wurde schon gesetzt und kann nicht mehr geändert werden!");
                }
            },

            'edit'
            
        );

    },

    // Zählt alle Meilensteine die schon vergeben worden sind zusammen
    countMeilensteinPos(list, callback, task) {

        var me = this;

        // Die ID welche ausgewählt wurde
        var id;

        if(task == 'edit') {
            id = list.getSelectedSingle()[1];
        } else if(task == 'delete') {
            id = list.getSelectedColumn(1);

        }

        // Wenn es eine ID gibt
        if(id) {

            // Ajax
            app.simpleRequest('getMeilensteinSet', 'akquise-handle', id, 
            
                // Success
                function(response) {
                    callback(response); 
                }, 

                // Error
                function(xhr) {

                    app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
    
                }
            )

        }

    },

    // Funktion welche die Akquise Aktion Lädt
    loadChart() {

        var me = this;
        
        // Wird geleert bevor es befüllt wird
        $('#pie-chart').html("")
        $('.error-message-chart').html("");

        // TODO: PERFORMANCE VERBESSERN
        var offen = "0"; 
        var erfolgreich = "0"
        var nicht_erfolgreich = "0"

        // Muss die Daten aus der Datenbank laden und dann Dynamisch in Data anzeigen
        app.simpleRequest("getStatusForStatistic", "akquise-handle", me.id, 
        
            // Success
            function(response) {

                // Response Data
                var data = response.data[0];

                // Chart Container Größe anpassen
                $('.chart-container').attr('style', 'height: 300px !important');

                // Alle werden gezählt wie viele Offen,.. es gibt und dann überschrieben in der Variable
                // Wird so an das CHART übergeben
                offen = data.offen;
                erfolgreich = data.erfolgreich;
                nicht_erfolgreich = data.nicht_erfolgreich;

                if(offen > 0 || erfolgreich > 0 || nicht_erfolgreich > 0) {

                    // Canvas Anzeigen
                    $('#pie-chart').show();

                    // Container wieder anzeigen
                    $('.chart-container').show();

                    // Wenn der Chart schon existiert
                    if(me.chart !== undefined) {
                        
                        // Chart wird Zerstört und nochmal neu Erstellt
                        me.chart.destroy();

                    }

                    // Chart zusammen Bastelen
                    var ctx = document.getElementById('pie-chart').getContext('2d');
                    me.chart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            datasets: [{
                                data: [
                                    offen,erfolgreich,nicht_erfolgreich
                                ],
                                backgroundColor: [
                                    '#3498db',
                                    '#7ab929',
                                    '#e74c3c',
                                ],
                                label: 'Ergebnisse'
                            }],
                            labels: [
                                'Offen',
                                'Erfolgreich',
                                'Nicht erfolgreich',
                            ]
                        },
                        options: {
                            legend: {
                                position: 'left',
                                align: 'center'
                            },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                } else {

                    // Chart Container Auf 0px runterschrauben
                    $('.chart-container').attr('style', 'height: 0 !important');

                    // Chart Container Ausblenden
                    $('.chart-container').hide();

                    // Noch keine Daten vorhanden
                    $('.error-message-chart').html("<div class='alert alert-soft-grey'>Es sind noch keine Daten ersichtlich!</div>")

                }

            },

            // Error
            function(xhr) {

                // Fehlermeldung
                $('.error-message-chart').html("<div class='alert alert-soft-danger'>Die Statistik konnte nicht geladen werden. Bitte Wendenn Sie sich an den Admin</div>")

                // Canvas Entfernen
                $('#pie-chart').hide();

            }
            
        );

        

    },

    // Funktion die Custom Reset durchführt
    reset() {

        var me = this;

        // Reset
        $('#info-status-offen').html("");

        // Liste Neu Laden
        me.list.refresh(true);

        // Adressen List neuladen 
        me.listAdressen.refresh();    
    }

}