var ak_aktion = {

    init() {


        var me = this; 

        // Form
        me.initForm();

        // Modal
        me.initModal()

        // setzt Zeitstempel
        me.setDate();

        // Activation Card
        me.initActivationInput();

        // Events
        me.addEventListener();
    },

    initForm() {


        var me = this; 

        // Pickliste
        me.list = new Picklist('#akquise-aktionen-pickliste', 'akquise_aktionen');

    },

    initModal() {

        var me = this; 

        // Modal
        me.modal = new ModalForm('#form-akquise-aktionen');
        me.modal.initValidation();
        

    },


    initActivationInput() {

        new ActivationInput('#cb-aktivieren', [{
            selector: 'input[name=wiedervorlage_nach]',
            text: '10'
        }])

    },


    addEventListener() {


        var me = this;

        // $('#btn-akquise-aktion-add').on('click', function() {

        // });

        me.modal.on('submit', function() {
            me.submit();
        });

        $('#btn-akquise-aktion-add').on('click', function() {
            me.modal.open();
        });


        // Auswahl getroffen
        me.list.on('pick', function(el, data) {
            app.redirect('akquise-aktionen-details.php?id=' + data[1]);
        });

        // Funktion die alle Daten setzt sobald das Modal geladen wird
        me.modal.on('shown.bs.modal', function() {

            me.setDate();

            $('input[name="wiedervorlage_nach"]').val('10');

        });

    },

    // Submit eine Neue Aktion
    submit() {



        var me = this;


        me.modal.save('ak-submit', 'akquise-handle', function(response) {

            /* Callback Success */

            // Alle Input-Felder werden gesäubert
            me.modal.clearForm(); 

            me.modal.close(); 


            // Erfolgsmeldung
            app.notify.success.fire("Erfolgreich","Ihre Aktion wurde erfolgreich ausgeführt");
            
            // PickListe soll automatisch neu geladen werden -> damit man das Ergebnis sieht
            me.list.refresh(true);

            setTimeout(() => {

                if(response.success) {
                
                    app.redirect('akquise-aktionen-details.php?id=' + response.data);
    
                }
            }, 200);

            


        },
        /* Callback Error ist nicht vorhanden */
        function() {

            app.notify.error.fire("Fehler","Es ist ein  Fehler aufgetreten. Bitte wendne Sie sich an den Admin!");

        } 
        
        );

    },

    setDate() {

        // setzt heutiges Datum
        $('input[name="zeitstempel"]').val(moment().format('YYYY-MM-DD'));

    }


}