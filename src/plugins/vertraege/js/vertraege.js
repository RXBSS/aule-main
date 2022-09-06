
var v = {


    init() {


        var me = this;

        // Standardmäßig immer Hide da unbefristet
        $('input[name="vertragsende"]').hide();

        // Pickliste
        me.initPickliste();

        // Modal
        me.initModalForm();

        // Quickselect
        // me.initQuickselect();

        // Activation
        // me.initActivation2();

        // Checkbox Befristung Handle
        me.unbefristetHandle();

        // EventListener
        me.addEventListener();

    },

    initPickliste() {

        var me = this;

        me.list = new Picklist('#pickliste-vertraege', 'vertraege');

    },

    initModalForm() {


        var me = this;

        me.modal = new ModalForm('#modal-vertraege');
        me.modal.initValidation();

    },

    // Quickselect 
    // initQuickselect() {

    //     var me = this;

    //     // Vertrags Vorlagen
    //     me.quickVertragsVorlagen = new Quickselect('default', {
    //         selector: '#vertrags_vorlagen',
    //         table: 'vertraege_vorlagen',
    //         fields: ['bezeichnung'],
    //         primary: 'id'
    //     });

    // },

    initActivation2() {

        var me = this;

        // ************************************************************
        // Kündigungsfrist Aktivation
        // ************************************************************
        me.kuendigungsfrist = new ActivationCheckbox('#kuendigungsfrist',
            [
                {
                    el: '.kuendigungsfrist-body'
                },
                {
                    el: '.kuendigungsfrist-body'
                }
            ], me.modal);

        // ************************************************************
        // Verlängerung Aktivation
        // ************************************************************
        me.verlaengerung = new ActivationCheckbox('#verlaengerung', 
            [
                {
                    el: '.verlaengerung-body'
                }, 
                {
                    el: '.verlaengerung-body'
                },
                {
                    el: '#kuendigung_frist',
                    child: me.kuendigungsfrist
                }
            ], me.modal);


        // // ************************************************************
        // // Laufzeit Aktivation
        // // ************************************************************
        me.laufzeit = new ActivationCheckbox('#laufzeit', 
            [
                {
                    el: '.laufzeit-body'
                }, 
                {
                    el: '.laufzeit-body'
                },
                {
                    el: '#verlaengerung_kuendigung_ebene',
                    child: me.verlaengerung
                }
            ], me.modal);


    },

    // Activation
    initActivation() {

        var me = this;

        // Mit Reverse Parameter
        new ActivationInput('#cb-aktivieren', [{
            selector: 'input[name="laufzeit"]',
            reverse: true,
        }]);

        new ActivationCheckbox('#verlaengerung', function(el, isChecked, isInit) {

            // Wenn die Checkbox Gechecked ist
            if(isChecked) {
                $('#verlaengerung-selector, #kuendigungsfrist-body').show();
            }

            // wenn Nicht gecheckt ist 
            else {

                $('#verlaengerung-selector, #kuendigungsfrist-body').hide();

            }
        });

        new ActivationCheckbox('#kuendigungsfrist', function(el, isChecked, isInit) {

            // Wenn die Checkbox Gechecked ist
            if(isChecked) {
                $('#kuendigung-selector').show();
            }

            // wenn Nicht gecheckt ist 
            else {
                $('#kuendigung-selector').hide();
            }
        });


        // Als String
        // new ActivationInput('#cb-aktivieren', 'input[name=example-field]');

    },


    addEventListener() {

        var me = this; 

        // *****************************************************************************
        // Standard Events
        // *****************************************************************************

        // Wenn Datum sich ändert oder Laufzeit
        $('input[name="vertragsbeginn"]').on('change', function() {
            me.setVertragsende();
        });

        // Wenn Datum sich ändert oder Laufzeit
        $('input[name="vertragsbeginn"]').on('keyup', function() {
            me.setVertragsende();
        });

        // Wenn Laufzeit sich ändert soll sich das Feld automatisch anpassen
        $('input[name="laufzeit"]').on('keyup', function() {
            me.setVertragsende();
        });

        // Checkbox on CHange
        $('input[name="cb-aktivieren"]').on('change', function() {
            me.unbefristetHandle();
        });

        // Checkbox Verländerung On Change
        // $('input[name="verlaengerung"]').on('change', function() {
        //     console.log("VERLÄNDERUNGER");
        // });

        // Checkbox Kündigungsfrist On Change
        // $('input[name="kuendigungsfrist"]').on('change', function() {
        //     console.log("Kündigungsfrist");
        // });

        // Wenn ein Select Getriggert wird
        $('select.set-data-unit').on('change', function() {


            $('#' + $(this).data('selector-unit')).html('').html($(this).find(":selected").text());
        });
        
        // Wenn Interval Select eine andere Auswahl getroffen wird
        $('select[name="laufzeit_interval"]').on('change', function() {
            // $('.laufzeit_interval').html('').html($(this).find(":selected").text());

            me.setVertragsende();

        });

        // Wenn das modal geöffnet ist sollten verschieden Einstellungen schon getroffen werden
        $('#vertraege-add').on('click', function() {

            // Checkbox Befristung wieder Aktiv setzen
            $('input[name="cb-aktivieren"]').prop('checked', true);

            // Laufzeit wieder auf Monate und alles neu Laden
            $('select[name="laufzeit_interval"]').val('M');

            // Neu Laden handle
            me.unbefristetHandle();
        });

        $('#vertraege-add').on('click', function() {
            me.modal.open();
        });

        // *****************************************************************************
        // Form Handle Events
        // *****************************************************************************

        me.list.on('pick', function(el, data) {
            app.redirect('vertraege-details.php?id=' + data[1]);
        });

        // Wenn Modal Geschlossen wird -- Modal zurücksetzen
        me.modal.container.on('click', '.btn-schliessen', function() {
            me.modal.reset(1)
        });

        // Wenn ein neuer Vertrag angelegt wird
        me.modal.on('submit', function() { 
            me.submit();
        });

        // Form Zurücksetzen
        me.modal.container.on('click', '.btn-schliessen', function() {
            me.modal.clearForm();
        });

        // me.simpleModalTaskV = new simpleModalTask('#vertraege-add', me.list, me.modal, 'v-submit', 'vertraege-handle');

    },
    
    // Neuer vertrag erstellen
    submit() {

        var me = this;

        // id der Ausgewählten Zeile
        var id = me.list.getSelectedSingle();

        // Save Funktion
        me.modal.save('v-submit', 'vertraege-handle', function(data) {

            /* Callback Success */

            // Alle Input-Felder werden gesäubert
            me.modal.clearForm(); 

            me.modal.close(); 

            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
            
            // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
            me.list.refresh(true);

            // 
            app.redirect('vertraege-details.php?id=' + data['data']);

        },
        /* Callback Error ist nicht vorhanden */
        false, {

            // Additional Data - falls es Edit werden soll
            id: id
        });


    },


    // unbefristet
    unbefristetHandle() {

        var me = this;

        // Wenn die Checkbox gechecked ist dann nicht anzeigen
        if($('input[name="cb-aktivieren"]').is(':checked')) {
            $('input[name="vertragsende"], input[name="laufzeit"], select[name="laufzeit_interval"], #unbefristet_laufzeit_interval, #verlaengerung-body').hide();
            $('select[name="laufzeit_interval"]').removeClass('editable').attr('disabled', 'disabled')
        } else {
            $('input[name="vertragsende"], input[name="laufzeit"], select[name="laufzeit_interval"], #unbefristet_laufzeit_interval, #verlaengerung-body').show();
            $('select[name="laufzeit_interval"]').addClass('editable').removeAttr('disabled')

        }

        ( ($('input[name="cb-aktivieren"]').is(':checked')) ? $('input[name="vertragsende"]').hide() : $('input[name="vertragsende"]').show() ); 

    },

    setVertragsende() {

        var me = this;

        // // 
        if(!$('input[name="cb-aktivieren"]').is(':checked')) {

            // Input Wieder anzeigen
            $('input[name="vertragsende"]').show();

            // Intervall Laufzeit Auslesen
            var interval = $('select[name="laufzeit_interval"]').val();
 
            // Der Wert wird richtig geparst und in das Feld geschrieben
            var newValue = moment($('input[name="vertragsbeginn"]').val()).add($('input[name="laufzeit"').val(), interval).subtract(1, 'days').format('DD.MM.YYYY');

            me.modal.container.find('input[name="vertragsende"]').val(newValue).blur();

        }

    }


}