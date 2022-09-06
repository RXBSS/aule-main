var i = {


    init: function() {

        var me = this; 

        // Funktionen die auf beiden Seiten da sein sollen
        me.initBoth();

        // Standardmäßg hide
        $('#abschreibung').hide();

        // Init der Pickliste
        me.initPickliste();

        // Init des Modals
        me.initModal();

        // Init Context Menu
        // me.contextMenuVerleih();

        // EventListener
        me.addEventListener();

    },

    initPickliste() {

        var me =  this; 

        // Pickliste
        me.list = new Picklist('#inventar-pickliste', 'inventar', {
            type: "single-picklist",
            card: false,
            buttons: false,
            // addHandleButtons: true,
            addButtons: [
                {
                    action: "objekt-verleih",             
                    class: "objekt-verleih",              
                    icon: "fa-solid fa-truck-moving",           
                    tooltip: "Kaufobjekt Verleihen",   
                    show: 'onSingleSelected',
                    pos: 1                    
                },
                {
                    action: "objekt-details",             
                    class: "objekt-details",              
                    icon: "fa-solid fa-arrow-right",           
                    tooltip: "Details Weiterleitung",   
                    show: 'onSingleSelected',
                    pos: 1                    
                }
            ]
        });

    },

    initModal() {

        var me = this;

        // Modal
        me.modal = new ModalForm('#modal-inventar');
        me.modal.initValidation();

        // Abschreibung FormValidation ausblenden
        me.modal.fvInstanz.disableValidator('abschreibezeitraum')


        // Modal Verleih
        me.modalVerleih = new ModalForm('#inventar-verleih-form');
        me.modalVerleih.initValidation();

    },

    addEventListener() {

        var me = this; 

        // ******************************************************************************
        // Standard Events
        // ******************************************************************************

        // Wenn der Kaufpreis geändert wurde
        $('input[name="kaufpreis"]').on('keyup', function() {

            // Validieren wenn es größer als 800 ist
            if(parseInt($(this).val()) >= 800) {
                me.modal.fvInstanz.enableValidator('abschreibezeitraum')
            } else {
                me.modal.fvInstanz.disableValidator('abschreibezeitraum')
            }

        }); 

        // *****************************************************************************************************
        // Form Handler Events
        // *****************************************************************************************************

        me.modal.container.find('.btn-schliessen').on('click', function() {
            me.modal.reset(1);
        });

        // Weiterleitung auf die Details Seite -- 
        // me.list.on('pick', function(el, data) {
        //     app.redirect('inventar-details.php?id=' + data[1]);


        //     // app.notify.info.fire("Wird noch Programmiert","Wird noch Programmiert");


        // });

        // Verleihen des Kaufobjekte
        me.list.container.on('click', '.objekt-verleih', function(el, data) {
            me.objektVerleih(me.list.getSelectedSingle()[1]);
        });

        // Weiterleitung auf die Details Seite
        me.list.container.on('click', '.objekt-details', function(el, data) {
            app.redirect('inventar-details.php?id=' + me.list.getSelectedSingle()[1]);
        });

        // Submit Modal Verleih
        me.modalVerleih.on('submit', function() {
            me.verleihSubmit(me.list.getSelectedSingle()[1], me.modalVerleih, function(response) {
                // Liste Neu Laden
                me.list.refresh(true);

                me.modalVerleih.reset(0);
            });
        });

        // Verleih beenden
        me.modalVerleih.container.on('click', '#verleih-beenden', function() {
            me.verleihBeenden(me.list.getSelectedSingle()[1], function(response) {
                me.modalVerleih.reset();

                // Liste Neu laden
                me.list.refresh(true);

                // Modal Schließen
                me.modalVerleih.close();
            });
        });
        

        // console.log(me.contextMenu.container);


        // me.contextMenu.on('pick', function(e, El) {
        //     e.preventDefault();
        //     me.contextMenuChoose(El);

        //     return false;

        // });

        // me.contextMenu.container.on('click', '.context-menu-rausgeben', function() {

        //     e.preventDefault();

        //     console.log('TEST');
        // });

        // // Context Menu Verleiht
        // me.contextMenu.container.find('#context-menu-verleih .context-menu-rausgeben').on('click', function(e) {

        // });


        me.simpleModalTaskAG = new simpleModalTask('.btn-inventar-add', me.list, me.modal, 'i-submit', 'inventar-handle');

        // me.simplePickListeTasksAG = new simplePickListeTasks(null, me.list, me.modal, 'i-delete', 'inventar-handle.php', 'i-edit');
        

    },

    // // Verleih beenden
    // verleihBeenden() {

    //     var me = this;

    //     // Id
    //     var id = me.list.getSelectedSingle()[1];


    //     // Mit Ajax Verleih beenden
    //     app.simpleRequest("verleihBeenden", "inventar-handle", id, 
        
    //         // Success
    //         function(response) {
    //             console.log(response);

    //             // Reset
    //             me.modalVerleih.reset();

    //             // Liste Neu laden
    //             me.list.refresh(true);

    //             // Modal Schließen
    //             me.modalVerleih.close();

    //             // Erfolgsmeldung
    //             app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
    //         },

    //         // Error
    //         function(response) {
    //             app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
    //         }
            
    //     );

    // },

    // Objekt wird verliehen
    objektVerleih(id) {

        var me = this;

        me.getDataInventar(id, function(response) {

            // Wenn es einen Nutzer gibt an den Verliehen wurde
            if(response.data.nutzer_id.value > 0) {

                // Verleihung kann beendet werden
                $('#verleih-beenden').show();

                // Warnung das Objekt schon Verliehen ist
                $('.warning-nicht-verfügbar').html("<div class='alert alert-soft-info'> Das Objekt ist aktuell in Leihe! </div>")

            }

            else {

                // Verleih kann nicht beendet werden ohne das es Verliehen wurde
                $('#verleih-beenden').hide();

                // Warnung d
                $('.warning-nicht-verfügbar').html("")

            }

        }); 



        // Prüfen ob das Objekt schon verliehen wurde
        // me.getDataInventar(id, function(response) {

        //     console.log(response);

        //     // In Allen Fällen das Modal Öffnen
        //     me.modalVerleih.open();
        //     me.modalVerleih.container.find($('input[name="kaufobjekt"]')).val(response.data.kaufobjekt)

        //     // Wenn es einen Nutzer gibt an den Verliehen wurde
        //     if(response.data.nutzer_id.value > 0) {

        //         // Verleihung kann beendet werden
        //         $('#verleih-beenden').show();

        //         // Option 
        //         var option = '<option value="'+ address.country +'">'+ address.political +'</option>'

        //         // Fügt es an den Select an
        //         me.modalNeueAdresse.container.find(('select[name=land]')).html(option);

        //         me.modalVerleih.container.find($('input[name="kaufobjekt"]')).val(response.data.kaufobjekt)
        //         me.modalVerleih.container.find($('input[name="kaufobjekt"]')).val(response.data.kaufobjekt)
        //         me.modalVerleih.container.find($('input[name="kaufobjekt"]')).val(response.data.kaufobjekt)
        //         me.modalVerleih.container.find($('input[name="kaufobjekt"]')).val(response.data.kaufobjekt)


        //     } else {

        //         // Verleih kann nicht beendet werden ohne das es Verliehen wurde
        //         $('#verleih-beenden').hide();

        //     }

        // });

    },

    // Holt Alle Daten des Inventar Objektes
    getDataInventar(id, callback) {

        var me = this;

        me.modalVerleih.loadAndOpen("verleih-edit", "inventar-handle", id, 
        
            // Success
            function(response) {
                callback(response);
            }
            
        );

        // Holt die Daten via Ajax
        // app.simpleRequest("i-edit", "inventar-handle", id, 
            
        //     // Success
        //     function(response) {
        //         // callback(response);
        //     }
            
        // );

    },

    // Wenn eine Auswwahl getroffen wurde
    // contextMenuChoose(el) {

    //     var me = this;

    //     // Objekt Verleihen
    //     if(el.data('action') == 'rausgeben') {

    //         console.log("VERLEIH");

    //     } else if(el.data('action') == 'details') {

    //         console.log("details");

    //     }

    // },

    // Kontext Menu Öffnen für Verleih
    // contextMenuVerleih() {

    //     var me = this;

    //     me.contextMenu = new ContextMenu('#inventar-pickliste', {

    //         // Als String
    //         html:   ''
    //             + '<ul class="dropdown-menu context-menu" id="context-menu-verleih">'
    //                 + '<li><a class="dropdown-item context-menu-rausgeben" href="javascript:void(0);" data-action="rausgeben"><i class="fa-solid fa-truck-moving"></i> Rausgeben</a></li>'
    //                 + '<li><a class="dropdown-item context-menu-details" href="javascript:void(0);" data-action="details"><i class="fa-solid fa-arrow-right"></i> Details</a></li>'
    //                 // + '<li><a class="dropdown-item" href="javascript:void(0);" data-action="bearbeiten"><i class="fa-solid fa-edit"></i> Bearbeiten</a></li>'
    //                 // + '<li><a class="dropdown-item" href="javascript:void(0);" data-action="entfernen"><i class="fa-solid fa-trash"></i> Entfernen</a></li>'
    //                 // + '<li>'
    //                     // + '<hr class="dropdown-divider">'
    //                 // + '</li>'
    //                 // + '<li><a class="dropdown-item" href="javascript:void(0);" data-action="neu"><i class="fa-solid fa-plus"></i> Neu Erstellen</a></li>'
    //             + '</ul>',

    //         contextSelector: '#context-menu-verleih' 

    //     });
        
          
        

    // }

}