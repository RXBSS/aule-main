/**
 * Diese Bereich kümmert sich um die Initalisierung und verwaltung des Adressen Bereichs. 
 * Dabei geht es um Rechnungs- und Lieferadresse initalisieren. 
 * 
 * Hierbei gibt es zum einen die Möglichkeit, Adressen neu anzulegen und zu editieren
 * 
 * 
 */
var detailHelperAdressen = {

    /**
     * Adressen initalisiern
     * 
     * 
     * 
     * 
     */
    initAdr: function () {

        var me = this;

        // Adressen JS HIER INIT -- Neu Erstellen
        me.initAdressen();

        // Adressen Pickliste
        me.initAdrPickliste();

        // Adressen Modal
        me.initAdrModal()

        // Event Listner hinzufügen
        me.addAdrListner();

        // Sezte LF Verfügbar, nach Checkbox
        me.adrSetLfAvaiable();

        // Auswahl nur auf Kunden 
        // me.form.qs['rechnungsanschrift_id'].setFilter("ist_kunde", "1");
        me.form.qs['lieferanschrift_id'].setFilter("ist_kunde", "1");

        // Warnmeldung für gesperrten Kunden ausblenden
        me.form.container.find('.adressen-details-kontosperre-warning').hide();
    },

    /**
     * 
     */
    addAdrListner: function () {

        var me = this;

        // ***************************************************************************************
        // Standard Events
        // ***************************************************************************************


        // Rechnungsadresse Action Buttons
        me.form.qs['rechnungsanschrift_id'].on('action', function (el, action, value) {
            switch (action) {
                case "add":
                    me.modalNeueAdresse.open();
                    break;
                case "edit":
                    me.adrEdit('rechnungsanschrift');
                    break;
                case "search":
                    me.picklistAdr.open();
                    break;

            }
        });

        // Lieferadresse Action Buttons
        me.form.qs['lieferanschrift_id'].on('action', function (el, action, value) {
            switch (action) {
                case "add":
                    me.modalNeueAdresse.open();
                    break;
                case "edit":
                    me.adrEdit('lieferanschrift');
                    break;
                case "search":
                    me.picklistAdr.open();
                    break;
            }
        });


        // ***************************************************************************************
        // Form Handler
        // ***************************************************************************************

        // Checkbox Rechnungsadresse = Lieferadresse
        me.form.getEl('lf_gleich_re').on('change', function () {
            me.adrSetLfAvaiable();
        });

        // Quickselect beim Auswählen einer Rechnungsadresse
        me.form.qs['rechnungsanschrift_id'].on('select2:select', function () {
            me.adrSet($(this).val(), 'rechnungsanschrift');
        });

        // Quickselect beim Auswählen einer Lieferadresse
        me.form.qs['lieferanschrift_id'].on('select2:select', function () {
            me.adrSet($(this).val(), 'lieferanschrift')
        });

        // Wenn neue Adresse Abgeschickt werden soll
        me.modalNeueAdresse.on('submit', function () {
            me.submitNeueAdresse();
        });

        // Init Modal
        me.modal.on('shown.bs.modal', function () {

            // Title für das Modal
            var adrTitle = (me.adressen == 'rechnungsanschrift') ? " Rechnungsadresse bearbeiten" : " Lieferadresse bearbeiten";

            me.modal.container.find('.modal-title').html('<i class="fas fa-plus"></i>' + adrTitle)

        });

        // Submit Modal
        me.modal.on('submit', function () {
            me.adrSubmit();
        });

    },

    /**
     * Init Modal Adressen
     */
    initAdrModal() {
        var me = this;
        me.modal = new ModalForm('#modal-adressen-form');
        me.modal.initValidation();
    },

    /**
     * 
     */
    initAdrPickliste() {

        var me = this;

        // Pickliste initalisieren
        me.picklistAdr = new PicklistModal("adressen", {
            type: 'single-picklist',
            quickPick: true,
            fixFilter: new PickFilter('ist_kunde', 1)
        });


        // Adressen on Pick
        me.picklistAdr.on('pick', function (el, data) {

            // Typ
            var type = $('#tab-content-adresse').find('.tab-pane.active').data('type');

            // Adressen
            me.adrSet(data[1], type);
        });
    },

    // Wenn eine neue Adresse erstellt werden soll über die Akquise
    submitNeueAdresse() {

        var me = this;

        // Optionen
        var options = {
            // 'modal': me.modalAddKunde,
        }

        // Open Dialog -- Abschicken der Ajax
        me.openDialog(options, function (response) {

            // Wenn Rechnugnsadrsse und Lieferadresse Identisch sind -- Beide überschreiben
            if ($('input[name="lf_gleich_re"]').prop('checked')) {

                me.adrSet(response.data, 'rechnungsanschrift');
                me.adrSet(response.data, 'lieferanschrift');

                // Ansonsten nur da setzen auf welcher Seite man sich befindet
            } else {

                me.adrSet(response.data, $('.btn-adresse.active').data('adresse'))

            }

        });

    },

    /**
     * Funktion zum Reset des Adressen Formulars
     */
    adrSchliessen() {

        var me = this;

        // Formular auf Standard zurücksetzen
        me.form.reset(0);

        // Input Disabled löschen
        $('#card-address input').removeClass('editable').attr('readonly', true);

        // Editieren Button Einblenden
        $('#adressen-details-bearbeiten').attr('data-status', '1').show();

        // Schließen und Speichern Button Ausblenden
        $('#adressen-details-speichern, #adressen-details-schliessen').attr('data-status', '2').hide();
    },

    /**
     * Funktion zum Speichern der Adressen
     */
    adrSubmit() {

        var me = this;

        // Save Funktion um das Modal zu Speichern
        me.modal.save('adr_d-submit', 'adressen-handle',

            // Success
            function (response) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // 
                me.adrSet(me.adrID, me.adressen);

            },

            // Error
            function (response) {
                app.notify.error.fire("Fehler", "Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Additonal
            {
                id: me.adrID
            }

        )

    },

    /**
     * Funktion zum Editieren der Adresse die dann direkt gespeichert wird 
     * 
     */
    adrEdit(source) {

        var me = this;

        // Nur Wenn eine Rechnungs oder Lieferadresse Ausgewählt wurde
        if ((source == 'rechnungsanschrift' && me.form.qs['rechnungsanschrift_id'].val() > 0) || (source == 'lieferanschrift' && me.form.qs['lieferanschrift_id'].val() > 0)) {

            // ID ist immer diejenige SELECT auf der das Tab sitzt
            me.adrID = (source == 'rechnungsanschrift') ? me.form.qs['rechnungsanschrift_id'].val() : me.form.qs['lieferanschrift_id'].val();

            // Modal Öffnen und Laden
            me.modal.loadAndOpen('load', 'adressen-handle', me.adrID, function (response) {

                // Set Select in Ländert
                var option = '<option value="' + response.data.land + '">' + response.data.land_text + '</option>'
                $('select[name=land]').html(option);
            })

        }

        // Keine Auswahl getroffen
        else {

            // Warnung - Keine Adresse
            app.notify.warning.fire("Keine Auswahl getroffen", "Sie müssen eine Auswahl der Adresse treffen, bevor Sie bearbeiten können!");
        }

        //

    },

    /**
     * Adresse setzen
     * 
     * @param {Number} id ID der Adresse
     * @param {String} type Der Typ `rechnungsanschrift` oder `lieferanschrift`
     */
    adrSet(id, type) {

        var me = this;

        // Ausblenden
        me.form.container.find('.adressen-details-kontosperre-warning').hide();

        // Daten per API abfragen
        app.simpleRequest("get-adresse", "vertraege-handle.php", id, function (result) {

            // Wenn der Kunde Gesperrt ist - Warnmeldung einblenden
            if (result.data.kunde_gesperrt == 1) {
                me.form.container.find('.adressen-details-kontosperre-warning').show();
            }

            // Daten für den entsprechenden Typ setzen
            me.form.qs[type + '_id'].setData(id, result.data.name);
            me.form.getEl(type + '_strasse').val(result.data.strasse);
            me.form.getEl(type + '_plz').val(result.data.plz);
            me.form.getEl(type + '_ort').val(result.data.ort);
            me.form.getEl(type + '_land').val(result.data.land);

            // Wenn die Adressen identisch sind, auch die Lieferadresse setzen
            if (me.adrCheckLfAndReIdentical() && type == 'rechnungsanschrift') {
                me.form.qs['lieferanschrift_id'].setData(id, result.data.name)

                // Daten setzen
                me.form.setSomeData({
                    lieferanschrift_strasse: result.data.strasse,
                    lieferanschrift_plz: result.data.plz,
                    lieferanschrift_ort: result.data.ort,
                    lieferanschrift_land: result.data.land,
                });
            }
        });
    },

    /**
     * Prüft ob die Rechnungsadresse und die Lieferadresse gleich sind (Checkbox)
     * @returns {Boolean} Rückgabewert
     */
    adrCheckLfAndReIdentical() {

        var me = this;
        var result = me.form.container.find('input[name=lf_gleich_re]').prop('checked');
        return result;
    },

    /**
     * Setzt die GUI für Eingabe und Änderung der Adresse
     * ALT setLfAvailible
     */
    adrSetLfAvaiable() {

        var me = this;

        // Lieferadresse = Rechnungsadresse
        if (me.adrCheckLfAndReIdentical()) {

            // Info Feld ausblenden
            me.form.container.find('.adressen-details-seperate-lieferadresse').hide();

            // Feld deaktivieren
            me.form.setFieldReadonly('lieferanschrift_id', true);

            // ID auslesen
            var id = me.form.qs['rechnungsanschrift_id'].val();

            // Wenn eine ID vorhanden ist
            if (id) {
                me.adrSet(id, 'lieferanschrift');
            } else {
                me.form.qs['lieferanschrift_id'].reset();
            }

            // Lieferadresse != Rechnungsadresse
        } else {

            // Anzeige setzen
            me.form.container.find('.adressen-details-seperate-lieferadresse').show();

            // Felder leeren
            me.form.setFieldReadonly('lieferanschrift_id', false);
            me.form.qs['lieferanschrift_id'].reset();

            // Felder leeren
            me.form.setFieldData(['lieferanschrift_strasse', 'lieferanschrift_plz', 'lieferanschrift_ort', 'lieferanschrift_land'], "");
        }
    },

    adrReadonly(readonly) {
        var me = this;

        var action = (!readonly) ? 'removeClass' : 'addClass';

        // Klasse hinzufügen oder entfernen
        $('#adressen-details-erstellen')[action]('disabled')
        $('#adressen-details-bearbeiten')[action]('disabled')
        $('#adressen-details-suchen')[action]('disabled')
    }

}