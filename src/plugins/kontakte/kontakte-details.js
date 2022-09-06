var k_d = {

    init: function() {

        var me = this; 

        me.id = app.getUrlId();

        // Card - Formular
        me.card = new CardForm('#form-kontakte');

        // Adressen - Pickliste
        me.adressen = new PicklistModal("adressen", {
            type: 'single-picklist'
        });

        // Init - EventListener
        me.addEventListener();
    },

    addEventListener() {
        var me = this;

        // On Submit
        me.card.on('submit', function() {
            me.submit(); 
        });

        me.card.load('loadKontakte', 'kontakte-handle.php', me.id, function(){});

        // Wenn ein Datensatz aus Adressen ausgeweählt wurde
        me.adressen.on('pick', function(el, data) {
            me.card.container.find('input[name=unternehmen]').val(data[2])
            me.card.container.find('input[name=adressen_id]').val(data[1])
        });

        // app.simpleRequest("k-edit", "kontakte-handle.php");

        me.simplePickListeTask= new simpleModalTask('#pickliste-adressen-open', me.adressen, me.adressen, null, null, null);

    },

    // Submit Funktion der Card
    submit() {

        var me = this;

        // task file success error additional
        me.card.save('k-submit','kontakte-handle',
            
            // Success
            function(response) {
                app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
            },

            // Error
            function(xhr) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");
            },

            // Adiitional
            {
                id: me.id
            }
        );
    }
}