
var mtr = {

    // init
    init: function() {

        var me = this;

        // Init Modal
        me.modal = new ModalForm('#modal-mitarbeiter-form');
        
        // Schaltet Modal Validierung ein
        me.modal.initValidation();

        // Init Pickliste
        me.list = new Picklist('#mitarbeiter-pickliste', 'mitarbeiter', {
            type: 'single',
            card: false
        })
        

        // EventListener
        mtr.addEventListener();

       
    },

    // EventListener
    addEventListener() {

        var me = this;

        // 
        me.simpleModalTask = new simpleModalTask('#modal-mitarbeiter-open', me.list, me.modal, 'mtr-submit', 'mitarbeiter-handle');


        // Duplettenprüfung - Ist die Adresse bereits vorhanden Abfrage
        $('input[name="nachname"]').on('blur', function() {
            me.mitarbeiterDuplettenpruefung();
        });

        me.list.on('pick', function (el, data) {
            app.redirect('mitarbeiter-details.php?id=' + data[1]);
        });
    }, 

    mitarbeiterDuplettenpruefung() {

        // Holt die Daten aus den Input Feldern um Sie weiterzugeben
        var vorname = $('input[name="vorname"]').val();
        var nachname = $('input[name="nachname"]').val();
        var data = {
            vorname: vorname,
            nachname: nachname
        }

        var dP = new duplettenPruefung("getMitarbeiter", "mitarbeiter-handle", data, "Dieser Mitarbeiter ist bereits angelegt. Möchten Sie diesen noch einmal anlegen?");
    }
}