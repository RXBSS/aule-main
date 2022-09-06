var adressenHersteller = {

    // ---------------------------------------------------------------------------
    // ---------------------------------------------------------------------------
    // STAMMDATEN
    init: function() {

        var me = this; 

        me.id = app.getUrlId();

        me.formHersteller = new CardForm('#form-hersteller-stammdaten');

        me.initLoad();

        // Eventlistener
        me.addEventListener();

    },

    initLoad() {

        var me = this;

        me.formHersteller.load('load-hersteller', 'adressen-handle', me.id, function(res) {

        });
    },


    addEventListener() {

        var me = this; 

        // Prüft ob der Toggler an oder aus ist
        $('input[name="ist_hersteller"]').on('change', function() {
            me.pillsToggler($(this));
        });

        var mainCard = new ActivationCard('#activation-card-hersteller');
        mainCard.addForm(me.formHersteller);


        /**
         * FORM HANDLER
         */

        me.formHersteller.on('submit', function() {
            me.submit();
        });

        // Bei Discrad nochmacl checken des Icons im Tabs
        me.formHersteller.container.on('click', '.btn-form-discard', function() {
            me.pillsToggler($('input[name="ist_hersteller"]'));
        });
    },

    pillsToggler(el) {

        if(el.is(':checked')) {
            $('#pills-hersteller i').remove();
            $('#pills-hersteller').prepend('<i class="fa-solid fa-toggle-on"></i>');
        } else {
            $('#pills-hersteller i').remove();
            $('#pills-hersteller').prepend('<i class="fa-solid fa-toggle-off"></i>');
        }
    },


    submit() {

        var me = this; 

        me.formHersteller.save("hersteller-save", "adressen-handle", function(res) {

            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
        }, false, {id: me.id})

    }

}