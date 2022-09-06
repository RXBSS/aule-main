$(document).on('app:ready', function() {

    // Pickliste
    // *********
    var picklist = new Picklist("#auftraege-pickliste", "auftraege");

    // On Pick
    picklist.on('pick', function (el, data) {
        app.redirect('auftrag-details?id=' + data[1]);
    });

    // Button zum Erstellen eines neuen Auftrags
    $('#btn-neuer-auftrag').on('click', function() {
        createAuftrag();
    });

    // Erstellen eines neuen Auftrags
    hotkeys('ctrl+e', function (event, handler) {
        event.preventDefault();
        createAuftrag();
    });
});

function createAuftrag() {
    app.simpleRequest("entwurf-erstellen", "auftraege-handle", null, function(response) {
        app.redirect('auftrag-details?id=' + response.data);
    });
}