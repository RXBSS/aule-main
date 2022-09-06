class HistorySidebar {

    // Optionen
    constructor(options) {

        var me = this;

        options = options || {};

        // Einstellungen abgleichen
        me.settings = $.extend({}, {
            icon: 'fa-solid fa-history',
            name: 'Historie',
            width: 400,
            ajax: false
        }, options);

        // 
        if (!me.settings.ajax) {
            throw "Bitte die Ajax Daten angeben!";
        }


        // Neuen Action Button erstellen
        me.actionButton = new Notification({
            icon: me.settings.icon
        });

        // Do Something
        me.sidebar = new Sidebar({
            name: me.settings.name,
            width: me.settings.width,
            clickToClose: true,
            actionButton: me.actionButton,

        });

        // Sidebar holen
        var el = me.sidebar.getEl();

        // Content Justifyen
        el.addClass('d-flex flex-column justify-content-between');

        // Wenn die Bar geöffnet wird
        me.sidebar.on('open', function () {

            // Lade anzeigen
            me.sidebar.setLoading();

            // Simple Request durchführen
            app.simpleRequest(me.settings.ajax.task, me.settings.ajax.file, me.settings.ajax.data, function (response) {

                var html = '<div>' + 
                                '<h4><i class="' + me.settings.icon + '"></i> ' + me.settings.name + '</h4>' + 
                            '</div>' + 
                            '<div class="history-timeline"></div>';

                // HTML schreiben
                me.sidebar.setHtml(html);

                // 
                me.timeline = new Timeline(el.find('.history-timeline'));

                // Beispiel Datensatz
                var dataSet = [];

                $.each(response.data, function (index, value) {

                    // Datenset erstellen 
                    var dataSetTemp = {
                        'timestamp': value.zeitstempel,
                        'icon': false,
                        'content': false,
                        'subcontent': (value.user_id) ? "<i class=\"fa-solid fa-user\"></i> " + value.vorname + " " + value.nachname : false
                    };

                    // Hinzufügen
                    dataSet.push(me.render(dataSetTemp, value));
                });
                
                // Daten setzen
                me.timeline.setData(dataSet.reverse());

                // Timeline Rendern
                me.timeline.render();
            });
        });
    }

    // Daten übergeben
    render(template, data) {

        template.content = "¯\_(ツ)_/¯";

        // Daten zurückgeben
        return template;
    }


    // Öffnen
    open() {
        var me = this;
        me.sidebar.open();
    }
}