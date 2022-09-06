



var artikel = {

    // Variablen
    lagerChart: false,
    lagerForm: false,
    priorChartData: false,


    init() {

        var me = this;

        // Id festlegen
        me.id = app.getAndCheckUrlId("artikel");

        // 
        if(me.id) {

            // Form 
            me.initForm();

            // Lager und Preise
            me.initLagerUndPreise();
            
            // Init Ident
            me.initIdent();

            // Init Verknüpfungen
            me.initVerknuepfungen();

            // Init Dokumente
            me.initDokumente();

            // Init Dokumente
            me.initBilder();

            // Historie
            me.initHistorie();

            // Event Listner
            me.addListner();
        }

    },


    initForm() {

        // Form in einer Card
        var form = new CardForm('#form-artikel');

        // Init FormValidation
        form.initValidation();

        var defData = false;

        // Activatoin Multi
        new ActivationMulti(form.container.find('input[name=status_id]'), '.alert-status', form);


        form.load('load', 'artikel-handle.php', app.getUrlId(), function (data) {
            defData = data;
        });

        // Artikel Attribute
        var attr = new ArtikelAttribute('#artikel-attribute', form);

        form.qs['zuordnung'].link(form.qs['artikelgruppe'], 'zuordnung_id', 'Zuordnung');

        // Beim Ändern der Artikelgruppe
        form.qs['artikelgruppe'].on('change', function () {

            // Wert
            var value = $(this).val();

            // Neu Laden            
            attr.load(value, function (fields) {

                var attributeData = {};

                $.each(defData.data.attribute, (index, value) => {
                    attributeData['attribute' + index] = value;
                });

                form.setData(attributeData, false, true);
            });
        });

        // On Submit
        form.on('submit', function () {
            form.save('edit', 'artikel-handle');
        });

    },

    

    /**
     * Event Listner hinzufügen
     */
    addListner() {

        var me = this;

        $('.btn-artikel-kopieren').on('click', function () {
            app.alert.info.fire("Artikel Kopieren", "Diese Funktion ist zum jetztigen Zeitpunkt noch nicht programmiert!");
        });

        $('.btn-artikel-nachfolger').on('click', function () {
            app.alert.info.fire("Nachfolger erstellen", "Diese Funktion ist zum jetztigen Zeitpunkt noch nicht programmiert!");
        });

         // STRG + H - Historie
         hotkeys('ctrl+h', function (e, handler) {
            e.preventDefault();
            me.history.open();
        });


    },

    initHistorie() {

        var me = this;

         // Auftragshistorie
         me.history = new ArtikelHistorySidebar({
            ajax: {
                task: "load-historie",
                file: "artikel-handle",
                data: me.id
            }
        });

        /*

       // Beispiel Datensatz
       var dataSet = [{
           'timestamp': '2021-05-07 09:55:56',
           'icon': 'fa fa-envelope',
           'content': 'Artikel wurde <strong>2x</strong> an <strong>Kunde</strong> versendet'
       },{
           'timestamp': '2021-05-07 09:55:56',
           'icon': 'fa fa-truck-loading',
           'content': 'Artikel wurde <strong>8x</strong> von <strong>Systeam</strong> angeliefert'
       },{
           'timestamp': '2021-05-06 13:12:22',
           'icon': 'fa fa-shopping-cart',
           'content': 'Artikel <strong>8x</strong> bei <strong>Systeam</strong> bestellt'
       },{
           'timestamp': '2021-05-06 10:20:00',
           'icon': 'fa fa-user-clock',
           'content': '<strong>Kunde</strong> hat <strong>2x</strong> den Artikel bestellt'
       },{
           'timestamp': '2020-04-12 08:19:00',
           'icon': 'fa fa-plus',
           'content': 'Artikel wurde erstellt'
       }];
       
       // Erstellen
       var timeline = new Timeline('#artikel-historie');
       
       // Daten setzen
       timeline.setData(dataSet);
       
       // Write Data
       timeline.render();
       
       */
    }


}

