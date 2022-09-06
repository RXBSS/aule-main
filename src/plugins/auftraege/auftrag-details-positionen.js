/**
 * AUFTRAG - POSITIONEN
 */
var auPos = {

    // Position initalisieren
    initPos() {

        var me = this;

        // Positionsliste
        me.initPositionsListe("auftraege_positionen");

        // Artikelliste hinzufügen
        me.initArtikelListe();

        // Position Form
        me.initPositionForm();

        // Liefer Form
        me.initLieferForm();

        // Bestell Form
        me.initBestellForm();

        // Rechnung Form
        me.initRechnungForm();

        // Event Listner hinzufügen
        me.addPosEventListner();
    },


    initLieferForm() {

        var me = this;

        // Form initalisieren
        me.lieferForm = new Form('#form-lieferung');

        // Form Validation aktivieren
        me.lieferForm.initValidation();
    },

    initBestellForm() {

        var me = this;

        // Form initalisieren
        me.bestellForm = new Form('#form-bestellung');

        // Form Validation aktivieren
        me.bestellForm.initValidation();
    },


    initRechnungForm() {

        var me = this;

        // Form initalisieren
        me.rechnungForm = new Form('#form-rechnung');

        // Form Validation aktivieren
        me.rechnungForm.initValidation();
    },

    

    


    // EVENTLISTNERS 
    // #############

    // Events Listeners für die Positonen
    addPosEventListner() {

        var me = this;  



        // Events der Picklisten
        // #####################

        // On Submit
        me.positionForm.on('submit', function () {
            me.savePosition();
        });

        // TODO: Wenn das Modal geöffnet wird, dann muss dies entsprechend angepasst werden
        me.positionForm.container.get(0).addEventListener('shown.bs.modal', function (event) {
            // me.positionForm.container.find('input[name=menge]').focus();
        });

        // TODO: Plus und Minus Tasten drücken während man auf der Tabelle steht
        me.positionList.on('key', function (el, data) {

            // Plus
            if (data == 107 || data == 187) {
                app.notify.success.fire("Erfolgreich", "+1");
            }

            // Minus
            if (data == 109 || data == 189) {
                app.notify.success.fire("Erfolgreich", "-1");
            }
        });

        // Artikelauswahl verwalten
        me.positionList.on('selection', function (el, data) {
            me.handlePositionSelection(data);
        });


        // Tastenkombinationen und Shortcuts
        // #################################

        // TODO: HotKeys - INSERT (Einfügen)
        hotkeys('insert', function (event, handler) {
            me.neuePosition();
        });


        // Form 
        me.positionForm.container.on('click', '.btn-positionen-speichern', function () {
            me.positionForm.fvInstanz.validate().then(function (status) {
                console.log(status);
            });
        });

    },

    changePosStatus() {

        var me = this;


        // 
        me.positionList.waitForReady(function () {

            // Abwählen 
            me.positionList.deselect();

            // Entwurf
            if (me.status == 1) {

                // Beliefern und Geliefert ausblenden
                me.positionList.colVisible(['geliefert', 'liefern', 'bestellen'], false);

                // Offnener Auftrag
            } else if (me.status == 2) {

                // Geliefert wird im Status 2 immer angezeigt
                me.positionList.colVisible(['geliefert'], true);

                // Je nach Substatus
                if (me.subStatus == 0) {
                    me.positionList.colVisible(['liefern', 'bestellen'], false);
                } else if (me.subStatus == 1) {
                    me.positionList.colVisible(['liefern'], true);
                    me.positionList.colVisible(['bestellen'], false);
                } else if (me.subStatus == 2) {
                    me.positionList.colVisible(['liefern'], false);
                    me.positionList.colVisible(['bestellen'], true);
                }

            } else if (me.status == 3 || me.status == 4) {
                me.positionList.colVisible(['liefern', 'bestellen', 'bestand', 'bestellt'], false);
            } 
        });
    },

    

    /**
     * In diese Funktion wird das anwählen des Artikels verwaltet.
     * Je nach Status und Anwahl müssen hier verschiedene Dinge passieren!
     */
    handlePositionSelection() {

        var me = this;

        // Selected 
        var result = me.positionList.getSelectedColumn(1);

        // Alle Ausblenden
        $('body').find('.col-selector').removeClass().addClass('col-selector').hide();

        // Positionen sollen immer angezeigt werden!
        me.positionList.container.closest('.col-selector').show();

        // Button ausblenden und die Klasse hinzufügen
        $('.btn-pos-shift, .btn-pos-delete').hide();


        if (result) {

            // Entscheiden nach Status
            switch (me.status) {

                // Entwurf
                case 1:

                    // Wenn mindestens eine angewählt wurde
                    if (result) {

                        // Vorerst nur bei einem Möglich
                        if (result.length == 1) {
                            $('.btn-pos-shift').show();
                        }

                        $('.btn-pos-delete').show();

                        me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                        me.positionForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();

                        // Positions ID/s übergeben
                        me.loadPositionForm(result);
                    }

                    break;

                // Belieferung
                case 2:

                    // Lieferungen
                    if (me.subStatus == 1 && result) {
                        me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                        me.lieferForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();

                        // Bestellungen
                    } else if (me.subStatus == 2 && result) {
                        me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                        me.bestellForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();
                    }

                    break;
                case 3:

                    // Wenn etwas angewählt wurde
                    if (result) {
                        me.positionList.container.closest('.col-selector').removeClass().addClass('col-selector col-md-8');
                        me.rechnungForm.container.closest('.col-selector').removeClass().addClass('col-selector col-md-4').show();
                    }

                    break;

                case 4:

                    // Wenn vollständig?

                    break;

            }

            // Delesect
        }

        $(window).trigger('dt-resize');



    },


    


    // Position speichern
    savePosition() {

        var me = this;

        // Daten speichern
        me.positionForm.save('positionen-save', 'auftraege-handle', function () {
            me.reloadPositions();
        });
    },

    neuePositionUeberVertrag() {
        var me = this;

        app.alert.success.fire("Artikel über Vertrag", "Diese Funktion soll einen Artikel über ein Gerät heraussuchen. Dabei wird automatisch der Vertrag des Gerätes hinterlegt, falls er vorhanden ist. <br><strong>Diese Funktion ist noch nicht programmier!</strong>");
    },  


    // Lieferung
    // *********


    /**
     * 
     * @param {Boolean} [teillieferung=false]
     */
    automatischLiefern(teillieferung) {

        var me = this;

        // Initalisieren
        teillieferung = teillieferung || false;

        // Einfache Abfrage
        app.simpleRequest("automatisch-liefern", "auftraege-handle", {
            id: me.id,
            teillieferung: teillieferung

            // Success Callback
        }, function () {
            app.notify.success.fire("Erfolgreich", "Die Positionen wurden gefüllt!");
            me.reloadPositions();

        });
    }






}