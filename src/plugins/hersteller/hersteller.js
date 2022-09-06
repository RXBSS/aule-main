
var hersteller = {
    
    // Variable
    c: $('#hersteller-pickliste'),

    // init
    init: function() {

        hersteller.initPickListe();
        hersteller.addEventListener();

    },

    // EventListener
    addEventListener: function() {

    },

    // Init Pickliste
    initPickListe: function() {

        hersteller.c = new Picklist(hersteller.c, 'hersteller');

    }

}