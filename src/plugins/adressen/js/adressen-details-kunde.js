var adressenKunde = {


    init() {

        var me = this;

        // App aus der URL auslesen
        me.id = app.getUrlId();

        // Form
        me.initForm();
        me.addListner();
        me.initAcitvationCards();
        me.initActivationInput();
        me.initLoad();
    },
    

    /**
     * Initialisieren der Formulars
     */
    initForm() {

        var me = this;

        // Form und Validierung
        me.form = new CardForm('#form-kunden-stammdaten');
        me.form.initValidation();

    },

    // Karten die aktiviert werden können
    initAcitvationCards() {

        var me = this;

        // Haupt-Kunden Karte
        var cardMain = new ActivationCard('#activation-card-kunde');
        cardMain.addForm(me.form, ['ist_betreiber']);

        // E-Mail Rechnung
        var cardEmailRechnung = new ActivationCard('#activation-card-email-rechnung');
        cardEmailRechnung.addForm(me.form);
        
        // Konto Sperre
        var cardKontoSperre = new ActivationCard('#activation-card-konto-sperre');
        cardKontoSperre.addForm(me.form, ['kunde_gesperrt_grund', 'kunde_gesperrt_mitarbeiter', 'kunde_gesperrt_datum']);
    },

    initActivationInput() {
        var me = this;

        new ActivationInput('#kunde_email_rechnung_benutzerdefiniert', [{
            selector: 'input[name=kunde_email_rechnung_adresse]',
            text: $('input[name="email"]').val()
        }], me.form);
    },

    // Lädt die Card neue mit den aktuellen Daten
    initLoad() {

        var me = this;

        // Daten inital laden
        me.form.load('kunde-load', 'adressen-handle', me.id, function (res) {

            me.changeKundenType();

            // Wenn der Kundenstatus auf 0 (Interessant) steht dann soll die Kundenummer weg
            if(res.data.kundenstatus == 'interessent' || res.data.kundenstatus == "") {
                $('.ist-kunde-toggler').hide();
            }

        });
    },

    /**
     * Alles Events
     */
    addListner() {

        var me = this;

         // Prüft ob der Toggler an oder aus ist
         $('input[name="ist_kunde"]').on('change', function() {
            me.pillsToggler($(this));
        });

        // 
        // $('input[name="kunde_email_rechnung_benutzerdefiniert"]').on('change', function() {
        //     me.emailBenutzerDefReset($(this));
        // });

        /**
         * FORM HANDLER
         * 
         */

        // Toggle zwischen Betreiber und Rechnungsempfänger 
        me.form.container.on('change', 'input[name=ist_betreiber]', function () {
            me.changeKundenType();
        });

        // Formular abschicken
        me.form.on('submit', function () {
            me.submit();
        });

        // Wenn das Formular nicht vollständig ausgefüllt wurde
        me.form.on('invalid', function() {
            app.notify.error.fire("Fehler","Bitte die Form vollständig ausfüllen!");
        });

        // Bei Discard nochmal checken des Icons in den Tabs, damit immer das richtige Icon oben angezeigt wird
        me.form.container.on('click', '.btn-form-discard', function() {
            me.pillsToggler($('input[name="ist_kunde"]'));
        });
    },

    emailBenutzerdefiniert() {

        var me = this; 

       
    
    },

    /**
     * Dynamisch mit ActivtionCard und oben Tabs Pills
     */
    pillsToggler(el) {

        // Wenn die ActivationCard gecheckt ist
        if(el.is(':checked')) {
            $('#pills-kunde i').remove();
            $('#pills-kunde').prepend('<i class="fa-solid fa-toggle-on"></i>');

        // Wenn die ActivationCard nicht gecheckt ist
        } else {
            $('#pills-kunde i').remove();
            $('#pills-kunde').prepend('<i class="fa-solid fa-toggle-off"></i>');
        }

    },

    /**
     * Submit Funktion
     */
    submit() {

        var me = this;

        // Speichern
        me.form.save('kunde-save', "adressen-handle", function (res) {

            // Damit immer die Richtigen Daten angezeigt werden ;)
            // me.initLoad();


 
            // TODO: Das sollte im Standard verhalten passieren oder nicht?
            // Wenn das Feld leer ist sollte es weiterhin ausgeblendet sein egal was sein dazugehöriger Checkbox ist
            // if(!res.log[2].formData.kunde_email_rechnung_adresse) {

            
            //     $('input[name=kunde_email_rechnung_adresse]').attr("disabled", true);
            // }


            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich angepasst");


            // Todo: Neuladen der Form
            // me.initLoad();

        }, false, 
        
        // Addtional
        { 
            id: me.id,
            email: $('input[name="email"]').val()
        });
    },



    /**
     * Diese Funktion setzt alles, wenn zwischen BE und RE gesetzt wird
     */
    changeKundenType() {

        var me = this;

        // Type auslesen
        var type = me.form.container.find('input[name=ist_betreiber]:checked').val();

        

        // Ein- und Ausblenden
        $('.kunden-type').hide();
        $('.kunden-type-' + type).show();

        // Do Specific  
        // -- Enable und Disable Validation

    }

}