var ident = {

    // Variable
    c: $('#ident-pickliste'),

    // init
    init: function () {
        ident.initPickListe();
        ident.addEventListener();
    },

    // EventListener
    addEventListener: function () {

    },

    // Init Pickliste
    initPickListe: function () {

        var me = this;

        // Pickliste initalisieren
        me.list = new Picklist(ident.c, 'ident', {
            type: 'single',
            card: false
        });

        // Weiterleitung - wenn eine Auswahl in der Pickliste getroffen wurde
        me.list.on('pick', function (el, data) {
            app.redirect('ident-details?id=' + data[1]);
        });

    }

}