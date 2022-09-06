/**
 * 
 */
var agErst = {


    initErstellen() {

        var me = this;

        // Form zum erstellen
        me.erstellenForm = new ModalForm('#angebot-erstellen-form');
        me.erstellenForm.initValidation();

        // Activation Multi
        new ActivationMulti(me.erstellenForm.container.find('input[name=angebot-versandart]'), '.angebot-erstellen-versandart', me.erstellenForm);

        // On Submit der Form
        me.erstellenForm.on('submit', function() {

            // Speichern vollständig
            me.erstellenForm.save('angebot-erstellen', me.handler, function() {
                
                // Was muss danach passieren?

            }, null, {
                id: me.id
            });
        });
    },


    /**
     * 
     */
    erstellen() {

        var me = this;

        // Entwurf validieren
        me.entwurfValidieren(function(response) {

            app.alert.loader.fire();
           
            // Erstellen des Dokuments
            app.simpleRequest("documentErstellen", me.handler, me.id, function(response) {

                // Loader schließen
                app.alert.loader.close();

                // Modal anzeigen
                $('#angebot-erstellen-modal').modal('show');

            // Etwas stimmt noch nicht
            }, function(response) {
                console.log('not t');
                
            }); 
        });
    },

    
    // Validieren des Entwurfs
    // TODO: XXX
    entwurfValidieren(callback) {

        var me = this;

        /**
         * Entwurf validieren
         * 
         */
        app.simpleRequest("entwurfValidieren", me.handler, me.id, function(response) {
            callback(response);
        }, function(response) {
            app.alert.warning.fire("Daten nicht vollständig","Bitte prüfen Sie das und das!");
        });
    },


}