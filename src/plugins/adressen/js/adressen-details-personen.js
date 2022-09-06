var ad_p =  {

    init: function() {

        var me = this; 

        // Additional Data wird der Pickliste übergeben zum Filtern
        me.id = app.getUrlId();
        
        // Kontake - Value speichern
        me.unternehmen = $('input[name="unternehmen"]').val();
        me.adressen_id = $('input[name="adressen_id"]').val();

        // Kontake - Mehr Anzeigen
        me.kontakte_ma = $('#kontakte-mehr-anzeigen');
        me.kontakte_ma.hide();

        // Init Modal
        me.initModalForm();

        // Init Pickliste
        me.initPickliste();

        // AddEventListener
        me.addEventListener();
    }, 

    addEventListener() {
        var me = this; 

        // ***********************************************************************************
        // Standard Events
        // ***********************************************************************************

        // Kontakte - Peronen Tabs geladen
        $('#pills-personen').on('shown.bs.tab', function() {

            // Personen Rows werden Resizet
            me.personenlist.redraw();

            // Visitenkarten Anzeigen
            me.cardView();
        });

        // Kontakte - Ansichte als Pickliste
        $('#adressen-personen-pickliste-ausloeser').on('click', function() {
            $('#adressen-kontakte-pickliste').show();
            $('#adressen-kontakte-card').hide();
            $('#adressen-personen-ansichten').hide();
        });

        // Kontakte - Mehr anzeigen Toggler
        $('#kontakte-mehr-anzeigen-toggler').on('click', function() {
            me.mehrAnzeigen();
        });

        // TODO: Kunde - Toggler Switch 
        $('#adressen-kunde-aktivieren').on('change', function(e) {
            me.toggleAktivieren(); 
        });

        // Wenn über die Visitenkarten Ansicht ein neuer Kontakt hinzugefügt wird
        $('#adressen-personen-ansichten').on('click', '#button-kontakte-hinzufuegen', function() {
            me.addDialog();
        });

        // Wenn ein Kontakt aus der Visitenkarten Ansicht gelöscht werden soll
        $('#adressen-kontakte-card').on('click', '.button-kontakt-delete', function() {
            me.deleteVisitenkarten($(this));
        })

        // ***********************************************************************************
        // Form Handler Events
        // ***********************************************************************************

        // Kontakte - Modal Open Values wieder zurücklegen
        me.personenModal.on('shown.bs.modal', function() {
            $('input[name="unternehmen"]').val(me.unternehmen);
            $('input[name="adressen_id"]').val(me.adressen_id);

            // me.changeModal();

            // me.personenModal.container.find('#adressen-id').append('<p>TEST</p>');

            me.personenModal.container.find('#adressen-id').html('');
            me.personenModal.container.find('#adressen-id').append('<input type="hidden" name="adressen_id" value="' + me.id + '">');
        });

        // Kontakte - Ansicht als Karte
        me.personenlist.container.on('click', '.card-ansicht', function() {
            $('#adressen-kontakte-pickliste').hide();
            $('#adressen-kontakte-card').show();
            $('#adressen-personen-ansichten').show();
        });

        // Kontakte Modal - Wenn das Model geschlossen wird soll alles vollständig zurückgesetzt werden
        me.personenModal.container.on('click', '.btn-schliessen', function() {
            me.resetKontakte();
        });

        // Dialog Öffnen
        me.personenlist.container.on('click', '.dt-action[data-action="add"]', function() {
            me.addDialog();
        });

                

        // Adressen Personen - erstellen
        // me.simpleModalTaskKontakte = new simpleModalTask(null, me.personenlist, me.personenModal, 'k-submit', 'kontakte-handle');

        // ------------------------------------------------------------
        // 2. Submit Funktion (Abschicken)
        // ------------------------------------------------------------
        me.personenModal.on('submit', function() {
            me.submit();
        });

         // ------------------------------------------------------------
        // 3. Edit Funktion (Editieren von vorhanden Daten)
        // ------------------------------------------------------------
        me.personenlist.container.on('click','.dt-action[data-action="edit"]', function() {
           
            // Selected auslesen

            // id wird in der Variable Gespeichert
            var id = me.personenlist.getSelectedSingle()[13];

            // console.log(me.personenlist.getSelectedSingle()[13]);
            

            // console.log(me.personenlist.getSelectedColumn(13));

            // Wenn es eine id gibt
            if(id) {

                // 1. loadAndOpen()
                me.personenModal.loadAndOpen('load', 'kontakte-handle', id, function() {

                    
                });

            // Darf nicht vorkommen
            } 


            // Klasse ****simpleEditTask**** wird aufgerufen -> Doku steht in der Datei
            // me.simpleEdit = new simpleEditTask(me.personenlist, me.personenModal, 'load', 'kontakte-handle');
        });

        
        // ------------------------------------------------------------
        // 4. Delete Funktion (Löschen von einer oder mehreren einträgen )
        // ------------------------------------------------------------
        me.personenlist.container.on('click','.dt-action[data-action="delete"]', function() {
            
            me.deleteAdressenKontakte();
        });

        // ------------------------------------------------------------
        // 5. Schliesen des Modals
        // ------------------------------------------------------------
        me.personenlist.container.on('click', '.btn-dt-close', function() {

            // PickListe wird automatisch neu geladen
            me.personenlist.refresh(true);
        });

        // Wenn eine Auswahl getroffen wurde und neue Kontakte hinzugefügt werden sollen
        me.personenPicklistModal.on('pick', function(el, data) {
            me.submitPicklistKontakte(el , data);
        });


         // Adressen Person - editieren und löschen
        //  me.simplePickListeTasksPL = new simplePickListeTasks(null, me.personenlist, me.personenModal, 'k-delete', 'kontakte-handle', 'load');
       
    },

    initPickliste() {
        var me = this; 
        
        // Adressen Personen - Kontakte Pickliste
        me.personenlist = new Picklist('#adressen-personen-pickliste', 'kontakte', {
            type: 'multi-picklist',
            card: false,
            addHandleButtons: true,
            submitButton: false,
            data: [
                me.id,
                'adressen'
            ],
            addButtons: [
                {
                    action: "card-ansicht",       
                    class: "card-ansicht",                
                    icon: "fa-solid fa-id-card",      
                    id: "adressen-personen-card-auslöser",
                    tooltip: "Ansicht - Card",         
                    pos: 30                           
                }
            ]
        });

        // Pickiste Kontakte
        me.personenPicklistModal = new PicklistModal('kontakte2', {
            type: "multi-picklist",
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'adressen_kontakte',
                    field: 'kontakte_id',
                    filter: {
                        adressen_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            }

        });
    },

    initModalForm() {
        var me = this; 

        // Adressen Personen - Modal Kontakte
        me.personenModal = new ModalForm('#modal-kontakte-form');
        me.personenModal.initValidation();

        // Adresse Sollte Ausblendet sein -- weil macht kein Sinn wieso sollt man einen andere Adresse auswählen können man ist auf der Adresse die man bearbeiten will
        me.personenModal.container.find('#kontakt-adresse .adressen-select').hide();
    },

    // Kontakte Neu hinzufügen
    submit() {

        var me = this;

        // id der Ausgewählten Zeile
        var id = me.personenlist.getSelectedSingleColumn(1);

        // Save Funktion
        me.personenModal.save('k-submit', 'kontakte-handle', function(response) {

            /* Callback Success */

            // Daten die Abgeschickt worden sind
            var data = me.personenModal.getData();

            // Addtional Data das mitgegeben wird
            var additional = {
                'adressen_id': me.id,
                'kontakte_id': response.data.data,
                'abteilung': data.abteilung,
                'funktion': data.funktion
            }

            // Formular Abschicken damit der neue Kontakt auch in der Adresen_Kontakte auftaucht ---- N:N Verbindung
            app.simpleRequest("submitAdressenKontakt", "adressen-handle", additional, function(response2) {
            });

            // Alle Input-Felder werden gesäubert
            me.personenModal.clearForm(); 

            me.personenModal.close(); 

            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
            
            // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
            me.personenlist.refresh(true);

            // Card View NeuLaden
            me.cardView();


        },
        /* Callback Error ist nicht vorhanden */
        false, {

            // Additional Data - falls es Edit werden soll
            id: id,
            adressen_id: me.id
        });

    },

    // Submit über schnell hinzufügen
    submitPicklistKontakte(el, data) {

        var me = this;

        // Daten die mitgegeben werden
        var data = [
            id = me.id, 
            data = data
        ];

        // Ajax
        app.simpleRequest("newKontakt", "kontakte-details-handle", data,
        
            // Succcess
            function(response) {

                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
                me.personenlist.refresh(true);

                me.personenPicklistModal.refresh(true);

                // Reload CardView der Kontakte
                me.cardView();

                // Reload des Tabs
                // $('#pills-personen').tab('show');

    

                // $('#personen').removeClass('active');
                // $('#personen').addClass('active');
            },

            // Error
            function(a,b,c) {
                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            }
        );


    },

    // Löschen den Kontakt wieder aus der Adressen raus
    deleteAdressenKontakte() {

        var me = this;

        // Wenn es eine Auswahl gibt
        if(me.personenlist.getSelectedLength() > 0) {

            // Abfrage was alles gemacht werden soll
            app.alert.question.fire('Wollen Sie wirklich löschen?','Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                .then((result) => { 	        

                    // Wenn der Nutzer zustimmt
                    if(result.value) {

                        // Alle angewählten Ids auslesen
                        var ids = me.personenlist.getSelectedColumn(1);

                        var data = {
                            'adressen_id': me.id,
                            'id': ids
                        }

                        // Simple Request
                        app.simpleRequest('deleteAdressenKontakte', 'kontakte-handle', data, function() {                                
                            
                            // PickListe wird automatisch neu geladen
                            me.personenlist.refresh(true);

                            // Reload CardView der Kontakte
                            me.cardView();


                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                            //
                            // return true;
                        });
                    }
            });
        } else {
            app.notify.error.fire("Auswahl Treffen","Es wurden keine Auswahl getroffen");
        }

    },

    // Einen Kontak aus der Visitenkarten Ansicht löschen
    deleteVisitenkarten(el) {

        var me = this;

        // Die Kontakte ID die gelöscht werden soll
        var kontakte_id = el.data('kontakte');

        // Additional Data
        var data = {
            'kontakte_id': kontakte_id,
            'adressen_id': me.id
        }

        // Dialog
        app.alert.question.fire("Wollen Sie den Kontakt löschen?","Dieser Vorgang ist nicht mehr Rückgängig zu machen!")
        
            .then((result) => {

                // Wenn Ja --- Löschen
                if(result.isConfirmed) {

                    // Ajax Hier
                    app.simpleRequest("deleteVisitenkarte", "adressen-handle", data, 
                    
                        // Success
                        function(response) {

                            // Reload CardView der Kontakte
                            me.cardView();


                            // Pickliste ebenfalls neuladen
                            me.personenlist.refresh(true);

                            // Erfolgsmeldung
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
                        },

                        // Error
                        function(xhr) {
                            app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
                        }

                        
                    );
                }

                // Wenn Nein --- Nicht Löschen

            });
        ;

    },

    // VisitenKarten CardView ansicht anzeigen
    cardView() {

        var me = this;

        // HTML leeren
        $('#adressen-kontakte-card').html('');

        // Ajax
        app.simpleRequest("cardView", "adressen-handle", me.id, 
        
            // Success
            function(response) {
            
                // Wenn es Daten gibt
                if(response.data.length > 0) {

                    var res = "";

                    // Geht alle Daten durch
                    $.each(response.data, function(key, value) {

                        // Result
                        res += "<div class='col-lg-6'>"
                            + "<div class='visitenkarte'>"
                                + "<div class='p-3'>"
                                    + "<input type='hidden' name='kontakt-id' val='" + response.data[key].id +  "'>"
                                    + "<div class='d-flex pb-2'>"
                                        + "<div class='pr-2'>"
                                            + "<i class='fa-solid fa-circle-user fa-3x user-icon'></i>"
                                        + "</div>"
                                        + "<div>"
                                            + "<strong class='kontakt-info'> " + value.vorname +  " " + value.nachname + " </strong><br>";
                                            if(value.funktion) {
                                                res += "<strong class='kontakt-info text-overflow'> " +  value.funktion + " </strong><br>";
                                            }
                                        res += "</div>"
                                    + "</div>";

                                        if(value.telefon) {
                                            res += "  <i class='fa-solid fa-phone'></i> <a href='tel:" + value.telefon + "'>" + value.telefon +  "</a>";
                                        }
                                    
                                        if(value.email) {
                                            res += "<div class='row'><div class='col-lg-1'><i class='fa-solid fa-envelope'></i> </div> <div class='col-lg-10'><a class='text-overflow' href='mailto:" + value.email + "'> " + value.email +  " </a></div></div>";
                                        }

                                        res += "<div class='position-relative' style='bottom: 20px;'><div class='position-absolute top-0 end-0'><a data-kontakte='" + response.data[key].id + "' class='action-item fa-solid fa-trash text-danger button-kontakt-delete text-end' href='javascript:void(0);'></a> </div></div>";


                                res += "</div>"
                            + "</div>"
                        + "</div>";

                        $('#adressen-kontakte-card').html(res);
                    });

                }

                // Wenn es keine Daten gibt
                else {

                    // Meldung das noch keine Kontakte da sind
                    $('#adressen-kontakte-card').html("<div class='col'><div class='mt-lg-2 alert alert-soft-warning'>Es sind noch keine Kontakte hinterlegt</div></div>");

                }
            }
        );

    },

    // Funktion die das Modal verändert sobald es geöffnet wird
    changeModal() {

        var me = this;

        // Adressen ID Muss dynamisch hinzugefügt werden
       

    },

    // Dialog das Frage ob schnell hinzufügen oder neu Erstellen 
    addDialog() {

        var me = this;

        app.alert.question.fire({
            title: 'Schnell oder Neu?',
            text: 'Wollen Sie einen Kontakt aus den vorhanden Kontakten hinzufügen oder einen neuen Kontakt erstellen?',
            confirmButtonText: 'Schnell Hinzufügen',
            cancelButtonText: 'Abbrechen',
            denyButtonText: 'Neu Erstellen',
            showDenyButton: true,
            denyButtonColor: '#0000ff',
            // showCloseButton: true,
        }).then((result) => {

            // Wenn Schnell Hinzufügen 
            if(result.isConfirmed) {

                // Pickliste Modal Öffnen zum schnell hinzufügen von Kontakten
                me.personenPicklistModal.open();

            }

            // Wenn neu erstelle -- Abrechn
            else if(result.dismiss === Swal.DismissReason.deny) {

                // Zurück setzen alles
                me.personenModal.reset(1);

                // Öffne das Modal
                me.personenModal.open();

            }

        });

    },

    mehrAnzeigen() {
        var me = this; 

        // Toggler
        me.kontakte_ma.toggle();

        // Text ändert sich
        $('#kontakte-mehr-anzeigen-toggler').text(function(i, text){
            return text === "Mehr anzeigen" ? "Weniger anzeigen" : "Mehr anzeigen";
        });
       
    },

    // Reset Kontakte Modal
    resetKontakte() {

        // Kontake Mehr anzeigen - Details sollen verschwinden
        $('#kontakte-mehr-anzeigen').hide();

        // Kontakte Mehr anzeigen - Text wird wieder auf das Standard "Mehr anzeigen" zurückgesetzt
        $('#kontakte-mehr-anzeigen-toggler').text(function(i, text){
            return"Mehr anzeigen";
        });
    },

    toggleAktivieren() {
        var me = this; 

        switchStatus = $(this).is(':checked');
        // alert(switchStatus);

        // if(switchStatus == true) {
        //     $('#adressen-kunde-aktivieren').prop('checked', false);
        // } if(switchStatus == false) {
        //     $('#adressen-kunde-aktivieren').prop('checked', true);
        // }

        // var checkboxValue = $('input[name="ist_kunde"]').val();

        // console.log(checkboxValue);
    
        // app.alert.question.fire("Speichern!","Wollen Sie wirklich die Änderung speichern").then(result => {
        //     app.simpleRequest("kunde-aktivieren", "adressen-handle", checkboxValue, function() {

        //     }, false)
        // });
    }

}