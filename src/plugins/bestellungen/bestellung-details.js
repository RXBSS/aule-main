// Auftrag
var b = {

    // Konstanten
    form: false,


    init: function () {

        var me = this;

        // Id zurückgeben
        me.id = app.getUrlId();

        // Selected Bestellpos
        me.selectedBestellPos = false;

        // Id
        if (me.id) {

            // Daten laden
            app.simpleRequest("load", "bestellungen-handle", me.id, function (response) {

                // Initalisieren
                me.initForm();

                // Positionen initalisieren
                me.initPos();

                // Abschicken initalisieren
                me.initAbschicken();


                // Status
                me.changeStatus(response.data.status_id);                
                
                // Loader anhalten
                app.wrapperLoader.stop();

                // Card Sizer
                new CardSizer(['#card-lieferant', '#status-1', '#status-2']);

                // Event Listner hinzufügen
                me.addListner();
            });


            // Fehlermeldung ausgeben
        } else {
            app.alert.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte kontaktieren Sie den Administrator!").then(function () {
                app.redirect('bestellungen');
            })
        }
    },

    // Status setzen
    changeStatus(status) {
         
        var me = this;

        // Auftrag Info oben setzen
        $('.detail-status').hide();
        $('.detail-status[data-status="' + status + '"]').show();

        console.log(status);

        if(status > 1) {
            me.form.setReadonly(true);
        }


    },


    initForm() {

        var me = this;

        // Neue Form
        me.form = new Form('#form-bestellung');

        // Form Validation aktivieren
        me.form.initValidation();

        // Form laden
        me.form.load("load", "bestellungen-handle", me.id);

        // Activation Input Liefertermin
        new ActivationInput('#hat_liefertermin', 'input[name=liefertermin]', me.form);

    },

    /**
     * Die Pickliste für die Adressen
     */
    initpicklistAdressen() {

        var me = this;

        // Rechnungsadresse
        me.picklistAdressen = new PicklistModal("adressen", {
            type: 'single-picklist',
            quickPick: true
        });

        // On Pick
        me.picklistAdressen.on('pick', function (el, data) {
            console.log(data);
        });
    },

    initAbschicken() {

        var me = this;

        // Abschicken
        me.abschicken = new ModalForm('#form-bestellung-abschicken');

        var fields = {
            'methode': {
                validators: {
                    notEmpty: {
                        message: 'Bitte vollständig ausfüllen',
                    },
                }
            }
        }

        // Validierung
        me.abschicken.initValidation(fields);

        // Abschicken
        me.abschicken.on('submit', function () {
            me.abschicken.save('abschicken', 'bestellungen-handle', function () {
                app.notify.success.fire("Erfolgreich", "Die Bestellung wurde erfolgreich versendet!");
                me.abschicken.close();
                me.changeStatus(2);
            }, null, {
                id: me.id
            });
        });

        // Erstmaliges Handlen
        me.handleBestellungAbschickenMethode();
    },


    // Event Listner
    addListner() {

        var me = this;

        // Quickselect beim Auswählen einer Rechnungsadresse
        me.form.qs['lieferant'].on('select2:select', function () {
            me.setAddress($(this).val());
        });

        // Speichern
        $('.btn-entwurf-speichern').on('click', function () {
            me.entwurfSpeichern();
        });

        // Löschen
        $('.btn-entwurf-loeschen').on('click', function () {
            me.entwurfLoeschen();
        });

        // Anzeigen - Preview
        $('.btn-entwurf-preview').on('click', function () {
            app.showDocument(me.id, 'be', true);
        });

        // Anzeigen - Original
        $('.btn-anzeigen').on('click', function () {
            app.showDocument(me.id, 'be', false);
        });

        // Abschicken
        $('.btn-bestellung-abschicken').on('click', function () {
            me.prepareAbschicken();
        });



        // Neuen Wareneingang
        $('.btn-wareneingang').on('click', function () {
            app.notify.success.fire("TODO", "Startet einen neuen Wareneingang");
        });

        // Stornieren
        $('.btn-stornieren').on('click', function () {
            app.notify.success.fire("TODO", "Kann eine Bestellung stornieren lassen");
        });



        // Wenn die Methode geändert wird
        $('input[name=methode]').on('change', function () {
            me.handleBestellungAbschickenMethode();
        });

        // Hotkeys
        hotkeys('ctrl+h', function (event, handler) {
            event.preventDefault();
            $('#timeline-container').toggleClass('open');
        });

        hotkeys('ctrl+s', function (event, handler) {
            event.preventDefault();
            me.entwurfSpeichern();
        });

        hotkeys('ctrl+enter', function (event, handler) {
            event.preventDefault();
            me.prepareAbschicken();
        });
    },


    // Adresse setzen
    setAddress(id) {

        var me = this;

        var type = "lieferant";

        // Daten per API abfragen
        app.simpleRequest("get-adresse", "auftraege-handle.php", id, function (result) {

            // Daten für den entsprechenden Typ setzen
            me.form.container.find('input[name=' + type + '_name]').val(result.data.name);
            me.form.container.find('input[name=' + type + '_strasse]').val(result.data.strasse);
            me.form.container.find('input[name=' + type + '_plz]').val(result.data.plz);
            me.form.container.find('input[name=' + type + '_ort]').val(result.data.ort);
            me.form.container.find('input[name=' + type + '_land]').val(result.data.land);
        });
    },


    entwurfSpeichern() {

        var me = this;

        // Speichern
        me.form.fvInstanz.validate().then(function (status) {
            if (status == 'Valid') {

                // Speichern
                me.form.save('entwurf-speichern', 'bestellungen-handle', function (response) {

                    // Zurücksetzen der Form
                    me.form.reset(2);

                    // Wenn es einen Custom Callback gibt
                    if (typeof callback == 'function') {
                        callback();
                        // Falls nicht
                    } else {
                        app.notify.success.fire("Gespeichert", "Der Entwurf wurde erfolgreich gespeichert");
                    }

                    // Wenn das Speichern fehlschlägt
                }, null, {
                    id: me.id
                });
            }
        });
    },

    entwurfLoeschen() {
        var me = this;

        app.alert.question.fire("Bestellung Entwurf Löschen?", "Wollen Sie den Bestell-Entwurf wirklich löschen. Dann bestätigen Sie diese Meldung mit Ja.").then(function (data) {

            if (data.isConfirmed) {

                // Loader aktivieren
                app.alert.loader.fire();

                // Auftrag löschen
                app.simpleRequest("entwurf-loeschen", "bestellungen-handle", me.id, function (data) {

                    // Löschen
                    app.alert.error.fire("Löschen", "Der Auftrag wurde gelöscht!").then(function () {
                        app.redirect('bestellungen');
                    });
                });
            }
        });
    },

    initHistory() {


        // Beispiel Datensatz
        var dataSet = [{
            'timestamp': '2021-05-06 10:20:00',
            'icon': 'fa-solid fa-plus',
            'content': 'Entwurf erstellt'
        }, {
            'timestamp': '2021-05-06 11:20:00',
            'icon': 'fa-solid fa-paper-plane',
            'content': 'Bestellung an den Lieferanten versendet'
        }];

        // Erstellen
        var timeline = new Timeline('#timeline');

        // Daten setzen
        timeline.setData(dataSet.reverse());

        // Write Data
        timeline.render();
    },


    // Vorbereiten
    prepareAbschicken() {

        var me = this;

        app.notify.loader.fire();

        // 
        app.simpleRequest('prepare', 'bestellungen-handle', me.id, function (response) {
            app.notify.loader.close();

            me.abschicken.open();
            me.abschicken.setData({
                methode: response.data.lieferant_bestellung_art,
                email: response.data.lieferant_bestellung_email,
            }, false, true);

            me.handleBestellungAbschickenMethode();
        });


        // TODO: E-Mail Feld ausblenden
        // TODO: Bevorzugte Übertragungsmethode für den Lieferanten aus der Datenbank wählen
        // TODO, hier muss gespeichert werden!


    },

    handleBestellungAbschickenMethode() {

        var me = this;

        var method = me.abschicken.container.find('input[name=methode]:checked').val();

        //  
        if (typeof method != 'undefined' && method == 3) {
            me.abschicken.container.find('input[name=email]').parent().show();
            me.abschicken.fvInstanz.enableValidator('email');

        } else {
            me.abschicken.container.find('input[name=email]').parent().hide();
            me.abschicken.fvInstanz.disableValidator('email');
        }
    },
};

// Zusammenführen
b = Object.assign(b, pos);