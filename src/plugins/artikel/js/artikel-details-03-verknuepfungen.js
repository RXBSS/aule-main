var artikelVerknuepfungen = {
    initVerknuepfungen() {
        var me = this;

        // Pickliste für die Verknüpfungen
        me.initVerknPicklist();

        // Suche für die Artikel
        me.initArtikelVerknList();

        // Event Listner
        me.addVerknListner();

        me.setVerknZaehler();

    },

    // Liste der Verknüpfungen
    initVerknPicklist() {

        var me = this;

        // Liste
        me.verknList = new Picklist("#picklist-verknuepfung", "artikel_verknuepfungen", {
            type: 'multi-picklist',
            data: me.id,
            addButtons: [{
                action: 'delete',
                icon: 'fa-solid fa-trash',
                pos: 2,
                show: 'onSelected',
                tooltip: 'Verknüpfung löschen'
            }]
        });

        // Action
        me.verknList.on('action', function (el, action) {
            if (action == 'delete') {
                var data = me.verknList.getSelectedColumn('id');
                me.deleteVerkn(data);
            }
        });
    },

    // Auswahl-Liste für Artikel
    initArtikelVerknList() {

        var me = this;

        me.artikelVerknList = new PicklistModal("artikel", {
            title: '<i class="fa-solid fa-magnifying-glass"></i> Artikel Suchen',
            type: 'multi-picklist'
        });

        me.addVerknType = false;

        // On Pick
        me.artikelVerknList.on('pick', function (el, data) {
            var data = me.artikelVerknList.getSelectedColumn('id');
            me.addVerkn(data);
        });




    },

    /**
     * Fragt die Anzahl der Links ab
     */
    setVerknZaehler() {

        var me = this;

        // Ajax Abfrage der API
        app.simpleRequest("get-verknuepfung", "artikel-handle", me.id, function (response) {

            // Setzen der Felder
            $('.artikel-verkn-summe').html(response.data.links.all.length);
            $('.artikel-verkn-vorgaenger').html(response.data.links['1a'].length);
            $('.artikel-verkn-nachfolger').html(response.data.links['1b'].length);
            $('.artikel-verkn-alternativen').html(response.data.links['2'].length);
            $('.artikel-verkn-modell').html(response.data.links['3'].length);
        });
    },


    addVerknListner() {

        var me = this;

        // Verknüpfung hinzufügen
        $('.btn-artikel-add-verknuepfung').on('click', function () {
            me.startAddVerkn($(this).data('type'));
        });

        $('.btn-artikel-filter-verknuepfung').on('click', function () {
            me.filterVerkn($(this));
        });
    },

    getVerknData(type) {

        var obj = {
            '1a': {
                title: '<i class="fa-solid fa-magnifying-glass"></i> Vorgänger suchen',
                headline: 'Vorgänger hinzufügen',
                text: 'Soll der/die Artikel als Vorgänger-Artikel hinzugefügt werden',
            },
            '1b': {
                title: '<i class="fa-solid fa-magnifying-glass"></i> Nachfolger suchen',
                headline: 'Nachfolger hinzufügen',
                text: 'Soll der/die Artikel als Nachfolger-Artikel hinzugefügt werden'
            },
            2: {
                title: '<i class="fa-solid fa-magnifying-glass"></i> Alternativ suchen',
                headline: 'Alternative hinzufügen',
                text: 'Soll der/die Artikel als Alternative-Artikel hinzugefügt werden'
            },
            3: {
                title: '<i class="fa-solid fa-magnifying-glass"></i> Modell suchen',
                headline: 'Modell hinzufügen',
                text: 'Soll der/die Artikel als Modell-Artikel hinzugefügt werden'
            }
        };

        return obj[type];
    },


    startAddVerkn(type) {

        var me = this;

        // Wenn man startet
        me.addVerknType = type;

        var verknData = me.getVerknData(type);

        // Titel der Pickliste ändern
        me.artikelVerknList.container.find('.modal-title').html(verknData.title);

        // Öffnen
        me.artikelVerknList.open();
    },

    addVerkn(linkTo) {

        var me = this;

        // Verknüpfungsdaten
        var verknData = me.getVerknData(me.addVerknType);

        // Wenn ein Typ vorhanden ist
        if (me.addVerknType) {

            // Alert Question
            app.alert.question.fire({
                title: verknData.headline,
                html: verknData.text

                // Antwort
            }).then(function (response) {

                // TODO: Hier noch die Warnmeldung hinzufügen?

                // Wenn der Kunde bestätigt hat
                if (response.isConfirmed) {

                    // Wirklich hinzufügen
                    app.simpleRequest("add-verknuepfung", "artikel-handle", {
                        artikelId: me.id,
                        linkTo: linkTo,
                        art: me.addVerknType

                        // Ergebnis
                    }, function (response) {
                        app.notify.success.fire("Erfolgreich", "Der Artikel wurde erfolgreich verknüpft");
                        me.verknList.reload();
                    });


                }
            });
        }
    },


    // 
    doAddVerkn() {

    },


    /**
     * Anzahl an Ids
     */
    deleteVerkn(ids) {

        var me = this;
    
        app.alert.question.fire("Verknüpfungen löschen","Sollen die Verknüpfungen wirklich gelöscht werden? Dies kann nicht mehr rückgängig gemacht werden!").then(function(response) {

            if(response.isConfirmed) {

                // Wirklich hinzufügen
                app.simpleRequest("delete-verknuepfung", "artikel-handle", ids, function (response) {
                    me.verknList.reload(true);
                    app.notify.success.fire("Erfolgreich", "Die Verknüpfungen wurden erfolgreich gelöscht");
                });
            }
        });
    },




    filterVerkn(el) {

        var me = this;

        // Diesen Aktiv setzen
        var type = el.data('type');


        if (!el.hasClass('active')) {



            // Filter setzen
            if (type == '1a') {
                var filter = new PickFilter([
                    new PickFilter(2, 1),
                    new PickFilter(12, me.id)
                ]);
            } else if (type == '1b') {
                var filter = new PickFilter([
                    new PickFilter(2, 1),
                    new PickFilter(9, me.id)
                ]);
            } else if (type == '2') {
                var filter = new PickFilter(2, 2);
            } else if (type == '3') {
                var filter = new PickFilter(2, 3);
            }

            // 
            me.verknList.setFilter(filter);


            // GUI anpassen
            $('.btn-artikel-filter-verknuepfung').addClass('disabled');
            el.removeClass('disabled');
            el.addClass('active');

        } else {
            $('.btn-artikel-filter-verknuepfung').removeClass('active disabled');
            me.verknList.resetFilter();
        }


    }


};