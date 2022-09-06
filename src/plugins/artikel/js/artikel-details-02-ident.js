/**
 * Alles für den Ident Bereich
 * - 
 * 
 * 
 */
var artikelIdent = {

    /**
     * Init Ident
     */
    initIdent() {

        var me = this;

        me.initIdentForm();

        // Karten aktivieren
        me.initIdentCards();

        // Zähler Picklisten (Artikel Zähler und Auswahl Zähler)
        me.initZaehlerPicklists();

        // Event Listner hinzufügen
        me.addIdentListner();

    },


    initIdentForm() {

        var me = this;

        // Neue Form
        me.identForm = new CardForm('#artikel-ident');

        var fields = {
            zaehler: {
                validators: {
                    callback: {
                        message: 'Bitte mindestens eine Zähler angeben',
                        callback: function () {
                            return (me.identForm.getFieldData('zaehler').checked && me.artikelZaehlerPicklist.getRowCount() == 0) ? false : true;
                        },
                    }
                }
            }
        };

        // Validierung aktivieren
        me.identForm.initValidation(fields);

        // TODO: Muss noch dynamisch passieren!
        me.identForm.qs['software_name'].setFilter('hersteller_id', 1, null, 'Für diesen Hersteller wurde keine Software angelegt');

        // Installation Radio
        me.installationRadio = new ActivationMulti(me.identForm.find('ident_typ_id'), '.ident-typ-id-elements', me.identForm);

        // Laden
        me.identForm.load('ident-load', 'artikel-handle.php', me.id, function (response) {
            console.log(response);
        });

        me.identForm.on('initComplete', function () {
            me.artikelZaehlerPicklist.setReadonly(true);
        });

        // Auf jede Änderung der Form reagieren und weitergeben
        me.identForm.on('readonly', function (el, readonly) {
            me.artikelZaehlerPicklist.setReadonly(readonly);
        });

        // Ident Form
        me.identForm.on('submit', function () {

            console.log(me.identForm.getData());

            // Ident speichern
            me.identForm.save('ident-save', 'artikel-handle', function () {

            }, null, {
                id: me.id
            });
        });
    },


    initZaehlerPicklists() {

        var me = this;

        // Artikel Zähler Pickliste
        me.artikelZaehlerPicklist = new Picklist("#pickliste-zaehler", "artikel_zaehler", {
            type: 'simple',
            select: 'multi',
            autoDeselect: true,
            card: false,
            pagination: false,
            filter: new PickFilter("artikel_id", me.id)
        });

        // Wenn es vollständig ist
        me.artikelZaehlerPicklist.on('dtInitComplete', function () {

            me.checkZaehlerTable();

            // Draw Event
            me.artikelZaehlerPicklist.DataTable.on('draw', function (a, b) {
                me.checkZaehlerTable();
            });
        });

        // Draw Event für Revalidierung
        me.artikelZaehlerPicklist.on('draw', function() {
            me.identForm.fvInstanz.revalidateField('zaehler');
        });

        // Zähler Auswahl Picklist
        me.zaehlerPicklist = new PicklistModal("zaehler", {
            type: 'multi-picklist',
            autoDeselect: false,

            // Bereits ausgewählte
            disabled: {
                query: {
                    table: 'artikel_zaehler',
                    field: 'zaehler_id',
                    filter: {
                        artikel_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            }
        });

        // On Pickl
        me.zaehlerPicklist.on('pick', function () {
            me.addZaehler();
        });


    },

    checkZaehlerTable() {

        var me = this;

        if (me.artikelZaehlerPicklist.getRowCount() > 0) {
            me.artikelZaehlerPicklist.container.show();
            $('.action-add-zaehler-large').hide();
        } else {
            me.artikelZaehlerPicklist.container.hide();
            $('.action-add-zaehler-large').show();
        }
    },


    initIdentCards() {
        var me = this;

        // Karten aktivieren
        me.identCardFirmware = new ActivationCard('#software-firmware-card');
        me.identCardGarantie = new ActivationCard('#garantie-card');
        me.identCardZaehler = new ActivationCard('#zaehler-card');

        // Form hinzufügen
        me.identCardFirmware.addForm(me.identForm);
        me.identCardGarantie.addForm(me.identForm);
        me.identCardZaehler.addForm(me.identForm);

    },

    /**
     * Event Listner
     */
    addIdentListner() {

        var me = this;

        console.log()

        // Container
        me.identForm.container.on('click', '.action-add-zaehler', function () {
            me.zaehlerPicklist.open();
        });

        // Container
        me.identForm.container.on('click', '.action-delete-zaehler', function () {
            me.deleteZaehler();
        });
    },

    /**
     * Zähler hinzufügen
     */
    addZaehler() {

        var me = this;

        // Ausgewählte Zähler Ids
        var selected = me.zaehlerPicklist.getSelectedColumn('id');

        // Ajax Call
        app.simpleRequest("add-zaehler", "artikel-handle", {
            id: me.id,
            zaehler: selected

            // Erfolgreich
        }, function (response) {

            // Liste aktualisieren
            me.artikelZaehlerPicklist.refresh();
            me.zaehlerPicklist.refresh();

        });
    },

    /**
     * Zähler löschen
     */
    deleteZaehler() {

        var me = this;

        // Ausgewählte Zähler
        var selected = me.artikelZaehlerPicklist.getSelectedColumn('id');

        // Wenn etwas ausgewählt wurde
        if (selected) {

            // Ajax Call
            app.simpleRequest("remove-zaehler", "artikel-handle", {
                id: me.id,
                zaehler: selected
            }, function (response) {
                me.artikelZaehlerPicklist.refresh();
                me.zaehlerPicklist.refresh();
            });

            // Wenn nichts ausgewählt wurde
        } else {
            app.notify.error.fire("Fehler", "Bitte wählen Sie einen Zähler aus, der gelöscht werden soll!");
        }
    }


}   
