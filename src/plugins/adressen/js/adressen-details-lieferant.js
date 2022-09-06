var adressenLieferant = {



    init: function() {

        var me = this; 

        me.id = app.getUrlId();

        // Init Cardd
        me.formLieferant = new CardForm('#form-lieferant-stammdaten');

        me.initActivationCard();
        me.initActivationInput();

        // Actitavtion Checkboxen
        me.initActivationCheckbox();

        me.initLoad();

        // Eventlistener
        me.addEventListener();

    },

    initActivationCard() {

        var me = this;

        var cardMain = new ActivationCard('#activation-card-lieferant');
        cardMain.addForm(me.formLieferant);

        // Zahlungsbedinungen
        var cardZahlungsbedinung = new ActivationCard('#activation-card-zahlungsbedinungen');
        cardZahlungsbedinung.addForm(me.formLieferant);

        // Zahlungsbedinungen
        var cardMindermengenzuschlag = new ActivationCard('#activation-card-mindermengenzuschlag');
        cardMindermengenzuschlag.addForm(me.formLieferant);

        // Zahlungsbedinungen
        var cardVersandVersicherung = new ActivationCard('#activation-card-versand-versicherung');
        cardVersandVersicherung.addForm(me.formLieferant);

    },

    initActivationInput() {
        var me = this;

        // Die Große Karte von Lieferant
        new ActivationInput('#lieferant_bestellung_email_benutzerdefiniert', [{
            selector: 'input[name=lieferant_bestellung_email]',
            text: $('input[name="email"]').val()
        }], me.form);

        


    },

    // Activation Checkbox für Zahlung, Versand, Mindermengen
    initActivationCheckbox() {

        var me = this;

        // Einfachste Variante
        new ActivationCheckbox('#skonto-checkbox', '#skonto-checked', me.formLieferant);
        new ActivationCheckbox('#freibetrag-checkbox', '#freibetrag-checked', me.formLieferant);
        // new ActivationCheckbox('#checkbox', '#container', me.formLieferant);
        // new ActivationCheckbox('#checkbox', '#container', me.formLieferant);



    },

    /**
     * Load der Lieferanten Tab
     */
    initLoad() {

        var me = this;
        
        me.formLieferant.load('load-lieferanten', 'adressen-handle', me.id, function(res) {


            // Wenn es Skonto gibt
            if(res.data.lieferant_zahlungsbedingung_skonto) {
                $('input[name="skonto-checkbox"]').prop('checked', true);
                $('#skonto-checked').show();
            }

            // Wenn es einen Freibetrag gibt
            if(res.data.lieferant_versand_versicherung_freibetrag) {
                $('input[name="freibetrag-checkbox"]').prop('checked', true);
                $('#freibetrag-checked').show();
            }

        });
    },

    addEventListener() {
        var me = this; 

        // Prüft ob der Toggler an oder aus ist
        $('input[name="ist_lieferant"]').on('change', function() {

            // 
            me.pillsToggler($(this));
        });

        

        /**
         * FORM HANDLER
         */

        // Formular abschicken
        me.formLieferant.on('submit', function() {
            me.submit();
        });

        // Bei Discrad nochmacl checken des Icons im Tabs
        me.formLieferant.container.on('click', '.btn-form-discard', function() {
            me.pillsToggler($('input[name="ist_lieferant"]'));
        });

    },

    pillsToggler(el) {

        if(el.is(':checked')) {
            $('#pills-lieferant i').remove();
            $('#pills-lieferant').prepend('<i class="fa-solid fa-toggle-on"></i>');
        } else {
            $('#pills-lieferant i').remove();
            $('#pills-lieferant').prepend('<i class="fa-solid fa-toggle-off"></i>');
        }
    },

    submit() {
        
        var me = this;

        // Abschicken der Form
        me.formLieferant.save('lieferant-save', "adressen-handle", function(res) {

            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");
        
        }, false, {id: me.id});

    }


}