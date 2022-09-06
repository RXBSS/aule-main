/**
 * In diesem Teil sind alle Funktionen zum
 * - Hinzufügen (add)
 * - Löschen (delete)
 * - Neu Laden (reload)
 * - Positionen verschieben (shift)
 * 
 */
var detailHelperPosHandle = {


    /**
     * @param {Array|String|Number} artikel Die Ids die hinzugefügt werden sollen
     */
    posAdd(artikel) {

        var me = this;
        artikel = (Array.isArray(artikel)) ? artikel : [artikel];

        // Simple Request
        app.simpleRequest("positionen-add", me.handler, {
            id: me.id,
            artikel: artikel

        }, function () {

            me.posReload();
            app.notify.success.fire("Erfolgreich", "Es wurden mehrere Positionen eingefügt!");

            if (artikel.length === 1) {
                // me.openPosition(response.data[0]);
                console.log('open Position');
            }
        });
    },


    /**
     * Diese Funktion ruft die Pickliste auf
     * 
     * @param {Array|String|Number} ids Die Ids die hinzugefügt werden sollen
     */
    posAddStart() {
        var me = this;

        // Quick
        app.alert.info.fire({
            title: 'Artikel hinzufügen',
            text: "Bitte wählen Sie über welche Methode Sie einen Artikel hinzufügen wollen",
            icon: 'question',
            confirmButtonText: 'Artikel',
            showCancelButton: true,
            cancelButtonText: 'Vertrag',
            showDenyButton: true,
            denyButtonText: 'Modell',
        }).then(function (result) {

            if (result.isConfirmed) {
                me.artikelSearchList.open(function (action, data) {
                    if (action == 'pick') {
                        var artikel = [];
                        for (var item in data) {
                            artikel.push(data[item][1]);
                        }
                        me.posAdd(artikel);
                    }
                });
            } else if (result.isDismissed && result.dismiss == 'cancel') {
                app.alert.info.fire("Vertrag Auswahl", "Diese Funktion ist noch nicht programmiert, folgt aber noch!");
            } else if (result.isDenied) {
                app.alert.info.fire("Modell Auswahl", "Diese Funktion ist noch nicht programmiert, folgt aber noch!");
            }
        });
    },



    /**
     * Führt den die AJAX Abfrage zum Löschen mit der Handle aus
     * 
     * Ehemals deletePosition
     * 
     * @param {Array|String|Number} ids Die Ids die gelöscht werden sollen
     */
    posDelete(ids) {

        var me = this;

        ids = (typeof ids == 'object') ? ids : [ids];

        // Simple Request
        app.simpleRequest("positionen-delete", me.handler, ids, function () {

            me.posReload(true);

            app.notify.success.fire("Erfolgreich gelöscht", "Die Positionen wurde erfolgreich gelöscht!");

            // Handle Position Selection
            me.handlePositionSelection();
        });
    },

    /**
     * Diese Funktion ruft die Pickliste auf
     * 
     * @param {Array|String|Number} ids Die Ids die hinzugefügt werden sollen
     */
    posDeleteStart(ids) {

        var me = this;

        // 
        app.alert.delete.fire("Position Löschen").then(function (result) {
            if (result.isConfirmed) {
                me.posDelete(ids);
            }
        });
    },



    /**
     * Liest die Daten aus der Liste aus und übergibt Sie dann an die eigentliche Löschfunktion
     * Ehemals deletePositionByList
     * 
     */
    posDeleteByList() {
        var me = this;
        var array = me.positionList.getSelectedColumn(1);
        me.posDelete(array);
    },

    /**
     * Läd die Liste neu
     */
    posReload(clear) {
        var me = this;
        clear = clear || false;

        me.positionList.reload(clear);
        me.calculateTotal();
    },


    /**
     * Verschiebt eine oder mehrere Positionen nach oben und unten
     * 
     * Ehemals shiftPosition
     * @TODO Mehrere auf einmal verschieben ermöglichen!
     * 
     * @param {Array|String|Number} ids Die Ids die gelöscht werden sollen
     * @param {String} direction Angabe der Richtigung (up, down, top, bottom) sind erlaubt
     */
    posShift(ids, direction) {

        var me = this;

        ids = (typeof ids == 'object') ? ids : [ids];

        // Simple Request
        app.simpleRequest("positionen-shift", me.handler, {
            id: me.id,
            colId: ids,
            direction: direction
        }, function () {
            me.positionList.refresh();
        });
    },


    /**
     * 
     * doShiftPosition
     * 
     * @param {*} direction 
     */
    posShiftByList(direction) {

        var me = this;

        // Richtiung
        direction = (app.keys.ctrl) ? ((direction == 'up') ? 'top' : 'bottom') : direction;

        // Spalten ID auslesen
        var colId = me.positionList.getSelectedColumn(1);

        // Speichern
        var hasChange = me.positionForm.hasChange();

        // Prüfen ob sich Änderungen in der Form ergeben haben
        if (hasChange) {

            // Wenn ja, vorher nach speichern Fragen
            app.alert.save.fire("Positionsdaten speichern?", "Sie haben in den Positionsdaten etwas geändert.").then(function (data) {

                if (data.isConfirmed) {

                    // Speichern?
                    console.warn('hier muss noch gespeichert wernden')

                    // TODO: Hier muss noch gespeichert werden!
                    me.posShift(colId, direction);
                }
            });

            // Wenn nein, direkt sortieren
        } else {
            me.posShift(colId, direction);
        }
    },

    /**
    * Position speichern
    */
    posSave() {

        var me = this;

        console.log('-- Save');

        // Daten speichern
        me.positionForm.save('positionen-save', me.handler, function (response) {

            // Reload
            me.posReload();

            // Nur Validierun löschen
            me.positionForm.reset(2);

        });
    },



    handlePositionSelectionDefault() {

        var me = this;

        // Ergebnisse
        var result = me.positionList.getSelectedColumn(1);

        // Alle Ausblenden
        $('body').find('.col-selector').removeClass().addClass('col-selector').hide();

        // Positionen sollen immer angezeigt werden!
        me.positionList.container.closest('.col-selector').show();

        $('.btn-pos-shift, .btn-pos-delete').hide();

        // Trigger Resize für DataTables, damit die Spalten wieder die gleiche Breite haben
        $(window).trigger('dt-resize');

        return result;
    },
}