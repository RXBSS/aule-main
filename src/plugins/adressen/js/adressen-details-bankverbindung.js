var ab =  {

    init: function() {

        var me = this; 

        // Additional Data wird der Pickliste übergeben zum Filtern damit nur die Spalten aus der Datenbank die zu dieser ID passen
        me.id = app.getUrlId();
        $('input[name=id]').val(me.id)

        // Standardmäßig soll der Loader Ausblendet sein
        $('#bankverbindung-laedt').hide();

        // Adressen ID muss abgespeichert werden, damit wird dann wieder der Filter benutzt
        $('input[name=adressen_id]').val(me.id)

        // Todo: Standardmäßig ausgeblendet Weil Handle Buttons wird nicht benutzt hier an der Stelle eigene Buttons
        $('.btn-bankverbindung-edit, .btn-bankverbindung-delete').hide();

        me.initModalForm();
       
        me.initPickliste();

        // AddEventListener
        me.addEventListener();
    }, 

    addEventListener() {
        var me = this; 

        // --------------------------------------------------------
        // Form Handler Buttons

        // Add New
        $('.btn-bankverbindung-add').on('click', function() {
            me.add();
        });

        // Edit
        $('.btn-bankverbindung-edit').on('click', function() {
            // Alle Inputs werden zurückgesetzt wenn es nicht erfolgreich war && Fehlermeldung löschen
            me.resetBankverbindung();

            me.edit();
        });

        // Delete
        $('.btn-bankverbindung-delete').on('click', function() {
            me.delete();
        });

        // Wenn die auf die Liste gedrückt wird - Show und Hide der HandleButtons
        me.list.container.on('click', function() {
            me.handleButtons();
        });

        // ------------------------------------------------------------
        // Form Eventlistener
        me.modal.container.find('input[name="iban_search"]').on('keyup', function() {
            

            me.ibanSearch($(this));
        });

        // Formular wird abgeschickt
        me.modal.container.on('submit', function() {
            me.submit();
        });
    },

    initPickliste() {
        var me = this;

        // Adressen Eigenschaften - Pickliste Bankverbindungen
        me.list = new Picklist('#bankverbindungen-pickliste', 'adressen_bankverbindung', {
            type: 'multi-picklist',
            card: false,
            submitButton: false,
            data: me.id,
            description: false, 
            lengthMenu: false,
            pagination: false, 
            search: false,                      
            buttons: false
        });
    },

    initModalForm() {
        var me = this; 

        // Adressen Eigenschaften - Modal Bankverbindugnen
        me.modal = new ModalForm('#adressen-bankverbindungen-form');

        // Validierung
        var fields = {
            iban: {
                validators: {
                    stringLength: {
                        min: 22,
                        message: 'Die IBAN muss min. 22 Zeichen haben'
                    }
                }
            },
            iban_search: {
                validators: {
                    stringLength: {
                        min: 22,
                        message: 'Die IBAN muss min. 22 Zeichen haben'
                    }
                }
            }
        }

        // Init Validierung
        me.modal.initValidation(fields);

    },


    // Funktion Helper IBAN SEARCH
    ibanSearch(el) {

        var me = this;

        // Iban werden alle Leerzeichen entfernt
        var searchString = el.val().trim().split(" ").join("");

        // Alle Leerzeichen entfernen
        el.val(searchString)

        // HTML Leeren
        $('.iban-gueltig').html('');

        // Alle Felder leeren sobald irgendwas gedrückt wird
        me.modal.container.find('.input-felder-bankverbindung input').val('');

        // Wenn die Länger kleiner als 22 ist dan alle Input Felder leeren
        if(el.val().length >= 22) {

            // Anzeigen das etwas Lädt
            $('#bankverbindung-laedt').show();

            // Funktion aufgerufen und Iban wird als Parameter übergeben
            me.neueBankverbindung(searchString);
        
        } 

       
    },

    // ein und Auschalten Validierung
    onOffValidation(bool) {


        var me = this;

        // Alle  Input Felder die es in dem Modal Bankverbindungen gibt
        me.bankverbindungObj = {
            'standard': ['iban', 'bic', 'bank']
        };

        // Geht Alle Felder durch
        $.each(me.bankverbindungObj, function(key, value) {

            // Schaltet die Validierung ab
            me.modal.fvInstanz.disableValidator(value);
        
        });

    },

    // Bankverbindung automatisch eintragen
    neueBankverbindung(iban) {

        var me = this; 

        // Nur wenn die Iban länger als 10 Zeichen sind dann wird eine Abfrage gestartet
        if(iban.length >= 22) {

            // me.modal.fvInstanz.disableValidator('iban_search');

            // Url die über den Proxy angesprochen werden soll
            var dataUrl = "https://openiban.com/validate/"+ iban +"?getBIC=true&validateBankCode=true";

            // Ajax Abfrage mit der URL gibt die Daten zurück
            app.simpleRequest("getIbanData", "adressen-bankverbindung-handle", dataUrl, function(response) {

                // Wenn die Abfrage erfolgreich war
                if(response.data.valid) {

                    // Es war Erfolgreich wieder ausblenden
                    $('#bankverbindung-laedt').hide();


                    // Alle Alerts Löschen
                    $('.iban-gueltig').empty();

                    // Erfolgsmeldung
                    $('.iban-gueltig').append(
                        '<div class="alert alert-success" role="alert">'
                        + '<i class="fa-solid fa-check"></i> Iban ist gültig'
                      + '</div>'
                    );

                    // me.modal.container.find('input[name="iban_search"]').disableValidator('iban_search')


                    // Inputfelder werden gefüllt mit den Daten die zurück gekommen sind
                    me.modal.container.find('input[name="iban"').val(response.data.iban);
                    me.modal.container.find('input[name="bic"').val(response.data.bankData.bic);
                    me.modal.container.find('input[name="bank"').val(response.data.bankData.name);
                    me.modal.container.find('input[name="plz"').val(response.data.bankData.zip);
                    me.modal.container.find('input[name="ort"').val(response.data.bankData.city);

                // Wenn die Abfrage nicht erfolgreich war
                } else {
                    
                    // Alle Inputs werden zurückgesetzt wenn es nicht erfolgreich war && Fehlermeldung löschen
                    me.resetBankverbindung();

                    // Es war Erfolgreich wieder ausblenden
                    $('#bankverbindung-laedt').hide();

                    // IBAN ist wirklich ungültig
                    if(iban.length >= 10) {

                        // Fehlermeldung
                        $('.iban-gueltig').append(
                            '<div class="alert alert-danger" role="alert">'
                            + '<i class="fa-solid fa-times"></i> Iban ist ungültig'
                        + '</div>'
                        );
                    }

                    // IBAN ist zu kurz
                    else if (iban.length < 10 ) {

                        // HTML Leeren
                        $('.iban-gueltig').html('');
                    }

                }

            }, function(xhr) {

                // Alle Inputs werden zurückgesetzt wenn es nicht erfolgreich war && Fehlermeldung löschen
                me.resetBankverbindung();

                // Es war Erfolgreich wieder ausblenden
                $('#bankverbindung-laedt').hide();

                // TODO: testen bei Fehler
                // IBAN ist wirklich ungültig
                if(iban.length >= 10) {

                    // Fehlermeldung
                    $('.iban-gueltig').append(
                        '<div class="alert alert-danger" role="alert">'
                        + '<i class="fa-solid fa-times"></i> Iban ist ungültig'
                    + '</div>'
                    );
                }

                // IBAN ist zu kurz
                else if (iban.length < 10 ) {

                    // HTML Leeren
                    $('.iban-gueltig').html('');
                }
            });
        } 
    },

    add() {
        var me = this; 

        // Reset der Inputs
        me.resetBankverbindung();

        // Input Iban Search löschen
        $('input[name="iban_search"]').val('');
            
        // Selected id wird auf 0 gesetzt damit ein neues erstellt werden kann - vlt. nicht die beste Lösung aber es geht
        me.selectedid = 0;
        me.modal.open();
    },

    resetBankverbindung() {

        var me = this;

        // Alle Alerts Löschen
        $('.iban-gueltig').empty();

        // Inputfelder werden alle geleert
        me.modal.container.find('input[name="iban"').val('');
        me.modal.container.find('input[name="bic"').val('');
        me.modal.container.find('input[name="bank"').val('');
        me.modal.container.find('input[name="plz"').val('');
        me.modal.container.find('input[name="ort"').val('');

    },

    edit() {

        var me = this; 

        // Prüfen ob eine Auswahl getroffen wurde oder nicht
        if(me.list.getSelectedLength() > 0) {

            // Alle Alerts Löschen
            $('.iban-gueltig').empty();

            // Id der ausgewählten Spalte
            me.selectedid = me.list.getSelectedColumn(1)[0];

            // Modal öffnet sich
            me.modal.open();

            // Modal wird geladen
            me.modal.load("load", "adressen-bankverbindung-handle", me.selectedid, function(response) {

                // TODO: Richtige Darstellung von Bank und Ort
                // Keine Gute Lösung weil manchmal einen längeren Namen hat
                // $('input[name="bank"]').val(response.data.bank.split(" ")[0]);
                // $('input[name="ort"]').val(response.data.bank.split(" ")[1]);
            } );

        } else {
            app.notify.error.fire("Keine Auswahl","Es wurde keine Auswahl getroffen!");
        }
    }, 

    delete() {

        var me = this;

        // Wenn eine Spalte Ausgewählt wurde
        if(me.list.getSelectedLength() > 0) {
            // Abfrage was alles gemacht werden soll
            app.alert.question.fire('Wollen Sie wirklich löschen?','Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                .then((result) => { 	        

                    // Wenn der Nutzer zustimmt
                    if(result.value) {

                        // Alle angewählten Ids auslesen
                        var ids = me.list.getSelectedColumn(1);

                        // Simple Request
                        app.simpleRequest("bv-delete", "adressen-bankverbindung-handle", ids, function(response) {

                            // Erfolgsmeldung
                            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
        
                            // List wird neu geladen
                            me.list.refresh(true);

                            // me.handleButtons();

                            // Seite neu Geladen - weil das Selected sonst Zwischen gespeichert wird und die anderen Aktionen nicht ausgeführt werden
                            // location.reload();
        
                        }, function(res) {
        
                            // Fehlermeldung
                            app.notify.error.fire("Nicht Erfolgreich","Ihr Aktion konnte nicht ausgeführt werden");
                        }
                        );
                    }
            });

        // Wenn keine Spalte ausgewählt wurde
        } else {
            app.notify.error.fire("Keine Auswahl","Es wurde keine Auswahl getroffen");
        }
    },

    submit() {

        var me = this;

        var id = me.list.getSelectedSingle()[1];

        // app.alert.question.fire("Abschicken!","Soll das Formular wirklich abgeschickt werden?").
        // then((result) => {

            // Aktion wird Ausgeführt
            // if (result.isConfirmed) {

                // Ajax Request
                me.modal.save('bv-submit', 'adressen-bankverbindung-handle', function(response) {

                    app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                    // List neu Laden
                    me.list.refresh();

                    // Alle Input Felder leeren
                    $('input[name="iban_search"]').val('');

                    // location.reload();

                }, null, {
                    id: me.selectedid
                });
              
            // Aktion wird abgebrochen
            // } else if (result.dismiss === Swal.DismissReason.cancel) {
                // app.notify.error.fire("Abbruch","Die Aktion wird auf Wunsch abgebrochen!");
            // }
        // });
    },

    // 
    handleButtons() {

        var me = this;

        // Wenn ein Auswahl getroffen wird
        if(me.list.getSelectedLength() > 0) {

            // Edit && Delete Button anzeigen
            $('.btn-bankverbindung-edit, .btn-bankverbindung-delete').show();
            
            // Add Button ausblenden
            $('.btn-bankverbindung-add').hide();

        // Wenn Keine Auswahl getroffen wurde
        } else {

            // Edit && Delete Button ausblenden
            $('.btn-bankverbindung-edit, .btn-bankverbindung-delete').hide();
            
            // Add Button anzeigen
            $('.btn-bankverbindung-add').show();

        }
    }
}