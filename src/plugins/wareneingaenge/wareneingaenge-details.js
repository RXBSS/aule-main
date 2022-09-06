var w = {


    // Initalisieren
    init() {

        var me = this;

        // Url Id
        me.id = app.getUrlId();

        // Wenn keine ID vorhanden ist
        if (!me.id) {
            app.redirect('wareneingaenge');
        }

        // Initalisieren
        me.initMainForm();
        me.initNewForm();
        me.initEditForm();
        me.initBestellliste();
        me.initLieferliste();

        // Add Listner
        me.addListner();


    },


    addListner() {

        var me = this;

        $('.wareneingang-manuell-hinzufuegen').on('click', function () {
            me.newForm.open();
        });

        // Bestellung importieren
        $('#btn-bestellung-importieren').on('click', function () {
            me.bestellliste.open();
        });

        $('.btn-save-and-next').on('click', function () {
            me.saveAndNext();
        });

        $('.btn-save-only').on('click', function () {
            me.saveOnly();
        });

        $('.btn-next-only').on('click', function () {
            me.nextOnly();
        });

        $('input[name=position-lieferung]').on('change', function () {
            var value = $(this).val();
            me.changeLieferStatus(value);
        });

        $('.btn-wareneingang-abschliessen').on('click', function () {
            me.jetztBeliefern();
        })

    },


    initMainForm() {
        var me = this;
        me.mainForm = new Form('#form-wareneingang');

        // Nur Lieferantn auswählen
        me.mainForm.qs.lieferant.filter = {
            field: 'ist_lieferant',
            value: 1
        }

    },


    initNewForm() {
        var me = this;
        me.newForm = new ModalForm('#form-new-position');
    },

    /**
     * Positionsform
     */
    initEditForm() {
        var me = this;

        // Form Element herstellen
        me.editForm = new Form('#form-edit-position');

        // Card festlegen
        me.cardContainer = me.editForm.container.closest(".card");


    },

    // Bestellliste initalisieren
    initBestellliste() {

        var me = this;

        // Bestellungen
        me.bestellliste = new PicklistModal("bestellungen", {
            type: 'single-picklist'
        });

        // Bestellung
        me.bestellliste.on('pick', function (el, data) {
            me.importOrder(data[1], data[2]);
        });
    },

    initLieferliste() {

        var me = this;

        // Lieferungen
        me.lieferliste = new Picklist("#pickliste-lieferungen", "wareneingaenge_lieferungen2", {

            type: 'single-picklist',
            card: false,
            search: true,
            pagination: false,
            buttons: false,
            lengthMenu: false,

            data: function () {

                // Rückgabe
                return {
                    auftrag: me.id
                }
            }
        });

        // On Select
        me.lieferliste.on('selection', function (el, value) {
            me.loadEditForm(value);
        });

    },



    /**
     * Bestellungen importieren
     * 
     * @param {Integer} bestellungId Die ID der Bestellung die integriert werden soll
     */
    importOrder(bestellungId, lieferant) {

        var me = this;

        // Bestellung importieren
        app.simpleRequest("bestellung-importieren", "wareneingaenge-handle", {

            lieferungId: me.id,
            bestellungId: bestellungId

            // Wenn die Bestellung importiert wurde
        }, function (response) {

            // Refresh
            me.lieferliste.refresh();

            $('input[name=lieferant]').val(lieferant).prop('disabled', true);

        });
    },

    // Bei einem Klick auf den Bereich
    loadEditForm(data) {

        var me = this;

        // TODO: Wenn es noch nicht abgespeichet wurde


        // Anzeige der Daten ändern
        me.cardContainer.find('.form-edit-artikel-id').html(data[2]);
        me.cardContainer.find('.form-edit-artikel-herstellernummer').html(data[3]);
        me.cardContainer.find('.form-edit-artikel-hersteller').html(data[4]);
        me.cardContainer.find('.form-edit-artikel-bezeichnung').html(data[5]);


        // Setze Feld
        me.editForm.setFieldData('position-lieferung', data[8]);
        me.editForm.setFieldData('liefermenge', data[10]);
        me.editForm.setFieldData('id', data[1]);
        
        
        
        me.editForm.container.find('input[name=liefermenge]').data('complete', data[9]);






        // me.generateSeriennummern(4);


        if (!data) {

            me.cardContainer.hide();

            $('#lieferung-einzel').hide();
        } else {
            me.cardContainer.show();
        }
    },

    saveAndNext() {
        var me = this;

        me.save(function() {
            me.next();
        });
    },

    saveOnly() {
        var me = this;
        me.save();
    },

    nextOnly() {
        var me = this;
        me.next(false);
    },


    save(callback) {

        var me = this;

        var data = me.editForm.getData();

        app.simpleRequest("position-buchen", "wareneingaenge-handle", data, function (response) {

            // Neu laden
            me.lieferliste.reload();

            if(typeof callback == 'function') {
                callback(true);
            }
        });
    },

    next(saved) {

        var me = this;

        // Aktuellen Index auslesen
        var index = me.lieferliste.getSelectedIndex()[0];

        // Alle Reihe Deselecten
        me.lieferliste.resetSelected();

        // Nächste Reihe selecten
        me.lieferliste.DataTable.row(index + 1).select();

        // Wenn alles Vollständig gebucht wurde
        if (!me.lieferliste.DataTable.row(index + 1)[0].length) {

        }
    },



    // 
    generateSeriennummern(amount, array) {

        var html = '';

        array = array || [];



        for (var i = 1; i < amount + 1; i++) {
            html += '<div class="col-md-6"><div class="form-group form-floating">' +
                '<input type="text" name="seriennummer' + i + '" data-format="uppercase" class="form-control editable more-readable" placeholder="Seriennummer ' + i + '" autocomplete="off" value="' + ((array[i - 1]) ? array[i - 1] : "") + '">' +
                '<label>Seriennummer ' + i + '</label>' +
                '</div></div>';
        }

        // HTML setzen
        $('#seriennummer-bereich').html(html);

    },


    changeLieferStatus(id) {

        if (id == 0) {
            $('input[name=liefermenge]').val('0,0').prop('disabled', true);
        } else if (id == 1) {
            $('input[name=liefermenge]').val('').prop('disabled', false).focus();
        } else if (id == 2) {
            $('input[name=liefermenge]').val($('input[name=liefermenge]').data('complete')).prop('disabled', true);
        }
    },

    // Jetzt beliefern
    jetztBeliefern() {

        var me = this;

        // Form vollständig
        // Seriennummern prüfen
        // - Alle ausgefüllt
        // - Dubletten


        // Abfrage des Benutzers
        app.alert.question.fire("Wareneingang abschließen!", "Die Ware wird damit gebucht. ").then(function (response) {

            // Prüfen ob der Benutzer bestätigt hat
            if (response.isConfirmed) {

                // Neue Abfrage zum Speichern
                app.simpleRequest("wareneingang-buchen", "wareneingaenge-handle", me.id, function (response) {

                    // Weiterleiten
                    app.redirect('wareneingaenge');
                });
            }
        });

    }



}






