$(document).on('app:ready', function() {});

/**
 * Alle themen die die Tickets angehen werden hier geladen
 */
var tickets = {

    // Alles was beim Neuladen der Seite ausgeführt werden soll
    init() {

        var me = this;

        // Init der Pickliste
        me.initPickliste();

        // Init des Modals
        me.initModal();

        // Add EventListener
        me.addEventListener();

    },

    // Modal was beim Laden der Seite Init sein soll
    initModal() {

        var me = this;

        // Modal
        // ************
        me.modal = new ModalForm('#modal-ticket-form');
        me.modal.initValidation();

        
    },

    // Die Pickliste die beim Laden der Seite Init sein soll
    initPickliste() {

        var me = this; 

        // Pickliste
        // *********
        me.picklist = new Picklist("#tickets-pickliste", "tickets");
    },

    // Alle Events werden hier reingebracht
    addEventListener() {

        var me = this;


        // Normale Events
        // ******************************************************
        
        // Erstellen eines neuen Auftrags
        hotkeys('ctrl+e', function (event, handler) {
            event.preventDefault();
            me.modal.open();
        });

        // Button zum Erstellen eines neuen Auftrags
        $('#btn-neues-ticket').on('click', function() {
            me.modal.open();
        });


        // Form Handler
        // ******************************************************

        // On Pick
        me.picklist.on('pick', function (el, data) {
            app.redirect('ticket-details?id=' + data[1]);
        });
        
        // Submit Modal
        me.modal.on('submit', function() {
            me.createTicket();
        });

    },

    // Erstellt ein neues Ticket
    createTicket() {


        var me = this;

        // Save funktion
        me.modal.save('createTicket', 'tickets-handle', 
        
            // Success
            function(response) {

                // Redirect auf die Details Seite
                app.redirect('ticket-details?id=' + response.data);

            }, 

            // Error
            function(xhr) {

                app.notify.error.fire("Fehler","Es ist ein Fehler aufgetreten. Bitte wenden Sie sich an den Admin!");

            },

            // Additional
            false
            
        )

    }


}

function createTicket() {
    // app.simpleRequest("entwurf-erstellen", "auftraege-handle", null, function(response) {
    //     app.redirect('auftrag-details?id=' + response.data);
    // });
    alert('-- Neues Ticket');
}

