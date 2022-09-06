$(document).on('app:ready', function() {

    // Pickliste
    // *********
    var picklist = new Picklist("#picklist-angebote", "angebote");

    // On Pick
    picklist.on('pick', function (el, data) {
        app.redirect('angebot-details?id=' + data[1]);
    });

    // Button zum Erstellen eines neuen Auftrags
    $('.btn-neues-angebot').on('click', function() {
        createAngebot();
    });

    // Erstellen eines neuen Auftrags
    hotkeys('ctrl+e', function (event, handler) {
        event.preventDefault();
        createAngebot();
    });
});

function createAngebot() {
    app.simpleRequest("create", "angebote-handle", null, function(response) {
        app.redirect('angebot-details?id=' + response.data);
    });
}