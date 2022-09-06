/**
 * Dies ist ein Opjekt die Funktion für die Verträge Laufzeiten beeinhaltet
 * - Es gibt eine Funktion initVorlagen die nur alle Funktionen hat die auf der Vorlage Seite nötig sind 
 * - Die initLaufzeiten hat Funktion die darüber hinaus gehen -> auf der Veträge Details Seite benötigt die Laufzeit eine eigene Card und Validierung die es auf der Vorlagen 
 *      Seite nicht benötigt...
 */
var v_laufzeiten = {


    // Diese Funktion geht über die Vorlagen hinaus und hat noch eigene Individuelle Funktionen die er benötigt auf der Verträge seite
    initLaufzeiten() {

        var me = this;

    },

    // Diese Init Funktion beinhaltet Alle Funktionen die nur in der Vorlagen gültig ist
    initVorlagen() {

        var me = this;

        // Aktivierung der Checkboxen
        me.initActivationLaufzeiten();

        // Setzt immer den Monat als Standard Selects
        // me.setSelectInterval();

    },

    initActivationLaufzeiten() {

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
            ]);

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
            ]);


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
            ]);

    },


    initFormLaufzeiten() {

        var me = this;

        // me.formLaufzeiten = new CardForm("vertraege-aufzeiten-form");
        // me.formLaufzeiten.initValidation();

    },

    // Wählt bei allen Selects den Monat immer als Standard aus
    setSelectInterval() {

        var me = this;

        // Alle Selects Intervall
        var intervalSelects = ['laufzeit_interval', 'verlaengerung_laufzeit_interval', 'kuendigungsfrist_laufzeit_interval'];

        // SChleife geht alle Selects durch und setzt den Value
        $.each(intervalSelects, function(key, value) {
            $('select[name="' + value + '"]').select2().val("M").trigger("change");
        });


    },

}