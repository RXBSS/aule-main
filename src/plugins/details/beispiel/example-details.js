var ex = {

    init() {

        var me = this;

        // Id aus der $_GET Variable lesen
        me.id = app.getUrlId();

        // Die Datei in der alle Standard-Abfrage verarbeitet werden
        me.handler = "example-handle";

        // Prüfen, dass auch eine ID ausgewählt wurde
        if (me.id) {

            me.getData(me.id, function(response) { 
                
                if(response.success) {

                    // Initalisieren
                    me.initForm();
                    me.initAdr();
                    me.initPos();

                    // Status ändern
                    me.changeStatus(1);

                    // Hier kann man warten, bis alle Picklisten fertig sind
                    app.waitForPicklists([me.picklistAdr], function () {
                        
                        // Der Wrapper Loader Stop Befehl muss umbedingt vor dem Card-Sizer ausgeführt werden!
                        app.wrapperLoader.stop();

                        // Card Sizer
                        new CardSizer(['#card-adresse', '#card-form', '#status-1', '#status-2', '#status-3']);
                    });
                } else {
                    me.loadingError("Der Datensatz wurde nicht gefunden.", 'example');
                }
            });

        } else {
            me.loadingError("Der Datensatz wurde nicht gefunden.", 'example');
        }
    },

    /**
     * Event Listner hinzufügen
     */
    addListner() {

        // Event Listner



    },

    /**
     * Erstmaliges Abrufen der Daten
     * - Wichtig vor allem für den Status
     * - Außerdem wird damit geklärt, dass der Datensatz auch verfügbar ist
     */
    getData(id, callback) {

        // Beispiel
        setTimeout(function() {
            
            // Callback
            callback({
                success: true,
                status: 1
            });

        }, 200);

    },

    /**
     * Die Funktion für die Status GUI
     */
    setStatusGui() {

        var me = this;

        // Standard Dinge ändern
        me.setStatusGuiDefault();

        switch (me.status) {

            case 1:
                me.form.setReadonly(false);
                me.adrReadonly(false);
                break;

            case 2:
                me.adrReadonly(true);
                me.form.setReadonly(true);
                break;

            case 3:
                me.adrReadonly(true);
                me.form.setReadonly(true);
                break;

        }
    },
}