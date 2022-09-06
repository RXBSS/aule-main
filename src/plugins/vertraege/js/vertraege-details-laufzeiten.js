var v_laufzeiten = {

    initVertraegeLaufzeiten() {

        var me = this;

        // Standardmäßig ausgeblendet
        $('#vertraege-progress-bar').hide();

        // Init Validierung der Laufzeiten
        me.fields = me.initLaufzeitValidierung()

        // Inti Form
        me.initFormLaufzeiten();

        // Init Aktivation
        me.initAktivationLaufzeiten();

        // Load Form Date Laufzeiten
        me.loadFormLaufzeiten();

        // EventListner 
        me.addEventListenerLaufzeiten();

    },

    // init Form
    initFormLaufzeiten() {

        var me = this;

        // Karte der Laufzeiten der Vertäge
        me.formLaufzeiten = new CardForm('#form-laufzeiten');
        me.formLaufzeiten.initValidation(me.fields);

    },

    // Aktivation
    initAktivationLaufzeiten() {

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
            ], me.formLaufzeiten);

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
            ], me.formLaufzeiten);


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
            ], me.formLaufzeiten);


    },

    // Events
    addEventListenerLaufzeiten() {

        var me = this;

        // Wenn Datum sich ändert oder Laufzeit oder Intverall sich ändert
        $('input[name="vertragsbeginn"], #laufzeit, #verlaengerung, #kuendigungsfrist, select[name="laufzeit_interval"], select[name="verlaengerung_laufzeit_interval"], select[name="kuendigungsfrist_laufzeit_interval"]').on('change', function () {
            me.setEndDates();
        });

        // Wenn Laufzeit, Vertragslaufzeit, Kündigungslaufzeit sich ändert soll sich das Feld automatisch anpassen
        $('input[name="laufzeit"], input[name="kuendigungsfrist_laufzeit"], input[name="verlaengerung_laufzeit"]').on('keyup', function () {
            me.setEndDates();
        });

        // Laufzeiten Submit
        me.formLaufzeiten.on('submit', function () {
            me.submitLaufzeiten();
        });

        // Wenn die Form zurückgesetzt wird sollen die Standardwerte angenommen werden die die Form beim Laden der Seite hatte
        me.formLaufzeiten.on('end', function() {
            me.formLaufzeiten.setData(me.formLaufzeitData);
        })

    },

    // Schickt die Laufzeiten Form ab
    submitLaufzeiten() {

        var me = this;

        // Save Funktion Ajax
        me.formLaufzeiten.save('submitLaufzeiten', 'vertraege-handle',

            // Success
            function (response) {
                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Form Laden
                me.loadVertrag();

                // Laufzeiten Neu Laden
                me.loadFormLaufzeiten();

                // 
                me.formLaufzeitData = me.formLaufzeiten.getData();

            }, null, { id: me.id }
        )

    },

    // Load Form Laufzeiten
    loadFormLaufzeiten() {

        var me = this;

        me.formLaufzeiten.load("load", "vertraege-handle", me.id,
            function (response) {

                

                // var activationValue = {
                //     'laufzeit-trigger': response.data.laufzeit,
                //     'verlaengerung-trigger': response.data.verlaengerung_laufzeit,
                //     'kuendigungsfrist-trigger': response.data.kuendigungsfrist_laufzeit,
                // };

                // // Schleife geht durch das Objekt durch
                // $.each(activationValue, function (key, value) {

                //     // Wenn das Input oder der Select einen Wert hat -> dann soll die Checkbox gesetzt sein
                //     if (value) {
                //         // Setzt den Inhalt auf True damit er Angezeigt wird
                //         me.formLaufzeiten.setData({
                //             key: true
                //         });

                //         // Setzt das Feld Auf True -- Key
                //         me.formLaufzeiten.setFieldData(key, true);
                //     }
                // });

                if (response.data.laufzeit) {
                    me.formLaufzeiten.setData({
                        'laufzeit-trigger': true
                    });

                } else {
                    me.formLaufzeiten.container.find('input[name="vertragsende"]').val('');
                }

                if (response.data.verlaengerung_laufzeit) {
                    me.formLaufzeiten.setData({
                        'verlaengerung-trigger': true
                    });

                } else {
                    me.formLaufzeiten.container.find('input[name="verlaengerung_ende"]').val('');
                }

                if (response.data.kuendigungsfrist_laufzeit) {
                    me.formLaufzeiten.setData({
                        'kuendigungsfrist-trigger': true
                    })

                } else {
                    me.formLaufzeiten.container.find('input[name="kuendigungsfrist_ende"]').val('');
                }

                // 
                me.formLaufzeitData = me.formLaufzeiten.getData();

                me.setEndDates();

            }
        );


    },

    // Rechnet den Vertragsende aus
    setEndDates() {

        var me = this;

        // Abkürzung Form Container
        var formEl = me.formLaufzeiten.container;

        // Vertragsende nur setzen wenn es eine Laufzeit gibt 
        if (formEl.find('input[name="laufzeit"]').val() != '') {

            // Intervall der Vertragslaufzeit
            var intervalVertragslaufzeit = formEl.find('select[name="laufzeit_interval"]').val();

            // Enddatum des Vertrags
            var endDatumVertrag = moment($('input[name="vertragsbeginn"]').val()).add($('input[name="laufzeit"').val(), intervalVertragslaufzeit);

            // Vertragsende in das Input feld schreiben
            formEl.find('input[name="vertragsende"]').val(endDatumVertrag.subtract(1, 'days').format('DD.MM.YYYY')).blur();


            // Objekte mit den Name der Input Felder
            var inputFelder = {
                'kuendigung': ['verlaengerung_laufzeit', 'verlaengerung_laufzeit_interval', 'verlaengerung_ende'],
                'verlaengerung': ['kuendigungsfrist_laufzeit', 'kuendigungsfrist_laufzeit_interval', 'kuendigungsfrist_ende']
            }


            // Schleife geht durch alle Werte
            $.each(inputFelder, function (key, value) {

                // Wenn es einen Wert im Inputfeld (verlaengerung || kündigung)_laufzeit gibt
                if (formEl.find('input[name="' + value[0] + '"]').val() != '') {

                    // Nimmt den Interval Wert aus dem Select (verlaengerung || kündigung)_laufzeit_interval -- (Tag, Monat oder Jahr)
                    var newInterval = formEl.find('select[name="' + value[1] + '"]').val();

                    // Nimmt das Enddatum des Vertrages und Addiert die Laufzeit die in dem Inputfeld (verlaengerung || kündigung)_laufzeit steht mit dem newInterval
                    var finalDate = moment(endDatumVertrag).add($('input[name="' + value[0] + '"]').val(), newInterval).format('DD.MM.YYYY')

                    // Schreibt das Finale Datum in das Inputefeld (verlaengerung || kündigung)_ende
                    formEl.find('input[name="' + value[2] + '"]').val(finalDate).blur();

                }
            });
        }

        var inputEndeDate = ['vertragsende', 'verlaengerung_ende', 'kuendigungsfrist_ende', 'vertragsbeginn'];

        // Schleife geht alle Input Felder die Ende Datum sind durch
        $.each(inputEndeDate, function (key, value) {

            // Wenn eines der Vetragsende Input Feld ein Invalid Date hat dann das Feld leeren
            if(formEl.find('input[name="' + value + '"]').val() == 'Invalid date') {
                formEl.find('input[name="' + value + '"]').val('')
            }

            // Sobald einer dieser Feld nicht leer ist dann soll die Progess Bar wieder angezeigt werden
            if(formEl.find('input[name="' + value + '"]').val()) {
                $('#vertraege-progress-bar').show();
            }

        });

        // set Status Bar
        me.setStatusBar();

    },

    // setzt die Laufzeiten
    setStatusBar() {

        var me = this;

        // Die Werten in den einzelnen Abschnitten in der Progressbar leeren
        $('#vertraege-progress-bar .progress-bar').html('')

        // Daten auslesen
        var laufzeit = $('#laufzeit').prop('checked');
        var verlaengerung = $('#verlaengerung').prop('checked');
        var kuendigungsfrist = $('#kuendigungsfrist').prop('checked');

        // Vertragsdaten Progressbar
        var unbefristetDatum = moment(me.formLaufzeiten.container.find('input[name="vertragsbeginn"]').val()).format('DD.MM.YYYY');
        var befristetDatum = unbefristetDatum + ' - ' + me.formLaufzeiten.container.find('input[name="vertragsende"]').val();
        var verlaengerungDatum = me.formLaufzeiten.container.find('input[name="verlaengerung_ende"]').val();
        var kuendigungsfristDatum = me.formLaufzeiten.container.find('input[name="kuendigungsfrist_ende"]').val();

        // Werte der Inputfeld -- Vertragsdaten (Datums)
        var cases = [
            [100, unbefristetDatum, 0, '', 0, ''], // Nur Unbefristet
            [100, befristetDatum, 0, '', 0, ''], // Nur Befristet
            [80, befristetDatum, 0, '', 20, verlaengerungDatum], // Befristet und Verlängerung
            [60, befristetDatum, 20, kuendigungsfristDatum, 20, verlaengerungDatum], // Befristet, Verländerung und Kündigung
        ];

        // Aktueller Wert
        var current = (laufzeit && verlaengerung && kuendigungsfrist) ? 3 : ((laufzeit && verlaengerung) ? 2 : (laufzeit) ? 1 : 0);

        // Setzen der Progress bar
        $('#vertraege-progress-bar').find('[data-id=laufzeit]').width(cases[current][0] + "%").html(cases[current][1]);
        $('#vertraege-progress-bar').find('[data-id=verlaengerung]').width(cases[current][2] + "%").html(cases[current][3]);
        $('#vertraege-progress-bar').find('[data-id=kuendigungsfrist]').width(cases[current][4] + "%").html(cases[current][5]);

    }

}