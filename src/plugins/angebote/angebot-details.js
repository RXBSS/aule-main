var ag = {

    init() {

        var me = this;

        // Id aus der $_GET Variable lesen
        me.id = app.getUrlId();

        // Die Datei in der alle Standard-Abfrage verarbeitet werden
        me.handler = "angebote-handle";

        // Initalisieren des Status
        me.status = 0;
        me.subStatus = 0;

        // Id
        if (me.id) {

            // Init Form
            me.initForm();

            // Daten auslesen
            me.getData(function (response) {

                // Initalisieren
                me.initAdr();
                me.initPos();

                // Init Erstellen
                me.initErstellen();

                // Status ändern
                me.changeStatus(response.data.status_id);

                // Event Listner
                me.addListner();

                // Card Sizer aktivieren
                new CardSizer(['#card-address', '#card-form', '#status-1', '#status-2']);

            }, "angebote");
        } else {

            // Fehler beim Laden
            me.loadingError("Das Angebot wurde nicht gefunden!", "angebote");
        }
    },

    addListner: function () {

        var me = this;

        me.addDetailListners();

        // Angebot erstellen
        $('.btn-angebot-erstellen').on('click', function () {
            me.erstellen();
        });
    },


    /**
    * Init Form
    * 
    */
    initForm() {

        var me = this;

        // Neue Form
        me.form = new Form('#angebot-form');

        // Form Validation initalisieren
        me.form.initValidation();

        // Form
        me.form.on('invalid', function () {
            app.notify.error.fire("Fehler", "Einige Felder sind noch nicht vollständig ausgefüllt.");
        });

        // TODO: -- Hier muss noch die Standard-Funktion eingebaut werden
        me.form.qs['empfaenger'].on('action', function (el, action) {
            app.notify.success.fire("Jippi", "Do Something");
        });

        // Mit Platzhalter


        new ActivationCheckbox(me.form.getEl('hat_liefertermin'), [{
            el: me.form.getEl('liefertermin').closest('.form-group')
        }, {
            el: me.form.getEl('liefertermin_dummy').closest('.form-group'),
            reverse:true
        }], me.form);

    },

    /**
     * Speichern
     */
    save() {
        var me = this;

        // Entwurf speichern    

        if (me.status == 1) {
            me.entwurfSpeichern();
        }
    },  
    
    openHistory() {
        var me = this;
        app.alert.success.fire("Jippi", "Muss noch programmiert werden!");
    },

    initEntwurfWirdAngebot() {

        // angebot-erstellen-modal

    }


}   