
/**
 * Das ist das Objekt das nur auf der Notification.php Seite gilt
 */
var noti = {

    // Init Funktion
    init() {

        var me = this;

        // ID der Angemeldeten Person
        me.sessionID = $('input[name="sessionID"]').val();

        // Init Pickliste
        me.initPickliste();

        // Eventlistener
        me.addEventListener();
    },

    // Init Picklsite
    initPickliste() {

        var me = this;

        // Notification Pickliste
        me.list = new Picklist("#pickliste-notification", "notification", {
            card: false,
            data: me.sessionID // Nur eigene Notifications sehen
        });

    },

    // EventListener die nur auf der Seite sichtbar sind
    addEventListener() {

        var me = this; 

        // Wenn eine Auswahl aus der Liste getroffen wurde
        me.list.on('pick', function(el, data) {
            // app.redirect('notification-details.php?id=' + data[1]);
            app.notify.info.fire("Kommt...","Diese Funktion wird noch programmiert");
        });

    }

}