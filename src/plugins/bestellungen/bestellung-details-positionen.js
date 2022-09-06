var pos = {

    initPos() {

        var me = this;

        me.initBestellPos();
        me.initLieferPos();
        me.initPositionSelect();
        me.addPosListner();

    },

    



    initBestellPos() {

        var me = this;

        // Postitionen anpassen
        me.bestellPosList = new Picklist("#pickliste-positionen", "bestellung_positionen", {
            type: 'multi-picklist',
            card: false,
            pagination: false,
            lengthMenu: false,
            search: false,
            buttons: false,
            data: function () {
                return me.id;
            }
        });

        me.bestellPosList.on('selection', function (el, data) {
            me.lieferPosList.reload();
        });

        me.bestellPosList.on('key', function (el, key, cell) {

            // Nur wenn der Fokus auf dieser Position liegt!
            if (cell.index().column == 7) {

                if (key == 107 || key == 187) {
                    var lineId = me.bestellPosList.DataTable.row(cell.index().row).data()[1];
                    me.changePositionAmount(lineId, "+");
                } else if (key == 109 || key == 189) {
                    var lineId = me.bestellPosList.DataTable.row(cell.index().row).data()[1];
                    me.changePositionAmount(lineId, "-");
                }
            }


        });

        // Button ausblenden und die Klasse hinzufügen
        $('.btn-pos-up, .btn-pos-down, .btn-pos-delete, .btn-pos-edit').hide();
        $('.btn-pos-delete').addClass('dt-' + me.bestellPosList.id + '-onSelected');
        $('.btn-pos-up, .btn-pos-down, .btn-pos-edit').addClass('dt-' + me.bestellPosList.id + '-onSingleSelected');


    },

    initLieferPos() {

        var me = this;

        me.lieferPosList = new Picklist("#pickliste-lieferungen", "wareneingaenge_lieferungen2", {
            type: 'simple',
            card: false,
            pagination: false,
            data: function () {

                // Rückgabe
                return {
                    auftrag: me.id,
                    artikel: me.bestellPosList.getSelectedColumn(3)
                }
            }
        });


    },

    initPositionSelect() {

        var me = this;

        // 
        me.bestellPosPicklist = new PicklistModal("artikel", {
            type: 'multi-picklist'
        });

        // Daten eintragen
        me.bestellPosPicklist.on('pick', function (el, data) {
            var artikelIds = me.bestellPosPicklist.getSelectedColumn(1);
            me.addPosition(artikelIds);
        });

    },

    addPosListner() {

        // 
        var me = this;

        // Positionen
        $('.btn-pos-neu').on('click', function () {
            me.bestellPosPicklist.open();
        });

        // Positionen
        $('.btn-pos-edit').on('click', function () {
            app.notify.error.fire("Nocht nicht Programmiert", "Diese Funktion ist noch nicht programmiert. Diese Meldung dient als Platzhalter");
        });

        // Positionen
        $('.btn-pos-delete').on('click', function () {
            var ids = me.bestellPosList.getSelectedColumn(1);
            me.deletePosition(ids);
        });

        // Positionen
        $('.btn-pos-up').on('click', function () {
            app.notify.error.fire("Nocht nicht Programmiert", "Diese Funktion ist noch nicht programmiert. Diese Meldung dient als Platzhalter");
        });

        // Positionen
        $('.btn-pos-down').on('click', function () {
            app.notify.error.fire("Nocht nicht Programmiert", "Diese Funktion ist noch nicht programmiert. Diese Meldung dient als Platzhalter");
        });

    },



    // Position hinzufügen
    addPosition(artikelIds) {

        var me = this;

        // Simple Ajax Request
        app.simpleRequest("bestellposition-hinzufuegen", "bestellungen-handle", {
            artikel: artikelIds,
            bestellung: me.id
        }, function (response) {
            app.notify.success.fire("Positionen hinzugefügt", "Es wurden " + artikelIds.length + "Position/en erfolgreich hinzugefügt!");
            me.bestellPosList.refresh();
        });
    },


    editPosition(artikelIds) {

    },

    // Bestellposition löschen
    deletePosition(ids) {

        var me = this;

        // Frage zum löschen stellen
        app.alert.question.fire("Löschen Bestätigen", "Wollen Sie die Position/en wirklich löschen? Dies kann nicht mehr rückgänig gemacht werden").then(function (result) {

            // Prüfen, dass der Benutzer bestätigt hat
            if (result.isConfirmed) {

                // Simple Ajax Request
                app.simpleRequest("bestellposition-loeschen", "bestellungen-handle", ids, function (response) {
                    app.notify.success.fire("Positionen gelöscht", "Es wurden " + ids.length + "Position/en erfolgreich gelöscht!");
                    me.bestellPosList.refresh();
                });
            }
        });
    },

    // Change Line Id
    changePositionAmount(lineId, to) {

        var me = this;

        // Request
        app.simpleRequest("bestellposition-menge", "bestellungen-handle", { lineId: lineId, to: to }, function (response) {
            me.bestellPosList.reload();
        });
    },

}