/**
 * Das ist ein Objekt das dafür genutzt wird um einen Callback zu starten
 * 
 * Überall im ERP System kann es sein das man schnell Kontakte hinzufügen will 
 * Dies ist dafür geeignet und wird so gebaut das ein Callback zurück geht
 */

var kontakte_neu = {


    // Alles was zum Beginn der Seite schon geladen werden soll
    initKontakteNeu() {

        var me = this;

        // $('.duplettenpruefung').hide();

        // Modal Kontakte
        me.initKontakteNeuModal();

    },

    // Modal zum schnellen hinzufügen
    initKontakteNeuModal() {

        var me = this;

        me.modalneuerKontakt = new ModalForm('#kontakte-neu-modal-form');
        me.modalneuerKontakt.initValidation();

    },


    // Alle EventListener können hier geladen werden
    addEventListenerKontakteNeu() {

    },

    // Hier kommt der Ajax Absende part mit einem Callback zurück
    openDialogKontakteNeu(options, callback) {

        var me = this;

        // Ajax
        me.modalneuerKontakt.save('neuerKontakt', 'kontakte-handle.php', 
        
            // Success
            function(response) {

                // Erfolgsmeldung
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");

                // Modal wieder schließen
                me.modalneuerKontakt.close();

                // me.modalneuerKontakt.find('input').val('')
                // me.modalneuerKontakt.find('select').remove();

                // Modal zurücksetzen
                me.modalneuerKontakt.reset(1);

                // Modal Wieder öffnent
                // options.modal.open();

                // Callback der Zurück geht
                callback(response);


            },

            // Error
            function(a,b,c) {

                // Fehlermeldung
                app.notify.error.fire("Fehler", b.error);


            },

            // Additional Data
            false
    
        )
    }



}