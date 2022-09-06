var v_klausel = {


    initDetailsKlauseln() {

        var me = this;

        // Pickliste
        me.initPicklisteKlauseln();

        // Load Klauseln
        me.loadKlauselnWithGroups();

        // Evnts
        me.addEventListenerKlauseln();
    },

    initPicklisteKlauseln() {

        var me = this;

        // Pickliste der Klauseln Vertraege -- Übersicht von allen die hinzugefügt worden sind
        me.vertraegeKlauseln = new Picklist('#vertraege-klauseln-pickliste', 'vertraege_klauseln_vertraege', {
            type: "multi-picklist",
            card: false,
            autoDeselect: false,
            pagination: false,
            addButtons: [
                {
                    action: "add",
                    class: "add",
                    icon: "fa-solid fa-plus",
                    id: "add",
                    tooltip: "Gruppen Hinzufügen",
                    pos: 2
                },
                {
                    action: "btn-klausel-delete",
                    class: "btn-klausel-delete",
                    icon: "fa-solid fa-trash",
                    tooltip: "Löschen Klausel",
                    show: 'onSelected',
                    pos: 3
                }
            ],
            data: me.id
        });

        // Pickliste Modal mit dem man neue Klauseln hinzufügen kann
        me.paragraphenList = new PicklistModal('vertraege_klauseln', {
            type: "multi-picklist",
            config: {
                file: 'config-overwrite.json',
            },
            autoDeselect: false,
            disabled: {
                query: {
                    table: 'vertraege_klauseln_vertraege',
                    field: 'klausel_id',
                    filter: {
                        vertraege_id: me.id
                    }
                },
                icon: '<i class="fa-solid fa-check-double text-primary"></i>'
            },
            data: 'only_aktiv'
        });

    },

    // Events
    addEventListenerKlauseln() {

        var me = this;

        // TODO: CardSizer mit Fehler
        // Wenn Das Tab Klauseln angeklickt wird und geöffnet wird
        $('#tab-nav-vertraege-3').on('show.bs.tab', function () {
        });

        // Wenn ein Anwahl getroffen wird
        me.vertraegeKlauseln.on('selection', function (key, value) {
            me.markKlausel(value);
        });

        // Wenn in der Pickliste ein Paragraph hinzugefügt werden soll 
        me.vertraegeKlauseln.container.on('click', '.add', function () {
            me.paragraphenList.open();
        });

        // Wenn in der Paragraphen List etwas hinzugefügt werden soll
        me.paragraphenList.on('pick', function (el, data) {
            me.addKlauselnVertraege(data);
        });

        // Wenn aus der Liste ein Paragraph gelöscht werden soll
        me.vertraegeKlauseln.container.on('click', '.btn-klausel-delete', function () {
            me.deleteKlausel();

        });

        // Wenn auf Den Icon geklickt wird und auf Klausel gewechselt ist 
        $('#tab-nav-vertraege-3').on('click', function() {
            me.benutzerdefinierteVertrag();
        }); 

        // Wenn ein Benutzer Definierte Vertrag Aktiviert wird
        $('input[name="benuzterdefinierter-vertrag"]').on('click', function() {
            app.notify.info.fire("Folgt...","Diese Funktion wird noch Programmiert!");
        });


    },

    // Lädt alle Klauseln mit den dazugehörigen Gruppen
    loadKlauselnWithGroups() {

        var me = this;

        // Ajax
        app.simpleRequest("loadKlauselnWithGroups", "vertraege-handle", me.id,

            function (response) {

                // DOM Element Erstmal leeren
                $('#paragraphen-klauseln').html("");

                $('#paragraphen-klauseln').append(response.data)

            }
        );

    },

    // Wenn eine Auswahl getroffen wurde soll dieser angemarkt werden
    markKlausel(data) {

        var me = this;

        // Alle li erstmal Normalisieren
        $('#paragraphen-klauseln').find('li').css('font-weight', 'normal')

        // Schleife geht durch die Values der Pickliste Selection 
        $.each(data, function (key, value) {

            // Alle ausgewählten Klauseln bekommen bold Style
            $('#paragraphen-klauseln').find('li[data-klausel="' + value[3] + '"]').css('font-weight', 'bold')

        });

    },

    // Fügt einem Vertrag neue Klauseln hinu
    addKlauselnVertraege(data) {

        var me = this;

        // Additional data
        var additional = {
            'data': data,
            'id': me.id
        }

        // mit Ajax Formular abschicken
        app.simpleRequest("addKlauselnVertraege", "vertraege-handle", additional,

            // Success
            function (response) {

                app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");

                // Liste Neu Laden
                me.vertraegeKlauseln.refresh(true);
                me.paragraphenList.refresh(true);


                // PDF Neu Laden
                me.loadKlauselnWithGroups();
            }
        );
    },

    // Klauseln Löschen
    deleteKlausel() {

        var me = this;

        // Wenn es eine Auswahl gibt
        if (me.vertraegeKlauseln.getSelectedLength() > 0) {

            // Abfrage was alles gemacht werden soll
            app.alert.question.fire('Wollen Sie wirklich löschen?', 'Dieser Vorgang kann nicht Rückgängig gemacht werden!')
                .then((result) => {

                    // Wenn der Nutzer zustimmt
                    if (result.value) {

                        // Alle angewählten Ids auslesen
                        var ids = me.vertraegeKlauseln.getSelectedColumn(1);

                        // Simple Request
                        app.simpleRequest('deleteVertragKlausel', 'vertraege-handle', ids, function () {

                            // PickListe wird automatisch neu geladen
                            me.vertraegeKlauseln.refresh(true);

                            // Nue Laden der Klauseln
                            me.loadKlauselnWithGroups();

                            app.notify.success.fire("Erfolgreich", "Ihre Aktion wurde erfolgreich angepasst");
                        });
                    }
                });
        } else {
            app.notify.error.fire("Auswahl Treffen", "Es wurden keine Auswahl getroffen");
        }


    }
}