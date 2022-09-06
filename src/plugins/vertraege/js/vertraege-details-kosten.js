var v_kosten = {

    initVertraegeKosten() {

        var me = this;

        // Init Form
        me.initFormKosten();

        // Activation
        me.initActivationKosten();

        // Form Laden
        me.loadFormKosten();

        // Standard Mäßig Ausblenden des Selectes Kalendarium
        $('#zaehler-kalendarium, #pauschale-kalendarium').hide();

        // Events
        me.addEventListenerKosten();

    },

    // Form
    initFormKosten() {

        var me = this;

        // Karte der Abrechnung
        me.formKosten = new CardForm('#form-kosten');



        me.formKosten.initValidation();

    },

    // Activation
    initActivationKosten() {

        var me = this;

        // Pauschale Aktivattion
        new ActivationCheckbox('#pauschale', '.pauschale-body', me.formKosten);

        // Gesamtpauschale Aktivattion
        new ActivationCheckbox('#gesamtpauschale', '.gesamtpauschale-body', me.formKosten);

        // Zähler Aktivattion
        new ActivationCheckbox('#zaehler', '.zaehler-body', me.formKosten);

        // Einheitliche Preise
        var cb = new ActivationCheckbox('#zaehler_einheitlich', '#zaehler-einheitliche-preise');
        
        cb.on('callback', function(el, isChecked, isInit) {
            if(isChecked) {
                me.loadZaehler();
            }
            
        });

    },

    // Events
    addEventListenerKosten() {

        var me = this;

        // me.formKosten.getField ('zaehler_einheitlich').on('change', function() {
        //     if($(this).prop('checked')) {
        //         me.loadZaehler();
        //     }
        // });

        // Wenn die Form abgeschickt wird 
        me.formKosten.on('submit', function () {
            me.dialogPauschale();
            // me.submitKosten();
        });

        // Wenn die Auswahl Kalendarium getroffen wird soll das jeweilige Kalendarium angezeigt werden ansonsten nicht
        me.formKosten.container.on('change', 'select[name="pauschale_abrechnung_interval"], select[name="zaehler_abrechnung_interval"]', function () {
            if ($(this).val() == 'K') {
                $('#' + $(this).data('kalendarium')).show();
            } else {
                $('#' + $(this).data('kalendarium')).hide();
            }
        });

        // Wenn Sich die Pauschale || GesamtPauschale Ändert
        me.formKosten.container.on('click', 'input[name="pauschale-trigger"], input[id="gesamtpauschale"]', function () {
            me.hideAndShowPosPauschale();
        });

        me.formKosten.container.on('click', '.btn-form-discard', function () {

        });

    },

    /**
     * Lädt Alle Zaehler die es für die Positionen gibt die hinzugefügt wurden
     * 
     * z.B. Kopierer hat Zaehler Schwarz/Weiß, Farbe dann werden diese beiden hinzugefügt
     *      Wenn es einen Plotter in den Positionen gibt und dieser den Zaehler A hat soll dieser auch hinzugefügt werden und sonst keine
     */
    loadZaehler() {

        var me = this;

        // Ajax
        app.simpleRequest("loadZaehler", "vertraege-handle", me.id,

            // Success
            function (response) {
                console.log(response);

                var formKosten = new FormCreator();

                // HTML DOM ELEMENt löschen
                $('#zaehler-einheitliche-preise').html('');

                // 
                $.each(response.data, function (key, value) {

                    var zaehlerPauschale = "";

                    // Wenn es einen Zähler gibt
                    if (value.pauschale) {
                        zaehlerPauschale = value.pauschale.toLocaleString('de-DE', { minimumFractionDigits: 2 });
                    }


                    var newInput = formKosten.createInput('number', "zaehler-" + value.id, value.bezeichnung, zaehlerPauschale);

                    $('#zaehler-einheitliche-preise').append(newInput)

                });

            }

        );

    },

    // Load Form
    loadFormKosten() {

        var me = this;

        // Load
        me.formKosten.load("load", "vertraege-handle", me.id,
            function (response) {

                if (response.data.pauschale_abrechnung_interval) {
                    me.formKosten.setData({
                        'pauschale': true
                    })
                }

                if (response.data.gesamtpauschale_preis) {
                    me.formKosten.setData({
                        'gesamtpauschale-trigger': true
                    })

                    me.formKosten.container.find('input[name="gesamtpauschale_preis"]').val(me.turnintoGermanFormat(response.data.gesamtpauschale_preis))

                }

                if (response.data.zaehler_abrechnung_interval) {
                    me.formKosten.setData({
                        'zaehler': true
                    })
                }

                // Wenn es Einheitlich Preise gibt
                if (response.data.zaehler_einheitlich == '1') {

                    // Activation Checkbox Anzeigen
                    me.formKosten.container.find('#zaehler-einheitliche-preise').css('display', 'block')
                    
                }

                // Global GesamtKosten Pauschale
                me.gesamtKostenPauschale = response.data.gesamtpauschale_preis;
            
                me.loadZaehler();

            }
        );


    },

    // Ein Dialog der Abfragt ob wirklich gespeichert werden soll
    dialogPauschale() {

        var me = this;

        var newGesamtKostenPauschae = (me.formKosten.getData()['gesamtpauschale_preis']) ? me.formKosten.getData()['gesamtpauschale_preis'] : false;
        me.gesamtKostenPauschale = (me.gesamtKostenPauschale) ? me.gesamtKostenPauschale : false;

        // console.log(newGesamtKostenPauschae);
        // console.log(me.turnintoGermanFormat(me.gesamtKostenPauschale));

        console.log(me.formPositionen.getData());

        // Wenn die Gesamtpauschale beim Laden eine Andere ist als beim Abschicken
        if (me.turnintoGermanFormat(me.gesamtKostenPauschale) != newGesamtKostenPauschae && (me.formPositionen.getData()['pauschale'] != '')) {

            // Dialog
            app.alert.question.fire("Änderung vornehmen?", "Wenn Sie die Form speichern, werden alle Kosten für die einzelnen Positionen, die Sie angelegt haben gelöscht. Diesen Vorgang kann man nicht rückgängig machen.")
                .then((result) => {

                    // Wenn Ja
                    if (result.isConfirmed) {
                        me.submitKosten();
                    }
                });


        } else {
            me.submitKosten();
        }

    },

    // Submit der Card
    submitKosten() {

        var me = this;

        // Submit Save Funktion
        me.formKosten.save('submitKosten', 'vertraege-handle', function () {
            app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

            // Form Laden
            me.loadVertrag();
            me.loadFormKosten();

        }, null, { id: me.id })

    }

}