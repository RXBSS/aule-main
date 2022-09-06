var v_abrechnung = {


    initVertraegeAbrechnung() {

        var me = this;

        // Pickliste
        me.initPicklistAbrechnung();

    },

    initPicklistAbrechnung() {

        var me = this;

        // Pickliste der Klauseln Vertraege -- Übersicht von allen die hinzugefügt worden sind
        me.vertraegeKlauseln = new Picklist('#abrechnungen-pickliste', 'vertraege_abrechnung', {
            type: "simple",
            autoDeselect: false,
            pagination: false,
            data: me.id
        });

        // me.abrechnungList = new Picklist('#abrechnungen-pickliste', 'vertraege_abrechnung')

    }

}