

/**
 * Alle Funktionen die nur für die Positionen der Verträge geschriben sind
 * 
 */

var v_Pos = {


    // Init Positionen
    initVertraegePos() {

        var me = this;

        // Standardmäßig Hide
        $('#card-positionen-vertraege').hide();

        // Init Picklsite
        me.initPicklistePos();

        // Init Form
        me.initFormPos();

        // Positionsliste
        // me.initPositionsListe("vertraege_positionen");

        // // Artikelliste hinzufügen
        // me.initArtikelListe();

        // // Position Form
        // me.initPositionForm();

        // // Event Listner hinzufügen
        // me.addPosListner();

        // Add Event Listner
        me.addEventListenerPos2();


    },

    // Init Modal Positionen
    initFormPos() {

        var me = this;

        // 
        me.formPositionen = new CardForm('#form-positionen-artikel');
        me.formPositionen.initValidation();

    },

    initPicklistePos() {

        var me = this;

        // Postitionen anpassen
        me.positionList = new Picklist("#pickliste-positionen", 'vertraege_positionen', {
            type: 'multi-picklist',
            autoDeselect: false,
            card: false,
            // search: false,
            // pagination: false,
            lengthMenu: false,
            addHandleButtons: true,
            // buttons: false,
            data: me.id
        });

        // Postitionen anpassen
        me.identList = new PicklistModal("ident", {
            type: 'multi-picklist',
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'vertraege_positionen',
                    field: 'ident_id',
                    filter: {
                        vertrags_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            },
        });

    },

    addEventListenerPos2() {

        var me = this;

        // Wenn eine neue Position hinzugefügt werden soll
        me.positionList.container.on('click', '[data-action="add"]', function () {
            me.identList.open();
        });

        // Wenn eine Position gelöscht werden soll
        me.positionList.container.on('click', '[data-action="delete"]', function () {
            me.deletePositionen();
        });

        // Wenn eine Auswahl getroffen wurde soll das Edit verschwinden weil wir eine eigene Form dafür bauen
        me.positionList.on('selection', function () {
            me.positionList.container.find('a[data-action="edit"]').hide();

            // Wenn Nur eine Auswahl getroffen wurde dann Zeige dir Card an ansonsten nicht
            if (me.positionList.getSelectedLength() == 1) {
                $('#card-positionen-vertraege').show();

                me.loadPositionenCard();
            } else {
                $('#card-positionen-vertraege').hide();
                me.formPositionen.reset(1)
            }

        });

        // Wenn die Form abgeschickt wird
        me.formPositionen.on('submit', function () {
            me.submitPositionenForm();
        });

        // Wenn eine Auswahl in der Artikel Modal Liste getroffen wurde
        me.identList.on('pick', function (el, data) {
            me.addPositionenToList();
        });

        // Wennn die Form Editert wird
        me.formPositionen.container.on('click', '.btn-form-edit', function () {
            me.formPositionen.container.find('input').attr('disabled', false);
            me.formPositionen.container.find('input[name="bezeichnung"]').attr('disabled', true);
        })

        // Wenn die Form beendet wird
        me.formPositionen.on('end', function () {
            me.formPositionen.container.find('input').attr('disabled', true);
            me.formPositionen.setData(me.formPositionenData);
        });
    },

    // Formular wird abgeschickt
    submitPositionenForm() {

        var me = this;

        var positionenID = me.formPositionen.container.find('input[name="positionenID"]').val();

        // Save Funktion 
        me.formPositionen.save('submitPositionenForm', "vertraege-handle",

            // Success
            function (res) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                me.positionList.refresh();

                // Neu Laden der Form
                me.loadPositionenCard();
            },

            false,

            // Additional
            {
                id: positionenID
            }

        )

    },

    // Löscht Positionen
    deletePositionen() {

        var me = this;

        // Abfrage was alles gemacht werden soll
        app.alert.question.fire('Wollen Sie wirklich löschen?', 'Dieser Vorgang kann nicht Rückgängig gemacht werden!')
            .then((result) => {

                // Wenn der Nutzer zustimmt
                if (result.value) {

                    // Alle angewählten Ids auslesen
                    var ids = me.positionList.getSelectedColumn(1);

                    // Simple Request
                    app.simpleRequest('deletePositionen', 'vertraege-handle', ids, function () {
                        app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                        // PickListe wird automatisch neu geladen
                        me.positionList.refresh(true);
                        me.identList.refresh(true);

                    });
                }
            });

    },


    // Fügt eine Neue Artikel Positione hinzu (In Zukunft noch mehr)
    addPositionenToList() {

        var me = this;

        // id der Ausgewählten Zeile
        var ident_id = me.identList.getSelectedColumn(1);

        var additional = {
            'id': me.id,
            'ident_id': ident_id
        }

        // Artikel Hinzufüge mit Ajax
        app.simpleRequest("submitPositionenIdent", "vertraege-handle", additional,
            function (response) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                me.positionList.refresh(true);
                me.identList.refresh(true);

            }
        );

    },

    // Lädt die Positionen der Artikel
    loadPositionenCard() {

        var me = this;

        // Der Ausgewählte Position
        var idPos = me.positionList.getSelectedColumn(1)[0];

        // Lädt die Karte
        me.formPositionen.load('getPositionen', "vertraege-handle", idPos, function (response) {

            me.setPosData(response);

            // Pauschale in Positionen Ein und Auschalten
            me.hideAndShowPosPauschale();
        });
    },

    // Manipuliert die GUI mit der Rückgabe der Datenbank
    setPosData(response) {

        var me = this;

        // HTML DOM Leeren
        $('#positionen-form-creator').html('')

        var formPos = new FormCreator();

        $.each(response.data, function (key, value) {

            me.formPositionen.container.find('input[name="bezeichnung"]').val(value.artikelBezeichnung);
            me.formPositionen.container.find('input[name="beschreibung"]').val(value.beschreibung);
            me.formPositionen.container.find('input[name="positionenID"]').val(value.id);

            // Wenn es Pauschale Gibt
            if (value.pauschale) {
                me.formPositionen.container.find('input[name="pauschale"]').val(me.turnintoGermanFormat(value.pauschale));
            }


            // Wenn es Einheitliche Preise gibt sollen Keine Neuen Inputs erstellt werden mit dem Formcreator
            if (!me.formKosten.getData()['zaehler_einheitlich']['checked']) {

                var zaehlerPauschale = "";

                // Wenn es einen Zähler gibt
                if (value.zaehlerPauschale) {
                    zaehlerPauschale = value.zaehlerPauschale.toLocaleString('de-DE', { minimumFractionDigits: 2 });
                }

                var newInput = formPos.createInput('number', "zaehler-" + value.zaehler_id, value.zaehlerBezeichnung, zaehlerPauschale);

                $('#positionen-form-creator').append(newInput)

            }


        });

        me.formPositionenData = me.formPositionen.getData();

        // Alle Auf Disabled Setzen
        me.formPositionen.container.find('input').attr('disabled', true);

    },

    // Blendet die Pauschale der Positionen Ein und Aus
    hideAndShowPosPauschale() {

        var me = this;

        // Wenn bei den FormKosten es keine Pauschale gibt dann soll es nicht möglich sein eine Pauschale hinzuzufügen oder wenn ein gesamt Pauschale hinzugefügt wird dann soll es auch nicht gehn
        if (!me.formKosten.container.find('input[id="pauschale"]').prop('checked') || me.formKosten.container.find('input[id="gesamtpauschale"]').prop('checked')) {
            me.formPositionen.container.find('#pauschale-positionen').hide();
        } else {
            me.formPositionen.container.find('#pauschale-positionen').show();
        }

    },

    // Wechselt in das Deutsch Komma System die Zahen 
    turnintoGermanFormat(number) {

        number = new Intl.NumberFormat('de-DE', { minimumFractionDigits: 2 }).format(number)

        return number;

    },


    // *************************************************************************************
    // *************************************************************************************
    // Alte Funktionen
    // *************************************************************************************
    // *************************************************************************************

    initPositionsListe(name) {

        var me = this;

        // Postitionen anpassen
        me.positionList = new Picklist("#pickliste-positionen", name, {
            type: 'multi-picklist',
            card: false,
            search: false,
            pagination: false,
            lengthMenu: false,
            buttons: false,
            data: me.id
        });

        // Wenn vollständig initalisiert ist
        me.positionList.on('initComplete', function () {

            // Kalkulation durchführen
            // me.calculateTotal();

            // Handle Funktionen die zum Start geladen werden sollen
            me.handlePositionSelection();
        });

        // Selection
        me.positionList.on('selection', function () {
            me.handlePositionSelection();
        });
    },



    initPositionForm() {

        var me = this;

        // Form initalisieren
        me.positionForm = new Form('#form-position');

        // Form Validation aktivieren
        me.positionForm.initValidation();

        /*
        // Rabatt Aktiv
        new cbConnect(me.positionForm.container.find('input[name="rabatt_aktiv"]'), {
            fieldClass: '.rabatt-is-active',
            form: me.positionForm
        });
    
        */
    },

    // Events nur auf der Vertrag Seite
    addEventListenerPos() {

        var me = this;

        // Form 
        me.positionForm.container.on('click', '.btn-positionen-speichern', function () {
            me.positionForm.fvInstanz.validate().then(function (status) {
                me.positionEditieren(status);
            });
        });

    },


    // Position Editieren
    positionEditieren(status) {

        var me = this;

        // Wenn der Status Valid ist
        if (status == 'Valid') {

            // Get Data für Additional
            var data = {
                data: me.positionForm.getData(),
                id: me.posId[0]
            }

            // Akax
            app.simpleRequest("positionen-editieren", me.handler, data, function (response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Liste neu Laden
                me.positionList.refresh(true);
            });

        }

    },

    // Überschreiben der Funktion damit keine Fehler auftreten
    addField(name, selector) {

    },

    /**
     * 
     */
    handlePositionSelection() {

        var me = this;

        // Aktuelle ausgewählte
        var result = me.handlePositionSelectionDefault();

        // Entscheiden nach Status
        switch (me.status) {

            // Entwurf
            case 1:

                if (result) {
                    $('.btn-pos-shift, .btn-pos-delete').show();

                    // Wenn etwas gewählt ist
                    me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                    me.positionForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();

                    // Laden
                    me.loadPositionForm(result);
                }

                break;
        }
    },


    /**
     * Laden einer Position
     * @param {*} posId 
    */
    loadPositionForm(posId) {

        // multiple
        var me = this;

        // Positions ID als Array
        posId = (Array.isArray(posId)) ? posId : [posId];

        // Globale Variable
        me.posId = posId;

        // Wenn es nur eine Positoin ist
        if (posId.length == 1) {

            // Rahmen wieder zurücksetzen
            me.positionForm.container.closest('.col-selector').find('.card').css({ 'border': '0px' });
            me.positionForm.container.find('#form-multi-artikel-warning').hide();

            me.positionForm.load('positionen-load', me.handler, posId[0], function (response) {

                // Werte setzen
                // me.verbund.setValue('menge', parseFloat(response.data.menge));
                // me.verbund.setValue('ek', parseFloat(response.data.ek));
                // me.verbund.setValue('vk', parseFloat(response.data.vk));
                // me.verbund.calculate('vk', app.formatter.formatWaehrung(parseFloat(response.data.vk)));

                // // Form Daten erneuern
                // me.positionForm.renewInitFormData();

            });


            // Zurücksetzen
        } else {
            me.positionForm.reset(1);

            // Rahmen setzen
            me.positionForm.container.closest('.col-selector').find('.card').css({ 'border': '1px solid #c0392b' });
            me.positionForm.container.find('#form-multi-artikel-warning').show();
        }

        // Positions Id eintragen
        me.positionForm.container.find('input[name=id]').val(posId);
    },



    // Event Listener Positionen
    // addEventListenerPos() {

    // var me = this;

    // ********************************************************************************
    // Stanard Events
    // ********************************************************************************


    // Wenn die Position Editiert werden soll und Gespeichert wird
    // $('#btn-positionen-edit').on('click', function() {
    //     me.submitPos();
    // }); 


    // ********************************************************************************
    // Form Handler Events
    // ********************************************************************************


    // Wenn Pickliste eine Auswahl getroffen wird
    // me.list.on('selection', function(el, data) {
    //     me.handleVertraegePositionen();
    // });
    // },

    // Submit Funktion um die Position zu verändern
    submitPos() {

        var me = this;

    },

    // Wenn Pickliste eine Auswahl getroffen wurde
    // handleVertraegePositionen() {

    //     var me = this;

    //     var id =  me.list.getSelectedColumn(1);

    //     // Nur wenn es eine ID gibt
    //     if(id.length == '1') {

    //         // Ajax
    //         app.simpleRequest("getPos", "vertraege-handle", id, 

    //             function(response) {
    //                 console.log(response);

    //                 // Datein die Ausgelesen wurde eintragen
    //                 $('#vertrags_pos_edit').find('input[name="beschreibung"]').val(response.data.beschreibung);
    //                 $('#vertrags_pos_edit').find('input[name="pauschale"]').val(response.data.pauschale);

    //                 // Editieren Karten Anzeigen
    //                 $('.col-card-edit').show();

    //                 // Nur Noch bisschen Teilen auf COL-8
    //                 $('.col-pos-list').removeClass('col').addClass('col-md-8');

    //             },

    //             // Error
    //             function(xhr) {
    //                 app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
    //             }

    //         );
    //     }

    //     // Reset der Input Felder 
    //     else {

    //         // Reset
    //         $('#vertrags_pos_edit').find('input').val('');

    //         // Editieren Karten Ausblenden
    //         $('.col-card-edit').hide();

    //         // Positionen auf vollbreite
    //         $('.col-pos-list').removeClass('col-md-8').addClass('col');

    //     }


    // },

}